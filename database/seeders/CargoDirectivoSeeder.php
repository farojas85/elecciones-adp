<?php

namespace Database\Seeders;

use App\Models\CargoDirectivo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CargoDirectivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CargoDirectivo::firstOrCreate([ 'nombre' => 'Presidente(a)' ]);
        CargoDirectivo::firstOrCreate([ 'nombre' => 'Vice-Presidente(a)' ]);
        CargoDirectivo::firstOrCreate([ 'nombre' => 'Secretario(a)']);
        CargoDirectivo::firstOrCreate([ 'nombre' => 'Tesorero(a)']);
    }
}
