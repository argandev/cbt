<?php
namespace App\Repositories;

use App\Models\BankSoal;
use App\Repositories\AbstractRepository;

class BankSoalRepository extends AbstractRepository{
    public function __construct() {
        $this->model = new BankSoal();
    }
}
