<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TipoAcceso;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $acceso_total = TipoAcceso::select('id')->where('slug','acceso-total')->first()->id;
        $acceso_parcial =TipoAcceso::select('id')->where('slug','acceso-parcial')->first()->id;
        $acceso_denegado =TipoAcceso::select('id')->where('slug','acceso-denegado')->first()->id;

        Role::firstOrCreate([ 'nombre' => 'Super Usuario', 'slug' => 'super-usuario','tipo_acceso_id'=> $acceso_total]);
        Role::firstOrCreate([ 'nombre' => 'Administrador', 'slug' => 'administrador','tipo_acceso_id'=> $acceso_parcial ]);
        Role::firstOrCreate([ 'nombre' => 'Secretaria', 'slug' => 'secretaria','tipo_acceso_id'=> $acceso_parcial ]);
        Role::firstOrCreate([ 'nombre' => 'Mesa', 'slug' => 'mesa','tipo_acceso_id'=> $acceso_parcial ]);
        Role::firstOrCreate([ 'nombre' => 'Invitado', 'slug' => 'invitado','tipo_acceso_id'=> $acceso_denegado ]);
    }
}
