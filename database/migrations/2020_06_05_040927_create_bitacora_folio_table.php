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
        Schema::create('bitacora', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('horas', 6)->default(0);
            $table->integer('semestre');
            $table->integer('year');
            $table->integer('tipo');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('empresa_id');
            $table->unsignedBigInteger('encargado_id');

            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')
                                                        ->onDelete('cascade')->onUpdate('cascade');
            
            $table->foreign('empresa_id')->references('id')->on('empresa')
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
    }
}
