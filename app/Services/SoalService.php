<?php

namespace App\Services;

use App\Exceptions\BankSoalTidakAktifException;
use App\Exceptions\InsertDataGagalException;
use App\Exceptions\JadwalTidakDiTemukanException;
use App\Models\JawabanSiswa;
use App\Models\Siswa;
use App\Models\Soal;
use App\Services\Jadwal\JadwalService;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

/**
 * dadandev
 * @class SoalService
 */
final class SoalService
{
    public SoalPgServiceService $pgServiceService;
    public SoalEsayService $soalEsayService;
    public JadwalService $jadwalService;
    public JawabanSiswaService $jawabanSiswaService;
    public function __construct()
    {
        $this->pgServiceService = new SoalPgServiceService();
        $this->jadwalService = new JadwalService();
        $this->soalEsayService = new SoalEsayService();
        $this->jawabanSiswaService = new JawabanSiswaService();
    }

    //service body

    public function findSoalById(string|array $soal_id)
    {
        $soal = [];
        if ( is_array($soal_id) ) {
            $soal = Soal::whereIn('id',$soal_id);
        } else{
            $soal = Soal::where('id',$soal_id);
        }
        $soal->get();
    }

    /**
     * @throws BankSoalTidakAktifException
     * @throws JadwalTidakDiTemukanException
     * @throws InsertDataGagalException
     */
    public function giveSoals(Siswa $siswa, string $jadwalID): mixed
    {
        /**
         * mengambil jadwal aktif hari ini
         */
        $jadwals = $this->jadwalService->jadwalHariIni();
        /**
         * cocokan id jadwal aktif tersedia dan ambil sesuai dengan parameter yang di ambil
         * dari frontend
         */
        $jadwalFound = array_filter($jadwals, function ($item) use ($jadwalID) {
            return $item['id'] === $jadwalID;
        });
        if(!$jadwalFound) throw new JadwalTidakDiTemukanException("Jadwal tidak di temukan");
        //ambil yang coock nya jadi array asosiatif
        $jadwalFound = array_shift($jadwalFound);
        //cek apakah bank soal aktif atau tidak
        if ($jadwalFound->bank_soal->aktif == 0) {
          throw new BankSoalTidakAktifException("Bank soal tidak aktif");
        }
        /**
         * bank soal dari jadwal
         */
        $bankSoal = $jadwalFound->bank_soal;
        $bank_soal_id = $bankSoal->id;
        //pengaturan jadwal
        $setting = $jadwalFound->setting;
        //mengambil jadwaban siswa dari database

        $jawabanSiswa = $this->jawabanSiswaService->findByJadwalAndSiswa($jadwalID, $siswa->id);
        /**
         * jika jawaban siswa tidak ada soal akan di berikan kepada siswa
         * ini membagi soal acak kepada siswa
         * misal pg berapa, esay berapa
         */

        if (!$jawabanSiswa) {
            /**
             * soal 30 soal
             * Bobot nya pg 50%
             *           esay 30
             *           pg 20
             * Maka kita hitung yang muncul di ujian ada berapa soal
             * dengan rumus PG( 50% * 30 )
             */
            $jumlahSoalPg = ((intval($bankSoal->bobot['pilihan_ganda']) / 100) * $bankSoal->jumlah_soal);
            //jumlah soal esay
            $jumlahSoalEsay = ((intval($bankSoal->bobot['esay']) / 100) * $bankSoal->jumlah_soal);
            //jumlah soal pg
            $jumlahIsianSingkat = ((intval($bankSoal->bobot['isian_singkat']) / 100) * $bankSoal->jumlah_soal);
            //soal pg
            $soalPG = $this->pgServiceService->getSoal($bank_soal_id, $setting['acak_soal'], $jumlahSoalPg, $setting['acak_opsi']);
            $soalEssay = $this->soalEsayService->getSoal($bank_soal_id, $setting['acak_soal'], $jumlahSoalEsay);
            //ini di gunakan untuk mengurutkan soal mana yang akan tampil
            //ini nanti aja fitur selanjutnya
            $soals = [
                1 => $soalPG,
                2 => $soalEssay,
            ];
            $newSoal = collect([]);
            foreach ($soals as $key => $soal) {
                $soal = collect($soal)->toArray();
                $newSoal = $newSoal->merge($soal);
            }
            try {
                DB::beginTransaction();
                foreach ($newSoal as $item) {
                    $soalSiswa = [
                        'soal_id' => $item['id'],
                        'bank_soal_id' => $item['bank_soal_id'],
                        'siswa_id' => $siswa->id,
                        'jadwal_id' => $jadwalID,
                        'dijawab' => false,
                    ];
                    JawabanSiswa::create($soalSiswa);
                }
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw new InsertDataGagalException($e->getMessage());
            }
        }
        return null;
    }
}
