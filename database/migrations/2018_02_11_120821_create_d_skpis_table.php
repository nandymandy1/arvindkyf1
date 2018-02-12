<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDSkpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_skpis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('factory_id');
            $table->integer('no_load');
            $table->integer('no_line');
            $table->string('elo');
            $table->integer('so_pl');
            $table->integer('no_sew_mcs');
            $table->integer('no_people');
            $table->integer('no_help');
            $table->integer('no_kaja');
            $table->integer('no_opr');
            $table->integer('sam');
            $table->integer('no_send');
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
        Schema::dropIfExists('d_skpis');
    }
}
