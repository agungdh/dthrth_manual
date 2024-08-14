<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DTHRTH extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'dthrths';

    public function rincis()
    {
        return $this->hasMany(DTHRTHRinci::class, 'dthrth_id');
    }

    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }
}
