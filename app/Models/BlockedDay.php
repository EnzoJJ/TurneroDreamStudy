<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockedDay extends Model
{
    protected $fillable = ['date', 'reason', 'barber_id'];

    public function barber() {
        return $this->belongsTo(Barber::class);
    }
}