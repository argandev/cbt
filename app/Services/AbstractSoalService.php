<?php
namespace App\Services;
abstract class AbstractSoalService
{
    /**
     * @param string $bank_soal_id
     * @param bool $randomOpsi
     * @param bool $acakSoal
     * @param int $limit
     * @return mixed
     */
    abstract function getSoal(string $bank_soal_id, bool $acakSoal = false, int $limit = 5, bool $randomOpsi);

    /**
     * @param string $soal_id
     * @param string $bank_soal_id
     * @param string $siswa_id
     * @param \App\Enums\JenisSoal $jenisSoal
     * @param $jawab
     * @return mixed
     */
    abstract function jawab(string $soal_id, string $bank_soal_id, string $siswa_id, \App\Enums\JenisSoal $jenisSoal, $jawab);
}
