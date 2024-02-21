<?php
namespace App\Services;
/**
 * dadandev
 * @class SoalEsayService
 */
final class SoalEsayService extends \AbstractSoalService
{
    /**
     * @param string $bank_soal_id
     * @param bool $randomOpsi
     * @param bool $acakSoal
     * @param int $limit
     * @return void
     */
    //service body
    public function getSoal(string $bank_soal_id, bool $randomOpsi, bool $acakSoal = false, int $limit = 5)
    {

    }

    /**
     * @param string $soal_id
     * @param string $bank_soal_id
     * @param string $siswa_id
     * @param \App\Enums\JenisSoal $jenisSoal
     * @param $jawab
     * @return void
     */
    function jawab(string $soal_id, string $bank_soal_id, string $siswa_id, \App\Enums\JenisSoal $jenisSoal, $jawab)
    {
        // TODO: Implement jawab() method.
    }
}
