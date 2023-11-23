<?php

namespace Database\Seeders;

use App\Models\AmbitoJunta;
use App\Models\JuntaDirectiva;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JuntaDirectivaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ambito_junta = AmbitoJunta::where('nombre','Junta Ejecutiva Regional')
                        ->select('id')->first()
        ;

        $junta_ejecutiva = JuntaDirectiva::firstOrCreate([
            'ambito_junta_id' => $ambito_junta->id,
            'nombre' => 'J.E.R. HUÁNUCO',
            'ubigeo' => '10',
            'es_activo' => 1
        ]);
    }
}
