<?php
namespace App\Services;
use App\Enums\JenisSoal;
use App\Models\Soal;
use App\Services\AbstractSoalService;
/**
 * dadandev
 * @class SoalEsayService
 */
final class SoalEsayService extends AbstractSoalService
{
    /**
     * @param string $bank_soal_id
     * @param bool $randomOpsi
     * @param bool $acakSoal
     * @param int $limit
     * @return void
     */
    //service body
    public function getSoal(string $bank_soal_id,  bool $acakSoal = false, int $limit = 10, bool $randomOpsi = false) : mixed
    {
        $soals = Soal::where(['tipe_soal'=>JenisSoal::SOAL_ESAY,'bank_soal_id'=>$bank_soal_id]);
        if($acakSoal) {
            if($limit) {
                $soals->limit($limit)->inRandomOrder();
            } else {
                $soals->inRandomOrder();
            }
        } else {
            $soals->limit($limit);
        }
        return $soals->get();
    }

    /**
     * @param string $soal_id
     * @param string $bank_soal_id
     * @param string $siswa_id
     * @param JenisSoal $jenisSoal
     * @param $jawab
     * @return void
     */
    function jawab(string $soal_id, string $bank_soal_id, string $siswa_id, JenisSoal $jenisSoal, $jawab)
    {
        // TODO: Implement jawab() method.
    }
}
