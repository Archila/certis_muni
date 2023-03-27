<?php

use Illuminate\Database\Seeder;

use App\Models\Rol;

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
        Rol::unguard();
        User::unguard();

        //Roles
        Rol::create(['id' => 1, 'nombre' => 'Administrador', 'descripcion'=>'CONTROL DE OBRAS JEFATURA', ]);
        Rol::create(['id' => 2, 'nombre' => 'Operador', 'descripcion'=>'CONTROL DE OBRAS OPERADOR', ]);
        Rol::create(['id' => 3, 'nombre' => 'Cliente', 'descripcion'=>'OTRAS DEPENDENCIAS', ]);
        Rol::create(['id' => 4, 'nombre' => 'Informatica', 'descripcion'=>'INFORMÁTICA', ]);
        

        //Usuario
        $user = new User();
        $user->name = 'Ricardo Mérida';
        $user->email = 'muni@gmail.com';
        $user->username = 'admin';
        $user->password = bcrypt('muniX3la');
        $user->rol_id = 1;
        $user->save();

        //Usuario
        $user = new User();
        $user->name = 'Ivan Esteban';
        $user->email = 'muni@gmail.com';
        $user->username = 'i_esteban';
        $user->password = bcrypt('prueba123');
        $user->rol_id = 2;
        $user->save();

        //Usuario
        $user = new User();
        $user->name = 'Cliente';
        $user->email = 'muni@gmail.com';
        $user->username = 'cliente';
        $user->password = bcrypt('prueba123');
        $user->rol_id = 3;
        $user->save();

        //Usuario
        $user = new User();
        $user->name = 'Informatica';
        $user->email = 'muni@gmail.com';
        $user->username = 'informatica';
        $user->password = bcrypt('prueba123');
        $user->rol_id = 4;
        $user->save();
        
    }
}
