<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework_detail extends Model
{
    use HasFactory;

    public function homework(){
        return $this->belongsTo('\App\Models\Homework');
    }

    public function question(){
        return $this->belongsTo('\App\Models\Question','question_id','q_id');
    }
}
