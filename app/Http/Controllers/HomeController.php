<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $record_count = [0,0,0,0,0];
        $question_count = [0,0,0,0,0];

        
        //$records = \App\Models\User::find(auth()->user()->id)->records()->where('result',1)->get();
        $records = \App\Models\User::find(auth()->user()->id)->records()
                                        ->where('result',1)
                                        ->select('unit_id','question_id')
                                        ->groupBy('unit_id','question_id')
                                        ->get();


        
        foreach($records as $record){
            if($record->unit_id > 100 && $record->unit_id < 200){
                $record_count[0] += 1;
            } elseif($record->unit_id < 300){
                $record_count[1] += 1;
            } elseif($record->unit_id < 400){
                $record_count[2] += 1;
            } elseif($record->unit_id < 500){
                $record_count[3] += 1;
            } else {
                $record_count[4] += 1;
            }
        }

        $question_count[0] = \App\Models\Question::where('unit_id','>',100)->where('unit_id','<',200)->count();
        $question_count[1] = \App\Models\Question::where('unit_id','>',200)->where('unit_id','<',300)->count();
        $question_count[2] = \App\Models\Question::where('unit_id','>',300)->where('unit_id','<',400)->count();
        $question_count[3] = \App\Models\Question::where('unit_id','>',400)->where('unit_id','<',500)->count();
        $question_count[4] = \App\Models\Question::where('unit_id','>',500)->count();

        return view('home',compact('record_count','question_count'));
    }
}
