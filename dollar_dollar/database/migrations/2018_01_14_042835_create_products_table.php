<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_no');
            $table->string('description');
            $table->tinyInteger('active')->default("1");
            $table->tinyInteger('web_status')->default("1");
            $table->string('division');
            $table->integer('price_list_usd_a');
            $table->integer('price_list_usd_b');
            $table->integer('price_list_usd_c');
            $table->integer('price_list_usd_d');
            $table->integer('price_list_usd_x');
            $table->integer('price_list_usd_y');
            $table->integer('price_list_sgd_a');
            $table->integer('price_list_sgd_b');
            $table->integer('price_list_sgd_c');
            $table->integer('price_list_sgd_d');
            $table->integer('price_list_sgd_x');
            $table->integer('price_list_sgd_y');
            $table->tinyInteger('promotion')->default("0");

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
        //
        Schema::drop("products");
    }
}
