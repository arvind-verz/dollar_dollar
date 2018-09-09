<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolTipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_tips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('salary')->nullable();
            $table->string('payment')->nullable();
            $table->string('spend')->nullable();
            $table->string('privilege')->nullable();
            $table->string('loan')->nullable();
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
        Schema::dropIfExists('tool_tips');
    }
}
