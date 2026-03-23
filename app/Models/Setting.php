<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'opening_time',
        'closing_time',
        'slot_duration',
    ];
}