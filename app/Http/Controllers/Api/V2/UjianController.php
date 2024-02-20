<?php

namespace App\Http\Controllers\Api\V2;

use App\Hellpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Repositories\JadwalRepository;
use App\Services\Jadwal\JadwalService;
use App\Services\SiswaUjianService;
use App\Services\TokenService;
use App\Services\Ujian\UjianService;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class UjianController extends Controller
{
    /**
     * Undocumented function
     *
     * @return void
     */
    public function jawabanSiswa(Siswa $siswa, Jadwal $jadwal)
    {
        return $siswa;
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param JadwalService $jadwalService
     * @param TokenService $tokenService
     * @param SiswaUjianService $siswaUjianService
     * @return void
     */
    public function konfirmasi(Request $request, JadwalService $jadwalService, TokenService $tokenService, SiswaUjianService $siswaUjianService) {
        /**
         * mendapatkan id siswa.
         */
        $jadwalID = $request->post('jadwal_id');
        $siswa = $request->get('siswa_data');
        if (!$siswa) {
            return ApiResponse::notFound('Sisa tidak di ketahui! Silahkan login kembali');
        }
        $jadwal = $jadwalService->findById($jadwalID);
        // cek apakah ada jadwal
        if (!$jadwalID && !$jadwal) {
            ApiResponse::badRequest("Jadwal tidak di temukan");
        }
        $pengaturanJadwal = $jadwalService->extractSettings($jadwal);
        //cek apakah token di aktifkan atau tidak
        if ($pengaturanJadwal && ($pengaturanJadwal['token'] && $pengaturanJadwal['token'] == true)) {
            //cek token yang di inputkan siswa dengan token yang ada databse
            $tokenChecked = $tokenService->cekToken($request->post('token'));
            if (!$tokenChecked) {
                return ApiResponse::notFound("Token tidak di temukan! Silahkan hubungi administrator atau pengawas");
            }
        }
        //cek dulu apakah ujian ini telah di selesaikan oleh siswa atau apakah ujian ini adalah lanjutan
        $ujianSiswa  = $siswaUjianService->statusUjian($jadwal, $siswa);
        if (!$ujianSiswa) {
            $siswaUjianService->ujianBaru($jadwal, $siswa);
        }
        return ApiResponse::accept("SUKSESS");
    }
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param JadwalService $jadwalService
     * @return void
     */
    public function getJawaban( Request $request, JadwalService $jadwalService )
    {
        $siswa = $request->get('siswa_data');
        $jadwalID = $request->jadwal_id;
        if ( !$jadwalID ) {
            return ApiResponse::badRequest("Missing ID jadwal");
        }
        $bankSoal = $jadwalService->jadwalHariIni();
        $jadwalFound = array_filter($bankSoal, function($item) use($jadwalID){
            if( Uuid::isValid($jadwalID) ) {
                return $item['bank_soal_id'] === $jadwalID;
            }
        });
        $jadwalFound = array_shift($jadwalFound);
        $bank_soal_id = $jadwalFound->bank_soal->id;
        //ambil dari bank soal
        return $bank_soal_id;

    }
}