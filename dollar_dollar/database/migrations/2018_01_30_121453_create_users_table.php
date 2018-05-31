p<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->string('tel_phone')->nullable();
            $table->string('company')->nullable();
            $table->string('customer_code')->nullable();
            $table->string('contact_id')->nullable();
            $table->integer('price_list')->nullable();
            $table->longText('shipping_address')->nullable();
            $table->longText('billing_address')->nullable();
            $table->tinyInteger('web_login')->default("1");
            $table->tinyInteger('delete_status')->default("0");
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
