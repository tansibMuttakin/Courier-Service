<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    public function city(){
        return $this->belongsTo('App\Models\City');
    }

    public function areas(){
        return $this->hasMany('App\Models\Area');
    }
}
