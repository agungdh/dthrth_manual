<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    use HasFactory, HasUlids;

    public function skpd()
    {
        return $this->belongsTo(Skpd::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
