<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudianteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrera', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo', 10);
            $table->string('nombre', 60);
            $table->string('prefijo', 10);

            $table->timestamps();
        });

        Schema::create('estudiante', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo', 60)->nullable();
            $table->integer('semestre');
            $table->integer('year');
            $table->string('carne', 20);
            $table->string('registro', 20);
            $table->string('promedio', 6);
            $table->integer('creditos');
            $table->date('practicas');
            $table->boolean('activo')->default(0);
            $table->boolean('valido')->default(0);
            $table->unsignedBigInteger('persona_id');
            $table->unsignedBigInteger('carrera_id');

            $table->timestamps();

            $table->foreign('persona_id')->references('id')->on('persona')
                                                        ->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('carrera_id')->references('id')->on('carrera')
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
        Schema::dropIfExists('estudiante');

        Schema::dropIfExists('carrera');
    }
}
