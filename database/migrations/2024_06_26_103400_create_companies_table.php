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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('user_id');
            $table->unsignedSmallInteger('transition_id')->nullable();
            $table->string("company_name");
            $table->string("business_type");
            $table->string("type_of_industry")->nullable();
            $table->integer("number_of_ownership");

            $table->string("package_name");
            $table->string("plan_street_address")->nullable();
            $table->string("plan_city")->nullable();
            $table->string("plan_state")->nullable();
            $table->string("plan_zip_code")->nullable();
            $table->string("plan_zip_country")->nullable();
            $table->date('incorporation_date')->nullable();
            $table->date('renewal_date')->nullable();

            $table->decimal("total_amount")->default(0.00);
            $table->unsignedSmallInteger('order_id')->nullable();
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
        Schema::dropIfExists('companies');
    }
};
