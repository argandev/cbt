<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Agama;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(KelasSeeder::class);
        $this->call(AgamaSeeder::class);
        $this->call(SiswaSeeder::class);
        $this->call(JurusanSeeder::class);
        $this->call(MatpelSeeder::class);
    }
}
