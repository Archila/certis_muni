<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBitacoraFolioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('oficio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('destinatario', 80);
            $table->string('puesto', 80)->nullable();
            $table->string('encabezado', 80);
            $table->string('curso', 200)->nullable();
            $table->string('codigo_curso', 15)->nullable();
            $table->date('f_oficio')->nullable();
            $table->string('no_oficio')->nullable();
            //Solicitud
            $table->date('f_solicitud')->nullable();
            $table->integer('semestre');
            $table->integer('year');
            $table->integer('tipo');
            $table->boolean('aprobado')->default(0);
            $table->boolean('rechazado')->default(0);
            //Empresa
            $table->string('empresa', 200);
            $table->string('direccion', 150);
            $table->string('ubicacion', 150);
            //Estudiante
            $table->string('estudiante', 150);
            $table->string('registro', 10);
            $table->string('carne', 15);
            $table->string('cargo_encargado', 50)->nullable();
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('empresa_id');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')
                                                        ->onDelete('cascade')->onUpdate('cascade');
            
            $table->foreign('empresa_id')->references('id')->on('empresa')
                                                        ->onDelete('cascade')->onUpdate('cascade');
            
        });


        Schema::create('bitacora', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 200);
            $table->string('horas', 6)->default(0);
            $table->date('f_aprobacion')->nullable();
            $table->boolean('valida')->default(0);
            $table->string('codigo')->nullable();
            $table->unsignedBigInteger('oficio_id');
            $table->unsignedBigInteger('encargado_id');

            $table->timestamps();

            $table->unique('oficio_id');
            $table->foreign('oficio_id')->references('id')->on('oficio')
                                                        ->onDelete('cascade')->onUpdate('cascade');
            
            $table->foreign('encargado_id')->references('id')->on('encargado')
                                                        ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('folio', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numero');
            $table->date('fecha_inicial');
            $table->date('fecha_final');
            $table->string('horas', 6);
            $table->text('descripcion');
            $table->text('observaciones')->nullable();
            $table->boolean('revisado')->default(0);
            $table->unsignedBigInteger('bitacora_id');

            $table->timestamps();

            $table->foreign('bitacora_id')->references('id')->on('bitacora')
                                                        ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('revision', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('numero');
            $table->integer('folio_inicial');
            $table->integer('folio_final');
            $table->string('horas', 6);
            $table->text('observaciones')->nullable();
            $table->date('fecha');
            $table->string('ponderacion', 6);
            $table->unsignedBigInteger('bitacora_id');

            $table->timestamps();

            $table->foreign('bitacora_id')->references('id')->on('bitacora')
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
        Schema::dropIfExists('revision');

        Schema::dropIfExists('folio');

        Schema::dropIfExists('bitacora');

        Schema::dropIfExists('oficio');
    }
}
