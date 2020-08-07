<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('persona', 100);
            $table->string('accion', 240);
            $table->boolean('revisado')->default(0);
            $table->string('ruta', 100);
            $table->integer('elemento_id');
            $table->timestamps();
        });

        Schema::table('oficio', function (Blueprint $table) {
            $table->boolean('revisado')->default(0);
            $table->string('ruta_pdf', 100)->nullable();            
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('oficio', function (Blueprint $table) {
            $table->dropColumn('revisado');
            $table->dropColumn('ruta_pdf');
        });

        Schema::dropIfExists('notificaciones');
    }
}
