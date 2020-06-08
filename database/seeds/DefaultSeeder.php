<?php

use Illuminate\Database\Seeder;

use App\Models\Carrera;

class DefaultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carrera::unguard();

        //Carreras
        Carrera::create(['id' => 1, 'nombre' => 'Ingeniería Civil', 'codigo'=>'33', 'prefijo'=>'CIVI']);
        Carrera::create(['id' => 2, 'nombre' => 'Ingeniería Mecánica', 'codigo'=>'34', 'prefijo'=>'MECA']);
        Carrera::create(['id' => 3, 'nombre' => 'Ingeniería Industrial', 'codigo'=>'35', 'prefijo'=>'INDU']);
        Carrera::create(['id' => 4, 'nombre' => 'Ingeniería Mecánica Industrial', 'codigo'=>'36', 'prefijo'=>'MECA-IN']);
        Carrera::create(['id' => 5, 'nombre' => 'Ingeniería en Ciencias y Sistemas', 'codigo'=>'37', 'prefijo'=>'SIST']);
    }
}
