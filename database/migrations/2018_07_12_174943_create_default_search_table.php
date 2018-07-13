<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDefaultSearchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_search', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('promotion_id');
            $table->integer('placement');
            $table->integer('salary');
            $table->integer('payment');
            $table->integer('spend');
            $table->integer('wealth');
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
        Schema::dropIfExists('default_search');
    }
}
