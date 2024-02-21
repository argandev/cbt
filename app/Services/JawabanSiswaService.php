<?php
namespace App\Services;
use App\Enums\JenisSoal;
use App\Models\BankSoal;
use App\Models\Jadwal;
use App\Models\JawabanSiswa;
use App\Models\Soal;

/**
 * dadandev
 * @class JawabanSiswaService
 */
final class JawabanSiswaService
{
    public function findByJadwalAndSiswa(string $jadwalID, string $siswaID) {
        return JawabanSiswa::where([
            'siswa_id' => $siswaID,
            'jadwal_id' => $jadwalID,
        ])->first();
    }

    /**
     * @param string $jadwalID
     * @param string $siswaID
     * @return mixed
     */
    public function getJawaban(string $jadwalID, string $siswaID){
        $jawabanSiswa = JawabanSiswa::with(['soal'])->where([
            'siswa_id' => $siswaID,
            'jadwal_id' => $jadwalID,
        ])->get();
        $jadwal = Jadwal::where('id',$jadwalID)->with('bank_soal')->first();
        $setting = $jadwal->setting;
        $jawabans = $jawabanSiswa->pluck('soal_id')->toArray();
        $data = collect([]);
        $soals =  Soal::whereIn('id',$jawabans)->get();

        $soalFound = [];
        foreach ( $soals as $keySoal => $soal ) {
            $soalFound[$keySoal]['soal'] = $soal;
           if( $soal->tipe_soal == 'pg' )
           {
               if ( $setting['acak_opsi'] ) {
                   $soalFound[$keySoal]['soal']['jawaban'] = $soal->jawabans()->select(['id','jawaban'])->inRandomOrder()->get();
               } else {
                   $soalFound[$keySoal]['soal']['jawaban'] = $soal->jawabans()->select(['id','jawaban','label'])->orderByLabel('ASC')->get();
               }
           }
        }
        return $soalFound;

    }
}
