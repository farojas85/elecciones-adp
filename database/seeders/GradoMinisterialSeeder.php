<?php

namespace Database\Seeders;

use App\Models\GradoMinisterial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradoMinisterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GradoMinisterial::firstOrCreate(['nombre' => 'Ministro Principiante']);
        GradoMinisterial::firstOrCreate(['nombre' => 'Ministro Regional']);
        GradoMinisterial::firstOrCreate(['nombre' => 'Ministro Licenciado']);
        GradoMinisterial::firstOrCreate(['nombre' => 'Ministro Ordenado']);
    }
}
