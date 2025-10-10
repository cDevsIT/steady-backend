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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('initial_price', 10, 2)->default(0);
            $table->decimal('renewal_fee', 10, 2)->default(0);
            $table->decimal('transfer_fee', 10, 2)->default(0);
            $table->integer('renewal_period')->default(12); // in months
            $table->string('purchase_type')->default('direct'); // direct, funnel, both
            $table->boolean('is_active')->default(true);
            $table->boolean('is_renewable')->default(false);
            $table->boolean('auto_renewal')->default(false);
            $table->boolean('visible_on_funnel')->default(false);
            $table->boolean('is_transferable')->default(false);
            $table->boolean('requires_state_selection')->default(false);
            $table->boolean('requires_state_fees')->default(false);
            $table->boolean('is_for_address')->default(false);
            $table->unsignedBigInteger('last_updated_by')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'visible_on_funnel']);
            $table->index('is_renewable');
            $table->index('is_transferable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};