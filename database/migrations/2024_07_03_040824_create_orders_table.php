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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('user_id');
            $table->unsignedSmallInteger('company_id');
            $table->unsignedSmallInteger('transition_id')->nullable();
            $table->string("state_name");
            $table->decimal("state_filing_fee", 20, 2)->default(0.00);
            $table->string("package_name");
            $table->decimal("package_amount", 20, 2)->default(0.00);
            $table->text("package_file")->nullable();


            $table->boolean("has_en")->default(0);
            $table->decimal("en_amount", 20, 2)->default(0.00);
            $table->text("en_file")->nullable();
            $table->text("ein_number")->nullable();

            $table->boolean("has_agreement")->default(0);
            $table->decimal("agreement_amount", 20, 2)->default(0.00);
            $table->text("agreement_file")->nullable();

            $table->boolean("has_processing")->default(0);
            $table->decimal("processing_amount", 20, 2)->default(0.00);
            $table->text("processing_file")->nullable();

            $table->decimal("total_amount")->default(0.00);
            $table->string("status")->default("pending");
            $table->string("payment_status")->default("unpaid")->comment('unpaid','paid');


            $table->date('incorporation_date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->date('business_filing_date')->nullable();
            $table->string('compliance_status')->default("active");
            $table->string('name_availability_search_status')->default("pending");
            $table->string('state_filing_status')->default("pending");
            $table->string('setup_business_address_status')->default("pending");
            $table->string('mail_forwarding_status')->default("pending");
            $table->string('ein_filing_status')->default("pending");
            $table->string('operating_agreement_status')->default("pending");
            $table->string('complete_status')->default("pending");





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
