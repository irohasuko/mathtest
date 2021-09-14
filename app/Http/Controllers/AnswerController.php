<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;

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
    public function store_result($unit_id, $question_id, $result) :void
    {
        $record = new Record();

        $record->user_id = auth()->user()->id;
        $record->unit_id = $unit_id;
        $record->question_id = $question_id;
        $record->result = $result;

        $record->save();
    }

    public function unit101_a01(Request $request, $unit_id)
    {
        $question_id = 10101;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10102;         
        return view('answer/equation',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit101_a02(Request $request, $unit_id)
    {
        $question_id = 10102;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10103;         
        return view('answer/equation',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit101_a03(Request $request, $unit_id)
    {
        $question_id = 10103;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);
        $a = $request->answers;
        $r = $request->right_answers;

        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10104;         
        return view('answer/equation',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit101_a04(Request $request, $unit_id)
    {
        $question_id = 10104;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10105;         
        return view('answer/equation',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit101_a05(Request $request, $unit_id)
    {
        $question_id = 10105;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10106;         
        return view('answer/equation',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit101_a06(Request $request, $unit_id)
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
        
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text .'='. str_replace($option,$right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10107;         
        return view('answer/equation',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit101_a07(Request $request, $unit_id)
    {
        $question_id = 10107;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10108;         
        return view('answer/equation',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit101_a08(Request $request, $unit_id)
    {
        $question_id = 10108;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10109;         
        return view('answer/equation',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit101_a09(Request $request, $unit_id)
    {
        $question_id = 10109;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text .'='. str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10110;         
        return view('answer/equation',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit101_a10(Request $request, $unit_id)
    {
        $question_id = 10110;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10111;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit101_a11(Request $request, $unit_id)
    {
        $question_id = 10111;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10112;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit101_a12(Request $request, $unit_id)
    {
        $question_id = 10112;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10201;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit102_a01(Request $request, $unit_id)
    {
        $question_id = 10201;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10202;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit102_a02(Request $request, $unit_id)
    {
        $question_id = 10202;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10203;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit102_a03(Request $request, $unit_id)
    {
        $question_id = 10203;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10204;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit102_a04(Request $request, $unit_id)
    {
        $question_id = 10204;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10205;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit102_a05(Request $request, $unit_id)
    {
        $question_id = 10205;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10206;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit102_a06(Request $request, $unit_id)
    {
        $question_id = 10206;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10207;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit102_a07(Request $request, $unit_id)
    {
        $question_id = 10207;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10208;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit102_a08(Request $request, $unit_id)
    {
        $question_id = 10208;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10209;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit102_a09(Request $request, $unit_id)
    {
        $question_id = 10209;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10210;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit102_a10(Request $request, $unit_id)
    {
        $question_id = 10210;
        $result = $this->check_answer($request->answer,$request->right_answer);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.$request->options[($request->right_answer-1)].'$$';
        $answer_text = '$$'.$request->options[($request->answer-1)].'$$';
        $next_id = 10211;         
        return view('answer/select',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit102_a11(Request $request, $unit_id)
    {
        $question_id = 10211;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10301;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit103_a01(Request $request, $unit_id)
    {
        $question_id = 10301;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10302;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit103_a02(Request $request, $unit_id)
    {
        $question_id = 10302;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10303;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit103_a03(Request $request, $unit_id)
    {
        $question_id = 10303;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10304;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit103_a04(Request $request, $unit_id)
    {
        $question_id = 10304;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10305;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit103_a05(Request $request, $unit_id)
    {
        $question_id = 10305;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10306;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit103_a06(Request $request, $unit_id)
    {
        $question_id = 10306;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10307;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit103_a07(Request $request, $unit_id)
    {
        $question_id = 10307;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10308;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit103_a08(Request $request, $unit_id)
    {
        $question_id = 10308;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10309;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit103_a09(Request $request, $unit_id)
    {
        $question_id = 10309;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10401;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit104_a01(Request $request, $unit_id)
    {
        $question_id = 10401;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10402;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit104_a02(Request $request, $unit_id)
    {
        $question_id = 10402;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10403;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit104_a03(Request $request, $unit_id)
    {
        $question_id = 10403;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 10404;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit104_a04(Request $request, $unit_id)
    {
        $question_id = 10404;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.$request->options[($request->right_answer-1)].'$$';
        $answer_text = '$$'.$request->options[($request->answer-1)].'$$';
        $next_id = 20101;         
        return view('answer/select',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit201_a01(Request $request, $unit_id)
    {
        $question_id = 20101;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20102;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit201_a02(Request $request, $unit_id)
    {
        $question_id = 20102;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20103;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit201_a03(Request $request, $unit_id)
    {
        $question_id = 20103;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20104;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit201_a04(Request $request, $unit_id)
    {
        $question_id = 20104;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20105;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit201_a05(Request $request, $unit_id)
    {
        $question_id = 20105;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20201;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit202_a01(Request $request, $unit_id)
    {
        $question_id = 20201;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20202;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit202_a02(Request $request, $unit_id)
    {
        $question_id = 20202;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20203;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit202_a03(Request $request, $unit_id)
    {
        $question_id = 20203;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20204;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit202_a04(Request $request, $unit_id)
    {
        $question_id = 20204;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20205;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit202_a05(Request $request, $unit_id)
    {
        $question_id = 20205;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20206;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit202_a06(Request $request, $unit_id)
    {
        $question_id = 20206;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20207;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit202_a07(Request $request, $unit_id)
    {
        $question_id = 20207;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20301;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit203_a01(Request $request, $unit_id)
    {
        $question_id = 20301;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20302;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit203_a02(Request $request, $unit_id)
    {
        $question_id = 20302;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20303;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit203_a03(Request $request, $unit_id)
    {
        $question_id = 20303;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20304;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit203_a04(Request $request, $unit_id)
    {
        $question_id = 20304;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20305;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit203_a05(Request $request, $unit_id)
    {
        $question_id = 20305;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20306;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit203_a06(Request $request, $unit_id)
    {
        $question_id = 20306;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20307;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit203_a07(Request $request, $unit_id)
    {
        $question_id = 20307;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20308;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

    public function unit203_a08(Request $request, $unit_id)
    {
        $question_id = 20308;
        $option = $this->option;
        $result = $this->check_answer($request->answers,$request->right_answers);
        $this->store_result($unit_id,$question_id,$result);

        $text = $request->text.str_replace($option,$request->right_answers,$request->blank_text);
        $answer_text = '$$'.str_replace($option,$request->answers,$request->blank_text);
        $next_id = 20401;         
        return view('answer/sentence',compact('text','answer_text','question_id','unit_id','next_id','result'));
    }

}
