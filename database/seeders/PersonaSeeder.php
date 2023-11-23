<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\Sexo;
use App\Models\TipoDocumento;
use App\Models\Role;
use App\Models\Persona;
use App\Models\User;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sexo = Sexo::select('id')->where('codigo',1)->first()->id;

        $tipo_documento = TipoDocumento::select('id')->where('tipo','0')->first()->id;

        $role = Role::select('id')->where('slug','super-usuario')->first()->id;

        $persona = Persona::firstOrCreate([
            'tipo_documento_id' => $tipo_documento,
            'numero_documento' => '100100100100100',
            'nombres' => 'ADMIN',
            'apellido_paterno' => 'MASTER',
            'apellido_materno' => 'MASTER',
            'sexo_id' => $sexo,
        ]);

        $user = User::firstOrCreate([
            'persona_id' => $persona->id,
            'name' => 'admin',
            'email' => 'admin@me.com',
            'password' => Hash::make('123456789')
        ]);

        //enlazar el rol con el usuario
        $user->roles()->sync([$role]);
    }
}
