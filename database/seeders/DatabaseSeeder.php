<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\chofer;
use App\Models\clientes;
use App\Models\PedimentoA1;
use App\Models\PedimentoRT;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        clientes::factory(25)->create();
        chofer::factory(25)->create();
        PedimentoRT::factory(25)->create();
        PedimentoA1::factory(25)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
