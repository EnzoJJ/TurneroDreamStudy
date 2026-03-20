<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turns extends Model
{
    // Esto es fundamental para que no te dé error de "Mass Assignment"
    protected $fillable = [
        'barber_id', 
        'client_name', 
        'client_email', 
        'client_phone', 
        'start_time', 
        'status', 
        'token'
    ];

    // Relación: Un turno pertenece a un barbero
    public function barber()
    {
        return $this->belongsTo(Barber::class);
    }
}