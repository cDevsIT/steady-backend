<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_renew_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('order_id')->nullable();
            $table->unsignedSmallInteger('company_id')->nullable();
            $table->unsignedSmallInteger('user_id_id')->nullable();
            $table->unsignedSmallInteger('transition_id')->nullable();
            $table->decimal("total_amount")->default(0.00);
            $table->string("status")->default("pending");
            $table->string("payment_status")->default("unpaid")->comment('unpaid','paid');
            $table->unsignedSmallInteger('createdBy')->nullable();
            $table->unsignedSmallInteger('updatedBy')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
