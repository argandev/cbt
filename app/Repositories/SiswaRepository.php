<?php
namespace App\Repositories;
use App\Models\Siswa;
use App\Repositories\AbstractRepository;
class SiswaRepository extends AbstractRepository{
    public function __construct(){
        $this->model = new Siswa;
    }

    public function getSiswaByApiToken(string $api_token){
        return $this->model->with('kelas')->whereApiToken($api_token)->first();
    }
}
