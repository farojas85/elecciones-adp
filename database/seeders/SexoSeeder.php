<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Sexo;

class SexoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sexo::firstOrCreate(['codigo' => 1,'nombre' => 'Masculino' ]);
        Sexo::firstOrCreate(['codigo' => 2,'nombre' => 'Femenino' ]);
    }
}
