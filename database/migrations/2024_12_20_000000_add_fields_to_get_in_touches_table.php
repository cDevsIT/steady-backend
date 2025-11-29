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
        Schema::table('get_in_touches', function (Blueprint $table) {
            // Add new fields if they don't exist
            if (!Schema::hasColumn('get_in_touches', 'first_name')) {
                $table->string('first_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('get_in_touches', 'last_name')) {
                $table->string('last_name')->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('get_in_touches', 'email')) {
                $table->string('email')->nullable()->after('emails');
            }
            if (!Schema::hasColumn('get_in_touches', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('get_in_touches', 'country_code')) {
                $table->string('country_code', 10)->nullable()->after('phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('get_in_touches', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'email', 'phone', 'country_code']);
        });
    }
};

