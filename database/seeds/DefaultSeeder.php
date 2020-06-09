<?php

use Illuminate\Database\Seeder;

use App\Models\Carrera;
use App\Models\Rol;
use App\Models\Persona;

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
        Rol::unguard();

        //Carreras
        Carrera::create(['id' => 1, 'nombre' => 'Ingeniería Civil', 'codigo'=>'33', 'prefijo'=>'CIVI']);
        Carrera::create(['id' => 2, 'nombre' => 'Ingeniería Mecánica', 'codigo'=>'34', 'prefijo'=>'MECA']);
        Carrera::create(['id' => 3, 'nombre' => 'Ingeniería Industrial', 'codigo'=>'35', 'prefijo'=>'INDU']);
        Carrera::create(['id' => 4, 'nombre' => 'Ingeniería Mecánica Industrial', 'codigo'=>'36', 'prefijo'=>'MECA-IN']);
        Carrera::create(['id' => 5, 'nombre' => 'Ingeniería en Ciencias y Sistemas', 'codigo'=>'37', 'prefijo'=>'SIST']);

        //Roles
        Rol::create(['id' => 1, 'nombre' => 'Administrador', 'descripcion'=>'Usuario con todos los privilegios', ]);
        Rol::create(['id' => 2, 'nombre' => 'Supervisor civil', 'descripcion'=>'Supervisor de prácticas de la carrera de Ingenieria Civil', ]);
        Rol::create(['id' => 3, 'nombre' => 'Supervisor mecánica', 'descripcion'=>'Supervisor de prácticas de la carrera de Ingenieria Mecánica', ]);
        Rol::create(['id' => 4, 'nombre' => 'Supervisor industrial', 'descripcion'=>'Supervisor de prácticas de la carrera de Ingenieria Industrial', ]);
        Rol::create(['id' => 5, 'nombre' => 'Supervisor mecánica-industrial', 'descripcion'=>'Supervisor de prácticas de la carrera de Ingenieria Mecánica-Industrial', ]);
        Rol::create(['id' => 6, 'nombre' => 'Supervisor sistemas', 'descripcion'=>'Supervisor de prácticas de la carrera de Ingeniería en ciencias y sistemas', ]);
        
        //Personas
        Persona::create(['id' => 1, 'nombre' => 'Administrador', 'apellido'=>'--', 'telefono'=>1, 'correo'=>'admin@kodsolutions.net' ]);

        //Usuario
        
    }
}
