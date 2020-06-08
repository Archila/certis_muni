<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 60);
            $table->string('descripcion', 150)->nullable();
            $table->unsignedBigInteger('empresa_id');

            $table->timestamps();

            $table->foreign('empresa_id')->references('id')->on('empresa')
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
        Schema::dropIfExists('actividad');
    }
}
