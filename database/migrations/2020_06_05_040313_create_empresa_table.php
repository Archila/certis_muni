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
            $table->string('descripcion', 200)->nullable();
            $table->boolean('activo')->default(1);
            $table->timestamps();
        });

        Schema::create('empresa', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 200);
            $table->string('ubicacion', 100);
            $table->string('direccion', 100);
            $table->string('alias', 150)->nullable();
            $table->string('correo', 60);
            $table->string('telefono', 10);
            $table->string('contacto', 80)->nullable();
            $table->string('tel_contacto', 10)->nullable();
            $table->string('correo_contacto', 60)->nullable();
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
