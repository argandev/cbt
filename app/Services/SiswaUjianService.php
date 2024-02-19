<?php

namespace App\Services;

use App\Enums\UjianSiswa;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\SiswaUjian;

/**
 * dadandev.
 *
 * @class SiswaUjianService
 */
final class SiswaUjianService
{
    public function statusUjian(Jadwal $jadwal, Siswa $siswa): ?SiswaUjian{
        $jadwalID = $jadwal->id;
        $siswaID = $siswa->id;
        return SiswaUjian::where([
             'siswa_id' => $siswaID,
             'jadwal_id' => $jadwalID,
         ])->first();
    }
    // service body
    /**
     * Undocumented function
     *
     * @param Jadwal $jadwal
     * @param Siswa $siswa
     * @return SiswaUjian|null
     */
    public function statusProgress(Jadwal $jadwal, Siswa $siswa) : bool
    {
        $statusUjian = $this->statusUjian($jadwal,$siswa);
        if ( $statusUjian && $statusUjian->status_ujian === UjianSiswa::PROGRESS) {
            return true;
        }
        return false;
    }

    /**
     * Undocumented function
     *
     * @param Jadwal $jadwal
     * @param Siswa $siswa
     * @return void
     */
    public function ujianBaru(Jadwal $jadwal, Siswa $siswa) : ?SiswaUjian
    {
        try {
           return SiswaUjian::create([
                'siswa_id' => $siswa->id,
                'jadwal_id' => $jadwal->id,
                'waktu_start' => now(),
                'waktu_end' => null,
                'sisa_waktu' => null,
                'status_ujian' => UjianSiswa::PROGRESS,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
