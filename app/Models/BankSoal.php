<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model
{
    use HasUuid;
    use HasFactory;

    protected $casts = [
        'bobot' => 'array'
    ];

    public function jadwal(){
        return $this->hasMany(Jadwal::class);
    }
}
