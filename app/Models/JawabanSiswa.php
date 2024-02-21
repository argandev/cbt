<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    use HasFactory,
        HasUuid;
    protected $guarded =[];
    public function soal(){
        return $this->belongsTo(Soal::class);
    }
}
