<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterOficioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('oficio', function (Blueprint $table) {
            $table->integer('horas')->default(400);
            $table->string('institucion', 200)->default("en la empresa que usted dirige");            
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
            $table->dropColumn('horas');
            $table->dropColumn('institucion');
        });
    }
}
