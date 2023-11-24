<?php

namespace Database\Seeders;

use App\Models\Persona;
use App\Models\Role;
use App\Models\Sexo;
use App\Models\TipoDocumento;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sexo = Sexo::select('id')->where('codigo',1)->first()->id;

        $tipo_documento = TipoDocumento::select('id')->where('tipo','0')->first()->id;

        $role = Role::select('id')->where('slug','mesa')->first()->id;

        $persona1 = Persona::firstOrCreate([
            'tipo_documento_id' => $tipo_documento,
            'numero_documento' => '100100100100101',
            'nombres' => 'MESA 1',
            'apellido_paterno' => 'MESA 1',
            'apellido_materno' => 'MESA 1',
            'sexo_id' => $sexo,
        ]);

        $user1 = User::firstOrCreate([
            'persona_id' => $persona1->id,
            'name' => 'mesa01',
            'email' => 'mesa01@me.com',
            'password' => Hash::make('mesa01')
        ]);

        //enlazar el rol con el usuario
        $user1->roles()->sync([$role]);

        $persona2 = Persona::firstOrCreate([
            'tipo_documento_id' => $tipo_documento,
            'numero_documento' => '100100100100102',
            'nombres' => 'MESA 2',
            'apellido_paterno' => 'MESA 2',
            'apellido_materno' => 'MESA 2',
            'sexo_id' => $sexo,
        ]);

        $user2 = User::firstOrCreate([
            'persona_id' => $persona2->id,
            'name' => 'mesa02',
            'email' => 'mesa02@me.com',
            'password' => Hash::make('mesa02')
        ]);

        //enlazar el rol con el usuario
        $user2->roles()->sync([$role]);


        $persona3 = Persona::firstOrCreate([
            'tipo_documento_id' => $tipo_documento,
            'numero_documento' => '100100100100103',
            'nombres' => 'MESA 3',
            'apellido_paterno' => 'MESA 3',
            'apellido_materno' => 'MESA 3',
            'sexo_id' => $sexo,
        ]);

        $user3 = User::firstOrCreate([
            'persona_id' => $persona3->id,
            'name' => 'mesa03',
            'email' => 'mesa03@me.com',
            'password' => Hash::make('mesa03')
        ]);

        //enlazar el rol con el usuario
        $user3->roles()->sync([$role]);

        $persona4 = Persona::firstOrCreate([
            'tipo_documento_id' => $tipo_documento,
            'numero_documento' => '100100100100104',
            'nombres' => 'MESA 4',
            'apellido_paterno' => 'MESA 4',
            'apellido_materno' => 'MESA 4',
            'sexo_id' => $sexo,
        ]);

        $user4 = User::firstOrCreate([
            'persona_id' => $persona4->id,
            'name' => 'mesa04',
            'email' => 'mesa04@me.com',
            'password' => Hash::make('mesa04')
        ]);

        //enlazar el rol con el usuario
        $user4->roles()->sync([$role]);
    }
}
