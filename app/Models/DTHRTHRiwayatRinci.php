<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DTHRTHRiwayatRinci extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'dthrth_riwayat_rincis';
}
