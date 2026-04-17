<?php

namespace App\Console\Commands;

use App\Models\Billing;
use App\Models\CustomerSubscription;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateMonthlyBillings extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'billing:generate-monthly
                            {--month= : Bulan target (1-12), default bulan ini}
                            {--year= : Tahun target, default tahun ini}';

    /**
     * The console command description.
     */
    protected $description = 'Generate tagihan bulanan untuk semua langganan aktif (idempotent).';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = Carbon::now();
        $month = (int) ($this->option('month') ?: $now->month);
        $year = (int) ($this->option('year') ?: $now->year);

        $this->info("Generating billing untuk {$month}/{$year}...");

        $generated = 0;
        $skipped = 0;
        $failed = 0;

        CustomerSubscription::query()
            ->whereRaw('is_active IS TRUE')
            ->with(['package', 'customer'])
            ->chunkById(100, function ($subscriptions) use ($month, $year, &$generated, &$skipped, &$failed) {
                foreach ($subscriptions as $subscription) {
                    // Skip jika subscription tidak memiliki paket
                    if (! $subscription->package || ! $subscription->customer) {
                        $skipped++;

                        continue;
                    }

                    // Idempotency: skip jika sudah ada billing bulan ini
                    $exists = Billing::where('subscription_id', $subscription->id)
                        ->where('billing_month', $month)
                        ->where('billing_year', $year)
                        ->exists();

                    if ($exists) {
                        $skipped++;

                        continue;
                    }

                    // Hitung due_date: tanggal siklus + 7 hari grace period
                    $cycleDay = $subscription->billing_cycle_date ?? 1;
                    $dueDate = Carbon::createFromDate($year, $month, min($cycleDay, Carbon::createFromDate($year, $month, 1)->daysInMonth))
                        ->addDays(7);

                    try {
                        DB::transaction(function () use ($subscription, $month, $year, $dueDate) {
                            Billing::create([
                                'user_id' => $subscription->user_id,
                                'customer_id' => $subscription->customer_id,
                                'subscription_id' => $subscription->id,
                                'amount' => $subscription->package->price,
                                'status' => 'unpaid',
                                'due_date' => $dueDate->toDateString(),
                                'payment_date' => null,
                                'billing_month' => $month,
                                'billing_year' => $year,
                            ]);
                        });

                        $generated++;
                    } catch (\Throwable $e) {
                        $failed++;
                        Log::error('GenerateMonthlyBillings: gagal buat billing', [
                            'subscription_id' => $subscription->id,
                            'customer' => $subscription->customer->name,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            });

        Log::info('GenerateMonthlyBillings selesai', [
            'bulan' => "{$month}/{$year}",
            'generated' => $generated,
            'skipped' => $skipped,
            'failed' => $failed,
        ]);

        $this->info("Selesai. Generated: {$generated} | Dilewati: {$skipped} | Gagal: {$failed}");

        return self::SUCCESS;
    }
}
