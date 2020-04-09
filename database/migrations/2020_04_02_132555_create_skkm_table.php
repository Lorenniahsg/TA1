<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkkmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skkm', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->bigInteger('id_mhs')->unsigned();
            $table->float('skkm');
            $table->foreign('id_mhs')->references('dim_id')->on('dimx_dim')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skkm');
    }
}
