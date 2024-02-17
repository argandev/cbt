<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agama extends Model
{
    use HasUuid;
    use HasFactory;
    public function siswa() : HasMany{
        return $this->hasMany(Siswa::class);
    }
}
