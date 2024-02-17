<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Agama::create([
            'nama' => "Islam",
            'kode_agama' => "ISLAM",
        ]);
        Agama::create([
            'nama' => "Kristen",
            'kode_agama' => "KRISTEN",
        ]);
        Agama::create([
            'nama' => "Hindu",
            'kode_agama' => "Hindu",
        ]);

    }
}
