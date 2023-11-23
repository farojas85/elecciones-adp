<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TipoAcceso;

class TipoAccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoAcceso::firstOrCreate([ 'nombre' => 'Acceso Total','slug' => 'acceso-total']);
        TipoAcceso::firstOrCreate([ 'nombre' => 'Acceso Parcial','slug' => 'acceso-parcial']);
        TipoAcceso::firstOrCreate([ 'nombre' => 'Acceso Denegado','slug' => 'acceso-denegado']);
    }
}
