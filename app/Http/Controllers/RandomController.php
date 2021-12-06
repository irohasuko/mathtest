<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Question;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class RandomController extends Controller
{
    public function list()
    {
        $rate = [];
        
        if(\App\Models\User::find(auth()->user()->id)->records()->count() < 1){
            return view('error/random');
        }

        $records = \App\Models\User::find(auth()->user()->id)->records()
            ->select('question_id',DB::raw('COUNT(result) AS count'),DB::raw('COUNT(result=1 OR NULL) AS a'),DB::raw('COUNT(result=0 OR NULL) AS b'))
            ->groupBy('question_id')
            ->get();
            
        foreach($records as $record){
            if($record->a != 0){ //テスト用　本来は $record->count != 0
                $rate[$record->question_id] = round($record->a / $record->count,4);
            }
        }

        asort($rate);
        $weaks = array_slice($rate,0,10,1);
        $w_id = array_keys($weaks);
        $id_order = implode(',', $w_id);
        $items = Question::whereIn('q_id', $w_id)->orderByRaw(DB::raw("FIELD(q_id, $id_order)"))->get();
        $questions = [];
        foreach($items as $item){
            array_push($questions,[$item->unit_id,$item->q_id,$item->caption,round($weaks[$item->q_id]*100,1)]);
        }
        return view('random/random_list',compact('questions'));
    }
}

    