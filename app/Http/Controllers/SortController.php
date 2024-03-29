<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SortController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    public function unit_select(){
        $math1s = Unit::where('id','>',100)->where('id','<',200)->get();
        $math2s = Unit::where('id','>',200)->where('id','<',300)->get();
        $math3s = Unit::where('id','>',300)->where('id','<',400)->get();
        $mathAs = Unit::where('id','>',400)->where('id','<',500)->get();
        $mathBs = Unit::where('id','>',500)->where('id','<',600)->get();
        return view('select/unit_select',compact('math1s','math2s','math3s','mathAs','mathBs'));
    }

    public function q_select($id){
        $unit = Unit::where('id',$id)->first();
        $items = Question::where('unit_id', $id)->get();
        if(Auth::check()){
            $records = \App\Models\User::find(auth()->user()->id)->records()
                                            ->where('unit_id',$id)
                                            ->where('result',1)
                                            ->select('question_id')
                                            ->groupBy('question_id')
                                            ->get();
            $success = [];
            foreach($items as $item){
                $success[$item->q_id] = 0;
            }

            foreach($records as $record){
                $success[$record->question_id] = 1;
            }
        
            return view('select/item_select',compact('items','success','unit'));
        }else{
            return view('select/item_select',compact('items','unit'));
        }

    }

    public function q_route($q_id){
        $unit_id = floor($q_id / 100);
        return redirect(route('question',['unit_id' => $unit_id,'q_id' => $q_id]));
    }
}

