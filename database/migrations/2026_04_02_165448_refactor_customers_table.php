<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Hapus kolom payment-tracking lama (dipindah ke tabel payments)
            $dropColumns = [];

            if (Schema::hasColumn('customers', 'is_paid')) {
                $dropColumns[] = 'is_paid';
            }

            if (Schema::hasColumn('customers', 'last_paid')) {
                $dropColumns[] = 'last_paid';
            }

            if (Schema::hasColumn('customers', 'due_date')) {
                $dropColumns[] = 'due_date';
            }

            if ($dropColumns !== []) {
                $table->dropColumn($dropColumns);
            }

            // Tambah billing_cycle_date (1–28)
            if (! Schema::hasColumn('customers', 'billing_cycle_date')) {
                $table->tinyInteger('billing_cycle_date')->unsigned()->default(1)->comment('Tanggal siklus tagihan bulanan (1-28)');
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'billing_cycle_date')) {
                $table->dropColumn('billing_cycle_date');
            }

            if (! Schema::hasColumn('customers', 'due_date')) {
                $table->date('due_date')->nullable();
            }

            if (! Schema::hasColumn('customers', 'last_paid')) {
                $table->timestamp('last_paid')->nullable();
            }

            if (! Schema::hasColumn('customers', 'is_paid')) {
                $table->boolean('is_paid')->default(false);
            }
        });
    }
};
