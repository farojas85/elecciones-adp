<?php

namespace Database\Seeders;

use App\Models\CargoDirectivo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            SexoSeeder::class,
            TipoDocumentoSeeder::class,
            TipoAccesoSeeder::class,
            RoleSeeder::class,
            PersonaSeeder::class,
            MenuSeeder::class,
            PermisoSeeder::class,
            UbigeoSeeder::class,
            GradoMinisterialSeeder::class,
            AmbitoJuntaSeeder::class,
            CargoDirectivoSeeder::class,
            JuntaDirectivaSeeder::class,
            VueltaProcesoSeeder::class
        ]);
    }
}
