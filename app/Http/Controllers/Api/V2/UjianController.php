<?php

namespace App\Http\Controllers\Api\V2;

use App\Hellpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Repositories\JadwalRepository;
use App\Services\Jadwal\JadwalService;
use App\Services\TokenService;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    public function konfirmasi(Request $request,
     JadwalService $jadwalService,
     TokenService $tokenService
     ){
        /**
         * mendapatkan id siswa.
         */
        $id_jadwal = $request->post('jadwal_id');
        $siswa = $request->get('siswa_data');
        if (!$siswa) {
            return ApiResponse::notFound('Sisa tidak di ketahui! Silahkan login kembali');
        }
        // cek apakah ada jadwal
        if (!$id_jadwal && !$jadwalService->findById($id_jadwal)) {
            ApiResponse::badRequest("Jadwal tidak di temukan");
        }
        $pengaturanJadwal = $jadwalService->extractSettings($id_jadwal);
        //cek apakah token di aktifkan atau tidak
        if( $pengaturanJadwal && ($pengaturanJadwal['token'] && $pengaturanJadwal['token'] == true)) {
            //cek token yang di inputkan siswa dengan token yang ada databse
           $tokenChecked = $tokenService->cekToken( $request->post('token') );
           if ( !$tokenChecked ) {
               return ApiResponse::notFound("Token tidak di temukan! Silahkan hubungi administrator atau pengawas");
           }
        }
    }
}
