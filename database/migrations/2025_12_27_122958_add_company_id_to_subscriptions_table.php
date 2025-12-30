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
        Schema::table('subscriptions', function (Blueprint $table) {
            // Add company_id column after order_id
            $table->unsignedBigInteger('company_id')->nullable()->after('order_id');
            
            // Add foreign key constraint
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            
            // Add index for better query performance
            $table->index('company_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['company_id']);
            
            // Drop index
            $table->dropIndex(['company_id']);
            
            // Drop column
            $table->dropColumn('company_id');
        });
    }
};
