<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEncargadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encargado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('profesion', 60);
            $table->string('puesto', 100);
            $table->string('colegiado', 20)->nullable();
            $table->unsignedBigInteger('persona_id');

            $table->timestamps();

            $table->foreign('persona_id')->references('id')->on('persona')
                                                        ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('encargado');
    }
}
