<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            'kode_jurusan' => "RPL",
            'nama' => "Rekayasa Perangkat Lunak"
        ]);
        Jurusan::create([
            'kode_jurusan' => "RPL",
            'nama' => "Multimedia"
        ]);
        Jurusan::create([
            'kode_jurusan' => "TKJ",
            'nama' => "Teknik Komputer Dan Jaringan"
        ]);
    }
}
