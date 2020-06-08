<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_empresa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 60);
            $table->boolean('activo')->default(1);
            $table->timestamps();
        });

        Schema::create('empresa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 60);
            $table->string('direccion', 100);
            $table->string('alias', 60)->nullable();
            $table->string('correo', 30);
            $table->string('telefono', 10);
            $table->string('contacto', 60)->nullable();
            $table->string('tel_contacto', 10)->nullable();
            $table->string('correo_contacto', 30)->nullable();
            $table->string('ubicacion_x', 15)->nullable();
            $table->string('ubiacion_y', 15)->nullable();
            $table->string('calificacion', 15)->nullable();
            $table->boolean('publico')->default(0);
            $table->boolean('valido')->default(0);
            $table->unsignedBigInteger('tipo_empresa_id');
            $table->unsignedBigInteger('usuario_id');

            $table->timestamps();

            $table->foreign('tipo_empresa_id')->references('id')->on('tipo_empresa')
                                                        ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('empresa');

        Schema::dropIfExists('tipo_empresa');
    }
}
