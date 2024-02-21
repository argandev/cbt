<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Siswa extends Model
{
    use HasUuid;
    use HasFactory;

    protected $guarded = [];
    protected $hidden = [
        'password',
    ];
    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function agama() : BelongsTo{
        return $this->belongsTo(Agama::class);
    }
    /**
     * Undocumented function
     *
     * @return BelongsTo
     */
    public function kelas() : BelongsTo{
      return  $this->belongsTo(Kelas::class);
    }
}
