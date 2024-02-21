<?php

namespace App\Http\Controllers\Api\V2;

use App\Enums\JenisSoal;
use App\Exceptions\DataTidakDitemukanException;
use App\Exceptions\InsertDataGagalException;
use App\Hellpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\Jadwal;
use App\Models\JawabanSiswa;
use App\Models\JawabanSoal;
use App\Models\Siswa;
use App\Models\Soal;
use App\Repositories\JadwalRepository;
use App\Services\Jadwal\JadwalService;
use App\Services\JawabanSiswaService;
use App\Services\SiswaUjianService;
use App\Services\SoalEsayService;
use App\Services\SoalPgServiceService;
use App\Services\SoalService;
use App\Services\TokenService;
use App\Services\Ujian\UjianService;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Mockery\Exception;
use PhpParser\Node\Stmt\TryCatch;
use PHPUnit\Framework\InvalidDataProviderException;
use Ramsey\Uuid\Uuid;
use Spatie\FlareClient\Api;

class UjianController extends Controller
{


    /**
     * @param Request $request
     * @param JadwalService $jadwalService
     * @param TokenService $tokenService
     * @param SiswaUjianService $siswaUjianService
     * @return HttpResponse
     * @throws \Throwable
     */
    public function konfirmasi(Request $request, JadwalService $jadwalService, TokenService $tokenService, SiswaUjianService $siswaUjianService) : \Illuminate\Http\Response {
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
        $pengaturanJadwal = $jadwal->setting;
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
     * @param Request $request
     * @param SoalService $soalService
     * @return HttpResponse
     */
    public function getJawaban( Request $request,SoalService $soalService, JawabanSiswaService $jawabanSiswaService)
    {

        $siswaID = $request->get('siswa_data')->id;
        $jadwalID = $request->get('jadwal_id');
        try {
            $soalService->giveSoals(
                $request->get('siswa_data'),
                $request->get('jadwal_id')
            );
            //setelah soal berhasil di berikan kepada siswa
            //ambil lagi data nya untuk di tampilkan

           $soal = $jawabanSiswaService->getJawaban(
                $jadwalID,
                $siswaID
            );

            return ApiResponse::acceptWithData(
                'suksess',
                $soal,
            );
        } catch (DataTidakDitemukanException|InsertDataGagalException $th) {
            return ApiResponse::badRequest($th->getMessage());
        } catch(\Throwable $e) {
            return ApiResponse::accept($e->getMessage());
        }


    }

}
