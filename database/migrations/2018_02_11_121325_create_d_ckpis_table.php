<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDCkpisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_ckpis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('factory_id');
            $table->integer('cut_qty');
            $table->string('consumption');
            $table->integer('people');
            $table->integer('pcs_sew_emb');
            $table->integer('c_men');
            $table->integer('mcs_used');
            $table->integer('no_bandkife');
            $table->integer('no_stknife');
            $table->integer('no_fusing');
            $table->integer('fusing_out');
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
        Schema::dropIfExists('d_ckpis');
    }
}
