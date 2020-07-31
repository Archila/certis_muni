<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupervisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supervisor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('profesion', 80)->nullable();
            $table->integer('colegiado');
            $table->unsignedBigInteger('persona_id');

            $table->timestamps();

            $table->foreign('persona_id')->references('id')->on('persona')
                                                        ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('estudiante', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_supervisor');
    
            $table->foreign('usuario_supervisor')->references('id')->on('users')
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
        Schema::table('estudiante', function (Blueprint $table) {
            $table->dropColumn('usuario_supervisor');
        });

        Schema::dropIfExists('supervisor');
    }
}
