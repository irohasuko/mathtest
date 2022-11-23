<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Question;
use App\Models\Unit;
use App\Models\Formula;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    //数字比較
    public function check_answer($answers, $right_answers){
        if($right_answers == $answers){
            $result = 1;
        } else {
            $result = 0;
        }
        return $result;
    }

    public function answer(Request $request,$unit_id,$q_id)
    {
        if (!multiSubmitCheck($request)) return view('error');
        $end = time();
        $time = $end - $request->start;
        $question = Question::where('q_id',$q_id)->first();
        $unit = Unit::where('id',$unit_id)->first();
        $func = 'unit'.$unit_id.'_a'.substr($q_id, 3);
        echo $this->$func($request,$unit,$question,$time);
    }

    public $option = ['ア','イ','ウ','エ','オ','カ','キ','ク','ケ','コ'];

    //因数分解の答え判定
    public function check_answer2($answers, $right_answers){
        if($right_answers == $answers || 
            ($right_answers[0] == $answers[2] && $right_answers[1] == $answers[3] && $right_answers[2] == $answers[0] && $right_answers[3] == $answers[1])){
                $result = 1;
            } else {
                $result = 0;
            }
            return $result;
    }

    //結果の保存
    public function store_result($unit_id, $question_id, $result,$time) :void
    {
        if(Auth::check()){
            $record = new Record();

            $record->user_id = auth()->user()->id;
            $record->unit_id = $unit_id;
            $record->question_id = $question_id;
            $record->result = $result;
            $record->time = $time;

            $record->save();
        }
    }

    public function unit101_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 10101;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10102;
        $f_number = [10102];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit101_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 10102;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10103;
        $f_number = [10102];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit101_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 10103;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);
        $a = $request->answers;
        $r = $request->right_answers;

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10104;
        $f_number = [10102];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);    
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit101_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 10104;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10105;         
        $f_number = [10102];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);  
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit101_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 10105;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10106;       
        $f_number = [10104];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);    
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit101_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 10106;
        $option = $this->option;

        if(isset($request->answers[2])){
            if($request->right_answers[1]*$request->right_answers[3] > 0){
                for($i=0;$i<4;$i++){
                    $right_answers[$i] = abs($request->right_answers[$i]);
                }
                $result = $this->check_answer2($request->answers,$right_answers);
            } else {
                for($i=0;$i<4;$i++){
                    $right_answers[$i] = abs($request->right_answers[$i]);
                }
                $result = $this->check_answer($request->answers,$right_answers);
            }
        } else {
            if($request->answers[0] == abs($request->right_answers[0]) && $request->answers[1] == abs($request->right_answers[1])){
                $result = 1;
            } else {
                $result = 0;
            }
            for($i=0;$i<4;$i++){
                $right_answers[$i] = abs($request->right_answers[$i]);
            }
        }
        
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10107;    
        $f_number = [10103];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);       
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit101_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 10107;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10108;
        $f_number = [10103];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);        
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit101_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 10108;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10109;
        $f_number = [10105];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);           
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit101_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 10109;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10110;
        $f_number = [10107];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);       
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit101_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 10110;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10111;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
    }

    public function unit101_a11(Request $request, $unit,$question,$time)
    {
        $question_id = 10111;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10112;
        $f_number = [10106];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);           
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit101_a12(Request $request, $unit,$question,$time)
    {
        $question_id = 10112;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10201;
        $f_number = [10109];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);           
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit102_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 10201;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10202;
        $f_number = [10201,10202];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit102_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 10202;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10203;
        $f_number = [10203];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit102_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 10203;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);
        
        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10204;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
    }

    public function unit102_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 10204;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $plot = $request->plot;
        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10205;
        $f_number = [10202,10204];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','plot','sample_text','formulas'));
    }

    public function unit102_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 10205;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $plot = $request->plot;
        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10206;
        $f_number = [10202,10203,10204];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit102_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 10206;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10207;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
    }

    public function unit102_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 10207;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10208;
        $f_number = [10103,10205];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit102_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 10208;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10209;
        $f_number = [10206];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit102_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 10209;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10210;
        $f_number = [10205];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit102_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 10210;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.'\\\\'.$request->options[$request->right_answers[0]-1].'$$';
        $answer_text = '$$'.$request->options[$request->answers[0]-1].'$$';
        $next_id = 10211;
        $f_number = [10206];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/select',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit102_a11(Request $request, $unit,$question,$time)
    {
        $question_id = 10211;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10301;
        $f_number = [10206];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit103_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 10301;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10302;
        $f_number = [10301,10302];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit103_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 10302;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10303;
        $f_number = [10301];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit103_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 10303;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10304;
        $f_number = [10303,10304];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit103_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 10304;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10305;
        $f_number = [10305];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit103_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 10305;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10306;
        $f_number = [10305];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit103_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 10306;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10307;
        $f_number = [10306];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit103_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 10307;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10308;
        $f_number = [10306];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit103_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 10308;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10309;
        $f_number = [10307,10308];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit103_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 10309;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10401;
        $f_number = [10302,10306,10307,10308];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit104_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 10401;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10402;
        $f_number = [10401];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit104_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 10402;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10403;
        $f_number = [10402];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit104_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 10403;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10404;
        $f_number = [10403];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit104_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 10404;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $script = $request->script;
        $text = $request->text.'\\\\'.$request->options[$request->right_answers[0]-1].'$$';
        $answer_text = '$$'.$request->options[$request->answers[0]-1].'$$';
        $next_id = 20101;
        $f_number = [10404];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/select',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','script'));
    }

    public function unit201_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20101;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20102;
        $f_number = [20101];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit201_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20102;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20103;
        $f_number = [20102];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit201_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20103;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20104;
        $f_number = [20102];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit201_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20104;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20105;
        $f_number = [20104];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit201_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20105;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20201;
        $f_number = [20108];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);        
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit202_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20201;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20202;
        $f_number = [20201];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit202_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20202;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20203;
        $f_number = [20203];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit202_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20203;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20204;
        $f_number = [20204];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit202_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20204;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20205;
        $f_number = [20205,20206];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit202_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20205;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20206;
        $f_number = [20207];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit202_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20206;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20207;
        $f_number = [20208];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit202_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20207;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20301;
        $f_number = [20207];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit203_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20301;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20302;
        $f_number = [20301,20303];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit203_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20302;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20303;
        $f_number = [20304];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit203_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20303;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20304;
        $f_number = [20305];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit203_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20304;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20305;
        $f_number = [20303,20306];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit203_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20305;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20306;
        $f_number = [20307];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit203_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20306;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20307;
        $f_number = [20308];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit203_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20307;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20308;
        $f_number = [20302,20308];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit203_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 20308;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20401;
        $f_number = [20309];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit204_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20401;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20402;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
    }

    public function unit204_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20402;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20403;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','plot'));
    }

    public function unit204_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20403;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20404;
        $f_number = [10302,20404];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit204_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20404;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20405;
        $f_number = [10302,20405];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit204_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20405;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20406;    
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','plot'));
    }

    public function unit204_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20406;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20407;
        $f_number = [20402];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit204_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20407;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20408;
        $f_number = [20406];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit204_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 20408;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20501;
        $f_number = [20402,20406];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit205_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20501;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20502;
        $f_number = [10101,20501];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit205_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20502;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20503;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
    }

    public function unit205_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20503;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20504;
        $f_number = [20503,20504];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit205_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20504;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20505;
        $f_number = [20503,20504];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit205_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20505;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20506;
        $f_number = [20504,20505,20506];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit205_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20506;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20507;
        $f_number = [20505,20506];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit205_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20507;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20508;
        $f_number = [20504];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit205_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 20508;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20509;
        $f_number = [20504,20507,20508];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit205_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 20509;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20510;
        $f_number = [20506,20507,20508];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit205_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 20510;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20601;
        $f_number = [20504];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit206_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20601;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20602;
        $f_number = [20601];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);        
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit206_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20602;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20603;
        $f_number = [20604,20605];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit206_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20603;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20604;
        $f_number = [20602,20606];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit206_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20604;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20605;
        $f_number = [20602,20606];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit206_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20605;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20606;
        $f_number = [20608];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit206_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20606;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20607;
        $f_number = [20608];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit206_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20607;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20701;
        $f_number = [20607,20608];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit207_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20701;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20702;
        $f_number = [20702,20703];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit207_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20702;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20703;
        $f_number = [20702,20705];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit207_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20703;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20704;
        $f_number = [20701];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','formulas','sample_text'));
    }

    public function unit207_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20704;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20705;
        $f_number = [20704];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit207_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20705;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20706;
        $f_number = [20706];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit207_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20706;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20707;
        $f_number = [20707];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit207_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20707;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30101;
        $f_number = [20706];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit301_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30101;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30102;
        $f_number = [30101];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit301_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30102;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30103;
        $f_number = [30102,30103];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit301_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30103;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30104;
        $f_number = [30102];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit301_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30104;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30105;
        $f_number = [30104];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit301_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30105;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30106;
        $f_number = [30107];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit301_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 30106;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30201;
        $f_number = [30108];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit302_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30201;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30202;
        $f_number = [30201];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit302_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30202;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30203;
        $f_number = [30202];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit302_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30203;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30204;
        $f_number = [30203];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit302_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30204;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30205;
        $f_number = [30202,30204];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);        
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit302_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30205;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30206;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
    }

    public function unit302_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 30206;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30207;
        $f_number = [20309,30202];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);        
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit302_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 30207;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30208;
        $f_number = [20311];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit302_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 30208;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30301;
        $f_number = [30206];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit303_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30301;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30302;
        $f_number = [30301];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit303_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30302;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30303;
        $f_number = [30301];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit303_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30303;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30304;
        $f_number = [30302];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit303_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30304;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30305;
        $f_number = [30303];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit303_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30305;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30401;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
    }

    public function unit304_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30401;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30402;
        $f_number = [30402];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit304_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30402;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30403;
        $f_number = [30402,30404];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);        
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit304_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30403;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30404;
        $f_number = [30401,30404];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit304_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30404;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30405;
        $f_number = [30405,30406];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit304_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30405;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30406;
        $f_number = [30407];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit304_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 30406;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30501;
        $f_number = [30409];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit305_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30501;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30502;
        $f_number = [20604,30502];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit305_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30502;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30503;
        $f_number = [20604,30503];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit305_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30503;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30504;
        $f_number = [30504];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit305_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30504;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30505;
        $f_number = [30504];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit305_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30505;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30506;
        $f_number = [30506];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit305_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 30506;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30507;
        $f_number = [30502,30506];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit305_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 30507;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30508;
        $f_number = [30507];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit305_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 30508;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30509;
        $f_number = [30504,30506,30507];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit305_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 30509;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30510;
        $f_number = [30504,30508];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit305_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 30510;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30511;
        $f_number = [30509];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit305_a11(Request $request, $unit,$question,$time)
    {
        $question_id = 30511;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $plot = $request->plot;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30512;
        $f_number = [30513,30514];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','plot'));
    }

    public function unit305_a12(Request $request, $unit,$question,$time)
    {
        $question_id = 30512;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30601;
        $f_number = [30516];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30601;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30602;
        $f_number = [30601];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30602;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30603;
        $f_number = [30602];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30603;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30604;
        $f_number = [30603];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30604;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30605;
        $f_number = [30601,30604];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);        
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30605;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30606;
        $f_number = [30604];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 30606;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30607;
        $f_number = [30604];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 30607;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30608;
        $f_number = [30605];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 30608;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30609;
        $f_number = [30601];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 30609;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30610;
        $f_number = [30602];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 30610;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30611;
        $f_number = [30606];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a11(Request $request, $unit,$question,$time)
    {
        $question_id = 30611;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30612;
        $f_number = [30601,30602,30608];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit306_a12(Request $request, $unit,$question,$time)
    {
        $question_id = 30612;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40101;
        $f_number = [30601,30613];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit401_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 40101;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40102;
        $f_number = [40302];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit401_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 40102;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40103;
        $f_number = [40104,40106];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit401_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 40103;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40104;
        $f_number = [40103,40104];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit401_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 40104;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40105;
        $f_number = [40105];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit401_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 40105;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40106;
        $f_number = [40105];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit401_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 40106;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40107;
        $f_number = [40103,40106];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit401_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 40107;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40108;
        $f_number = [40106];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit401_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 40108;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40109;
        $f_number = [40107,40108,40109];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit401_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 40109;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40110;
        $f_number = [40106,40107,40109];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit401_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 40110;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40111;
        $f_number = [40111];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit401_a11(Request $request, $unit,$question,$time)
    {
        $question_id = 40111;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40201;
        $f_number = [40112];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit402_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 40201;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $a_script = $request->a_script;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40202;
        $f_number = [40202];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','a_script'));
    }

    public function unit402_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 40202;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $a_script = $request->a_script;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40203;
        $f_number = [40201,40202];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','a_script'));
    }

    public function unit402_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 40203;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $a_script = $request->a_script;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40204;
        $f_number = [40202];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','a_script'));
    }

    public function unit402_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 40204;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $a_script = $request->a_script;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40205;
        $f_number = [40203,40204];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','a_script'));
    }

    public function unit402_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 40205;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $a_script = $request->a_script;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40206;
        $f_number = [40204];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','a_script'));
    }

    public function unit402_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 40206;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $a_script = $request->a_script;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40207;
        $f_number = [40205];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','a_script'));
    }

    public function unit402_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 40207;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $a_script = $request->a_script;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40208;
        $f_number = [40206];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','a_script'));
    }

    public function unit402_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 40208;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $a_script = $request->script;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40209;
        $f_number = [40205,40207];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','a_script'));
    }

    public function unit402_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 40209;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $a_script = $request->script;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40210;
        $f_number = [40208];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas','a_script'));
    }

    public function unit402_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 40210;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40301;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
    }

    public function unit403_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 40301;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40302;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit403_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 40302;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40303;
        $f_number = [40303];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit403_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 40303;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40304;
        $f_number = [40304,40305,40306];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit403_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 40304;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40305;
        $f_number = [40307];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit403_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 40305;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50101;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
    }

    public function unit501_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 50101;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50102;
        $f_number = [50111];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit501_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 50102;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50103;
        $f_number = [50112];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit501_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 50103;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50104;
        $f_number = [50101,50106];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit501_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 50104;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50105;
        $f_number = [50113];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit501_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 50105;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50106;
        $f_number = [50113,50114];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit501_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 50106;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50107;
        $f_number = [50108,50109];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit501_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 50107;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50201;
        $f_number = [50108,50110];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit502_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 50201;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50202;
        $f_number = [50201,50202];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit502_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 50202;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50203;
        $f_number = [50203,50204];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit502_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 50203;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50204;
        $f_number = [50205,50206];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit502_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 50204;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50205;
        $f_number = [50205];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit502_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 50205;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50206;
        $f_number = [50206];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit502_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 50206;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50207;
        $f_number = [50205,50207];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit502_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 50207;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50208;
        $f_number = [50208];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit502_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 50208;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50209;
        $f_number = [50202,50205];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }

    public function unit502_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 50209;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $sample_text = $request->sample_text;
        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10101;
        $f_number = [50203];
        $f = app()->make('App\Http\Controllers\FormulaController');
        $formulas = $f->formula_get($f_number);          
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','formulas'));
    }



}
