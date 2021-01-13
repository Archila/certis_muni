<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('saludo', 100);
            $table->string('nombre', 300)->nullable();
            $table->string('ubicacion', 500)->nullable();
            $table->string('departamento', 100)->nullable();
            $table->string('autorizador', 100)->nullable();
            $table->string('responsable', 100)->nullable();
            $table->string('correo', 100)->nullable();
            $table->string('telefono', 10)->nullable();
            $table->string('coordinador', 100)->nullable();
            $table->string('curso', 150)->nullable();
            $table->string('codigo', 10)->nullable();
            $table->string('nota', 10)->nullable();
            $table->string('docente', 100)->nullable();
            $table->string('ruta_constancia', 300)->nullable();
            $table->string('ruta_certificacion', 300)->nullable();
            $table->string('ruta_cronograma', 300)->nullable();
            $table->string('ruta_carta', 300)->nullable();

            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')
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
        Schema::dropIfExists('solicitud');
    }
}
