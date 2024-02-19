<?php

namespace App\Models;

use App\Enums\UjianSiswa;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaUjian extends Model
{
    use HasFactory,HasUuid;
    protected $guarded = [];
    protected $cast = [
        'status_ujian' => UjianSiswa::class,
    ];
}
