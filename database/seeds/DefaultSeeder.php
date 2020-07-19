<?php

use Illuminate\Database\Seeder;

use App\Models\Carrera;
use App\Models\Rol;
use App\Models\Persona;
use App\Models\TipoEmpresa;
use App\Models\Estudiante;
use App\Models\Supervisor;

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
        Persona::create(['id' => 2, 'nombre' => 'Jose Ricardo', 'apellido'=>'Merida Lopez', 'telefono'=>45454545, 'correo'=>'merida@gmail.com' ]);
        Persona::create(['id' => 3, 'nombre' => 'Eddie Omar', 'apellido'=>'Flores Aceituno', 'telefono'=>45454545, 'correo'=>'eddie@kodsolutions.net' ]);
        Persona::create(['id' => 4, 'nombre' => 'Ivan Alejandro', 'apellido'=>'Esteban Archila', 'telefono'=>984686512, 'correo'=>'ivancorrero@gmail.com' ]);
        Persona::create(['id' => 5, 'nombre' => 'Jonathan Gustavo', 'apellido'=>'Chavez Barreno', 'telefono'=>78965482, 'correo'=>'jonathan@gmail.com' ]);
        Persona::create(['id' => 6, 'nombre' => 'Pablo Saul', 'apellido'=>'Coyoy Ixquiac', 'telefono'=>499485115, 'correo'=>'pablo@gmail.com' ]);
        Persona::create(['id' => 7, 'nombre' => 'Gerson Jose', 'apellido'=>'Ochoa Lopez', 'telefono'=>79548214, 'correo'=>'gerson@gmail.com' ]);
        Persona::create(['id' => 8, 'nombre' => 'Josue Javier', 'apellido'=>'Cayax Ralda', 'telefono'=>68457178, 'correo'=>'cayax@gmail.com' ]);

        //Estudiantes
        Estudiante::create(['id' => 1, 'semestre'=>2, 'year'=>'2020', 'registro'=>'201330001', 'carne'=>'26003000101001', 'promedio'=>'75.5', 'creditos'=>220, 'direccion'=>'Zona 1 12-5 Xela', 'practicas'=>'2020-05-05', 'persona_id'=>4, 'carrera_id'=>4 ]);
        Estudiante::create(['id' => 2, 'semestre'=>2, 'year'=>'2020', 'registro'=>'201330002', 'carne'=>'26003000101001', 'promedio'=>'75.5', 'creditos'=>220, 'direccion'=>'Zona 3 2-5 Xela', 'practicas'=>'2020-05-05', 'persona_id'=>5, 'carrera_id'=>4 ]);
        Estudiante::create(['id' => 3, 'semestre'=>2, 'year'=>'2020', 'registro'=>'201330003', 'carne'=>'26003000101001', 'promedio'=>'75.5', 'creditos'=>220, 'direccion'=>'Zona 2 11-5 Xela', 'practicas'=>'2020-05-05', 'persona_id'=>6, 'carrera_id'=>4 ]);
        Estudiante::create(['id' => 4, 'semestre'=>2, 'year'=>'2020', 'registro'=>'201330004', 'carne'=>'26003000101001', 'promedio'=>'75.5', 'creditos'=>220, 'direccion'=>'Zona 3 15-2 Huehue', 'practicas'=>'2020-05-05', 'persona_id'=>7, 'carrera_id'=>1 ]);
        Estudiante::create(['id' => 5, 'semestre'=>2, 'year'=>'2020', 'registro'=>'201330005', 'carne'=>'26003000101001', 'promedio'=>'75.5', 'creditos'=>220, 'direccion'=>'Zona 7 21-7 Xela', 'practicas'=>'2020-05-05', 'persona_id'=>8, 'carrera_id'=>1 ]);

        //Supervisor
        Supervisor::create(['id' => 1, 'profesion'=>'Ingeniero Civil', 'colegiado'=>'202015255', 'persona_id'=>2, ]);
        Supervisor::create(['id' => 2, 'profesion'=>'Ingeniero Mecanico Industrial', 'colegiado'=>'20205424', 'persona_id'=>3, ]);

        //Usuario
        $user = new User();
        $user->name = 'Administrador';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('prueba123');
        $user->carne = 'admin';
        $user->persona_id = 1;
        $user->rol_id = 1;
        $user->save();

        //Usuario
        $user = new User();
        $user->name = 'Ricardo Merida';
        $user->email = 'merida@gmail.com';
        $user->password = bcrypt('prueba123');
        $user->carne = 'ricardo';
        $user->persona_id = 2;
        $user->rol_id = 3;
        $user->save();

        //Usuario
        $user = new User();
        $user->name = 'Eddie Flores';
        $user->email = 'eddie@gmail.com';
        $user->password = bcrypt('prueba123');
        $user->carne = 'eddie';
        $user->persona_id = 3;
        $user->rol_id = 6;
        $user->save();

        //Usuario
        $user = new User();
        $user->name = 'Ivan Esteban';
        $user->email = 'ivan@gmail.com';
        $user->password = bcrypt('prueba123');
        $user->carne = 'ivan';
        $user->persona_id = 4;
        $user->rol_id = 2;
        $user->save();

        //Usuario
        $user = new User();
        $user->name = 'Jonathan Chavez';
        $user->email = 'jonathan@gmail.com';
        $user->password = bcrypt('prueba123');
        $user->carne = 'jonathan';
        $user->persona_id = 5;
        $user->rol_id = 2;
        $user->save();

        //Usuario
        $user = new User();
        $user->name = 'Pablo Coyoy';
        $user->email = 'pablo@gmail.com';
        $user->password = bcrypt('prueba123');
        $user->carne = 'pablo';
        $user->persona_id = 6;
        $user->rol_id = 2;
        $user->save();

        //Usuario
        $user = new User();
        $user->name = 'Gerson Ochoa';
        $user->email = 'gerson@gmail.com';
        $user->password = bcrypt('prueba123');
        $user->carne = 'gerson';
        $user->persona_id = 7;
        $user->rol_id = 2;
        $user->save();

        //Usuario
        $user = new User();
        $user->name = 'Josue Cayax';
        $user->email = 'cayax@gmail.com';
        $user->password = bcrypt('prueba123');
        $user->carne = 'cayax';
        $user->persona_id = 8;
        $user->rol_id = 2;
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
