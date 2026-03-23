<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turns extends Model
{
    protected $fillable = [
        'barber_id', 
        'client_name', 
        'client_email', 
        'client_phone', 
        'start_time', 
        'status', 
        'token'
    ];
    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}