<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;
use App\Models\Question;
use App\Models\Unit;

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
        $record = new Record();

        $record->user_id = auth()->user()->id;
        $record->unit_id = $unit_id;
        $record->question_id = $question_id;
        $record->result = $result;
        $record->time = $time;

        $record->save();
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
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
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
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','plot'));
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
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','plot','sample_text'));
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
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text','plot'));
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
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result','sample_text'));
    }

    public function unit102_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 10208;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10209;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit102_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 10209;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10210;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit102_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 10210;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.'\\\\'.$request->options[$request->right_answers[0]-1].'$$';
        $answer_text = '$$'.$request->options[$request->answers[0]-1].'$$';
        $next_id = 10211;         
        return view('answer/select',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit102_a11(Request $request, $unit,$question,$time)
    {
        $question_id = 10211;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10301;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit103_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 10301;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10302;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit103_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 10302;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10303;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit103_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 10303;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10304;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit103_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 10304;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10305;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit103_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 10305;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10306;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit103_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 10306;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10307;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit103_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 10307;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10308;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit103_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 10308;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10309;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit103_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 10309;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10401;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit104_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 10401;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10402;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit104_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 10402;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10403;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit104_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 10403;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10404;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit104_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 10404;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.'\\\\'.$request->options[$request->right_answers[0]-1].'$$';
        $answer_text = '$$'.$request->options[$request->answers[0]-1].'$$';
        $next_id = 20101;         
        return view('answer/select',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit201_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20101;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20102;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit201_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20102;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20103;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit201_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20103;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20104;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit201_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20104;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20105;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit201_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20105;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20201;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit202_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20201;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20202;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit202_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20202;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20203;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit202_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20203;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20204;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit202_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20204;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20205;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit202_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20205;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20206;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit202_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20206;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20207;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit202_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20207;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20301;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit203_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20301;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20302;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit203_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20302;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20303;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit203_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20303;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20304;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit203_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20304;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20305;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit203_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20305;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20306;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit203_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20306;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20307;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit203_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20307;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20308;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit203_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 20308;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20401;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit204_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20401;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20402;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit204_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20402;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20403;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit204_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20403;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20404;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit204_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20404;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20405;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit204_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20405;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20406;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit204_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20406;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20407;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit204_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20407;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20408;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit204_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 20408;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20501;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit205_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20501;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20502;         
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit205_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20502;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20503;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit205_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20503;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20504;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit205_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20504;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20505;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit205_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20505;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20506;         
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit205_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20506;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20507;         
        return view('answer/equation',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit205_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20507;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20508;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit205_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 20508;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20509;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit205_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 20509;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20510;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit205_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 20510;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20601;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit206_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20601;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20602;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit206_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20602;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20603;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit206_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20603;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20604;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit206_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20604;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20605;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit206_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20605;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20606;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit206_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20606;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20607;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit206_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20607;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20701;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit207_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 20701;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20702;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit207_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 20702;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20703;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit207_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 20703;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20704;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit207_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 20704;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20705;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit207_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 20705;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20706;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit207_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 20706;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20707;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit207_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 20707;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30101;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit301_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30101;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30102;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit301_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30102;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30103;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit301_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30103;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30104;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit301_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30104;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30105;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit301_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30105;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30106;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit301_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 30106;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30201;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit302_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30201;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30202;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit302_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30202;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30203;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit302_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30203;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30204;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit302_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30204;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30205;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit302_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30205;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30206;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit302_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 30206;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30207;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit302_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 30207;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30208;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit302_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 30208;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30301;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit303_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30301;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30302;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit303_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30302;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30303;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit303_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30303;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30304;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit303_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30304;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30305;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit303_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30305;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30401;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit304_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30401;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30402;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit304_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30402;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30403;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit304_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30403;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30404;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit304_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30404;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30405;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit304_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30405;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30406;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit304_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 30406;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30501;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30501;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30502;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30502;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30503;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30503;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30504;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30504;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30505;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30505;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30506;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 30506;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30507;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 30507;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30508;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 30508;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30509;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 30509;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30510;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 30510;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30511;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a11(Request $request, $unit,$question,$time)
    {
        $question_id = 30511;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30512;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit305_a12(Request $request, $unit,$question,$time)
    {
        $question_id = 30512;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30601;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 30601;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30602;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 30602;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30603;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 30603;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30604;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 30604;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30605;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 30605;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30606;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 30606;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30607;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 30607;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30608;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 30608;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30609;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 30609;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30610;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 30610;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30611;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a11(Request $request, $unit,$question,$time)
    {
        $question_id = 30611;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 30612;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit306_a12(Request $request, $unit,$question,$time)
    {
        $question_id = 30612;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40101;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit401_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 40101;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40102;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit401_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 40102;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40103;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit401_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 40103;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40104;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit401_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 40104;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40105;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit401_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 40105;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40106;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit401_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 40106;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40107;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit401_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 40107;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40108;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit401_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 40108;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40109;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit401_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 40109;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40110;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit401_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 40110;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40111;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit401_a11(Request $request, $unit,$question,$time)
    {
        $question_id = 40111;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40201;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit402_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 40201;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40202;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit402_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 40202;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40203;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit402_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 40203;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40204;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit402_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 40204;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40205;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit402_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 40205;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40206;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit402_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 40206;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40207;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit402_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 40207;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40208;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit402_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 40208;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40209;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit402_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 40209;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40210;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit402_a10(Request $request, $unit,$question,$time)
    {
        $question_id = 40210;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40301;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
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

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40303;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit403_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 40303;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40304;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit403_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 40304;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 40305;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit403_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 40305;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50101;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit501_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 50101;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50102;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit501_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 50102;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50103;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit501_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 50103;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50104;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit501_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 50104;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50105;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit501_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 50105;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50106;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit501_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 50106;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50107;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit501_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 50107;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50201;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit502_a01(Request $request, $unit,$question,$time)
    {
        $question_id = 50201;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50202;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit502_a02(Request $request, $unit,$question,$time)
    {
        $question_id = 50202;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50203;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit502_a03(Request $request, $unit,$question,$time)
    {
        $question_id = 50203;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50204;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit502_a04(Request $request, $unit,$question,$time)
    {
        $question_id = 50204;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50205;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit502_a05(Request $request, $unit,$question,$time)
    {
        $question_id = 50205;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50206;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit502_a06(Request $request, $unit,$question,$time)
    {
        $question_id = 50206;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50207;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit502_a07(Request $request, $unit,$question,$time)
    {
        $question_id = 50207;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50208;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit502_a08(Request $request, $unit,$question,$time)
    {
        $question_id = 50208;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 50209;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }

    public function unit502_a09(Request $request, $unit,$question,$time)
    {
        $question_id = 50209;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($question->unit_id,$question->q_id,$result,$time);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10101;         
        return view('answer/sentence',compact('text','answer_text','question','unit','next_id','result'));
    }



}
