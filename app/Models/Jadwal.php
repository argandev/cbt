<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasUuid;
    use HasFactory;

    protected $casts=[
        'setting' => 'array'
    ];
    public function bank_soal(){
        return $this->belongsTo(BankSoal::class);
    }
}
