<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 60);
            $table->string('descripcion', 150)->nullable();
            $table->unsignedBigInteger('empresa_id');

            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresa')
                                                        ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('area_encargado', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('area_id');
            $table->unsignedBigInteger('encargado_id');
            $table->string('puesto', 100);
            $table->timestamps();

            $table->foreign('area_id')->references('id')->on('area')
                                                        ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('encargado_id')->references('id')->on('encargado')
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
        Schema::dropIfExists('area_encargado');
        
        Schema::dropIfExists('area');
    }
}
