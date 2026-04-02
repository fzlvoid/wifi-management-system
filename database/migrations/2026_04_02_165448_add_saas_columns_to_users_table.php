<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('id');
            }

            if (! Schema::hasColumn('users', 'api_key')) {
                $table->string('api_key', 64)->unique()->nullable()->after('role');
            }

            if (! Schema::hasColumn('users', 'subscription_start')) {
                $table->date('subscription_start')->nullable()->after('api_key');
            }

            if (! Schema::hasColumn('users', 'subscription_end')) {
                $table->date('subscription_end')->nullable()->after('subscription_start');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(array_filter([
                Schema::hasColumn('users', 'name') ? 'name' : null,
                Schema::hasColumn('users', 'api_key') ? 'api_key' : null,
                Schema::hasColumn('users', 'subscription_start') ? 'subscription_start' : null,
                Schema::hasColumn('users', 'subscription_end') ? 'subscription_end' : null,
            ]));
        });
    }
};
