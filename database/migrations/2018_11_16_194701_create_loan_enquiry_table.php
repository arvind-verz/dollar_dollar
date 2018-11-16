<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanEnquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_enquiry', function (Blueprint $table) {
            $table->increments('id');
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('country_code')->nullable();
            $table->string('telephone')->nullable();
            $table->string('rate_type')->nullable();
            $table->string('property_type')->nullable();
            $table->string('loan_amount')->nullable();
            $table->string('loan_type')->nullable();
            $table->tinyInteger('delete_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_enquiry');
    }
}
