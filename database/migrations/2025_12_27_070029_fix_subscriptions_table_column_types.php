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
            // Change user_id from smallint to bigint to match users.id
            $table->unsignedBigInteger('user_id')->change();
            
            // Change transition_id from smallint to bigint to match transitions.id
            $table->unsignedBigInteger('transition_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->unsignedSmallInteger('user_id')->change();
            $table->unsignedSmallInteger('transition_id')->change();
        });
    }
};