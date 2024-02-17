<?php

namespace Tests\Feature;

use App\Services\LoginService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ValidationServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_validation_success(): void
    {
        $data = [
            'kode_peserta' => "098765QWER",
            'password' => '123',
        ];
        $loginService = new LoginService();
        $validation = $loginService->validasi($data);
        var_dump($validation);
        $this->assertTrue($validation);
    }
    public function test_validation_fails(): void
    {
        $data = [
            'kode_peserta' => "",
            'password' => '123',
        ];
        $loginService = new LoginService();
        $validation = $loginService->validasi($data);
        $this->assertIsArray($validation->messages());
    }
}
