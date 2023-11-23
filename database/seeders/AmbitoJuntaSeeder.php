<?php

namespace Database\Seeders;

use App\Models\AmbitoJunta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AmbitoJuntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AmbitoJunta::firstOrCreate([ 'nombre' => 'Junta Directiva Nacional' ]);
        AmbitoJunta::firstOrCreate([ 'nombre' => 'Junta Ejecutiva Regional' ]);
        AmbitoJunta::firstOrCreate([ 'nombre' => 'Junta Directiva Sectorial']);
    }
}
