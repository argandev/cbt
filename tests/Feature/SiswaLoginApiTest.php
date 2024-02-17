<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SiswaLoginApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_siswa_validation_passed(): void
    {
        $response = $this->post('api/v2/siswa/login',[
            'kode_peserta' => "poiuytrew3",
            'password' => "123"
        ]);
        $response->assertStatus(200);
    }
    public function test_siswa_validation_fails(): void
    {
        $response = $this->post('api/v2/siswa/login',[
            'kode_peserta' => "",
            'password' => "123"
        ]);
        $response->assertStatus(403);
    }
}
