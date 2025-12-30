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
        Schema::table('register_agent_information', function (Blueprint $table) {
            // Add user_id after order_id
            $table->unsignedBigInteger('user_id')->nullable()->after('order_id');
            
            // Add agent_type after user_id
            $table->enum('agent_type', ['individual', 'company'])->nullable()->after('user_id');
            
            // Add foreign key constraint for user_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Add index for better query performance
            $table->index('user_id');
            $table->index('agent_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('register_agent_information', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['user_id']);
            
            // Drop indexes
            $table->dropIndex(['user_id']);
            $table->dropIndex(['agent_type']);
            
            // Drop columns
            $table->dropColumn('user_id');
            $table->dropColumn('agent_type');
        });
    }
};
