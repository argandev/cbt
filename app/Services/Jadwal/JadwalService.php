<?php
namespace App\Services\Jadwal;
use App\Models\Jadwal;
date_default_timezone_set("Asia/Jakarta");
use App\Repositories\BankSoalRepository;
use App\Repositories\JadwalRepository;
use Exception;
use Ramsey\Uuid\Uuid;

/**
 * dadandev
 * @class JadwalService
 */
final class JadwalService
{
    protected JadwalRepository $jadwalRepository;
    protected BankSoalRepository $bankSoalRepository;
    public function __construct(

    ) {
        $this->jadwalRepository = new JadwalRepository();
        $this->bankSoalRepository = new BankSoalRepository();
    }
    public function findById($id){
        return $this->jadwalRepository->findById($id);
    }
    public function getJadwalById(string $id)
    {
        return $this->jadwalRepository->findById($id);
    }
    public function extractSettings(mixed $jadwal) {
       if(is_string($jadwal) && !($jadwal instanceof Jadwal)) {
        $jadwal = $this->jadwalRepository->findById($jadwal);
       }
       if ( $jadwal && ($settings = $jadwal->setting)) {
        return json_decode($settings,true);
    }
    }
    public function terdaftarDiJadwal($jadwal, $siswa)
    {
        $kelas = array_filter(json_decode($jadwal->kelas_ids, true), function ($e) {
            return Uuid::isValid($e);
        });
        if (!in_array($siswa->kelas_id, $kelas)) {
            return !true;
        }
        return !false;
    }

    public function jadwalDetail($jadwal_id)
    {
        $siswa = request()->get('siswa_data');
        try {
            $jadwal = $this->getJadwalById($jadwal_id);
            $bankSoal = $this->bankSoalRepository->findById($jadwal->bank_soal_id);
            //cek apakah bank soal aktif?
            if ($bankSoal->aktif) {
                return [
                    'id' => $jadwal->id,
                    'lama_ujian' => $jadwal->lama_ujian,
                    'waktu_mulai' => $jadwal->waktu_mulai,
                    'unix_time' => strtotime($jadwal->tanggal_mulai." ".$jadwal->waktu_mulai),
                    'settings' => $jadwal->setting,
                    'bank_soal' => [
                        'id' => $bankSoal->id,
                        'jumlah_soal' => $bankSoal->jumlah_soal,
                        'kode' => $bankSoal->kode_bank_soal,
                        'nama' => $bankSoal->nama,
                    ]
                ];
            }
        } catch (Exception $e) {
            error_log('bank-soal:' . $e->getMessage());
        }


    }

    public function jadwalHariIni()
    {
        //mendapatkan jadwal aktif hari ini berdasarkan siswa dan kelasnya.
        $siswa = request()->get('siswa_data');
        $resultJadwal = $this->jadwalRepository->getJadwalHariIni();
        $jadwals = [];
        foreach ($resultJadwal as $key => $jadwal) {
            //jika kelas == null berarti untuk umum
            if (is_null($jadwal->kelas_ids)) {
                $jadwals[] = [
                    'jadwal_id' => $jadwal,
                ];
            } else {
                /**
                 * sekarang cek apakah ujian ini untuk kelas yang telah di tentukan di jadwal
                 * apa tidak, jika tidak lanjutkan looping
                 * @author dadan <dadanhdyt@gmail.com>
                 */
                $kelas = array_filter(json_decode($jadwal->kelas_ids, true), function ($e) {
                    return Uuid::isValid($e);
                });
                if (!in_array($siswa['kelas_id'], $kelas)) {
                    continue;
                }
            }
            $jadwals[] = $jadwal;
        }

        return $jadwals;
    }
}
