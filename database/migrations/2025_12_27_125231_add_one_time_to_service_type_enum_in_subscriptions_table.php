<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify enum column to include 'one_time'
        // MySQL requires raw SQL to modify enum values
        DB::statement("ALTER TABLE `subscriptions` MODIFY COLUMN `service_type` ENUM('free', 'half_yearly', 'yearly', 'one_time') DEFAULT 'yearly'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values (remove 'one_time')
        DB::statement("ALTER TABLE `subscriptions` MODIFY COLUMN `service_type` ENUM('free', 'half_yearly', 'yearly') DEFAULT 'yearly'");
    }
};
