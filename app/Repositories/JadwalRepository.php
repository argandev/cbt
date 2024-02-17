<?php
namespace App\Repositories;
use App\Models\Jadwal;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

class JadwalRepository extends AbstractRepository{
    public function __construct(){
        $this->model = new Jadwal();
    }
    public function getJadwalHariIni(){
        return Jadwal::whereTanggalMulai(DB::raw('CURRENT_DATE'))->with('bank_soal')->get();
    }
}
