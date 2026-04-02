<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('payments');

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')
                ->constrained('customers')
                ->cascadeOnDelete();
            $table->decimal('amount', 15, 2)->comment('Snapshot harga paket saat tagihan dibuat');
            $table->enum('status', ['PAID', 'UNPAID'])->default('UNPAID');
            $table->date('due_date');
            $table->date('payment_date')->nullable();
            $table->string('billing_month', 7)->comment('Format YYYY-MM, mencegah duplikasi tagihan');
            $table->timestamps();

            $table->unique(['customer_id', 'billing_month'], 'payments_customer_billing_month_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
