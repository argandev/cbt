<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    use HasUuid;
    use HasFactory;
    /**
     * Undocumented function
     *
     * @return HasMany
     */
    public function kelas() : HasMany{
        return $this->hasMany(Siswa::class);
    }
}
