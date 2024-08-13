<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DTHRTHRiwayat extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'dthrth_riwayats';

    public function rincis()
    {
        return $this->hasMany(DTHRTHRiwayatRinci::class, 'dthrth_riwayat_id');
    }
}
