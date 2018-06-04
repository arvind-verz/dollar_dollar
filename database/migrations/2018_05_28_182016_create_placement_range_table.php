<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacementRangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('placement_range', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->nullable();
            $table->double('min_placement_range')->nullable();
            $table->double('max_placement_range')->nullable();
            $table->tinyInteger('delete_status')->default("0");
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
        Schema::dropIfExists('placement_range');
    }
}
