<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Services\Jadwal\JadwalService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JadwalController extends Controller
{
    /**
     * @param Request $request
     * @param JadwalService $jadwalService
     * @return Response
     */
    public function detail_jadwal(Request $request, JadwalService $jadwalService) : Response
    {
        $siswa = $request->get('siswa_data');
        $jadwal_id = $request->jadwal_id;
        if (is_null($jadwal_id)) {
            return response([
                'error' => true,
                'message' => "Gagal mendapatkan data",
                'data' => [],
            ], 401, [
                'Content-Type:application/json'
            ]);
        }
        $jadwal = $jadwalService->getJadwalById($jadwal_id);
        /**
         * cek apakah jadwal ujian hari ini atau tidak
         */
        $cekJadwal = strtotime($jadwal->tanggal_mulai) == strtotime(now()->format('Y-m-d'));
        if (!$jadwal || !$cekJadwal) {
            return response([
                'error' => true,
                'message' => "Jadwal tidak di temukan",
                'data' => [],
            ], 403, [
                'Content-Type:application/json'
            ]);
            //cek apakah siswa terjadwal di ujian
        } else if (!$jadwalService->terdaftarDiJadwal($jadwal, $siswa)) {
            return response([
                'error' => true,
                'message' => "Anda tidak terdaftar di jadwal",
                'data' => [],
            ], 403, [
                'Content-Type:application/json'
            ]);
        }
        return response([
            'error' => false,
            'message' => "Berhasil mendapatkan detail jadwal",
            'data' => $jadwalService->jadwalDetail($jadwal_id),
        ], 200, [
            'Content-Type:application/json'
        ]);
    }
    /**
     * Undocumented function
     *
     * @param JadwalService $jadwalService
     * @return Response
     */
    public function getJadwal(JadwalService $jadwalService): Response
    {
        $jadwals = $jadwalService->jadwalHariIni();
        $jadwal = [];
        foreach ($jadwals as $item) {
            $jadwal[] = [
                'id' => $item->id,
                'nama' => $item->nama,
                'tanggal' => $item->tanggal_mulai,
                'waktu' => $item->waktu_mulai,
                'durasi' => $item->lama_ujian,
            ];
        }
        return response([
            'error' => false,
            'message' => "Berhasil mendapatkan data",
            'data' => $jadwal,
        ], 200, [
            'Content-Type:application/json'
        ]);
    }
}