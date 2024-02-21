<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSoal extends Model
{
    use HasFactory,HasUuid;
    protected $hidden = [
        'benar'
    ];

    protected $casts = [
        'bobot' => "array"
    ];
    public  function soal(){
        return $this->belongsTo(Soal::class);
    }
}
