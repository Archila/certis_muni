<?php

use Illuminate\Database\Seeder;

use App\Models\Carrera;
use App\Models\Rol;
use App\Models\Persona;
use App\Models\TipoEmpresa;

use App\User;

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
        User::unguard();

        //Carreras
        Carrera::create(['id' => 1, 'nombre' => 'Ingeniería Civil', 'codigo'=>'33', 'prefijo'=>'CIVI']);
        Carrera::create(['id' => 2, 'nombre' => 'Ingeniería Mecánica', 'codigo'=>'34', 'prefijo'=>'MECA']);
        Carrera::create(['id' => 3, 'nombre' => 'Ingeniería Industrial', 'codigo'=>'35', 'prefijo'=>'INDU']);
        Carrera::create(['id' => 4, 'nombre' => 'Ingeniería Mecánica Industrial', 'codigo'=>'36', 'prefijo'=>'MECA-IN']);
        Carrera::create(['id' => 5, 'nombre' => 'Ingeniería en Ciencias y Sistemas', 'codigo'=>'37', 'prefijo'=>'SIST']);

        //Roles
        Rol::create(['id' => 1, 'nombre' => 'Administrador', 'descripcion'=>'Usuario con todos los privilegios', ]);
        Rol::create(['id' => 2, 'nombre' => 'Estudiante', 'descripcion'=>'Estudiante CUNOC', ]);
        Rol::create(['id' => 3, 'nombre' => 'Supervisor civil', 'descripcion'=>'Supervisor de prácticas de la carrera de Ingenieria Civil', ]);
        Rol::create(['id' => 4, 'nombre' => 'Supervisor mecánica', 'descripcion'=>'Supervisor de prácticas de la carrera de Ingenieria Mecánica', ]);
        Rol::create(['id' => 5, 'nombre' => 'Supervisor industrial', 'descripcion'=>'Supervisor de prácticas de la carrera de Ingenieria Industrial', ]);
        Rol::create(['id' => 6, 'nombre' => 'Supervisor mecánica-industrial', 'descripcion'=>'Supervisor de prácticas de la carrera de Ingenieria Mecánica-Industrial', ]);
        Rol::create(['id' => 7, 'nombre' => 'Supervisor sistemas', 'descripcion'=>'Supervisor de prácticas de la carrera de Ingeniería en ciencias y sistemas', ]);
        
        //Personas
        Persona::create(['id' => 1, 'nombre' => 'Administrador', 'apellido'=>'--', 'telefono'=>1, 'correo'=>'admin@kodsolutions.net' ]);

        //Usuario
        $user = new User();
        $user->name = 'Administrador';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('prueba123');
        $user->carne = 'admin';
        $user->persona_id = 1;
        $user->rol_id = 1;
        $user->save();

        //Tipos de empresa
        TipoEmpresa::create(['id' => 1, 'nombre' => 'Municipalidad', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 2, 'nombre' => 'Hospital/Centro de salud', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 3, 'nombre' => 'Constructora', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 4, 'nombre' => 'Minería', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 5, 'nombre' => 'Industria de Alimentos', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 6, 'nombre' => 'Industria textil', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 7, 'nombre' => 'Industria metalúrgica', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 8, 'nombre' => 'Consultoría', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 9, 'nombre' => 'Industria química/farmaceutica', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 10, 'nombre' => 'Tenería o peletería', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 11, 'nombre' => 'Industria automovilística', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 12, 'nombre' => 'Producción de energía', 'descripcion'=>'', ]);
        TipoEmpresa::create(['id' => 13, 'nombre' => 'Otro', 'descripcion'=>'', ]);
        
    }
}
