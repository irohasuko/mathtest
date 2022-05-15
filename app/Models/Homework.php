<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    public function group(){
        return $this->belongsTo('\App\Models\Group');
    }

    public function homework_details(){
        return $this->hasMany('\App\Models\Homework_detail');
    }
}
