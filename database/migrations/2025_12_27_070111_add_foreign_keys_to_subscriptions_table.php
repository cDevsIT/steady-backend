<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            // Make transition_id nullable if it's not already
            $table->unsignedBigInteger('transition_id')->nullable()->change();
            
            // Add foreign key for user_id if it doesn't exist
            if (!$this->foreignKeyExists('subscriptions', 'subscriptions_user_id_foreign')) {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }
            
            // Add foreign key for transition_id if it doesn't exist
            if (!$this->foreignKeyExists('subscriptions', 'subscriptions_transition_id_foreign')) {
                $table->foreign('transition_id')->references('id')->on('transitions')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['transition_id']);
        });
    }

    /**
     * Check if a foreign key exists
     */
    private function foreignKeyExists(string $table, string $keyName): bool
    {
        $foreignKeys = DB::select(
            "SELECT CONSTRAINT_NAME 
             FROM information_schema.KEY_COLUMN_USAGE 
             WHERE TABLE_SCHEMA = ? 
             AND TABLE_NAME = ? 
             AND CONSTRAINT_NAME = ?",
            [DB::getDatabaseName(), $table, $keyName]
        );
        
        return count($foreignKeys) > 0;
    }
};