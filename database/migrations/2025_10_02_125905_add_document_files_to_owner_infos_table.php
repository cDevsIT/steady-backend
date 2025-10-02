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
        Schema::table('owner_infos', function (Blueprint $table) {
            $table->string('scanned_passport_copy')->nullable()->after('Country');
            $table->string('bank_statement')->nullable()->after('scanned_passport_copy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('owner_infos', function (Blueprint $table) {
            $table->dropColumn(['scanned_passport_copy', 'bank_statement']);
        });
    }
};
