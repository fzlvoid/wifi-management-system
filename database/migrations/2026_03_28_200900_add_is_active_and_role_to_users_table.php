<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }

            if (! Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['admin', 'user'])->default('user');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('users', 'is_active')) {
                $columns[] = 'is_active';
            }

            if (Schema::hasColumn('users', 'role')) {
                $columns[] = 'role';
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
