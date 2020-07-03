<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 30)->unique();
            $table->string('descripcion', 150)->nullable();

            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
          $table->unsignedBigInteger('rol_id')->default(1);
          $table->unsignedBigInteger('persona_id')->default(1);

          $table->foreign('rol_id')->references('id')->on('rol')
                                                      ->onDelete('cascade')->onUpdate('cascade');

          $table->foreign('persona_id')->references('id')->on('persona')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('rol_id');
            $table->dropColumn('persona_id');
        });

        Schema::dropIfExists('rol');
    }
}
