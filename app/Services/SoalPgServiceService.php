<?php
namespace App\Services;
use App\Enums\JenisSoal;
use App\Models\Soal;
use App\Services\AbstractSoalService;
/**
 * dadandev
 * @class SoalPgServiceService
 */
final class SoalPgServiceService extends AbstractSoalService
{
    /**
     * @param string $bank_soal_id
     * @param bool $randomOpsi
     * @param bool $acakSoal
     * @param int $limit
     * @return array
     */
    //service body
    public function getSoal( string $bank_soal_id, bool $acakSoal = false ,int $limit = 5 ,bool $randomOpsi) {
        $tampilPG = [];

        if ( $acakSoal ) {
            $soalPG = Soal::where(['bank_soal_id'=>$bank_soal_id,'tipe_soal'=>JenisSoal::SOAL_PG])->limit($limit)->inRandomOrder()->get();
        } else {
            $soalPG = Soal::where(['bank_soal_id'=>$bank_soal_id,'tipe_soal'=>JenisSoal::SOAL_PG])->get();
        }


        return $soalPG;

    }

    /**
     * @param string $soal_id
     * @param string $bank_soal_id
     * @param string $siswa_id
     * @param JenisSoal $jenisSoal
     * @param $jawab
     * @return void
     */
    function jawab(string $soal_id, string $bank_soal_id, string $siswa_id, \App\Enums\JenisSoal $jenisSoal, $jawab)
    {
        // TODO: Implement jawab() method.
    }
}
