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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('transition_id')->nullable();
            $table->date('order_date');
            $table->date('renewal_date')->nullable();
            $table->enum('service_type', ['free', 'half_yearly', 'yearly'])->default('yearly');
            $table->decimal('service_fee', 20, 2)->default(0.00);
            $table->decimal('renewal_fee', 20, 2)->default(0.00);
            $table->timestamps();

            // Foreign keys
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('transition_id')->references('id')->on('transitions')->onDelete('set null');

            // Indexes
            $table->index('service_id');
            $table->index('order_id');
            $table->index('user_id');
            $table->index('service_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
