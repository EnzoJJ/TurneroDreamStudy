<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barber extends Model
{
    protected $fillable = ['name'];


    public function turns() {
        return $this->hasMany(Turns::class);
    }
}
