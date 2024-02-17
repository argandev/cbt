<?php

namespace Database\Factories;

use App\Models\Agama;
use App\Models\Kelas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jk = ['L','P'];
        shuffle($jk);
        return [
            'nama' => fake()->name(),
            'nis' =>fake()->unique()->numberBetween(0,1000000),
            'nisn' =>fake()->unique()->numberBetween(0,1000000),
            'jenis_kelamin' =>$jk[0],
            'kode_peserta' => rand(50,80).'-'.rand(1000,9700)."-".rand(10,20),
            'status' => true,
            'kelas_id' => Kelas::inRandomOrder()->first()->id,
            'agama_id' => Agama::inRandomOrder()->first()->id,
            'password' => Hash::make('123'),
        ];
    }
}
