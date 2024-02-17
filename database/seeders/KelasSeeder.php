<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kaelas = [
            [
                'nama' => "X",
                'parent_id' => null,
            ],
            [
                'nama' => "XI",
                'parent_id' => null,
            ],
            [
                'nama' => "XII",
                'parent_id' => null,
            ],
            [
                'nama' => "X-RPL 10",
                'parent_id' => 1,
            ],



        ];
        foreach ($kaelas as $key => $value) {
            Kelas::create($value);
        }

    }
}
