<?php

namespace Database\Seeders;

use App\Models\VueltaProceso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VueltaProcesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VueltaProceso::firstOrCreate(['nombre' => 'Primera Votación', 'abreviatura' => '1°  Votación']);
        VueltaProceso::firstOrCreate(['nombre' => 'Segunda Votación', 'abreviatura' => '2°  Votación']);
        VueltaProceso::firstOrCreate(['nombre' => 'Tercera Votación', 'abreviatura' => '3°  Votación']);
        VueltaProceso::firstOrCreate(['nombre' => 'Cuarta Votación', 'abreviatura' => '4°  Votación']);
        VueltaProceso::firstOrCreate(['nombre' => 'Quinta Votación', 'abreviatura' => '5°  Votación']);
        VueltaProceso::firstOrCreate(['nombre' => 'Sexta Votación', 'abreviatura' => '6°  Votación']);
    }
}
