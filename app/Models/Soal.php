<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\JenisSoal;
class Soal extends Model
{
    use HasFactory,HasUuid;
    protected $casts = [
        'jenis_soal' => JenisSoal::class,
    ];

    public function jawabans(){
        return $this->hasMany(JawabanSoal::class);
    }
}
