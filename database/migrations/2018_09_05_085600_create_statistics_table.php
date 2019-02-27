<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_team')->unsigned();
            $table->integer('points')->default(NULL);
            $table->integer('matches')->default(NULL);
            $table->integer('golas_scored')->default(NULL);
            $table->integer('goals_lost')->default(NULL);
            $table->timestamps();

            $table->foreign('id_team')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics');
    }
}
