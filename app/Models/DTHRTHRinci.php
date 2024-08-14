<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DTHRTHRinci extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'dthrth_rincis';

    public function dthrth()
    {
        return $this->belongsTo(DTHRTH::class, 'dthrth_id');
    }
}
