<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Services\LoginService;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function __construct(
        public LoginService $loginService = new LoginService(),
    ) {
    }

    public function me(Request $request){
        $data = $request->get('siswa_data');
        return response([
            'error' => false,
            'message' => "Berhasil mendapatakan data",
            'data' => $data,
        ],200);
    }
    public function login(Request $request)
    {
        /**
         * proses login
         */
        $data = $this->loginService->loginSiswa($request->only(['kode_peserta', 'password']));
        /**
         * cek jika data nya ada data user
         * siswa berhasil login
         */
        if (isset($data['user']) && !isset($data['errors'])) {
            return response([
                'error' => false,
                'message' => 'Login Berhasil',
                'data' => $data['user'],
            ], 200);
        }else{
            return response([
                'error' => true,
                'message' => 'Login gagal Username atau password salah',
                'errors' => $data['errors'] ?? []
            ], 403,[
                'Content-Type:application/json',
            ]);
        }

    }
}
