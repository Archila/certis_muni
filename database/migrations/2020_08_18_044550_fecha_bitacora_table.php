<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FechaBitacoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bitacora', function (Blueprint $table) {
            $table->date('fecha_inicio')->nullable();
            $table->string('puesto', 100)->nullable();            
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bitacora', function (Blueprint $table) {
            $table->dropColumn('fecha_inicio');
            $table->dropColumn('puesto');
        });
    }
}
