<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EncargadoBitacoraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bitacora', function (Blueprint $table) {
            $table->date('encargado',100)->nullable();
            $table->string('correo', 100)->nullable();            
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
            $table->dropColumn('encargado');
            $table->dropColumn('correo');
        });
    }
}
