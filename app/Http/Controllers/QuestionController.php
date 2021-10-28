<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Record;

class QuestionController extends Controller
{
    //ユーザ認証
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function question($unit_id,$q_id)
    {
        $func = 'unit'.substr($q_id, 0,3).'_q'.substr($q_id, 3);
        echo $this->$func($unit_id);
    }

    public $option = ['ア','イ','ウ','エ','オ','カ','キ','ク','ケ','コ'];

    //数学Ⅰ
    //数と式
    //式の展開　その１
    public function unit101_q01($unit_id){

        $question_id = 10101;
        $blanks = 3;
        $option = $this->option;

        $a = rand(1,7);
        do { $b = rand(-7,7); } while( $b==0 || gmp_gcd($a,$b)!=1 );
        $c = rand(1,7);
        do { $d = rand(-7,7); } while( $d==0 || gmp_gcd($c,$d)!=1 );

        //list($a,$b) = gcd($a,$b);
        //list($c,$d) = gcd($c,$d);

        $right_answers[0] = $a*$c;
        $right_answers[1] = $a*$d + $b*$c;
        $right_answers[2] = $b*$d;

        $item[0] = '\fbox{'.$option[0].'}x^2';
        $item[1] = ($right_answers[1]>0 ? '+' : '-').'\fbox{'.$option[1].'}x';
        $item[2] = ($right_answers[2]>0 ? '+' : '-').'\fbox{'.$option[2].'}';

        if($right_answers[1] === 0){ 
            unset($right_answers[1]);
            unset($item[1]);
            $blanks -= 1;
            $item = array_values($item);
            $right_answers = array_values($right_answers);

            $item[1] = str_replace($option,$option[1],$item[1]);
        }

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $text = '$$ ('.d1($a,'x') .d3($b).')('.d1($c,'x').d3($d).')';
        $blank_text = implode($item).'$$';

        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //式の展開　その２
    public function unit101_q02($unit_id){

        $question_id = 10102;
        $blanks = 3;
        $option = $this->option;

        $a = rand(1,5);
        do { $b = rand(-5,5); } while( $b==0 || gmp_gcd($a,$b)!=1 );
        $c = rand(1,5);
        do { $d = rand(-5,5); } while( $d==0 || gmp_gcd($c,$d)!=1 );
        $e = rand(1,5);
        do { $f = rand(-5,5); } while( $f==0 || gmp_gcd($e,$f)!=1 );
        $g = rand(1,5);
        do { $h = rand(-5,5); } while( $h==0 || gmp_gcd($g,$h)!=1 );

        $right_answers[0] = $a*$c - $e*$g ;
        $right_answers[1] = $a*$d + $b*$c - $e*$h - $f*$g;
        $right_answers[2] = $b*$d - $f*$h;

        $item[0] = ($right_answers[0]>0 ? '' : '-').'\fbox{'.$option[0].'}x^2';
        $item[1] = ($right_answers[1]>0 ? '+' : '-').'\fbox{'.$option[1].'}xy';
        $item[2] = ($right_answers[2]>0 ? '+' : '-').'\fbox{'.$option[2].'}y^{2}';

        for($i=0;$i<3;$i++){
            if($right_answers[$i] === 0){ 
                unset($right_answers[$i]);
                unset($item[$i]);
                $blanks -= 1;
            }
        }
        $right_answers = array_values($right_answers);
        $item = array_values($item);

        for($i=0;$i<$blanks;$i++)
        {
            $item[$i] = str_replace($option,$option[$i],$item[$i]);
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $text = '$$ ('.li($a,'x') .li(sign($b),'y').')('.li($c,'x').li(sign($d),'y').') - ('.li($e,'x') .li(sign($f),'y').')('.li($g,'x').li(sign($h),'y').')';
        $blank_text = fo(implode($item)).'$$';

        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //係数が分数の場合の展開
    public function unit101_q03($unit_id){

        $question_id = 10103;
        $blanks = 6;
        $option = $this->option;

        do { $a = rand(-8,8); } while( $a==0 ); //$b = rand(1,5);
        $c = rand(1,8); //$d = rand(1,5);
        $e = rand(1,8); //$f = rand(1,5);
        $g = rand(1,8); //$h = rand(1,5);

        do { $b = rand(2,8); } while($b/gmp_gcd($a,$b) == 1);
        do { $d = rand(2,8); } while($d/gmp_gcd($c,$d) == 1);
        do { $f = rand(2,8); } while($f/gmp_gcd($e,$f) == 1);
        do { $h = rand(2,8); } while($h/gmp_gcd($g,$h) == 1);

        list($a,$b) = gcd($a,$b);
        list($c,$d) = gcd($c,$d);
        list($e,$f) = gcd($e,$f);
        list($g,$h) = gcd($g,$h);

        $right_answers[0] = $a*$e;
        $right_answers[1] = $b*$f;
        $right_answers[2] = $a*$g*$d*$f + $c*$e*$b*$h;
        $right_answers[3] = $b*$h*$d*$f;
        $right_answers[4] = $c*$g;
        $right_answers[5] = $d*$h;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);

        $item[0] = ($right_answers[0]*$right_answers[1]>0 ? '' : '-').'\frac{\fbox{ア}}{\fbox{イ}}x^{2}';
        $item[1] = ($right_answers[2]*$right_answers[3]>0 ? '+' : '-').'\frac{\fbox{ウ}}{\fbox{エ}}xy';
        $item[2] = ($right_answers[4]*$right_answers[5]>0 ? '+' : '-').'\frac{\fbox{オ}}{\fbox{カ}}y^2';

        //分母が１の場合の処理
        for($i=1;$i<6;$i+=2){
            if(abs($right_answers[$i]) == 1){
                unset($right_answers[$i]);
                $item[($i-1)/2] = str_replace(['\frac{','}{\fbox{'.$option[$i].'}}'],['',''],$item[($i-1)/2]);
                unset($option[$i]);
                $blanks -= 1;
            }
        }

        //分子が０の場合の処理
        for($i=0;$i<6;$i+=2){
            if($right_answers[$i] == 0){
                if(isset($right_answers[$i+1])){
                    unset($right_answers[$i]);
                    unset($right_answers[$i+1]);
                    unset($option[$i]);
                    unset($option[$i+1]);
                    $blanks -= 2;
                } else {
                    unset($right_answers[$i]);
                    unset($option[$i]);
                    $blanks -= 1;
                }
                $item[$i/2] = '';
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $text = '$$ ('.fo(li(frac($a,$b),'x').li(frac($c,$d),'y')).')('.fo(li(frac($e,$f),'x').li(frac($g,$h),'y')).')';
        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //３項の展開
    public function unit101_q04($unit_id){

        $question_id = 10104;
        $blanks = 6;
        $option = $this->option;

        $a = rand(1,5);
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );

        $right_answers[0] = $a*$a;
        $right_answers[1] = $b*$b;
        $right_answers[2] = $c*$c;
        $right_answers[3] = 2*$a*$b;
        $right_answers[4] = 2*$b*$c;
        $right_answers[5] = 2*$c*$a;

        $item[0] = ($right_answers[0]>0 ? '' : '-').'\fbox{'.$option[0].'}x^2';
        $item[1] = ($right_answers[1]>0 ? '+' : '-').'\fbox{'.$option[1].'}y^2';
        $item[2] = ($right_answers[2]>0 ? '+' : '-').'\fbox{'.$option[2].'}z^2';
        $item[3] = ($right_answers[3]>0 ? '+' : '-').'\fbox{'.$option[3].'}xy';
        $item[4] = ($right_answers[4]>0 ? '+' : '-').'\fbox{'.$option[4].'}yz';
        $item[5] = ($right_answers[5]>0 ? '+' : '-').'\fbox{'.$option[5].'}zx';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $text = '$$ ('.fo(li($a,'x')).li(sign($b),'y').li(sign($c),'z').')^{2}';
        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //３乗の展開
    public function unit101_q05($unit_id){

        $question_id = 10105;
        $blanks = 4;
        $option = $this->option;

        $a = rand(1,5);
        do { $b = rand(-5,5); } while( $b==0 );

        $right_answers[0] = $a*$a*$a;
        $right_answers[1] = 3*$a*$a*$b;
        $right_answers[2] = 3*$a*$b*$b;
        $right_answers[3] = $b*$b*$b;

        $item[0] = ($right_answers[0]>0 ? '' : '-').'\fbox{'.$option[0].'}x^3';
        $item[1] = ($right_answers[1]>0 ? '+' : '-').'\fbox{'.$option[1].'}x^{2}y';
        $item[2] = ($right_answers[2]>0 ? '+' : '-').'\fbox{'.$option[2].'}xy^{2}';
        $item[3] = ($right_answers[3]>0 ? '+' : '-').'\fbox{'.$option[3].'}y^3';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $text = '$$ ('.fo(li($a,'x')).li(sign($b),'y').')^{3}';
        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //因数分解　その１
    public function unit101_q06($unit_id){

        $question_id = 10106;
        $blanks = 4;
        $option = $this->option;

        $right_answers[0] = rand(1,5);
        do { $right_answers[1] = rand(-7,7); } while( $right_answers[1]==0 || gmp_gcd($right_answers[0],$right_answers[1])!=1 );
        $right_answers[2] = rand(1,5);
        do { $right_answers[3] = rand(-7,7); } while( $right_answers[3]==0 || gmp_gcd($right_answers[2],$right_answers[3])!=1 );

        $a = $right_answers[0]*$right_answers[2];
        $b = $right_answers[0]*$right_answers[3] + $right_answers[1]*$right_answers[2];
        $c = $right_answers[1]*$right_answers[3];


        //問題テキストの設定
        if($b === 0){
            $text = '$$ '.fo(co($a)).'x^{2}'.sign($c).'y^{2}';
        } else {
            $text = '$$ '.fo(co($a)).'x^{2}'.sign($b).'xy'.sign($c).'y^{2}';
        }

        //解答テキストの設定
        if($right_answers[0] == $right_answers[2] && $right_answers[1] == $right_answers[3]){
            $blanks = 2;
            $item[0] = '(\fbox{'.$option[0].'}x';
            $item[1] = ($right_answers[1]>0 ? '+' : '-').'\fbox{'.$option[1].'}y)^{2}';
            unset($right_answers[2]);
            unset($right_answers[3]);

        } else {
            $item[0] = '(\fbox{'.$option[0].'}x';
            $item[1] = ($right_answers[1]>0 ? '+' : '-').'\fbox{'.$option[1].'}y)';
            $item[2] = '(\fbox{'.$option[2].'}x';
            $item[3] = ($right_answers[3]>0 ? '+' : '-').'\fbox{'.$option[3].'}y)';
        }

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //因数分解　その２
    public function unit101_q07($unit_id){

        //初期設定
        $question_id = 10107;
        $blanks = 5;
        $option = $this->option;

        //変数の設定
        do { $right_answers[0] = rand(-7,7); } while( $right_answers[0]==0);
        do { $right_answers[1] = rand(-7,7); } while( $right_answers[1]==0);

        $right_answers[2] = rand(2,7);
        do { $right_answers[3] = rand(-7,7); } while( $right_answers[3]==0);
        do { $right_answers[4] = rand(-7,7); } while( $right_answers[4]==0 || gmp_gcd(gmp_gcd($right_answers[2],$right_answers[3]),$right_answers[4])!=1 );

        //答えの計算
        $a = $right_answers[2];
        $b = $right_answers[0]*$right_answers[3];
        $c = $right_answers[3]+$right_answers[0]*$right_answers[2];
        $d = $right_answers[4]+$right_answers[1]*$right_answers[2];
        $e = $right_answers[0]*$right_answers[4]+$right_answers[1]*$right_answers[3];
        $f = $right_answers[1]*$right_answers[4];


        //問題テキストの設定
        $text = '$$'.d1($a,'x^{2}').d2($b,'y^{2}').d2($c,'xy').d2($d,'x').d2($e,'y').d3($f);

        //解答テキストの設定
        $item[0] = '(x';
        $item[1] = ($right_answers[0]>0 ? '+' : '-').'\fbox{'.$option[0].'}y';
        $item[2] = ($right_answers[1]>0 ? '+' : '-').'\fbox{'.$option[1].'})';
        $item[3] = '(\fbox{'.$option[2].'}x';
        $item[4] = ($right_answers[3]>0 ? '+' : '-').'\fbox{'.$option[3].'}y';
        $item[5] = ($right_answers[4]>0 ? '+' : '-').'\fbox{'.$option[4].'})';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //３乗の因数分解
    public function unit101_q08($unit_id){

        //初期設定
        $question_id = 10108;
        $pattern = rand(1,2);
        $option = $this->option;

        switch($pattern){
            case 1:
                $blanks = 2;

                //変数の設定
                $right_answers[0] = rand(1,4);
                do { $right_answers[1] = rand(-7,7); } while( $right_answers[1]==0 || gmp_gcd($right_answers[0],$right_answers[1])!=1);

                //答えの計算
                $a = $right_answers[0]*$right_answers[0]*$right_answers[0];
                $b = 3*$right_answers[0]*$right_answers[0]*$right_answers[1];
                $c = 3*$right_answers[0]*$right_answers[1]*$right_answers[1];
                $d = $right_answers[1]*$right_answers[1]*$right_answers[1];

                //問題テキストの設定
                $text = '$$'.d1($a,'x^{3}').d2($b,'x^{2}y').d2($c,'xy^{2}').d2($d,'y^{3}');

                //解答テキストの設定
                $item[0] = '(\fbox{'.$option[0].'}x';
                $item[1] = ($right_answers[1]>0 ? '+' : '-').'\fbox{'.$option[1].'}y)^{3}';
                break;
            case 2:
                $blanks = 5;

                //変数の設定
                $a = rand(1,4);
                do { $b = rand(-7,7); } while( $b==0 || gmp_gcd($a,$b)!=1);

                //答えの計算
                $right_answers[0] = $a;
                $right_answers[1] = $b;
                $right_answers[2] = $a*$a;
                $right_answers[3] = -1*$a*$b;
                $right_answers[4] = $b*$b;

                //問題テキストの設定
                $text = '$$'.d1($a*$a*$a,'x^{3}').d2($b*$b*$b,'y^{3}');

                //解答テキストの設定
                $item[0] = '(\fbox{'.$option[0].'}x';
                $item[1] = ($right_answers[1]>0 ? '+' : '-').'\fbox{'.$option[1].'}y)';
                $item[2] = '(\fbox{'.$option[2].'}x^{2}';
                $item[3] = ($right_answers[3]>0 ? '+' : '-').'\fbox{'.$option[3].'}xy';
                $item[4] = ($right_answers[4]>0 ? '+' : '-').'\fbox{'.$option[4].'}y^{2})';

                break;
        }


        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }
    
    //分母の有理化
    public function unit101_q09($unit_id){

        //初期設定
        $question_id = 10109;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(2,7); } while( $b==4 );
        do { $c = rand(1,5); } while( $c*$c-$b <= 0 || $a == $c);

        //答えの計算
        $right_answers[0] = $a*$c - $b;
        $right_answers[1] = $c-$a;
        $right_answers[2] = $b;
        $right_answers[3] = $c*$c - $b;

        $g = gmp_gcd($right_answers[0],gmp_gcd($right_answers[1],$right_answers[3]));

        $right_answers[0] /= $g;
        $right_answers[1] /= $g;
        $right_answers[3] /= $g;


        //問題テキストの設定
        $text = '$$ \frac{'.$a.'+\sqrt{'.$b.'}}{'.$c.'+\sqrt{'.$b.'}}';

        //解答テキストの設定
        $item[0] = '\frac{'.($right_answers[0]>0 ? '' : '-').'\fbox{'.$option[0].'}';
        $item[1] = ($right_answers[1]>0 ? '+' : '-').'\fbox{'.$option[1].'}'.'\sqrt{\fbox{'.$option[2].'}}}';
        $item[2] = '{\fbox{'.$option[3].'}}';

        if($right_answers[0] == 0){
            unset($right_answers[0]);
            $item[0] = '\frac{';
            $item[1] = fo($item[1]);
            unset($option[0]);
            $blanks -= 1;
        }

        if(abs($right_answers[1]) == 1){
            unset($right_answers[1]);
            $item[1] = str_replace('\fbox{'.$option[1].'}','',$item[1]);
            unset($option[1]);
            $blanks -= 1;
        }

        if($right_answers[3] == 1){
            unset($right_answers[3]);
            $item[0] = str_replace('\frac{','',$item[0]);
            $item[1] = str_replace('}}}','}}',$item[1]);
            $item[2] = '';
            unset($option[3]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //対称式
    public function unit101_q10($unit_id){

        //初期設定
        $question_id = 10110;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-10,10); } while( $a==0 );
        do { $b = rand(-10,10); } while( $b==0 );

        //答えの計算
        $right_answers[0] = $a*$b;
        $right_answers[1] = $a*$a - 2*$b;

        //問題テキストの設定
        $text = '$$ x+y='.$a.'、xy='.$b.'のとき、';

        //解答テキストの設定
        $blank_text = 'x^{2}y+xy^{2}=\fbox{ア}、x^{2}+y^{2}=\fbox{イ}'.'$$';

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //絶対値を含む1次不等式
    public function unit101_q11($unit_id){

        //初期設定
        $question_id = 10111;
        $blanks = 2;
        $option = $this->option;
        $pattern = rand(1,2);

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(1,5); } while( $b==0 );

        //答えの計算
        $right_answers[0] = -1*$b - $a;
        $right_answers[1] = $b - $a;

        switch($pattern){
            case 1:    //小なり
                $text = '$$ |x'.d3($a).'| ≦ '.$b.'  のとき、';
                $blank_text = '\fbox{ア} ≦ x ≦ \fbox{イ} $$';
                break;
            case 2:    //大なり
                $text = '$$ |x'.d3($a).'| > '.$b.'  のとき、';
                $blank_text = 'x < \fbox{ア} 、\fbox{イ} < x $$';
                break;
        }

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //連立1次不等式
    public function unit101_q12($unit_id){

        //初期設定
        $question_id = 10112;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        $b = rand(1,7);
        do { $d = rand(-7,7); } while( $d==0 );
        $e = rand(1,7);
        do { $c = rand(1,7); $f = rand(1,7); } 
        while( (($c-$b)/$a >= ($f-$e)/$d) || (gmp_gcd(gmp_gcd($a,$b),$c)!=1) || (gmp_gcd(gmp_gcd($d,$e),$f)!=1));

        //答えの計算
        $right_answers[0] = $c - $b;
        $right_answers[1] = $a;
        $right_answers[2] = $f - $e;
        $right_answers[3] = $d;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text =   '$$ \begin{cases}'.d1($a).'x'.d3($b).'\geqq '.$c.'  \\\ '.d1($d).'x'.d3($e).'\leqq '.$f.' \end{cases} を解くと、\\\ ';

        //空欄テキストの設定
        if($d > 0){
            $item[0] = ($right_answers[0]>=0 ? '' : '-').'\frac{\fbox{'.$option[0].'}}{\fbox{'.$option[1].'}}';
            $item[1] = '\leqq x \leqq ';
            $item[2] = ($right_answers[2]*$right_answers[3]>=0 ? '' : '-').'\frac{\fbox{'.$option[2].'}}{\fbox{'.$option[3].'}}';

            if($right_answers[1] == 1){
                unset($right_answers[1]);
                $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
                unset($option[1]);
                $blanks -= 1;
            }
    
            if($right_answers[3] == 1){
                unset($right_answers[3]);
                $item[2] = str_replace(['\frac{','}{\fbox{'.$option[3].'}}'],['',''],$item[2]);
                unset($option[3]);
                $blanks -= 1;
            }

        } else {
            $blanks = 2;
            $item[0] = 'x \geqq ';
            $item[1] = ($right_answers[2]*$right_answers[3]>=0 ? '' : '-').'\frac{\fbox{'.$option[0].'}}{\fbox{'.$option[1].'}}';
            $right_answers[0] = $right_answers[2];
            $right_answers[1] = $right_answers[3];
            unset($right_answers[2]);
            unset($right_answers[3]);

            if($right_answers[1] == 1){
                unset($right_answers[1]);
                $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[1]);
                unset($option[1]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //２次関数（102）
    //放物線の軸、頂点
    public function unit102_q01($unit_id){
        //初期設定
        $question_id = 10201;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-6,6); } while( $a==0 );
        do { $b = rand(-6,6); } while( $b==0 );
        do { $c = rand(-6,6); } while( $c==0 );

        //答えの計算
        $right_answers[0] = $b;
        $right_answers[1] = 2*$a;
        $right_answers[2] = $b;
        $right_answers[3] = 2*$a;
        $right_answers[4] = -1*$b*$b + 4*$a*$c;
        $right_answers[5] = 4*$a;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);


        //正解テキストの設定
        $text = '$$ y='.d1($a).'x^{2}'.d2($b).'x'.d3($c).'\\ について、\\\\';

        //空欄テキストの設定
        $item[0] = '軸は\\ x='.(-1*$right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}、';
        $item[1] = '頂点は\\ ('.(-1*$right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}},';
        $item[2] = ($right_answers[4]*$right_answers[5]<0?'-':'').'\frac{\fbox{オ}}{\fbox{カ}})';

        for($i=0;$i<3;$i++){
            if($right_answers[2*$i+1] == 1){
                unset($right_answers[2*$i+1]);
                $item[$i] = str_replace(['\frac{','}{\fbox{'.$option[2*$i+1].'}}'],['',''],$item[$i]);
                unset($option[2*$i+1]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //平行移動
    public function unit102_q02($unit_id){
        //初期設定
        $question_id = 10202;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-6,6); } while( $a==0 );
        do { $b = rand(-6,6); } while( $b==0 );
        do { $c = rand(-6,6); } while( $c==0 );
        do { $d = rand(-6,6); } while( $d==0 );
        do { $e = rand(-6,6); } while( $e==0 );

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = $b - 2*$a*$d;
        $right_answers[2] = $a*$d*$d + $c + $e - $b*$d;

        //正解テキストの設定
        $text = '$$ 放物線 \\ y='.d1($a).'x^{2}'.d2($b).'x'.d3($c).'\\ について、\\\\'
                    . 'x軸方向に'.$d.'、y軸方向に'.$e.'だけ平行移動すると、\\\\';

        //空欄テキストの設定
        $item[0] = 'y='.($right_answers[0]<0?'-':'').'\fbox{ア}x^{2}';
        $item[1] = ($right_answers[1]<0?'-':'+').'\fbox{イ}x';
        $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}';

        if($right_answers[1] == 0){
            unset($right_answers[1]);
            $item[1] = str_replace('+\fbox{'.$option[1].'}x','',$item[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if($right_answers[2] == 0){
            unset($right_answers[2]);
            $item[2] = str_replace('+\fbox{'.$option[2].'}','',$item[2]);
            unset($option[2]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //対称移動
    public function unit102_q03($unit_id){
        //初期設定
        $question_id = 10203;
        $blanks = 3;
        $option = $this->option;
        $pattern = rand(1,3);

        //変数の設定
        do { $a = rand(-6,6); } while( $a==0 );
        do { $b = rand(-6,6); } while( $b==0 );
        do { $c = rand(-6,6); } while( $c==0 );

        //答えの計算
        switch($pattern){
            case 1:
                $right_answers[0] = $a;
                $right_answers[1] = -1*$b;
                $right_answers[2] = $c;
                break;
            case 2:
                $right_answers[0] = -1*$a;
                $right_answers[1] = -1*$b;
                $right_answers[2] = -1*$c;
                break;
            case 3:
                $right_answers[0] = -1*$a;
                $right_answers[1] = $b;
                $right_answers[2] = -1*$c;
                break;
        }

        //正解テキストの設定
        $text = '$$ 放物線 \\ y='.d1($a).'x^{2}'.d2($b).'x'.d3($c).'\\ について、\\\\';
        switch($pattern){
            case 1:
                $text.= 'x軸に関して平行移動すると、\\\\';
                break;
            case 2:
                $text.= 'y軸に関して平行移動すると、\\\\';
                break;
            case 3:
                $text.= '原点に関して平行移動すると、\\\\';
                break;
        }

        //空欄テキストの設定
        $item[0] = 'y='.($right_answers[0]<0?'-':'').'\fbox{ア}x^{2}';
        $item[1] = ($right_answers[1]<0?'-':'+').'\fbox{イ}x';
        $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}';

        /*
        if($right_answers[1] == 0){
            unset($right_answers[1]);
            $item[1] = str_replace('+\fbox{'.$option[1].'}x','',$item[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if($right_answers[2] == 0){
            unset($right_answers[2]);
            $item[2] = str_replace('+\fbox{'.$option[2].'}','',$item[2]);
            unset($option[2]);
            $blanks -= 1;
        }
        */

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //２次関数の最大・最小　その１
    public function unit102_q04($unit_id){
        //初期設定
        $question_id = 10204;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-6,6); } while( $a==0 );
        do { $b = rand(-6,6); } while( $b==0 );
        do { $c = rand(-6,6); } while( $c==0 );

        //答えの計算
        $right_answers[0] = -1*$b;
        $right_answers[1] = 2*$a;
        $right_answers[2] = -1*$b*$b + 4*$a*$c;
        $right_answers[3] = 4*$a;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //正解テキストの設定
        $text = '$$ ２次関数 \\ y='.d1($a).'x^{2}'.d2($b).'x'.d3($c).'\\ は、\\\\';

        //空欄テキストの設定
        $item[0] = 'x='.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}のとき、';
        if($a > 0){
            $item[1] = '最小値'; 
        } else {
            $item[1] = '最大値';
        }
        $item[2] = ($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}}をとる';

        if($right_answers[1] == 1){
            unset($right_answers[1]);
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
            unset($option[1]);
            $blanks -= 1;
        }
        if($right_answers[3] == 1){
            unset($right_answers[3]);
            $item[2] = str_replace(['\frac{','}{\fbox{'.$option[3].'}}'],['',''],$item[2]);
            unset($option[3]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //２次関数の最大・最小　その２
    public function unit102_q05($unit_id){
        //初期設定
        $question_id = 10205;
        $blanks = 8;
        $option = $this->option;
        $flag = 0;  //答えテキストの場合分け

        //変数の設定
        do { $a = rand(-6,6); } while( $a==0 );
        do { $b = rand(-6,6); } while( $b==0 );
        do { $c = rand(-6,6); } while( $c==0 );
        $d = rand(-6,0);
        do { $e = rand(-6,6); } while( $d >= $e || $a*$d*$d+$b*$d+$c == $a*$e*$e + $b*$e + $c);

        //答えの計算
        for($i=0;$i<8;$i++){
            $right_answers[$i] = 1;
        }
        $f_d = $a*$d*$d + $b*$d + $c;
        $f_e = $a*$e*$e + $b*$e + $c;
        $axis = (-1*$b)/(2*$a);
        if($d < $axis && $axis < $e){    //範囲内に軸がある場合
            if($a>0){   //下に凸の場合
                //最大値の処理
                if($f_d > $f_e){    //x=dの時最大値
                    $right_answers[0] = $d;
                    $right_answers[2] = $f_d;
                } elseif($f_d < $f_e){  //x=eの時最大値
                    $right_answers[0] = $e;
                    $right_answers[2] = $f_e;
                }
                //最小値の処理
                $right_answers[4] = -1*$b;
                $right_answers[5] = 2*$a;
                $right_answers[6] = -1*$b*$b + 4*$a*$c;
                $right_answers[7] = 4*$a;

                list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);
                list($right_answers[6],$right_answers[7]) = gcd($right_answers[6],$right_answers[7]);

            } else {    //上に凸の場合
                //最大値の処理
                $right_answers[0] = -1*$b;
                $right_answers[1] = 2*$a;
                $right_answers[2] = -1*$b*$b + 4*$a*$c;
                $right_answers[3] = 4*$a;

                list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
                list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
                //最小値の処理
                if($f_d < $f_e){    //x=dの時最小値
                    $right_answers[4] = $d;
                    $right_answers[6] = $f_d;
                } elseif($f_d > $f_e){  //x=eの時最小値
                    $right_answers[4] = $e;
                    $right_answers[6] = $f_e;
                }
            }
        } else {    //範囲外に軸がある場合
            if($f_d>$f_e){  //x=dのほうが大きい場合
                $right_answers[0] = $d;
                $right_answers[2] = $f_d;
                $right_answers[4] = $e;
                $right_answers[6] = $f_e;
            } else {    //x=eのほうが大きい場合
                $right_answers[0] = $e;
                $right_answers[2] = $f_e;
                $right_answers[4] = $d;
                $right_answers[6] = $f_d;
            }
        }

        //正解テキストの設定
        $text = '$$ ２次関数 \\ y='.d1($a).'x^{2}'.d2($b).'x'.d3($c).'\\ ('.$d.'\leqq x \leqq'.$e.')\\ は、\\\\';

        //空欄テキストの設定
        $item[0] = 'x='.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}のとき、';
        $item[1] = '最大値'.($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}}をとり、\\\\';
        $item[2] = 'x='.($right_answers[4]*$right_answers[5]<0?'-':'').'\frac{\fbox{オ}}{\fbox{カ}}のとき、';
        $item[3] = '最小値'.($right_answers[6]*$right_answers[7]<0?'-':'').'\frac{\fbox{キ}}{\fbox{ク}}をとる';

        for($i=0;$i<4;$i++){
            if($right_answers[2*$i+1] == 1){
                unset($right_answers[2*$i+1]);
                $item[$i] = str_replace(['\frac{','}{\fbox{'.$option[2*$i+1].'}}'],['',''],$item[$i]);
                unset($option[2*$i+1]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //２次関数の決定
    public function unit102_q06($unit_id){
        //初期設定
        $question_id = 10206;
        $blanks = 5;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-6,6); } while( $a==0 );
        $b = rand(-6,6);
        do { $c = rand(-6,6); } while( $c==0 || $a == $c);
        do { $d = rand(-6,6); } while( $d==0 );

        //答えの計算
        $right_answers[0] = $a*$d - $a*$b + $b*$c;
        $right_answers[1] = $a*$c*($c-$a);
        $right_answers[2] = $a*$a*$d - $a*$a*$b + $b*$c*$c;
        $right_answers[3] = $a*$c*($a-$c);
        $right_answers[4] = $b;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //正解テキストの設定
        $text = '$$ ３点\\ ('.$a.',0)、\\ (0,'.$b.')、\\ ('.$c.','.$d.')\\ を通る二次関数は、\\\\';

        //空欄テキストの設定
        $item[0] = 'y='.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}x^{2}';
        $item[1] = ($right_answers[2]*$right_answers[3]<0?'-':'+').'\frac{\fbox{ウ}}{\fbox{エ}}x';
        $item[2] = ($right_answers[4]<0?'-':'+').'\fbox{オ}';

        if(abs($right_answers[1]) == 1){
            unset($right_answers[1]);
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
            unset($option[1]);
            $blanks -= 1;
        }
        if(abs($right_answers[3]) == 1){
            unset($right_answers[3]);
            $item[1] = str_replace(['\frac{','}{\fbox{'.$option[3].'}}'],['',''],$item[1]);
            unset($option[3]);
            $blanks -= 1;
        }
        if($right_answers[0] == 0){
            unset($right_answers[0]);
            $item[0] = 'y=';
            unset($option[0]);
            $blanks -= 1;
            if(isset($right_answers[1])){
                unset($option[1]);
                $blanks -= 1;
            }
        }
        if($right_answers[2] == 0){
            unset($right_answers[2]);
            $item[1] = '';
            unset($option[2]);
            $blanks -= 1;
            if(isset($right_answers[3])){
                unset($option[3]);
                $blanks -= 1;
            }
        }
        if($right_answers[4] == 0){
            unset($right_answers[4]);
            $item[2] = '';
            unset($option[4]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //２次方程式
    public function unit102_q07($unit_id){
        //初期設定
        $question_id = 10207;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $right_answers[0] = rand(1,5);
        do { $right_answers[1] = rand(-7,7); } while( $right_answers[1]==0 || gmp_gcd($right_answers[0],$right_answers[1])!=1 );
        $right_answers[2] = rand(1,5);
        do { $right_answers[3] = rand(-7,7); } while( 
            $right_answers[3]==0 || gmp_gcd($right_answers[2],$right_answers[3])!=1 ||
            ($right_answers[0] == $right_answers[2] && $right_answers[1] == $right_answers[3]));

        $a = $right_answers[1]*$right_answers[3];
        $b = $right_answers[0]*$right_answers[3] + $right_answers[1]*$right_answers[2];
        $c = $right_answers[0]*$right_answers[2];

        if(-1*$right_answers[0]/$right_answers[1] > -1*$right_answers[2]/$right_answers[3]){
            $right_answers = array($right_answers[2],$right_answers[3],$right_answers[0],$right_answers[1]);
        }

        //正解テキストの設定
        $text = '$$ ２次方程式:\\ '.d1($a).'x^{2}'.d2($b,'x').d3($c).'=0 \\ の解は、\\\\';

        //空欄テキストの設定
        $item[0] = 'x='.(-1*$right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}、';
        $item[1] = (-1*$right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}} \\ ';
        $item[2] = '(ただし、'.(-1*$right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}} \lt '.(-1*$right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}})';

        if(abs($right_answers[1]) == 1){
            unset($right_answers[1]);
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
            $item[2] = str_replace('\frac{\fbox{ア}}{\fbox{イ}}','\fbox{ア}',$item[2]);
            unset($option[1]);
            $blanks -= 1;
        }
        if(abs($right_answers[3]) == 1){
            unset($right_answers[3]);
            $item[1] = str_replace(['\frac{','}{\fbox{'.$option[3].'}}'],['',''],$item[1]);
            $item[2] = str_replace('\frac{\fbox{ウ}}{\fbox{エ}}','\fbox{ウ}',$item[2]);
            unset($option[3]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //判別式
    public function unit102_q08($unit_id){
        $question_id = 10208;
        $blanks = 2;
        $option = $this->option;
        $pattern = rand(1,3);

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );

        //答えの計算
        $right_answers[0] = $b*$b - 4*$a*$c;
        $right_answers[1] = 4*$a;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //正解テキストの設定
        $text = '$$ xの２次方程式 \\ '.d1($a,'x^{2}').d2($b,'x').'+k'.d3($c).'=0 \\ が \\\\';
        switch($pattern){
            case 1:
                $text .= '異なる２つの実数解を持つとき、';
                break;
            case 2:
                $text .= '重解を持つとき、';
                break;
            case 3:
                $text .= '実数解をもたないとき、';
                break;
        }
        $text .= 'kの範囲は、\\\\';

        //空欄テキストの設定
        switch($pattern){
            case 1:
                $item[0] = 'k \lt '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';
                break;
            case 2:
                $item[0] = 'k = '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';
                break;
            case 3:
                $item[0] = 'k \gt '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';
                break;
        }

        if($right_answers[1] == 1){
            unset($right_answers[1]);
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
            unset($option[1]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //２次不等式　その１
    public function unit102_q09($unit_id){
        $question_id = 10209;
        $blanks = 8;
        $option = $this->option;
        $pattern = rand(1,2);

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 || $b*$b -4*$a*$c <= 0);

        //答えの計算
        $right_answers[0] = -1*$b; 
        $right_answers[1] = -1;
        $right_answers[2] = $b*$b - 4*$a*$c;
        $right_answers[3] = 2*$a;

        $right_answers[4] = -1*$b; 
        $right_answers[5] = 1;
        $right_answers[6] = $b*$b - 4*$a*$c;
        $right_answers[7] = 2*$a;

        list($right_answers[1],$right_answers[2]) = root($right_answers[1],$right_answers[2]);
        list($right_answers[5],$right_answers[6]) = root($right_answers[5],$right_answers[6]);

        $s = gmp_gcd(gmp_gcd($right_answers[0],$right_answers[1]),$right_answers[3]);
        list($right_answers[0],$right_answers[1],$right_answers[3]) = array($right_answers[0]/$s,$right_answers[1]/$s,$right_answers[3]/$s);
        list($right_answers[4],$right_answers[5],$right_answers[7]) = array($right_answers[4]/$s,$right_answers[5]/$s,$right_answers[7]/$s);

        //正解テキストの設定
        switch($pattern){
            case 1:
                $text = '$$ ２次不等式:'.d1($a,'x^{2}').d2($b,'x').d3($c).'\gt 0 \\ の解は、\\\\';
                break;
            case 2:
                $text = '$$ ２次不等式:'.d1($a,'x^{2}').d2($b,'x').d3($c).'\lt 0 \\ の解は、\\\\';
                break;
        }

        //空欄テキストの設定
        $item[0] = 'x \lt \frac{'.($right_answers[0]<0?'-':'').'\fbox{ア}-\fbox{イ}\sqrt{\fbox{ウ}}}{\fbox{エ}}、';
        $item[1] = '\frac{'.($right_answers[4]<0?'-':'').'\fbox{オ}+\fbox{カ}\sqrt{\fbox{キ}}}{\fbox{ク}} \lt x';

        switch($pattern){
            case 1:
                $item[0] = 'x \lt \frac{'.($right_answers[0]<0?'-':'').'\fbox{ア}-\fbox{イ}\sqrt{\fbox{ウ}}}{\fbox{エ}}、';
                $item[1] = '\frac{'.($right_answers[4]<0?'-':'').'\fbox{オ}+\fbox{カ}\sqrt{\fbox{キ}}}{\fbox{ク}} \lt x';
                break;
            case 2:
                $item[0] = '\frac{'.($right_answers[0]<0?'-':'').'\fbox{ア}-\fbox{イ}\sqrt{\fbox{ウ}}}{\fbox{エ}} \lt x \lt';
                $item[1] = '\frac{'.($right_answers[4]<0?'-':'').'\fbox{オ}+\fbox{カ}\sqrt{\fbox{キ}}}{\fbox{ク}}';
                break;
        }

        if($right_answers[2] == 1){ //√の中身が１
            $blanks = 4;
            $right_answers[0] += $right_answers[1];
            $right_answers[1] = $right_answers[3];
            $right_answers[2] = $right_answers[4] + $right_answers[5];
            $right_answers[3] = $right_answers[7];
            list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
            list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
            for($i=4;$i<8;$i++){
                unset($right_answers[$i]);
            }
 
            switch($pattern){
                case 1:
                    $item[0] = 'x \lt '.($right_answers[0]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}、';
                    $item[1] = ($right_answers[2]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}} \lt x';
                    break;
                case 2:
                    $item[0] = ($right_answers[0]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}} \lt x \lt';
                    $item[1] = ($right_answers[2]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}}';
                    break;
                }
            
            if($right_answers[1] == 1){
                unset($right_answers[1]);
                $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
                unset($option[1]);
                $blanks -= 1;
            }
            if($right_answers[3] == 1){
                unset($right_answers[3]);
                $item[1] = str_replace(['\frac{','}{\fbox{'.$option[3].'}}'],['',''],$item[1]);
                unset($option[3]);
                $blanks -= 1;
            }
        } else {
            if(abs($right_answers[1])==1){  //√の係数が１
                unset($right_answers[1]);
                unset($right_answers[5]);
                $item[0] = str_replace('\fbox{'.$option[1].'}','',$item[0]);
                $item[1] = str_replace('\fbox{'.$option[5].'}','',$item[1]);
                unset($option[1]);
                unset($option[5]);
                $blanks -= 2;
            }
            if($right_answers[3] == 1){ //分母が1
                unset($right_answers[3]);
                unset($right_answers[7]);
                $item[0] = str_replace(['\frac{','}{\fbox{'.$option[3].'}}'],['',''],$item[0]);
                $item[1] = str_replace(['\frac{','}{\fbox{'.$option[7].'}}'],['',''],$item[1]);
                unset($option[3]);
                unset($option[7]);
                $blanks -= 2;
            }

        }
        
        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //２次不等式　その２
    public function unit102_q10($unit_id){
        //初期設定
        $question_id = 10210;
        $blanks = 2;
        $pattern = rand(1,2);

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); 
             $c = rand(-5,5); 
            } while( $b==0 || $c==0 || $b*$b -4*$a*$c >= 0);

        //答えの設定
        switch($pattern){
            case 1:
                if($a > 0){
                    $right_answers[0] = 2;
                } else {
                    $right_answers[0] = 1;
                }
                break;
            case 2:
                if($a > 0){
                    $right_answers[0] = 1;
                } else {
                    $right_answers[0] = 2;
                }
                break;
        }

        //正解テキストの設定
        $text = '$$ ２次不等式：'.d1($a,'x^{2}').d2($b,'x').d3($c);
        switch($pattern){
            case 1:
                $text .= '\gt 0 \\ の解は、\\\\' ;
                break;
            case 2:
                $text .= '\lt 0 \\ の解は、\\\\' ;
                break;
        }

        $item[0] = '①　なし\\\\';
        $item[1] = '②　すべての実数';

        $options[0] = '①　なし';
        $options[1] = '②　すべての実数';

        $blank_text = implode($item).'$$';
        return view('question/select',compact('right_answers','unit_id','question_id','text','options','blanks','blank_text'));
    }

    //放物線と軸の関係
    public function unit102_q11($unit_id){
        $question_id = 10211;
        $blanks = 8;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 || 4*$a*$a + 4*$a*$b*$b*$c <= 0);

        //答えの計算
        $right_answers[0] = 2*$a;
        $right_answers[1] = -1;
        $right_answers[2] = 4*$a*$a + 4*$a*$b*$b*$c;
        $right_answers[3] = $b*$b;

        $right_answers[4] = 2*$a;
        $right_answers[5] = 1;
        $right_answers[6] = 4*$a*$a + 4*$a*$b*$b*$c;
        $right_answers[7] = $b*$b;

        list($right_answers[1],$right_answers[2]) = root($right_answers[1],$right_answers[2]);
        list($right_answers[5],$right_answers[6]) = root($right_answers[5],$right_answers[6]);

        $s = gmp_gcd(gmp_gcd($right_answers[0],$right_answers[1]),$right_answers[3]);
        list($right_answers[0],$right_answers[1],$right_answers[3]) = array($right_answers[0]/$s,$right_answers[1]/$s,$right_answers[3]/$s);
        list($right_answers[4],$right_answers[5],$right_answers[7]) = array($right_answers[4]/$s,$right_answers[5]/$s,$right_answers[7]/$s);

        //正解テキストの設定
        $text = '$$ 放物線：y='.d1($a,'x^{2}').d2($b,'kx').d3($c).'+k \\\\ が\\ x\\ 軸に接するとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'k=\frac{'.($right_answers[0]<0?'-':'').'\fbox{ア}-\fbox{イ}\sqrt{\fbox{ウ}}}{\fbox{エ}}、';
        $item[1] = '\frac{'.($right_answers[4]<0?'-':'').'\fbox{オ}+\fbox{カ}\sqrt{\fbox{キ}}}{\fbox{ク}}';

        if($right_answers[2] == 1){ //√の中身が１
            $blanks = 4;
            $right_answers[0] += $right_answers[1];
            $right_answers[1] = $right_answers[3];
            $right_answers[2] = $right_answers[4] + $right_answers[5];
            $right_answers[3] = $right_answers[7];
            list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
            list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
            for($i=4;$i<8;$i++){
                unset($right_answers[$i]);
            }
 
            $item[0] = 'k='.($right_answers[0]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}、';
            $item[1] = ($right_answers[2]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}}';
            
            if($right_answers[1] == 1){
                unset($right_answers[1]);
                $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
                unset($option[1]);
                $blanks -= 1;
            }
            if($right_answers[3] == 1){
                unset($right_answers[3]);
                $item[1] = str_replace(['\frac{','}{\fbox{'.$option[3].'}}'],['',''],$item[1]);
                unset($option[3]);
                $blanks -= 1;
            }

        } else {
            if(abs($right_answers[1])==1){  //√の係数が１
                unset($right_answers[1]);
                unset($right_answers[5]);
                $item[0] = str_replace('\fbox{'.$option[1].'}','',$item[0]);
                $item[1] = str_replace('\fbox{'.$option[5].'}','',$item[1]);
                unset($option[1]);
                unset($option[5]);
                $blanks -= 2;
            }
            if($right_answers[3] == 1){ //分母が1
                unset($right_answers[3]);
                unset($right_answers[7]);
                $item[0] = str_replace(['\frac{','}{\fbox{'.$option[3].'}}'],['',''],$item[0]);
                $item[1] = str_replace(['\frac{','}{\fbox{'.$option[7].'}}'],['',''],$item[1]);
                unset($option[3]);
                unset($option[7]);
                $blanks -= 2;
            }

        }
        
        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //図形と計量（103）
    //三角比の相互関係
    public function unit103_q01($unit_id){
        $question_id = 10301;
        $blanks = 6;
        $option = $this->option;
        //$pattern = rand(1,2);

        //変数の設定
        do { $a = rand(-7,7); } while( $a==0 );
        do { $b = rand(1,8); } while( abs($a/$b) >= 1 );
        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = 1;
        $right_answers[1] = $b*$b - $a*$a;
        $right_answers[2] = $b;
        $right_answers[3] = 1;
        $right_answers[4] = $b*$b - $a*$a;
        $right_answers[5] = $a;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);
        list($right_answers[3],$right_answers[4]) = root($right_answers[3],$right_answers[4]);

        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);

        //正解テキストの設定
        $text = '$$ 0° \leqq \alpha \leqq 180° で、\cos \alpha ='.($a*$b<0?'-':'').'\frac{'.abs($a).'}{'.abs($b).'}のとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\sin \alpha =\frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}、';
        $item[1] = '\tan \alpha ='.($a<0?'-':'').'\frac{\fbox{エ}\sqrt{\fbox{オ}}}{\fbox{カ}}、';

        for($i=0;$i<2;$i++){
            if($right_answers[3*$i] == 1 && $right_answers[3*$i+1] != 1){
                $item[$i] = str_replace('\fbox{'.$option[3*$i].'}','',$item[$i]);
                unset($right_answers[3*$i]);
                unset($option[3*$i]);
                $blanks -= 1;
            }
            if($right_answers[3*$i+1] == 1){
                $item[$i] = str_replace('\sqrt{\fbox{'.$option[3*$i+1].'}}','',$item[$i]);
                unset($right_answers[3*$i+1]);
                unset($option[3*$i+1]);
                $blanks -= 1;
            }
            if(abs($right_answers[3*$i+2]) == 1){
                $item[$i] = str_replace(['\frac{','}{\fbox{'.$option[3*$i+2].'}}'],['',''],$item[$i]);
                unset($right_answers[3*$i+2]);
                unset($option[3*$i+2]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角方程式
    public function unit103_q02($unit_id){
        //初期設定
        $question_id = 10302;
        $blanks = 1;
        $option = $this->option;

        $deg = [0,30,45,60,90,120,135,150,180];

        //変数の設定
        $degree = $deg[rand(0,8)];
        $a; $b;
        list($b,$a) = d_cos($degree);
        $a *= -1;

        //答えの計算
        $right_answers[0] = $degree;

        //正解テキストの設定
        $text = '$$ 0° \leqq \alpha \leqq 180° で、'.d1($a,'\cos \theta').'+\sqrt{'.$b.'}=0 \\ のとき、\\\\';
        if($b == 1){
            $text = str_replace('\sqrt{'.$b.'}',$b,$text);
        } elseif($b == 0){
            $text = str_replace('+\sqrt{'.$b.'}','',$text);
        }

        //空欄テキストの設定
        $blank_text = '\theta = \fbox{ア}° $$';

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //特別な角度の三角比
    public function unit103_q03($unit_id){
        $question_id = 10303;
        $blanks = 10;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-7,7); } while( $a==0 );
        do { $b = rand(1,8); } while( abs($a/$b) >= 1 );
        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = $b;
        $right_answers[2] = 1;
        $right_answers[3] = $b*$b - $a*$a;
        $right_answers[4] = $b;
        $right_answers[5] = 1;
        $right_answers[6] = $b*$b - $a*$a;
        $right_answers[7] = $b;
        $right_answers[8] = -1*$a;
        $right_answers[9] = $b;

        list($right_answers[2],$right_answers[3]) = root($right_answers[2],$right_answers[3]);
        list($right_answers[5],$right_answers[6]) = root($right_answers[5],$right_answers[6]);

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[4]) = gcd($right_answers[2],$right_answers[4]);
        list($right_answers[5],$right_answers[7]) = gcd($right_answers[5],$right_answers[7]);
        list($right_answers[8],$right_answers[9]) = gcd($right_answers[8],$right_answers[9]);

        //正解テキストの設定
        $text = '$$ 0° \lt \theta \lt 180° で、\cos \theta ='.($a*$b<0?'-':'').'\frac{'.abs($a).'}{'.abs($b).'}のとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\sin (90°-\theta) ='.($right_answers[0]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}、';
        $item[1] = '\cos (90°-\theta) =\frac{\fbox{ウ}\sqrt{\fbox{エ}}}{\fbox{オ}}、\\\\';
        $item[2] = '\sin (180°-\theta) =\frac{\fbox{カ}\sqrt{\fbox{キ}}}{\fbox{ク}}、';
        $item[3] = '\cos (180°-\theta) ='.($right_answers[8]<0?'-':'').'\frac{\fbox{ケ}}{\fbox{コ}}';


        if($right_answers[2] == 1 && $right_answers[3] != 1){
            $item[1] = str_replace('\fbox{'.$option[2].'}','',$item[1]);
            $item[2] = str_replace('\fbox{'.$option[5].'}','',$item[2]);
            unset($right_answers[2]);
            unset($right_answers[5]);
            unset($option[2]);
            unset($option[5]);
            $blanks -= 2;
        }
        if($right_answers[3] == 1){
            $item[1] = str_replace('\sqrt{\fbox{'.$option[3].'}}','',$item[1]);
            $item[2] = str_replace('\sqrt{\fbox{'.$option[6].'}}','',$item[2]);
            unset($right_answers[3]);
            unset($right_answers[6]);
            unset($option[3]);
            unset($option[6]);
            $blanks -= 2;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //正弦定理　その１
    public function unit103_q04($unit_id){
        $question_id = 10304;
        $blanks = 3;
        $option = $this->option;

        $deg = [30,45,60,90,120,135];

        //変数の設定
        $dB = $deg[rand(0,5)];
        do { $dC = $deg[rand(0,5)]; } while( $dB+$dC >= 180 );
        $dA = 180 - ($dB+$dC);
        $a = rand(2,9);
        list($b_n,$b_d) = d_sin($dB);
        list($c_n,$c_d) = d_sin($dC);

        //答えの計算
        $right_answers[0] = $a*$c_d;
        $right_answers[1] = $b_n*$c_n;
        $right_answers[2] = $b_d*$c_n;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);

        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);

        //正解テキストの設定
        $text = '$$ △ABCにおいて、\\\\AB='.$a.'、∠A='.$dA.'°、∠B='.$dB.'°のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'AC =\frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}';

        if($right_answers[0] == 1 && $right_answers[1] != 1){
            $item[0] = str_replace('\fbox{'.$option[0].'}','',$item[0]);
            unset($right_answers[0]);
            unset($option[0]);
            $blanks -= 1;
        }
        if($right_answers[1] == 1){
            $item[0] = str_replace('\sqrt{\fbox{'.$option[1].'}}','',$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if($right_answers[2] == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[2].'}}'],['',''],$item[0]);
            unset($right_answers[2]);
            unset($option[2]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //正弦定理　その２
    public function unit103_q05($unit_id){
        $question_id = 10305;
        $blanks = 3;
        $option = $this->option;

        $deg = [30,45,60,90,120,135];

        //変数の設定
        $dB = $deg[rand(0,5)];
        do { $dC = $deg[rand(0,5)]; } while( $dB+$dC >= 180 );
        $dA = 180 - ($dB+$dC);
        $a = rand(2,9);
        list($c_n,$c_d) = d_sin($dC);

        //答えの計算
        $right_answers[0] = $a*$c_d;
        $right_answers[1] = $c_n;
        $right_answers[2] = 2*$c_n;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);

        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);

        //正解テキストの設定
        $text = '$$ △ABCにおいて、\\\\AB='.$a.'、∠A='.$dA.'°、∠B='.$dB.'°のとき、\\\\';

        //空欄テキストの設定
        $item[0] = '外接円の半径Rは、R =\frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}';

        if($right_answers[0] == 1 && $right_answers[1] != 1){
            $item[0] = str_replace('\fbox{'.$option[0].'}','',$item[0]);
            unset($right_answers[0]);
            unset($option[0]);
            $blanks -= 1;
        }
        if($right_answers[1] == 1){
            $item[0] = str_replace('\sqrt{\fbox{'.$option[1].'}}','',$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if($right_answers[2] == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[2].'}}'],['',''],$item[0]);
            unset($right_answers[2]);
            unset($option[2]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //余弦定理　その１
    public function unit103_q06($unit_id){
        $question_id = 10306;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        do { $b = rand(1,7); } while( $a == $b );
        $c = rand(1,7);
        do { $d = rand(2,8); } while( abs($c/$d) >= 1 || gmp_gcd($c,$d) != 1);

        //答えの計算
        $right_answers[0] = 1;
        $right_answers[1] = $a*$a*$d*$d + $b*$b*$d*$d - 2*$a*$b*$c*$d;
        $right_answers[2] = $d;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);

        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);

        //正解テキストの設定
        $text = '$$ △ABCにおいて、\\\\AB='.$a.'、BC='.$b.'、\cos B = \frac{'.$c.'}{'.$d.'}のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'AC=\frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}';

        if($right_answers[0] == 1 && $right_answers[1] != 1){
            $item[0] = str_replace('\fbox{'.$option[0].'}','',$item[0]);
            unset($right_answers[0]);
            unset($option[0]);
            $blanks -= 1;
        }
        if($right_answers[1] == 1){
            $item[0] = str_replace('\sqrt{\fbox{'.$option[1].'}}','',$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if($right_answers[2] == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[2].'}}'],['',''],$item[0]);
            unset($right_answers[2]);
            unset($option[2]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //余弦定理　その２
    public function unit103_q07($unit_id){
        $question_id = 10307;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a; $b; $c;
        list($a,$b,$c) = make_tri();

        //答えの計算
        $right_answers[0] = $a*$a + $b*$b - $c*$c;
        $right_answers[1] = 2*$a*$b;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //正解テキストの設定
        $text = '$$ △ABCにおいて、\\\\AB='.$a.'、BC='.$b.'、CA='.$c.'、のとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\cos B ='.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';

        if($right_answers[1] == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角形の面積
    public function unit103_q08($unit_id){
        $question_id = 10308;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $a; $b; $c;
        list($a,$b,$c) = make_tri();

        //答えの計算
        $right_answers[0] = 1;
        $right_answers[1] = 4*$a*$a*$b*$b - pow($a*$a+$b*$b-$c*$c,2);
        $right_answers[2] = 4;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);

        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);

        //正解テキストの設定
        $text = '$$ △ABCにおいて、\\\\AB='.$a.'、BC='.$b.'、CA='.$c.'のとき、\\\\';

        //空欄テキストの設定
        $item[0] = '△ABCの面積Sは、 S=\frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}';

        if($right_answers[0] == 1 && $right_answers[1] != 1){
            $item[0] = str_replace('\fbox{'.$option[0].'}','',$item[0]);
            unset($right_answers[0]);
            unset($option[0]);
            $blanks -= 1;
        }
        if($right_answers[1] == 1){
            $item[0] = str_replace('\sqrt{\fbox{'.$option[1].'}}','',$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if($right_answers[2] == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[2].'}}'],['',''],$item[0]);
            unset($right_answers[2]);
            unset($option[2]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //内接円の半径
    public function unit103_q09($unit_id){
        $question_id = 10309;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $a; $b; $c;
        list($a,$b,$c) = make_tri();

        //答えの計算
        $right_answers[0] = 1;
        $right_answers[1] = 4*$a*$a*$b*$b - pow($a*$a+$b*$b-$c*$c,2);
        $right_answers[2] = 2*($a+$b+$c);

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);

        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);

        //正解テキストの設定
        $text = '$$ △ABCにおいて、\\\\AB='.$a.'、BC='.$b.'、CA='.$c.'のとき、\\\\';

        //空欄テキストの設定
        $item[0] = '△ABCに内接する円の半径\\ r\\ は、\\\\ r=\frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}';

        if($right_answers[0] == 1 && $right_answers[1] != 1){
            $item[0] = str_replace('\fbox{'.$option[0].'}','',$item[0]);
            unset($right_answers[0]);
            unset($option[0]);
            $blanks -= 1;
        }
        if($right_answers[1] == 1){
            $item[0] = str_replace('\sqrt{\fbox{'.$option[1].'}}','',$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if($right_answers[2] == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[2].'}}'],['',''],$item[0]);
            unset($right_answers[2]);
            unset($option[2]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //データの分析(104)
    //代表値、範囲
    public function unit104_q01($unit_id){
        //初期設定
        $question_id = 10401;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $data = get_data(8);
        $r_data = $data;
        sort($r_data);

        //答えの計算
        $right_answers[0] = round(array_sum($data)/count($data),1);
        $right_answers[1] = ($r_data[3]+$r_data[4])/2;
        $right_answers[2] = $r_data[7] - $r_data[0];

        //正解テキストの設定
        $text = '※答えが小数第2位以上になる場合、四捨五入して小数第1位までの小数にして答えよ。';
        $text .= '$$ 以下のデータがある。 \\\\'.implode('　',$data).'\\\\';

        //空欄テキストの設定
        $item[0] = 'このデータの平均値は\fbox{ア}、';
        $item[1] = '中央値は\fbox{イ}、';
        $item[2] = 'データの範囲は\fbox{ウ}である。\\\\';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/data',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //四分位数(と箱ひげ図)
    public function unit104_q02($unit_id){
        //初期設定
        $question_id = 10402;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $data = get_data(8);
        $r_data = $data;
        sort($r_data);

        //答えの計算
        $right_answers[0] = ($r_data[1]+$r_data[2])/2;
        $right_answers[1] = ($r_data[5]+$r_data[6])/2;
        $right_answers[2] = $right_answers[1] - $right_answers[0];
        $right_answers[3] = round($right_answers[2]/2,1);

        //正解テキストの設定
        $text = '※答えが小数第2位以上になる場合、四捨五入して小数第1位までの小数にして答えよ。';
        $text .= '$$ 以下のデータがある。 \\\\'.implode('　',$data).'\\\\';

        //空欄テキストの設定
        $item[0] = 'このデータの第1四分位数は\fbox{ア}、';
        $item[1] = '第3四分位数は\fbox{イ}、\\\\';
        $item[2] = '四分位範囲は\fbox{ウ}、';
        $item[3] = '四分位偏差は\fbox{エ}である。';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/data',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //分散・標準偏差
    public function unit104_q03($unit_id){
        //初期設定
        $question_id = 10403;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        $data = array();
        for($j=0;$j<5;$j++){
            array_push($data,rand(1,8));
        }

        //答えの計算
        $data_2 = [$data[0]*$data[0],$data[1]*$data[1],$data[2]*$data[2],$data[3]*$data[3],$data[4]*$data[4]];
        $ave = array_sum($data)/count($data);
        $ave_2 = array_sum($data_2)/count($data_2);
        $s_2 = $ave_2 - pow($ave,2);
        $right_answers[0] = round($s_2,1);

        //正解テキストの設定
        $text = '※答えが小数第2位以上になる場合、四捨五入して小数第1位までの小数にして答えよ。';
        $text .= '$$ 以下のデータがある。 \\\\'.implode('　',$data).'\\\\';

        //空欄テキストの設定
        $item[0] = 'このデータの分散は\fbox{ア}である。';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/data',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //相関係数の読み取り
    public function unit104_q04($unit_id){
        //初期設定
        $question_id = 10404;
        $blanks = 4;
        $option = $this->option;
        $pattern = rand(1,2);

        //変数の設定
        $x = array();
        $y = array();
        for($j=0;$j<10;$j++){
            array_push($x,rand(100,250));
        }
        switch($pattern){
            case 1:
                for($j=0;$j<10;$j++){
                    array_push($y,-1*$x[$j]+275+rand(-20,20));
                }
                break;
            case 2:
                for($j=0;$j<10;$j++){
                    array_push($y,$x[$j]-75+rand(-20,20));
                }
                break;
        }

        //答えの設定
        switch($pattern){
            case 1:
                $right_answers[0] = 4;
                break;
            case 2:
                $right_answers[0] = 1;
                break;
        }

        //正解テキストの設定
        $canvas = '<canvas id="canvas" width="350" height="200">
                        canvas対応のブラウザでは、ここに図形が表示されます。
                   </canvas>';
                   
        $script = '<script type="text/javascript">
        　         window.onload = function draw() {
                        var canvas = document.getElementById(\'canvas\');
                        if (canvas.getContext) {
                            var y_axis = canvas.getContext(\'2d\');
                            y_axis.beginPath();
                            y_axis.moveTo(85,190);
                            y_axis.lineTo(85,10);
                            y_axis.lineTo(80,15);
                            y_axis.moveTo(85,10);
                            y_axis.lineTo(90,15);
                            y_axis.stroke();

                            var x_axis = canvas.getContext(\'2d\');
                            x_axis.beginPath();
                            x_axis.moveTo(85,190);
                            x_axis.lineTo(265,190);
                            x_axis.lineTo(260,195);
                            x_axis.moveTo(265,190);
                            x_axis.lineTo(260,185);
                            x_axis.stroke();

                            var a = canvas.getContext(\'2d\');
                            a.beginPath();
                            a.arc('.$x[0].','.$y[0].',3, 0, 2 * Math.PI);
                            a.fill();
                            a.beginPath();
                            a.arc('.$x[1].','.$y[1].',3, 0, 2 * Math.PI);
                            a.fill();
                            a.beginPath();
                            a.arc('.$x[2].','.$y[2].',3, 0, 2 * Math.PI);
                            a.fill();
                            a.beginPath();
                            a.arc('.$x[3].','.$y[3].',3, 0, 2 * Math.PI);
                            a.fill();
                            a.beginPath();
                            a.arc('.$x[4].','.$y[4].',3, 0, 2 * Math.PI);
                            a.fill();
                            a.beginPath();
                            a.arc('.$x[5].','.$y[5].',3, 0, 2 * Math.PI);
                            a.fill();
                            a.beginPath();
                            a.arc('.$x[6].','.$y[6].',3, 0, 2 * Math.PI);
                            a.fill();
                            a.beginPath();
                            a.arc('.$x[7].','.$y[7].',3, 0, 2 * Math.PI);
                            a.fill();
                            a.beginPath();
                            a.arc('.$x[8].','.$y[8].',3, 0, 2 * Math.PI);
                            a.fill();
                            a.beginPath();
                            a.arc('.$x[9].','.$y[9].',3, 0, 2 * Math.PI);
                            a.fill();
                        }
                    }
                   </script>';

        $text = '$$ 以上のデータがある。\\\\';
        $text .= 'このデータの相関係数に一番近いのは、\\\\';

        $item[0] = '①　-0.9\\\\';
        $item[1] = '②　-0.2\\\\';
        $item[2] = '③　\\ \\ \\ \\ \\ 0.2\\\\';
        $item[3] = '④　\\ \\ \\ \\ \\ 0.9\\\\';

        $options[0] = '①　-0.9';
        $options[1] = '②　-0.2';
        $options[2] = '③　 0.2';
        $options[3] = '④　 0.9';

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';
        return view('question/data_select',compact('right_answers','unit_id','question_id','text','blank_text','blanks','canvas','script','options'));

        //return view('question/data_select',compact('x','y','right_answer','unit_id','question_id','text','options','blanks'));
    }

    //数学Ⅱ
    //式と証明
    //二項定理
    public function unit201_q01($unit_id){
        //初期設定
        $question_id = 20101;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-3,3); } while( $a==0 );
        $b = rand(5,8);
        $c = $b - rand(2,3);
        $d = $b - $c;

        //答えの設定
        $right_answers[0] = gmp_fact($b)/(gmp_fact($c)*gmp_fact($d))*pow($a,$d);


        //問題テキストの設定
        $text = '$$ (x'.d2($a,'y').')^{'.$b.'}の展開式における、\\\\';

        //空欄テキストの設定
        $item[0] = 'x^{'.$c.'}y^{'.$d.'}の係数は、\fbox{ア}';

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //整式の割り算
    public function unit201_q02($unit_id){
        //初期設定
        $question_id = 20102;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 );
        do { $e = rand(-5,5); } while( $e==0 );

        //答えの設定
        $right_answers[0] = $a - $d;
        $right_answers[1] = $b - $e - $a*$d + $d*$d;
        $right_answers[2] = $c - $a*$e + $d*$e;

        //問題テキストの設定
        $text = '$$ x^{3}'.d2($a,'x^{2}').d2($b,'x').d3($c).'\\ を\\ x^{2}'.d2($d,'x').d3($e).'で割った時の\\\\';

        //空欄テキストの設定
        $item[0] = '商は、x'.($right_answers[0]<0?'-':'+').'\fbox{ア}、';
        $item[1] = '余りは、'.($right_answers[1]<0?'-':'').'\fbox{イ}x';
        $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}';

        if($right_answers[0] == 0){
            $item[0] = str_replace(($right_answers[0]<0?'-':'+').'\fbox{'.$option[0].'}','',$item[0]);
            unset($right_answers[0]);
            unset($option[0]);
            $blanks -= 1;
        }
        if($right_answers[1] == 0){
            $item[1] = str_replace(($right_answers[1]<0?'-':'').'\fbox{'.$option[1].'}x','',$item[1]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
            $item[2] = str_replace(($right_answers[2]<0?'':'+'),'',$item[2]);
        }elseif($right_answers[2] == 0){
            $item[2] = str_replace(($right_answers[2]<0?'-':'+').'\fbox{'.$option[2].'}','',$item[2]);
            unset($right_answers[2]);
            unset($option[2]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //割り算の基本公式
    public function unit201_q03($unit_id){
        //初期設定
        $question_id = 20103;
        $blanks = 5;
        $option = $this->option;

        //変数の設定
        $a = rand(2,5);
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 );

        //答えの設定
        $right_answers[0] = $a*$b + $c;
        $right_answers[1] = $b*$c + $d;
        $right_answers[2] = $a*$b + $c;
        $right_answers[3] = $b*$c + $d - $a*$b*$b*$d - $b*$c*$d - $a*$b - $c;
        $right_answers[4] = $right_answers[2];

        list($right_answers[1],$right_answers[2]) = gcd($right_answers[1],$right_answers[2]);
        list($right_answers[3],$right_answers[4]) = gcd($right_answers[3],$right_answers[4]);

        //問題テキストの設定
        $text = '$$ '.$a.'x^{3} + \alpha x^{2}+\alpha\beta x +\beta -1\\ を\\ x'.d3($b).'で割った時の\\\\
                 商が'.$a.'x^{2}'.d2($c,'x').d3($d).'であるとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\alpha = \fbox{ア}、';
        $item[1] = '\beta = '.($right_answers[1]*$right_answers[2]<0?'-':'').'\frac{\fbox{イ}}{\fbox{ウ}}、';
        $item[2] = '余りは、'.($right_answers[3]*$right_answers[4]<0?'-':'').'\frac{\fbox{エ}}{\fbox{オ}}である。';

        if($right_answers[2] == 1){
            $item[1] = str_replace(['\frac{','}{\fbox{'.$option[2].'}}'],['',''],$item[1]);
            unset($right_answers[2]);
            unset($option[2]);
            $blanks -= 1;
        }
        if($right_answers[4] == 1){
            $item[2] = str_replace(['\frac{','}{\fbox{'.$option[4].'}}'],['',''],$item[2]);
            unset($right_answers[4]);
            unset($option[4]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //恒等式
    public function unit201_q04($unit_id){
        //初期設定
        $question_id = 20104;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 );
        do { $e = rand(-5,5); } while( $e==0 );

        //答えの設定
        $right_answers[0] = 6*$a + $b;
        $right_answers[1] = 12*$a + 4*$b + $c;
        $right_answers[2] = -28*$a -8*$b -$c +$d;

        //問題テキストの設定
        $text = '$$'.d1($a,'x^{3}').d2($b,'x^{2}').d2($c,'x').d3($d).'= 
                '.d1($a).'(x-2)^{3} + \alpha (x-2)^{2} + \beta (x+1) + \gamma \\\\'.
                 'がxについての恒等式となるとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\alpha = \fbox{ア}、';
        $item[1] = '\beta = \fbox{イ}、';
        $item[2] = '\gamma = \fbox{ウ}';

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //相加平均、相乗平均の大小関係
    public function unit201_q05($unit_id){
        //初期設定
        $question_id = 20105;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(2,8);

        //答えの設定
        $right_answers[0] = 1;
        $right_answers[1] = $a;
        $right_answers[2] = 2;
        $right_answers[3] = $a;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = root($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ a>0のとき、a+\frac{'.$a.'}{a}は、\\\\';

        //空欄テキストの設定
        $item[0] = 'a = \fbox{ア}\sqrt{\fbox{イ}}で';
        $item[1] = '最小値\fbox{ウ}\sqrt{\fbox{エ}}をとる';

        if($right_answers[1] == 1){
            unset($right_answers[1]);
            unset($right_answers[3]);
            $item[0] = str_replace('\sqrt{\fbox{'.$option[1].'}}','',$item[0]);
            $item[1] = str_replace('\sqrt{\fbox{'.$option[3].'}}','',$item[1]);
            unset($option[1]);
            unset($option[3]);
            $blanks -= 2;
        } elseif($right_answers[0] == 1){
            unset($right_answers[0]);
            $item[0] = str_replace('\fbox{'.$option[0].'}','',$item[0]);
            unset($option[0]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //複素数と方程式(202)
    //複素数の基本
    public function unit202_q01($unit_id){
        //初期設定
        $question_id = 20201;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 );
        do { $e = rand(-5,5); } while( $e==0 );
        do { $f = rand(-5,5); } while( $f==0 || $a*$d-$b*$c == 0);

        //答えの設定
        $right_answers[0] = $c*$f - $d*$e;
        $right_answers[1] = $a*$d - $b*$c;
        $right_answers[2] = $b*$e - $a*$f;
        $right_answers[3] = $a*$d - $b*$c;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ 実数x,yが、('.$a.d2($b,'i').')x + ('.$c.d2($d,'i').')y'.d3($e).d2($f,'i').'=0 \\\\ を満たすとき、';

        //空欄テキストの設定
        $item[0] = 'x = '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}、';
        $item[1] = 'y = '.($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}}である。';

        for($i=0;$i<2;$i++){
            if(abs($right_answers[2*$i+1]) == 1){
                $item[$i] = str_replace(['\frac{','}{\fbox{'.$option[2*$i+1].'}}'],['',''],$item[$i]);
                unset($right_answers[2*$i+1]);
                unset($option[2*$i+1]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //虚数解をもつ条件
    public function unit202_q02($unit_id){
        //初期設定
        $question_id = 20202;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 || $b*$b+$c <= 0);

        //答えの設定
        $right_answers[0] = 2*$b;
        $right_answers[1] = 2;
        $right_answers[2] = $b*$b + $c;
        $right_answers[3] = 2*$b;
        $right_answers[4] = 2;
        $right_answers[5] = $b*$b + $c;

        list($right_answers[1],$right_answers[2]) = root($right_answers[1],$right_answers[2]);
        list($right_answers[4],$right_answers[5]) = root($right_answers[4],$right_answers[5]);

        var_dump($right_answers);

        //問題テキストの設定
        $text = '$$ aは実数とする。２次方程式\\ x^{2} + ax '.d2($b,'a').d3($c).'=0\\ が\\\\'
                .'異なる二つの虚数解をもつとき、\\\\';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]<0?'-':'').'\fbox{ア}-\fbox{イ}\sqrt{\fbox{ウ}} \lt a \lt';
        $item[1] = ($right_answers[3]<0?'-':'').'\fbox{エ}+\fbox{オ}\sqrt{\fbox{カ}}';

        if($right_answers[2] == 1){
            $right_answers[0] = 2*$b - 2*sqrt($b*$b+$c);
            $right_answers[1] = 2*$b + 2*sqrt($b*$b+$c);;
            $item[0] = ($right_answers[0]<0?'-':'').'\fbox{ア} \lt a \lt';
            $item[1] = ($right_answers[1]<0?'-':'').'\fbox{イ}';
            unset($right_answers[2]);
            unset($right_answers[3]);
            unset($right_answers[4]);
            unset($right_answers[5]);
            $blanks = 2;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //解と係数の関係　その１
    public function unit202_q03($unit_id){
        //初期設定
        $question_id = 20203;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-4,4); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );

        //答えの設定
        $right_answers[0] = -1*$b;
        $right_answers[1] = $a;
        $right_answers[2] = $c;
        $right_answers[3] = $a;
        $right_answers[4] = $b*$b - 2*$a*$c;
        $right_answers[5] = $a*$a;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);

        //問題テキストの設定
        $text = '$$ ２次方程式\\ '.d1($a,'x^{2}').d2($b,'x').d3($c).'=0\\ の\\\\'
                .'二つの解を \alpha、\beta とすると、\\\\';

        //空欄テキストの設定
        $item[0] = '\alpha + \beta ='.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}、';
        $item[1] = '\alpha \beta ='.($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}}、';
        $item[2] = '\alpha ^{2}+ \beta ^{2}='.($right_answers[4]*$right_answers[5]<0?'-':'').'\frac{\fbox{オ}}{\fbox{カ}}';

        for($i=0;$i<3;$i++){
            if($right_answers[2*$i+1] == 1){
                $item[$i] = str_replace(['\frac{','}{\fbox{'.$option[2*$i+1].'}}'],['',''],$item[$i]);
                unset($right_answers[2*$i+1]);
                unset($option[2*$i+1]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //解と係数の関係　その２
    public function unit202_q04($unit_id){
        //初期設定
        $question_id = 20204;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-4,4); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );

        //答えの設定
        $right_answers[0] = -2*$a;
        $right_answers[1] = $a*$a + $b*$b;

        //問題テキストの設定
        $text = '$$'.$a.d2($b,'i').'、'.$a.d2(-1*$b,'i').'を解に持つ２次方程式の一つは、\\\\';

        //空欄テキストの設定
        $item[0] = 'x^{2}';
        $item[1] = ($right_answers[0]<0?'-':'+').'\fbox{ア}x';
        $item[2] = ($right_answers[1]<0?'-':'+').'\fbox{イ}=0';;

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //剰余の定理
    public function unit202_q05($unit_id){
        //初期設定
        $question_id = 20205;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 );
        do { $e = rand(-3,3); } while( $e==0 );

        //答えの設定
        $right_answers[0] = $a*pow($e,3) + $b*pow($e,2) + $c*$e + $d;

        //問題テキストの設定
        $text = '$$'.d1($a,'x^{3}').d2($b,'x^{2}').d2($c,'x').d3($d).'\\ を\\\\ x'.d3(-1*$e).'\\ で割った余りは、';

        //空欄テキストの設定
        $item[0] = '\fbox{ア}である。';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }
    
    //因数定理
    public function unit202_q06($unit_id){
        //初期設定
        $question_id = 20206;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-3,3); } while( $d==0 || $d+$b == 0);

        //答えの設定
        $right_answers[0] = -1*$a*$d*$d*$d +2*$b*$d -$c;
        $right_answers[1] = $d*$d + $b*$d;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$'.d1($a,'x^{3}').'+ax^{2}'.d2($b,'(a-2)x').d3($c).'\\ が\\\\ x'.d3(-1*$d).'\\ で割り切れるとき、';

        //空欄テキストの設定
        $item[0] = 'a='.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';

        if(abs($right_answers[1]) == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //３次方程式
    public function unit202_q07($unit_id){
        //初期設定
        $question_id = 20207;
        $blanks = 3;
        $option = $this->option;
        $pattern = rand(1,2);

        //変数の設定
        switch($pattern){
            case 1: //解が整数
                //変数の設定
                do { $right_answers[0] = rand(-5,5); } while( $right_answers[0]==0 );
                do { $right_answers[1] = rand(-5,5); } while( $right_answers[1]==0 || $right_answers[0] == $right_answers[1]);
                do { $right_answers[2] = rand(-5,5); } while( $right_answers[2]==0 || $right_answers[2] == $right_answers[0] || $right_answers[2] == $right_answers[1]);
                sort($right_answers);

                //答えの設定
                $a = -1*($right_answers[0]+$right_answers[1]+$right_answers[2]);
                $b = $right_answers[0]*$right_answers[1] + $right_answers[1]*$right_answers[2] + $right_answers[2]*$right_answers[0];
                $c = -1*$right_answers[0]*$right_answers[1]*$right_answers[2];

                //空欄テキストの設定
                $item[0] = 'x='.($right_answers[0]<0?'-':'').'\fbox{ア}、';
                $item[1] = ($right_answers[1]<0?'-':'').'\fbox{イ}、';
                $item[2] = ($right_answers[2]<0?'-':'').'\fbox{ウ} \\\\';
                $item[3] = 'ただし、'.($right_answers[0]<0?'-':'').'\fbox{ア} \lt '.($right_answers[1]<0?'-':'').'\fbox{イ} \lt '.($right_answers[2]<0?'-':'').'\fbox{ウ}';
                break;
            case 2: //解が複素数
                //変数の設定
                $blanks = 5;
                $sq = array(0,1,4,9,16,25,36);
                do { $a = rand(-5,5); } while( $a==0 );
                do { $b = rand(-5,5); } while( $b==0 );
                do { $c = rand(-5,5); } while( $c==0 || in_array(abs($b*$b - 4*$c),$sq));

                //答えの設定
                $right_answers[0] = $a;
                $right_answers[1] = -1*$b;
                $right_answers[2] = 1;
                $right_answers[3] = abs($b*$b - 4*$c);
                $right_answers[4] = 2;

                list($right_answers[2],$right_answers[3]) = root($right_answers[2],$right_answers[3]);
                $s = gmp_gcd(gmp_gcd($right_answers[1],$right_answers[2]),$right_answers[4]);
                $right_answers[1] /= $s;
                $right_answers[2] /= $s;
                $right_answers[4] /= $s;

                //問題テキスト用に変数を再設定
                $a_c = $a; $b_c = $b; $c_c = $c;
                $a = $b_c - $a_c;
                $b = $c_c - $a_c*$b_c;
                $c = -1*$a_c*$c_c;

                //空欄テキストの設定
                $item[0] = 'x='.($right_answers[0]<0?'-':'').'\fbox{ア}、';
                if($b_c*$b_c - 4*$c_c > 0){
                    $item[1] = '\frac{'.($right_answers[1]<0?'-':'').'\fbox{イ} \pm \fbox{ウ}\sqrt{\fbox{エ}}}{\fbox{オ}}';
                }else{
                    $item[1] = '\frac{'.($right_answers[1]<0?'-':'').'\fbox{イ} \pm \fbox{ウ}\sqrt{\fbox{エ}}i}{\fbox{オ}}';
                }

                if($right_answers[4] == 1){
                    $item[1] = str_replace(['\frac{','}{\fbox{'.$option[4].'}}'],['',''],$item[1]);
                    unset($right_answers[4]);
                    unset($option[4]);
                    $blanks -= 1;
                }

                if($right_answers[2] == 1){
                    $item[1] = str_replace('\fbox{'.$option[2].'}','',$item[1]);
                    unset($right_answers[2]);
                    unset($option[2]);
                    $blanks -= 1;
                }

                $right_answers = array_values($right_answers);
                $option = array_values($option);

                break;
        }

        //問題テキストの設定
        $text = '$$ ３次方程式\\ x^{3}'.d2($a,'x^{2}').d2($b,'x').($c==0?'':d3($c)).'=0\\ の解は、\\\\';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //図形と方程式(203)
    //内分点・外分点の座標
    public function unit203_q01($unit_id){
        //初期設定
        $question_id = 20301;
        $blanks = 4;
        $option = $this->option;
        $pattern = rand(1,2);

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 );
        $e = rand(1,5);
        do { $f = rand(1,5); } while( $e==$f );
        list($e,$f) = gcd($e,$f);

        //答えの設定
        switch($pattern){
            case 1:
                $right_answers[0] = $a*$f + $c*$e;
                $right_answers[1] = $e + $f;
                $right_answers[2] = $b*$f + $d*$e;
                $right_answers[3] = $e + $f;
                break;
            case 2:
                $right_answers[0] = -1*$a*$f + $c*$e;
                $right_answers[1] = $e - $f;
                $right_answers[2] = -1*$b*$f + $d*$e;
                $right_answers[3] = $e - $f;
                break;
        }
        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ A('.$a.','.$b.')、B('.$c.','.$d.')において、\\\\ABを'.$e.':'.$f.'に';
        switch($pattern){
            case 1:
                $text .= '内分する点の座標は、\\\\';
                break;
            case 2:
                $text .= '外分する点の座標は、\\\\';
                break;
        }

        //空欄テキストの設定
        $item[0] = '('.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}},';
        $item[1] = ($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}})';

        if(abs($right_answers[1]) == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if(abs($right_answers[3]) == 1){
            $item[1] = str_replace(['\frac{','}{\fbox{'.$option[3].'}}'],['',''],$item[1]);
            unset($right_answers[3]);
            unset($option[3]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //重心の座標
    public function unit203_q02($unit_id){
        //初期設定
        $question_id = 20302;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 );
        do { $e = rand(-5,5); } while( $e==0 );
        do { $f = rand(-5,5); } while( $f==0 );

        //答えの設定
        $right_answers[0] = $a + $c + $e;
        $right_answers[1] = 3;
        $right_answers[2] = $b + $d + $f;
        $right_answers[3] = 3;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ A('.$a.','.$b.')、B('.$c.','.$d.')、C('.$e.','.$f.')\\ において、\\\\△ABCの重心の座標は、';

        //空欄テキストの設定
        $item[0] = '('.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}},';
        $item[1] = ($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}})';

        if(abs($right_answers[1]) == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if(abs($right_answers[3]) == 1){
            $item[1] = str_replace(['\frac{','}{\fbox{'.$option[3].'}}'],['',''],$item[1]);
            unset($right_answers[3]);
            unset($option[3]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //直線の方程式
    public function unit203_q03($unit_id){
        //初期設定
        $question_id = 20303;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 || $a == $c);
        do { $d = rand(-5,5); } while( $d==0 || $b == $d);

        //答えの設定
        $right_answers[0] = $b - $d;
        $right_answers[1] = $c - $a;
        $right_answers[2] = $a*$d - $b*$c;
        $right_answers[3] = 2*($a-$c);
        $right_answers[4] = 2*($b-$d);
        $right_answers[5] = -1*$a*$a + $c*$c -$b*$b +$d*$d;

        $s = gmp_gcd(gmp_gcd($right_answers[0],$right_answers[1]),$right_answers[2]);
        $s_2 = gmp_gcd(gmp_gcd($right_answers[3],$right_answers[4]),$right_answers[5]);
        $right_answers[0] /= $s; $right_answers[1] /= $s; $right_answers[2] /= $s;
        $right_answers[3] /= $s_2; $right_answers[4] /= $s_2; $right_answers[5] /= $s_2;
        if($right_answers[0] < 0){
            $right_answers[0] *= -1; $right_answers[1] *= -1; $right_answers[2] *= -1;
        }
        if($right_answers[3] < 0){
            $right_answers[3] *= -1; $right_answers[4] *= -1; $right_answers[5] *= -1;
        }

        //問題テキストの設定
        $text = '$$ A('.$a.','.$b.')、B('.$c.','.$d.') \\ を通る直線\\ l\\ の方程式、\\\\ および線分ABの垂直二等分線\\ m\\ の方程式は、\\\\';

        //空欄テキストの設定
        $item[0] = 'l:\fbox{ア}x';
        $item[1] = ($right_answers[1]<0?'-':'+').'\fbox{イ}y';
        $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ} = 0 \\\\';
        $item[3] = 'm:\fbox{エ}x';
        $item[4] = ($right_answers[4]<0?'-':'+').'\fbox{オ}y';
        $item[5] = ($right_answers[5]<0?'-':'+').'\fbox{カ} = 0';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //対称な点
    public function unit203_q04($unit_id){
        //初期設定
        $question_id = 20304;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 );
        do { $e = rand(-5,5); } while( $e==0 );
        $s = gmp_gcd(gmp_gcd($c,$d),$e);
        $c /= $s; $d /= $s; $e /= $s;

        //答えの設定
        $right_answers[0] = -1*($a*$c*$c + 2*$b*$c*$d + 2*$c*$e - $a*$d*$d);
        $right_answers[1] = $c*$c + $d*$d;
        $right_answers[2] = -1*($a*$c*$d + $b*$d*$d + 2*$d*$e - $b*$c*$c + $a*$c*$d);
        $right_answers[3] = $c*$c + $d*$d;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ A('.$a.','.$b.')\\ において、直線\\ '.d1($c,'x').d2($d,'y').d3($e).'=0 \\\\ に関して対称な点の座標は、\\\\';

        //空欄テキストの設定
        $item[0] = '('.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}},';
        $item[1] = ($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}})';

        if(abs($right_answers[1]) == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if(abs($right_answers[3]) == 1){
            $item[1] = str_replace(['\frac{','}{\fbox{'.$option[3].'}}'],['',''],$item[1]);
            unset($right_answers[3]);
            unset($option[3]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //点と直線の距離
    public function unit203_q05($unit_id){
        //初期設定
        $question_id = 20305;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 );
        do { $e = rand(-5,5); } while( $e==0 || $a*$d+$b*$e+$c==0);

        //答えの設定
        $right_answers[0] = abs($a*$d+$b*$e+$c);
        $right_answers[1] = $a*$a + $b*$b;
        $right_answers[2] = $a*$a + $b*$b;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);
        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);

        //問題テキストの設定
        $text = '$$ 直線\\ '.d1($a,'x').d2($b,'y').d3($c).'=0 \\ と点\\ ('.$d.','.$e.')\\\\との距離は、';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}である。';

        if($right_answers[0] == 1){
            if($right_answers[1] != 1){
                $item[0] = str_replace('\fbox{'.$option[0].'}','',$item[0]);
                unset($right_answers[0]);
                unset($option[0]);
                $blanks -= 1;
            }
        }
        if($right_answers[1] == 1){
            $item[0] = str_replace('\sqrt{\fbox{'.$option[1].'}}','',$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if($right_answers[2] == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[2].'}}'],['',''],$item[0]);
            unset($right_answers[2]);
            unset($option[2]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //円の方程式　その１
    public function unit203_q06($unit_id){
        //初期設定
        $question_id = 20306;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(-5,5);
        $b = rand(-5,5);
        do { $c = rand(-5,5); } while( $a*$a+$b*$b-$c*$c==0);

        //答えの設定
        $right_answers[0] = 1;
        $right_answers[1] = $a*$a+$b*$b-$c*$c;
        $right_answers[2] = -1*$a;
        $right_answers[3] = -1*$b;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ 方程式:x^{2}+y^{2}'.d2(2*$a,'x').d2(2*$b,'y').d4($c).'=0\\ は、\\\\';

        //空欄テキストの設定
        $item[0] = '半径\\ \fbox{ア}\sqrt{\fbox{イ}}、';
        $item[1] = '中心(\fbox{ウ},\fbox{エ})\\ の円を表す。';

        if($right_answers[0] == 1){
            if($right_answers[1] != 1){
                $item[0] = str_replace('\fbox{'.$option[0].'}','',$item[0]);
                unset($right_answers[0]);
                unset($option[0]);
                $blanks -= 1;
            }
        }
        if($right_answers[1] == 1){
            $item[0] = str_replace('\sqrt{\fbox{'.$option[1].'}}','',$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //円の方程式　その２
    public function unit203_q07($unit_id){
        //初期設定
        $question_id = 20307;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        $a = rand(-5,5);
        $b = rand(-5,5);
        $c = rand(-5,5);
        do { $d = rand(-5,5); } while( $a==$c && $b==$d );

        //答えの設定
        $right_answers[0] = -1*($a+$c);
        $right_answers[1] = 2;
        $right_answers[2] = -1*($b+$d);
        $right_answers[3] = 2;
        $right_answers[4] = ($a-$c)*($a-$c) + ($b-$d)*($b-$d);
        $right_answers[5] = 4;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);

        //問題テキストの設定
        $text = '$$ A('.$a.','.$b.')、B('.$c.','.$d.')を直径とする円の方程式は、\\\\';

        //空欄テキストの設定
        $item[0] = '(x'.($right_answers[0]<0?'-':'+').'\frac{\fbox{ア}}{\fbox{イ}})^{2}';
        $item[1] = '+(y'.($right_answers[2]<0?'-':'+').'\frac{\fbox{ウ}}{\fbox{エ}})^{2}';
        $item[2] = '=\frac{\fbox{オ}}{\fbox{カ}}';


        if($right_answers[0] == 0){
            $item[0] = 'x^{2}';
            unset($right_answers[0]);
            unset($option[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 2;
        }
        if($right_answers[2] == 0){
            $item[1] = '+y^{2}';
            unset($right_answers[2]);
            unset($option[2]);
            unset($right_answers[3]);
            unset($option[3]);
            $blanks -= 2;
        }
        for($i=0;$i<3;$i++){
            if(isset($right_answers[2*$i]) && $right_answers[2*$i+1]==1){
                $item[$i] = str_replace(['\frac{','}{\fbox{'.$option[2*$i+1].'}}'],['',''],$item[$i]);
                unset($right_answers[2*$i+1]);
                unset($option[2*$i+1]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //円の接線
    public function unit203_q08($unit_id){
        //初期設定
        $question_id = 20308;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $a = rand(-5,5);
        $b = rand(-5,5);
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 || $b==$c*$a+$d);

        //答えの設定
        $right_answers[0] = abs($c*$a-$b+$d);
        $right_answers[1] = $c*$c + 1;
        $right_answers[2] = $c*$c + 1;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);
        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);

        //問題テキストの設定
        $text = '$$ ('.$a.','.$b.')を中心とする円が、直線:y='.d1($c,'x').d3($d).'と接するとき、\\\\';

        //空欄テキストの設定
        $item[0] = '円の半径は、\frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}である。';

        if($right_answers[0] == 1){
            if($right_answers[1] != 1){
                $item[0] = str_replace('\fbox{'.$option[0].'}','',$item[0]);
                unset($right_answers[0]);
                unset($option[0]);
                $blanks -= 1;
            }
        }
        if($right_answers[1] == 1){
            $item[0] = str_replace('\sqrt{\fbox{'.$option[1].'}}','',$item[0]);
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }
        if($right_answers[2] == 1){
            $item[0] = str_replace(['\frac{','}{\fbox{'.$option[2].'}}'],['',''],$item[0]);
            unset($right_answers[2]);
            unset($option[2]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //弧度法
    public function unit204_q01($unit_id){
        //初期設定
        $question_id = 20401;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-11,11); } while( $a==0 );
        do { $b = rand(2,6); } while( $b==5 );
        list($a,$b) = gcd($a,$b);
        $a = gmp_intval($a); $b = gmp_intval($b);

        //答えの計算
        $right_answers[0] = 1;
        list($right_answers[1],$right_answers[2]) = d_sin(rad_to_deg($a,$b));
        $right_answers[3] = 1;
        list($right_answers[4],$right_answers[5]) = d_cos(rad_to_deg($a,$b));

        for($i=0;$i<2;$i++){
            list($right_answers[3*$i],$right_answers[3*$i+1]) = root($right_answers[3*$i],$right_answers[3*$i+1]);
            list($right_answers[3*$i],$right_answers[3*$i+2]) = gcd($right_answers[3*$i],$right_answers[3*$i+2]);
        }

        //正解テキストの設定
        $text = '$$';
        $radian = ($a*$b<0?'-':'').'\frac{'.abs($a).'}{'.abs($b).'}';
        if(abs($b) == 1){
            $radian = d1($a);
        }

        //空欄テキストの設定
        $item[0] = '\sin{('.$radian.'\pi)} = ';
        $item[1] = ($right_answers[1]*$right_answers[2]<0?'-':'').'\frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}、';
        $item[2] = '\cos{('.$radian.'\pi)} = ';
        $item[3] = ($right_answers[4]*$right_answers[5]<0?'-':'').'\frac{\fbox{エ}\sqrt{\fbox{オ}}}{\fbox{カ}}';

        for($i=0;$i<2;$i++){
            if($right_answers[3*$i+1] == 0){
                $item[2*$i+1] = str_replace(['\frac{\fbox{'.$option[3*$i].'}\sqrt{','}}{\fbox{'.$option[3*$i+2].'}}'],['',''],$item[2*$i+1]);
                unset($right_answers[3*$i]);
                unset($right_answers[3*$i+2]);
                unset($option[3*$i]);
                unset($option[3*$i+2]);
                $blanks -= 2;
            }else{
                if(abs($right_answers[3*$i+1]) == 1){
                    $item[2*$i+1] = str_replace('\sqrt{\fbox{'.$option[3*$i+1].'}}','',$item[2*$i+1]);
                    unset($right_answers[3*$i+1]);
                    unset($option[3*$i+1]);
                    $blanks -= 1;
                }elseif(abs($right_answers[3*$i]) == 1){
                    $item[2*$i+1] = str_replace('\fbox{'.$option[3*$i].'}','',$item[2*$i+1]);
                    unset($right_answers[3*$i]);
                    unset($option[3*$i]);
                    $blanks -= 1;
                }
                if(abs($right_answers[3*$i+2]) == 1){
                    $item[2*$i+1] = str_replace(['\frac{','}{\fbox{'.$option[3*$i+2].'}}'],['',''],$item[2*$i+1]);
                    unset($right_answers[3*$i+2]);
                    unset($option[3*$i+2]);
                    $blanks -= 1;
                }
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角関数のグラフ
    public function unit204_q02($unit_id){
        //初期設定
        $question_id = 20402;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(2,4);
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 );
        list($b,$c) = gcd($b,$c);

        //答えの計算
        $right_answers[0] = -1*$b;
        $right_answers[1] = $c;
        $right_answers[2] = $d;
        $right_answers[3] = 2*$a;

        //正解テキストの設定
        $text = '$$ y=2\sin{(\frac{x}{'.$a.'}'.($b*$c<0?'-':'+').'\frac{'.abs($b).'}{'.abs($c).'}\pi)}'.d3($d).'は、\\\\';
        if(abs($c)==1){
            $text = '$$ y=2\sin{(\frac{x}{'.$a.'}'.($b*$c<0?'-':'+').''.d1(abs($b)).'\pi)}'.d3($d).'は、\\\\';
        }

        //空欄テキストの設定
        $item[0] = 'y=2\sin{\frac{x}{'.$a.'}}\\ のグラフを';
        $item[1] = 'x軸方向に'.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}\pi、\\\\';
        $item[2] = 'y軸方向に'.($right_answers[2]<0?'-':'').'\fbox{ウ}だけ移動したものであり、\\\\';
        $item[3] = 'このグラフの周期は\fbox{エ}\piである。';

        list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,1,$blanks,$item[1]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //加法定理
    public function unit204_q03($unit_id){
        //初期設定
        $question_id = 20403;
        $blanks = 9;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(1,7); } while( $a>=$b );
        $c = rand(1,5);
        do { $d = rand(1,7); } while( $c>=$d || (gcd($a,$b)==gcd($c,$d)));

        list($a,$b) = gcd($a,$b);
        list($c,$d) = gcd($c,$d);

        //答えの計算
        $right_answers[0] = $a*$c;
        $right_answers[1] = 1;
        $right_answers[2] = ($b*$b-$a*$a)*($d*$d-$c*$c);
        $right_answers[3] = $b*$d;

        $right_answers[4] = $c;
        $right_answers[5] = ($b*$b-$a*$a);
        $right_answers[6] = $a;
        $right_answers[7] = ($d*$d-$c*$c);
        $right_answers[8] = $b*$d;

        list($right_answers[1],$right_answers[2]) = root($right_answers[1],$right_answers[2]);
        $s = gmp_gcd(gmp_gcd($right_answers[0],$right_answers[1]),$right_answers[3]);
        $right_answers[0] /= $s;    $right_answers[1] /= $s;    $right_answers[3] /= $s;

        list($right_answers[4],$right_answers[5]) = root($right_answers[4],$right_answers[5]);
        list($right_answers[6],$right_answers[7]) = root($right_answers[6],$right_answers[7]);
        $s = gmp_gcd(gmp_gcd($right_answers[4],$right_answers[6]),$right_answers[8]);
        $right_answers[4] /= $s;    $right_answers[6] /= $s;    $right_answers[8] /= $s;

        //正解テキストの設定
        $text = '$$ 0 \lt \alpha \lt \frac{\pi}{2}、0 \lt \beta \lt \frac{\pi}{2}とする。\\\\
                 \sin{\alpha}=\frac{'.$a.'}{'.$b.'}、\cos{\beta}=\frac{'.$c.'}{'.$d.'}のとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\sin{(\alpha + \beta)} = \frac{\fbox{ア}+\fbox{イ}\sqrt{\fbox{ウ}}}{\fbox{エ}}、\\\\';
        $item[1] = '\cos{(\alpha + \beta)} = \frac{\fbox{オ}\sqrt{\fbox{カ}}';
        $item[2] = '-\fbox{キ}\sqrt{\fbox{ク}}}{\fbox{ケ}}である。';

        if($right_answers[2] == 1){
            $blanks -= 2;
            $right_answers[0] += $right_answers[1];
            //$right_answers[3] = $right_answers[3];
            unset($right_answers[1]); unset($right_answers[2]);
            unset($option[1]);  unset($option[2]);
            list($right_answers[0],$right_answers[3]) = gcd($right_answers[0],$right_answers[3]);
            $item[0] = '\sin{(\alpha + \beta)} = \frac{\fbox{ア}}{\fbox{エ}}、\\\\';

            $blanks -= 2;
            $right_answers[4] = $right_answers[4]-$right_answers[6];
            //$right_answers[5] = $b*$b-$a*$a;
            //$right_answers[8] = $b*$d;
            unset($right_answers[6]);   unset($right_answers[7]);
            unset($option[6]);  unset($option[7]);
            list($right_answers[4],$right_answers[8]) = gcd($right_answers[4],$right_answers[8]);
            $item[1] = '\cos{(\alpha + \beta)} = '.($right_answers[4]<0?'-':'').'\frac{\fbox{オ}\sqrt{\fbox{カ}}}{\fbox{ケ}}である。';
            unset($item[2]);
            list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,4,5,$blanks,$item[1]);
        }else{
            list($right_answers,$option,$blanks,$item[0]) = l_root($right_answers,$option,1,2,$blanks,$item[0]);
            list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,4,5,$blanks,$item[1]);
            list($right_answers,$option,$blanks,$item[2]) = l_root($right_answers,$option,6,7,$blanks,$item[2]);
        }


        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //2倍角の公式
    public function unit204_q04($unit_id){
        //初期設定
        $question_id = 20404;
        $blanks = 5;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(1,7); } while( $a>=$b );
        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = 2*$a;
        $right_answers[1] = $b*$b - $a*$a;
        $right_answers[2] = $b*$b;
        $right_answers[3] = $b*$b - 2*$a*$a;
        $right_answers[4] = $b*$b;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);
        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);
        list($right_answers[3],$right_answers[4]) = gcd($right_answers[3],$right_answers[4]);

        //正解テキストの設定
        $text = '$$ 0 \lt \alpha \lt \frac{\pi}{2}とする。\sin{\alpha}=\frac{'.$a.'}{'.$b.'}のとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\sin{2 \alpha} = \frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}、';
        $item[1] = '\cos{2 \alpha} = '.($right_answers[3]<0?'-':'').'\frac{\fbox{エ}}{\fbox{オ}}、';

        list($right_answers,$option,$blanks,$item[0]) = l_root($right_answers,$option,0,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角不等式　その１
    public function unit204_q05($unit_id){
        //初期設定
        $question_id = 20405;
        $blanks = 4;
        $option = $this->option;
        $pattern = rand(1,2);

        //変数の設定
        $a = 1;
        switch($pattern){
            case 1: //sin
                $nu = [1,1,1,7,5,4];
                $de = [6,4,3,6,4,3];
                $n = rand(0,5);
                list($b,$c) = d_sin(rad_to_deg($nu[$n],$de[$n]));
                break;
            case 2: //cos
                $nu = [1,1,1,1,2,3,5];
                $de = [6,4,3,2,3,4,6];
                $n = rand(0,6);
                list($b,$c) = d_cos(rad_to_deg($nu[$n],$de[$n]));
                break;
        }

        list($a,$b) = root($a,$b);

        //答えの計算
        switch($pattern){
            case 1:
                if($n < 3){
                    $right_answers[0] = $nu[$n];
                    $right_answers[1] = $de[$n];
                    $right_answers[2] = $de[$n] - $nu[$n];
                    $right_answers[3] = $de[$n];
                }else{
                    $blanks = 5;
                    $right_answers[0] = $nu[$n];
                    $right_answers[1] = $de[$n];
                    $right_answers[2] = 3*$de[$n] - $nu[$n];
                    $right_answers[3] = $de[$n];
                    $right_answers[4] = 2;
                }
                break;
            case 2:
                $right_answers[0] = $nu[$n];
                $right_answers[1] = $de[$n];
                $right_answers[2] = 2*$de[$n] - $nu[$n];
                $right_answers[3] = $de[$n];
                break;
        }

        //正解テキストの設定
        $l_ans = ($c<0?'-':'').'\frac{'.$a.'\sqrt{'.$b.'}}{'.abs($c).'}';
        if($a == 1){
            $l_ans = ($c<0?'-':'').'\frac{\sqrt{'.$b.'}}{'.abs($c).'}';
        }
        if($b == 1){
            $l_ans = ($c<0?'-':'').'\frac{'.$a.'}{'.abs($c).'}';
        }
        if($b == 0){
            $l_ans = '0';
        }
        $text = '$$ 0 \leqq \theta \lt 2\piとする。';
        switch($pattern){
            case 1:
                $text .= '\sin{\theta} \geqq '.$l_ans.'の解は、\\\\';
                break;
            case 2:
                $text .= '\cos{\theta} \lt '.$l_ans.'の解は、\\\\';
                break;
        }

        //空欄テキストの設定
        switch($pattern){
            case 1:
                if($n < 3){
                    $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}\pi \leqq \theta \leqq';
                    $item[1] = '\frac{\fbox{ウ}}{\fbox{エ}}\pi';
                }else{
                    $item[0] = '0 \leqq \theta \leqq \frac{\fbox{ア}}{\fbox{イ}}\pi、';
                    $item[1] = '\frac{\fbox{ウ}}{\fbox{エ}}\pi \leqq \theta \lt \fbox{オ}\pi';
                }
                break;
            case 2:
                $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}\pi \lt \theta \lt';
                $item[1] = '\frac{\fbox{ウ}}{\fbox{エ}}\pi';
                break;
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角不等式　その２
    public function unit204_q06($unit_id){
        //初期設定
        $question_id = 20406;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = 2;
        $b = 1*rand_sign();
        $c = rand(2,5)*rand_sign();

        $c_1 = $a;
        $c_2 = -1*($a*$c + $b);
        $c_3 = -1*($a + $b*$c);

        //答えの計算
        if($b == 1){
            $theta = [2,3];
        }elseif($b == -1){
            $theta = [1,3];
        }

        $right_answers[0] = $theta[0];
        $right_answers[1] = $theta[1];
        $right_answers[2] = 2*$theta[1] - $theta[0];
        $right_answers[3] = $theta[1];

        if($c < 0){
            $blanks = 5;
            $right_answers[4] = 2;
        }

        //問題テキストの設定
        $text = '$$ 0 \leqq \theta \lt 2\piとする。\\\\';
        $text .= d1($c_1,'\sin{^{2}\theta}').d2($c_2,'\cos{\theta}').d4($c_3).'\gt 0 \\ の解は、\\\\';


        //空欄テキストの設定
        if($c > 0){
            $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}\pi \lt \theta \lt \frac{\fbox{ウ}}{\fbox{エ}}\pi';
        }else{
            $item[0] = '0 \leqq \theta \lt \frac{\fbox{ア}}{\fbox{イ}}\pi、';
            $item[1] = '\frac{\fbox{ウ}}{\fbox{エ}}\pi \lt \theta \lt \fbox{オ}\pi';
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //半角の公式
    public function unit204_q07($unit_id){
        //初期設定
        $question_id = 20407;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(-7,7); } while( abs($a)>=abs($b));
        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = 1;
        $right_answers[1] = ($b-$a)*2*$b;
        $right_answers[2] = 2*$b;
        $right_answers[3] = 1;
        $right_answers[4] = ($b+$a)*2*$b;
        $right_answers[5] = 2*$b;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);
        list($right_answers[3],$right_answers[4]) = root($right_answers[3],$right_answers[4]);
        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);
        list($right_answers[3],$right_answers[5]) = gcd($right_answers[3],$right_answers[5]);

        //正解テキストの設定
        $text = '$$ 0 \lt \theta \lt \piとする。\cos{\theta}='.($b<0?'-':'').'\frac{'.$a.'}{'.abs($b).'}のとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\sin{\frac{\theta}{2}} = \frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}、';
        $item[1] = '\cos{\frac{\theta}{2}} = \frac{\fbox{エ}\sqrt{\fbox{オ}}}{\fbox{カ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_root($right_answers,$option,0,1,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,3,4,$blanks,$item[1]);
        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,2,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,5,$blanks,$item[1]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角関数の合成
    public function unit204_q08($unit_id){
        //初期設定
        $question_id = 20408;
        $blanks = 8;
        $option = $this->option;

        //変数の設定
        $a = rand(1,3);
        $b = [1,3,1,3];
        $rad = [4,3,-4,-3];
        $pattern = rand(0,3);

        //答えの計算
        $right_answers[0] = $rad[$pattern] - 2;
        $right_answers[1] = 2*$rad[$pattern];
        $right_answers[2] = 1;
        $right_answers[3] = $a*$a + $a*$a*$b[$pattern];

        $right_answers[4] = 3*$rad[$pattern] - 2;
        $right_answers[5] = 2*$rad[$pattern];
        $right_answers[6] = -1;
        $right_answers[7] = $a*$a + $a*$a*$b[$pattern];

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);
        list($right_answers[2],$right_answers[3]) = root($right_answers[2],$right_answers[3]);
        list($right_answers[6],$right_answers[7]) = root($right_answers[6],$right_answers[7]);


        //問題テキストの設定
        $text = '$$ 0 \leqq \theta \lt 2\piとする。\\\\';
        $text .= 'f(\theta)='.d1($a,'\sin{\theta}').($rad[$pattern]<0?'-':'+').d1($a).'\sqrt{'.$b[$pattern].'}\cos{\theta}\\ とすると、f(\theta)は、\\\\';
        if($b[$pattern] == 1){
            $text = str_replace('\sqrt{'.$b[$pattern].'}','',$text);
        }


        //空欄テキストの設定
        $item[0] = '\theta = \frac{\fbox{ア}}{\fbox{イ}}\pi\\ で最大値\fbox{ウ}\sqrt{\fbox{エ}}、\\\\';
        $item[1] = '\theta = \frac{\fbox{オ}}{\fbox{カ}}\pi\\ で最小値-\fbox{キ}\sqrt{\fbox{ク}}をとる。';

        list($right_answers,$option,$blanks,$item[0]) = l_root($right_answers,$option,2,3,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,6,7,$blanks,$item[1]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }
    
    //指数関数・対数関数
    //指数の計算
    public function unit205_q01($unit_id){
        //初期設定
        $question_id = 20501;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(1,4);
        $b = rand(3,6);
        $c = rand(1,3);

        //答えの計算
        $right_answers[0] = 2*$a*$b + 4 - $b*$c;
        $right_answers[1] = 2*$b;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ 2^{'.$a.'} \times \sqrt['.$b.']{4} \div \sqrt{2^{'.$c.'}}';

        //空欄テキストの設定
        $item[0] = '2^{'.($right_answers[0]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //指数の式の値
    public function unit205_q02($unit_id){
        //初期設定
        $question_id = 20502;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(2,7);

        //答えの計算
        $right_answers[0] = $a*$a + 2;
        $right_answers[1] = $a * ($a*$a + 3);

        //問題テキストの設定
        $text = '$$ a \gt 0、a^{x}-a^{-x}='.$a.'\\ のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'a^{2x} + a^{-2x} = \fbox{ア} \\\\';
        $item[1] = 'a^{3x} - a^{-3x} = \fbox{イ}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //指数方程式
    public function unit205_q03($unit_id){
        //初期設定
        $question_id = 20503;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $x = rand(1,5);
        do { $y = rand(1,7); } while( $x >= $y );

        $a = -1*$x - $y;
        $b = $x*$y;

        //答えの計算
        list($right_answers[0],$right_answers[1]) = log_ans(3,$x);
        list($right_answers[2],$right_answers[3]) = log_ans(3,$y);

        //問題テキストの設定
        $text = '$$ 9^{x}'.d2($a,'\cdot 3^{x}').d3($b).'=0\\ の解は、小さい順に\\\\';

        //空欄テキストの設定
        $item[0] = 'x= \fbox{ア} +  \log_3 \fbox{イ}、';
        $item[1] = '\fbox{ウ} +  \log_3 \fbox{エ}';

        for($i=0;$i<2;$i++){
            if($right_answers[2*$i+1] == 1){
                $item[$i] = str_replace('+  \log_3 \fbox{'.$option[2*$i+1].'}','',$item[$i]);
                unset($right_answers[2*$i+1]);
                unset($option[2*$i+1]);
                $blanks -= 1;
            }elseif($right_answers[2*$i] == 0){
                $item[$i] = str_replace('\fbox{'.$option[2*$i].'} +  ','',$item[$i]);
                unset($right_answers[2*$i]);
                unset($option[2*$i]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //指数不等式
    public function unit205_q04($unit_id){
        //初期設定
        $question_id = 20504;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        do { $x = rand(-5,5); } while( $x == 0 );
        do { $y = rand(1,7); } while( $x >= $y );

        $a = -1*$x - $y;
        $b = $x*$y;

        //答えの計算
        if($x > 0){
            list($right_answers[0],$right_answers[1]) = log_ans(2,$x);
            list($right_answers[2],$right_answers[3]) = log_ans(2,$y);
        }else{
            $blanks = 2;
            list($right_answers[0],$right_answers[1]) = log_ans(2,$y);
        }

        //問題テキストの設定
        $text = '$$ 4^{x}'.d2($a,(abs($a)!=1?'\cdot':'').'2^{x}').d3($b).'>0\\ の解は、\\\\';

        //空欄テキストの設定
        if($x > 0){
            $item[0] = 'x \lt \fbox{ア} + \log_2 \fbox{イ}、';
            $item[1] = '\fbox{ウ} + \log_2 \fbox{エ} \lt x';
            for($i=0;$i<2;$i++){
                if($right_answers[2*$i+1] == 1){
                    $item[$i] = str_replace('+ \log_2 \fbox{'.$option[2*$i+1].'}','',$item[$i]);
                    unset($right_answers[2*$i+1]);
                    unset($option[2*$i+1]);
                    $blanks -= 1;
                }elseif($right_answers[2*$i] == 0){
                    $item[$i] = str_replace('\fbox{'.$option[2*$i].'} + ','',$item[$i]);
                    unset($right_answers[2*$i]);
                    unset($option[2*$i]);
                    $blanks -= 1;
                }
            }
        }else{
            $item[0] = 'x \gt \fbox{ア} + \log_2 \fbox{イ}';
            if($right_answers[1] == 1){
                $item[0] = str_replace('+ \log_2 \fbox{'.$option[1].'}','',$item[0]);
                unset($right_answers[1]);
                unset($option[1]);
                $blanks -= 1;
            }elseif($right_answers[0] == 0){
                $item[0] = str_replace('\fbox{'.$option[0].'} + ','',$item[0]);
                unset($right_answers[0]);
                unset($option[0]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //対数の計算
    public function unit205_q05($unit_id){
        //初期設定
        $question_id = 20505;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        $x = pow(rand(2,6),2);
        $y = rand(1,3);
        $z = sqrt($x)*pow(2,$y);

        $a = $z;
        $b = $x;
 
        //答えの計算
        $right_answers[0] = $y;

        //問題テキストの設定
        $text = '$$ \log_2 '.$a.'- \log_4 '.$b;

        //空欄テキストの設定
        $item[0] = '\fbox{ア}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //対数の式の値
    public function unit205_q06($unit_id){
        //初期設定
        $question_id = 20506;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $x = rand(1,3);
        $y = rand(1,7);

        $a = pow(10,$x);
        $b = pow(2,$y);

        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = $x;
        $right_answers[1] = $y;

        //問題テキストの設定
        $text = '$$ \log_{10} 2 = a\\ とおくと、\\\\';
        $text .= 'log_{10} '.($b==1?$a:'\frac{'.$a.'}{'.$b.'}');

        //空欄テキストの設定
        $item[0] = '\fbox{ア} - ';
        $item[1] = '\fbox{イ}a';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/equation',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //対数方程式
    public function unit205_q07($unit_id){
        //初期設定
        $question_id = 20507;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        $a = rand(2,5);
        do { $b = rand(-5,5); } while( $b == 0 );
        $c = rand(1,4);

        //答えの計算
        $right_answers[0] = pow($a,$c) - $b;

        //問題テキストの設定
        $text = '$$ \log_'.$a.' (x'.d4($b).')='.$c.'のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'x= \fbox{ア}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //対数不等式
    public function unit205_q08($unit_id){
        //初期設定
        $question_id = 20508;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(2,5);
        do { $b = rand(-5,5); } while( $b == 0 );
        $c = rand(1,4);

        //答えの計算
        $right_answers[0] = -1*$b;
        $right_answers[1] = pow($a,$c) - $b;

        //問題テキストの設定
        $text = '$$ \log_'.$a.' (x'.d4($b).') \lt'.$c.'のとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\fbox{ア} \lt x \lt \fbox{イ}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //大小関係
    public function unit205_q09($unit_id){
        //初期設定
        $question_id = 20509;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $x = rand(2,4);
        do { $y = rand(2,5); } while( $x >= $y );

        $a = $x;
        $b = $y*rand(1,3);
        $c = $y;
        $d = $x;
        $e = pow($a,2);
        $f = pow($a,3);

        //答えの計算
        $s['a'] = log($b,$a);
        $s['b'] = log($d,$c);
        $s['c'] = log($f,$e);

        asort($s);

        $right_answers = array_keys($s);

        //問題テキストの設定
        $text = '$$ a = \log_{'.$a.'}'.$b.'、b = \log_{'.$c.'}'.$d.'、c = \log_{'.$e.'}'.$f.'\\\\を小さい順に並び変えると、\\\\';

        //空欄テキストの設定
        $item[0] = '\fbox{ア} \lt \fbox{イ} \lt \fbox{ウ}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/alphabet',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //桁数
    public function unit205_q10($unit_id){
        //初期設定
        $question_id = 20510;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        $a = rand(2,10)*10;

        //答えの計算
        $right_answers[0] = floor(0.3010*$a)+1;

        //問題テキストの設定
        $text = '$$ \log_{10} 2 = 0.3010\\ とすると、\\\\ 2^{'.$a.'}は、';

        //空欄テキストの設定
        $item[0] = '\fbox{ア}桁の整数である。';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //微分法
    //平均変化率
    public function unit206_q01($unit_id){
        //初期設定
        $question_id = 20601;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        $b = rand(-5,5);
        $c = rand(-5,5);
        $d = rand(-5,5);

        $e = rand(-4,4);
        do { $f = rand(-5,5); } while( $e>=$f );

        //答えの計算
        $right_answers[0] = $a*($f*$f+$f*$e+$e*$e) + $b*($f+$e) + $c;

        //問題テキストの設定
        $text = '$$ f(x) = '.d1($a,'x^{3}').d2($b,'x^{2}').d2($c,'x').d4($d).'\\ において、\\\\
                 xが'.$e.'から'.$f.'まで変化するときの平均変化率は、';

        //空欄テキストの設定
        $item[0] = '\fbox{ア}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //公式による微分
    public function unit206_q02($unit_id){
        //初期設定
        $question_id = 20602;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-7,7); } while( $a==0 );
        $b = rand(-7,7);
        $c = rand(-7,7);
        $d = rand(-7,7);

        //答えの計算
        $right_answers[0] = 3*$a;
        $right_answers[1] = 2*$b;
        $right_answers[2] = $c;

        //問題テキストの設定
        $text = '$$ f(x) = '.d1($a,'x^{3}').d2($b,'x^{2}').d2($c,'x').d4($d).'\\ とすると、\\\\';

        //空欄テキストの設定
        $item[0] = 'f\'(x) = ';
        $item[1] = ($right_answers[0]<0?'-':'').'\fbox{ア}x^{2}';
        $item[2] = ($right_answers[1]<0?'-':'+').'\fbox{イ}x';
        $item[3] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}';

        for($i=0;$i<3;$i++){
            if($right_answers[$i] == 0){
                $item[$i+1] = '';
                unset($right_answers[$i]);
                unset($option[$i]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //接線の方程式
    public function unit206_q03($unit_id){
        //初期設定
        $question_id = 20603;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        $b = rand(-7,7);
        $c = rand(-7,7);

        $d = rand(-3,3);
        $e = $a*$d*$d + $b*$d + $c;

        //答えの計算
        $right_answers[0] = 2*$a*$d + $b;
        $right_answers[1] = -1*$a*$d*$d + $c;

        //問題テキストの設定
        $text = '$$ f(x) = '.d1($a,'x^{2}').d2($b,'x').d4($c).'\\ とする。\\\\
                 y = f(x)\\ 上の点('.$d.','.$e.')における接線は、\\\\';

        //空欄テキストの設定
        $item[0] = 'y = ';
        $item[1] = ($right_answers[0]<0?'-':'').'\fbox{ア}x';
        $item[2] = ($right_answers[1]<0?'-':'+').'\fbox{イ}';

        for($i=0;$i<2;$i++){
            if($right_answers[$i] == 0){
                $item[$i+1] = '';
                unset($right_answers[$i]);
                unset($option[$i]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //曲線上にない点から引いた接線
    public function unit206_q04($unit_id){
        //初期設定
        $question_id = 20604;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        $b = rand(-5,5);
        $c = rand(-5,5);

        $d = rand(-3,3);
        $f = rand(1,6);
        $e[0] = $a*$a*$d*$d + $a*$b*$d + $a*$c - $f*$f;
        $e[1] = $a;
        list($e[0],$e[1]) = gcd($e[0],$e[1]);
        

        //答えの計算
        $right_answers[0] = 2*($a*$d - $f) + $b;
        $right_answers[1] = -1*pow(($a*$d - $f),2) + $a*$c;
        $right_answers[2] = $a;

        $right_answers[3] = 2*($a*$d + $f) + $b;
        $right_answers[4] = -1*pow(($a*$d + $f),2) + $a*$c;
        $right_answers[5] = $a;

        list($right_answers[1],$right_answers[2]) = gcd($right_answers[1],$right_answers[2]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);

        //問題テキストの設定
        $text = '$$ f(x) = '.d1($a,'x^{2}').d2($b,'x').d4($c).'\\ とする。\\\\
                 y = f(x)\\ 上の接線のうち、点('.$d.','.($e[0]*$e[1]<0?'-':'').'\frac{'.abs($e[0]).'}{'.abs($e[1]).'})における接線は、\\\\';

        if(abs($e[1]) == 1){
            $text = '$$ f(x) = '.d1($a,'x^{2}').d2($b,'x').d4($c).'\\ とする。\\\\
            y = f(x)\\ 上の接線のうち、点('.$d.','.($e[0]*$e[1]<0?'-':'').abs($e[0]).')を通る接線は、\\\\';
        }

        //空欄テキストの設定
        $item[0] = 'y = '.($right_answers[0]<0?'-':'').'\fbox{ア}x';
        $item[1] = ($right_answers[1]*$right_answers[2]<0?'-':'+').'\frac{\fbox{イ}}{\fbox{ウ}}、';
        $item[2] = 'y = '.($right_answers[3]<0?'-':'').'\fbox{エ}x';
        $item[3] = ($right_answers[4]*$right_answers[5]<0?'-':'+').'\frac{\fbox{オ}}{\fbox{カ}}\\\\';
        if($right_answers[0]*$right_answers[3]>0){
            $item[4] = 'ただし、'.($right_answers[0]<0?'-':'').'\fbox{ア} \lt '.($right_answers[3]<0?'-':'').'\fbox{エ}';
        }

        for($i=0;$i<2;$i++){
            if($right_answers[3*$i] == 0){
                $item[2*$i] = 'y = ';
                $blanks -= 1;
            }
            list($right_answers,$option,$blanks,$item[2*$i+1]) = l_frac($right_answers,$option,3*$i+2,$blanks,$item[2*$i+1]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //極値
    public function unit206_q05($unit_id){
        //初期設定
        $question_id = 20605;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        do { $x = rand(-5,5); } while( $x==0 );
        $y = rand(-4,4);
        do { $z = rand(-5,5); } while( $y >= $z );
        
        $a = 2*$x;
        $b = -3*$x*($y+$z);
        $c = 6*$x*$y*$z;
        $d = rand(-5,5);

        //答えの計算
        if($a > 0){
            $right_answers[0] = $y;
            $right_answers[1] = $a*$y*$y*$y + $b*$y*$y + $c*$y + $d;
            $right_answers[2] = $z;
            $right_answers[3] = $a*$z*$z*$z + $b*$z*$z + $c*$z + $d;
        }else{
            $right_answers[0] = $z;
            $right_answers[1] = $a*$z*$z*$z + $b*$z*$z + $c*$z + $d;
            $right_answers[2] = $y;
            $right_answers[3] = $a*$y*$y*$y + $b*$y*$y + $c*$y + $d;
        }

        //問題テキストの設定
        $text = '$$ f(x) = '.d1($a,'x^{3}').d2($b,'x^{2}').d2($c,'x').d4($d).'\\ は、\\\\';

        //空欄テキストの設定
        $item[0] = 'x = \fbox{ア}で';
        $item[1] = '極大値\fbox{イ}、';
        $item[2] = 'x = \fbox{ウ}で';
        $item[3] = '極大値\fbox{エ}をとる。';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //極値から係数の決定
    public function unit206_q06($unit_id){
        //初期設定
        $question_id = 20606;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        do { $p = rand(-5,5); } while( $p==0 );
        do { $q = rand(-5,5); } while( $q==0 );
        do { $r = rand(-5,5); } while( $r==0 );
        do { $s = rand(-6,6); } while( $s==0 || $r>=$s);

        //答えの計算
        $right_answers[0] = $q;
        $right_answers[1] = 3*$r*$s;
        $right_answers[2] = -1*$q*($s+$r);
        $right_answers[3] = 2*$p*$r*$s;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
        
        //問題テキストの設定
        $text = '$$ f(x) = ax^{3}'.d2($p,'bx^{2}').d2($q,'x').'+a\\ が、\\\\
                x='.$r.','.$s.'で極値をとるとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'a = '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}、';
        $item[1] = 'b = '.($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}}';

        for($i=0;$i<2;$i++){
            list($right_answers,$option,$blanks,$item[$i]) = l_frac($right_answers,$option,2*$i+1,$blanks,$item[$i]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }


        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //方程式の解の個数
    public function unit206_q07($unit_id){
        //初期設定
        $question_id = 20607;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        do { $x = rand(-5,5); } while( $x==0 );
        $y = rand(-4,4);
        do { $z = rand(-5,5); } while( $y >= $z );
        
        $a = 2*$x;
        $b = -3*$x*($y+$z);
        $c = 6*$x*$y*$z;
        $d = rand(-5,5);

        $f_y = $a*$y*$y*$y + $b*$y*$y + $c*$y + $d;
        $f_z = $a*$z*$z*$z + $b*$z*$z + $c*$z + $d;

        //答えの計算
        if($f_y*$f_z > 0){
            $right_answers[0] = 1;
        }elseif($f_y*$f_z == 0){
            $right_answers[0] = 2;
        }else{
            $right_answers[0] = 3;
        }

        //問題テキストの設定
        $text = '$$ '.d1($a,'x^{3}').d2($b,'x^{2}').d2($c,'x').d4($d).'=0\\ の実数解の個数は、';

        //空欄テキストの設定
        $item[0] = '\fbox{ア}個である。';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //積分法
    //不定積分
    public function unit207_q01($unit_id){
        //初期設定
        $question_id = 20701;
        $blanks = 5;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = 3;
        $right_answers[2] = $b;
        $right_answers[3] = 2;
        $right_answers[4] = $c;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ \int{('.d1($a,'x^{2}').d2($b,'x').d4($c).')}dx = ';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}x^{3}';
        $item[1] = ($right_answers[2]<0?'-':'+').'\frac{\fbox{ウ}}{\fbox{エ}}x^{2}';
        $item[2] = ($right_answers[4]<0?'-':'+').'\fbox{オ}x';
        $item[3] = '+C';

        for($i=0;$i<2;$i++){
            list($right_answers,$option,$blanks,$item[$i]) = l_frac($right_answers,$option,2*$i+1,$blanks,$item[$i]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //定積分
    public function unit207_q02($unit_id){
        //初期設定
        $question_id = 20702;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        $e = rand(-5,5);
        do { $f = rand(-6,4); } while( $e<=$f );

        //答えの計算
        $right_answers[0] = 2*$a*$e*$e*$e + 3*$b*$e*$e + 6*$c*$e - 2*$a*$f*$f*$f - 3*$b*$f*$f - 6*$c*$f;
        $right_answers[1] = 6;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ \int_{'.$f.'}^{'.$e.'}{('.d1($a,'x^{2}').d2($b,'x').d4($c).')}dx = ';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //定積分と微分
    public function unit207_q03($unit_id){
        //初期設定
        $question_id = 20703;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        do { $x = rand(-5,5); } while( $x==0 );
        $y = rand(-5,5);
        do { $z = rand(-6,6); } while( $y>=$z );

        $p = $x;
        $q = -1*$x*($y+$z);
        $r = $x*$y*$z;

        //答えの計算
        $right_answers[0] = 2*$p;
        $right_answers[1] = $q;
        $right_answers[2] = $y;
        $right_answers[3] = $z;

        //問題テキストの設定
        $text = '$$ f(x)が、\int_{a}^{x}{f(t)}dt='.d1($p,'x^{2}').d2($q,'x').d4($r).'\\ を満たすとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'f(x) = '.($right_answers[0]<0?'-':'').'\fbox{ア}x';
        $item[1] = ($right_answers[1]<0?'-':'+').'\fbox{イ}、';
        $item[2] = 'a='.($right_answers[2]<0?'-':'').'\fbox{ウ}、';
        $item[3] = ($right_answers[3]<0?'-':'').'\fbox{エ}\\\\';
        if($right_answers[2]*$right_answers[3]>0){
            $item[4] = 'ただし、\fbox{ウ} \lt \fbox{エ}';
        }

        if($right_answers[1] == 0){
            $item[1] = '、';
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //絶対値を含む関数の定積分
    public function unit207_q04($unit_id){
        //初期設定
        $question_id = 20704;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(-5,2);
        do { $c = rand(-5,3); } while( $a >= $c );
        do { $b = rand(-5,5); } while( $c >= $b );

        //答えの計算
        $right_answers[0] = $a*$a + $b*$b + 2*$c*$c - 2*$a*$c - 2*$b*$c;
        $right_answers[1] = 2;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ \int_{'.$a.'}^{'.$b.'}{|x'.d4(-1*$c).'|}dx = ';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //曲線とx軸で囲まれた図形の面積
    public function unit207_q05($unit_id){
        //初期設定
        $question_id = 20705;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        do { $x = rand(-5,5); } while( $x==0 );
        $y = rand(-5,5);
        do { $z = rand(-6,6); } while( $y >= $z );

        $a = $x;
        $b = -1*$x*($y+$z);
        $c = $x*$y*$z;

        //答えの計算
        $right_answers[0] = abs($a)*pow($z-$y,3);
        $right_answers[1] = 6;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ 放物線\\ y='.d1($a,'x^{2}').d2($b,'x').d4($c).'\\ と、\\\\
                 x軸で囲まれた部分の面積は、';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //直線と曲線で囲まれた図形の面積
    public function unit207_q06($unit_id){
        //初期設定
        $question_id = 20706;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        do { $x = rand(-5,5); } while( $x==0 );
        $y = rand(-5,5);
        do { $z = rand(-6,6); } while( $y >= $z );

        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        $c = -1*$x;
        $d = $a + $x*($y+$z);
        $e = $b - $x*$y*$z;

        //答えの計算
        $right_answers[0] = abs($x)*pow($z-$y,3);
        $right_answers[1] = 6;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ 直線\\ y='.d1($a,'x').d4($b).'と放物線\\ y='.d1($c,'x^{2}').d2($d,'x').d4($e).'\\\\
                 で囲まれた部分の面積は、';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //３次関数ととx軸で囲まれた図形の面積
    public function unit207_q07($unit_id){
        //初期設定
        $question_id = 20707;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $x = rand(-4,0);
        do { $y = rand(-4,2); } while( $x >= $y );
        do { $z = rand(-4,4); } while( $y >= $z );

        $a = -1*($x+$y+$z);
        $b = $x*$y + $y*$z + $z*$x;
        $c = -1*$x*$y*$z;

        //答えの計算
        $right_answers[0] = -2*$y*$y*($y*$y-2*$x*$y-2*$y*$z+6*$x*$z) + $x*$x*($x*$x-2*$x*$y-2*$x*$z+6*$y*$z) + $z*$z*($z*$z-2*$x*$z-2*$y*$z+6*$x*$y);
        $right_answers[1] = 12;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ 曲線\\ y=x^{3}'.d2($a,'x^{2}').d2($b,'x').d4($c).'\\ と、\\\\
                 x軸で囲まれた２つの部分の面積の和は、';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //数学Ⅲ
    //複素数平面
    //極形式
    public function unit301_q01($unit_id){
        //初期設定
        $question_id = 30101;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $s = rand(0,5);
        $theta[0] = [1,1,1,2,3,5];
        $theta[1] = [6,4,3,3,4,6];

        $a = [3,1,1,1,1,3];
        $a_sign = [1,1,1,-1,-1,-1];
        $b = [1,1,3,3,1,1];
        $r = rand(1,3);

        list($t,$u) = root($r,$a[$s]);
        list($v,$w) = root($r,$b[$s]);

        //答えの計算
        $right_answers[0] = $r;
        $right_answers[1] = $a[$s]+$b[$s];
        $right_answers[2] = $theta[0][$s];
        $right_answers[3] = $theta[1][$s];

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ 複素数\\ '.complex($t*$a_sign[$s],$u,$v,$w).'\\ を極形式で表すと、\\\\';

        //$text = '$$';
        //空欄テキストの設定
        $item[0] = '\fbox{ア}\sqrt{\fbox{イ}}';
        $item[1] = '(\cos{\frac{\fbox{ウ}}{\fbox{エ}}\pi} +i\sin{\frac{\fbox{ウ}}{\fbox{エ}}\pi})';

        list($right_answers,$option,$blanks,$item[0]) = l_root($right_answers,$option,0,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //複素数の積と商
    public function unit301_q02($unit_id){
        //初期設定
        $question_id = 30102;
        $blanks = 7;
        $option = $this->option;

        //変数の設定
        $theta = [0,30,45,60,90,120,135,150,180];
        $alpha = rand(0,8);
        do{ $beta = rand(0,8); }while($alpha==$beta);

        $r_1 = rand(1,5)*2;
        $r_2 = rand(1,5)*2;

        list($a,$b) = d_cos($theta[$alpha]);
        list($c,$d) = d_sin($theta[$alpha]);
        $b = $r_1/$b;
        $d = $r_1/$d;

        list($e,$f) = d_cos($theta[$beta]);
        list($g,$h) = d_sin($theta[$beta]);
        $f = $r_2/$f;
        $h = $r_2/$h;

        $p = $theta[$alpha] + $theta[$beta];
        $q = $theta[$alpha] - $theta[$beta];
        if($q < 0){ $q += 360; }


        //答えの計算
        $right_answers[0] = $r_1*$r_2;
        $right_answers[1] = $p;
        $right_answers[2] = 180;
        $right_answers[3] = $r_1;
        $right_answers[4] = $r_2;
        $right_answers[5] = $q;
        $right_answers[6] = 180;

        list($right_answers[1],$right_answers[2]) = gcd($right_answers[1],$right_answers[2]);
        list($right_answers[3],$right_answers[4]) = gcd($right_answers[3],$right_answers[4]);
        list($right_answers[5],$right_answers[6]) = gcd($right_answers[5],$right_answers[6]);


        //問題テキストの設定
        $text = '$$ \alpha='.complex($b,$a,$d,$c).'、\beta='.complex($f,$e,$h,$g).'\\ とする。このとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\alpha \beta =';
        $item[1] = '\fbox{ア}';
        $item[2] = '(\cos{\frac{\fbox{イ}}{\fbox{ウ}}\pi} +i\sin{\frac{\fbox{イ}}{\fbox{ウ}}\pi})\\\\';
        $item[3] = '\frac{\alpha}{\beta} = ';
        $item[4] = '\frac{\fbox{エ}}{\fbox{オ}}';
        $item[5] = '(\cos{\frac{\fbox{カ}}{\fbox{キ}}\pi} +i\sin{\frac{\fbox{カ}}{\fbox{キ}}\pi})\\\\';
        $item[6] = 'ただし、偏角\thetaは、0 \lt \theta \lt 2\pi \\ とする。';

        list($right_answers,$option,$blanks,$item[4]) = l_frac($right_answers,$option,4,$blanks,$item[4]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //複素数の回転
    public function unit301_q03($unit_id){
        //初期設定
        $question_id = 30103;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $theta = [0,30,45,60,90,120,135,150,180];
        $alpha = rand(0,6);
        do { $beta = rand(1,7); } while(!in_array($theta[$alpha]+$theta[$beta],$theta));

        $r_1 = rand(1,5)*2;

        list($a,$b) = d_cos($theta[$alpha]);
        list($c,$d) = d_sin($theta[$alpha]);
        $b = $r_1/$b;
        $d = $r_1/$d;

        $x = $theta[$alpha] + $theta[$beta];

        list($e,$f) = d_cos($x);
        list($g,$h) = d_sin($x);
        $f = $r_1/$f;
        $h = $r_1/$h;

        $y[0] = $theta[$beta];
        $y[1] = 180;

        list($y[0],$y[1]) = gcd($y[0],$y[1]);
        

        //答えの計算
        $right_answers[0] = $f;
        $right_answers[1] = $e;
        $right_answers[2] = $h;
        $right_answers[3] = $g;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = root($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ \alpha='.complex($b,$a,$d,$c).'\\ とする。\\\\
                 点A(\alpha)を、原点を中心として、\frac{'.$y[0].'}{'.$y[1].'} \piだけ\\\\
                 回転した点を、点B(\beta)とすると、\\\\';

        //空欄テキストの設定
        $item[0] = '\beta =';
        $item[1] = ($right_answers[0]<0?'-':'').'\fbox{ア}\sqrt{\fbox{イ}}';
        $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}\sqrt{\fbox{エ}}i';

        if($right_answers[0]==0 || $right_answers[1]==0){
            $item[1] = '';
            unset($right_answers[0]);
            unset($right_answers[1]);
            unset($option[0]);
            unset($option[1]);
            $blanks -= 2;
        }else{
            list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,0,1,$blanks,$item[1]);
        }
        if($right_answers[2]==0 || $right_answers[3]==0){
            $item[2] = '';
            unset($right_answers[2]);
            unset($right_answers[3]);
            unset($option[2]);
            unset($option[3]);
            $blanks -= 2;
        }else{
            list($right_answers,$option,$blanks,$item[2]) = l_root($right_answers,$option,2,3,$blanks,$item[2]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //ド・モアブルの定理
    public function unit301_q04($unit_id){
        //初期設定
        $question_id = 30104;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $theta = [0,30,45,60,90,120,135,150,180];
        $alpha = rand(0,8);
        $z = rand(2,5);

        $r_1 = rand(1,5)*2;

        list($a,$b) = d_cos($theta[$alpha]);
        list($c,$d) = d_sin($theta[$alpha]);
        $b = $r_1/$b;
        $d = $r_1/$d;

        $x[0] = $theta[$alpha]*$z;
        $x[1] = 180;

        list($x[0],$x[1]) = gcd($x[0],$x[1]);

        $y = rad_to_deg($x[0],$x[1]);

        list($e,$f) = d_cos($y);
        list($g,$h) = d_sin($y);
        $f = pow($r_1,$z)/$f;
        $h = pow($r_1,$z)/$h;

        //答えの計算
        $right_answers[0] = $f;
        $right_answers[1] = $e;
        $right_answers[2] = $h;
        $right_answers[3] = $g;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = root($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ ('.complex($b,$a,$d,$c).')^{'.$z.'}= ';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]<0?'-':'').'\fbox{ア}\sqrt{\fbox{イ}}';
        $item[1] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}\sqrt{\fbox{エ}}i';

        if($right_answers[0]==0 || $right_answers[1]==0){
            $item[0] = '';
            unset($right_answers[0]);
            unset($right_answers[1]);
            unset($option[0]);
            unset($option[1]);
            $blanks -= 2;
        }else{
            list($right_answers,$option,$blanks,$item[0]) = l_root($right_answers,$option,0,1,$blanks,$item[0]);
        }
        if($right_answers[2]==0 || $right_answers[3]==0){
            $item[1] = '';
            unset($right_answers[2]);
            unset($right_answers[3]);
            unset($option[2]);
            unset($option[3]);
            $blanks -= 2;
        }else{
            list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,2,3,$blanks,$item[1]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //方程式の表す図形
    public function unit301_q05($unit_id){
        //初期設定
        $question_id = 30105;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        $b = rand(2,5);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = $b*$b-1;
        $right_answers[2] = abs($a)*$b;
        $right_answers[3] = $b*$b-1;

        //問題テキストの設定
        $text = '$$ |z'.d4($a).'| = '.d1($b,'|z|').'\\ があらわす図形は、\\\\';

        //空欄テキストの設定
        $item[0] = '点'.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}を中心とする';
        $item[1] = '半径\frac{\fbox{ウ}}{\fbox{エ}}の円';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,3,$blanks,$item[1]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //なす角
    public function unit301_q06($unit_id){
        //初期設定
        $question_id = 30106;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $theta = [0,30,45,60,90,120,135,150,180];
        $alpha = rand(1,8);

        $r_1 = rand(1,5)*2;

        list($a,$b) = d_cos($theta[$alpha]);
        list($c,$d) = d_sin($theta[$alpha]);
        $b = $r_1/$b;
        $d = $r_1/$d;

        //答えの計算
        $right_answers[0] = $theta[$alpha];
        $right_answers[1] = 180;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ 異なる３点A(\alpha),B(\beta),C(\gamma)に対して、\\\\
                 \frac{\gamma - \alpha}{\beta - \alpha} = '.complex($b,$a,$d,$c).'\\ のとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\angle{\beta \alpha \gamma} = \frac{\fbox{ア}}{\fbox{イ}}\pi';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);


        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //式と曲線
    //放物線
    public function unit302_q01($unit_id){
        //初期設定
        $question_id = 30201;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = 0;
        $right_answers[2] = -1*$a;

        //問題テキストの設定
        $text = '$$ 放物線\\ y^{2}='.d1(4*$a,'x').'は、\\\\';

        //空欄テキストの設定
        $item[0] = '焦点\\ (\fbox{ア},\fbox{イ})、';
        $item[1] = '準線\\ x = \fbox{ウ}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //楕円
    public function unit302_q02($unit_id){
        //初期設定
        $question_id = 30202;
        $blanks = 8;
        $option = $this->option;

        //変数の設定
        $a = rand(2,7);
        do { $b = rand(2,7); } while($a==$b);

        //答えの計算
        if($a > $b){
            $right_answers[0] = 2*$a;
            $right_answers[1] = 2*$b;
            $right_answers[2] = 1;
            $right_answers[3] = $a*$a-$b*$b;
            $right_answers[4] = 0;
            $right_answers[5] = -1;
            $right_answers[6] = $a*$a-$b*$b;
            $right_answers[7] = 0;
            list($right_answers[2],$right_answers[3]) = root($right_answers[2],$right_answers[3]);
            list($right_answers[5],$right_answers[6]) = root($right_answers[5],$right_answers[6]);
        }else{
            $right_answers[0] = 2*$b;
            $right_answers[1] = 2*$a;
            $right_answers[2] = 0;
            $right_answers[3] = 1;
            $right_answers[4] = $b*$b-$a*$a;
            $right_answers[5] = 0;
            $right_answers[6] = -1;
            $right_answers[7] = $b*$b-$a*$a;
            list($right_answers[3],$right_answers[4]) = root($right_answers[3],$right_answers[4]);
            list($right_answers[6],$right_answers[7]) = root($right_answers[6],$right_answers[7]);
        }

        //問題テキストの設定
        $text = '$$ 楕円\\ \frac{x^{2}}{'.($a*$a).'}+\frac{y^{2}}{'.($b*$b).'}=1\\ は、\\\\';

        //空欄テキストの設定
        $item[0] = '長軸の長さ\\ \fbox{ア}、短軸の長さ\\ \fbox{イ}\\\\';
        if($a>$b){
            $item[1] = '焦点 \\ (\fbox{ウ}\sqrt{\fbox{エ}},\\ \fbox{オ})、';
            $item[2] = '(-\fbox{カ}\sqrt{\fbox{キ}},\\ \fbox{ク})';
            list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,2,3,$blanks,$item[1]);
            list($right_answers,$option,$blanks,$item[2]) = l_root($right_answers,$option,5,6,$blanks,$item[2]);
        }else{
            $item[1] = '焦点 \\ (\fbox{ウ},\\ \fbox{エ}\sqrt{\fbox{オ}})、';
            $item[2] = '(\fbox{カ},\\ -\fbox{キ}\sqrt{\fbox{ク}})';
            list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,3,4,$blanks,$item[1]);
            list($right_answers,$option,$blanks,$item[2]) = l_root($right_answers,$option,6,7,$blanks,$item[2]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //双曲線
    public function unit302_q03($unit_id){
        //初期設定
        $question_id = 30203;
        $blanks = 10;
        $option = $this->option;

        //変数の設定
        $a = rand(2,7);
        do { $b = rand(2,7); } while($a==$b);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = 0;
        $right_answers[2] = -1*$a;
        $right_answers[3] = 0;
        $right_answers[4] = 1;
        $right_answers[5] = $a*$a+$b*$b;
        $right_answers[6] = 0;
        $right_answers[7] = -1;
        $right_answers[8] = $a*$a+$b*$b;
        $right_answers[9] = 0;
        list($right_answers[4],$right_answers[5]) = root($right_answers[4],$right_answers[5]);
        list($right_answers[7],$right_answers[8]) = root($right_answers[7],$right_answers[8]);

        //問題テキストの設定
        $text = '$$ 双曲線\\ \frac{x^{2}}{'.($a*$a).'}-\frac{y^{2}}{'.($b*$b).'}=1\\ は、\\\\';

        //空欄テキストの設定
        $item[0] = '頂点\\ (\fbox{ア},\\ \fbox{イ})、(-\fbox{ウ},\\ \fbox{エ})\\\\';
        $item[1] = '焦点 \\ (\fbox{オ}\sqrt{\fbox{カ}},\\ \fbox{キ})、';
        $item[2] = '(-\fbox{ク}\sqrt{\fbox{ケ}},\\ \fbox{コ})';
        list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,4,5,$blanks,$item[1]);
        list($right_answers,$option,$blanks,$item[2]) = l_root($right_answers,$option,7,8,$blanks,$item[2]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //２次曲線の平行移動
    public function unit302_q04($unit_id){
        //初期設定
        $question_id = 30204;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $p = rand(2,7);
        $q = rand(2,7);
        do { $r = rand(-5,5); } while($r==0);
        do { $s = rand(-5,5); } while($s==0);

        $a = $q;
        $b = $p;
        $c = -2*$q*$r;
        $d = -2*$p*$s;
        $e = $q*$r*$r + $p*$s*$s - $p*$q;

        //答えの計算
        $right_answers[0] = $p;
        $right_answers[1] = $q;
        $right_answers[2] = $r;
        $right_answers[3] = $s;

        //問題テキストの設定
        $text = '$$ 次の式\\ '.d1($a,'x^{2}').d2($b,'y^{2}').d2($c,'x').d2($d,'y').d4($e).'=0\\ は、\\\\';

        //空欄テキストの設定
        $item[0] = '楕円\\ \frac{x^{2}}{\fbox{ア}}+\frac{y^{2}}{\fbox{イ}}=1\\ を、\\\\';
        $item[1] = 'x軸方向に\fbox{ウ}、y軸方向に\fbox{エ}だけ\\\\';
        $item[2] = '平行移動したものである。';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //２次曲線と直線の共有点
    public function unit302_q05($unit_id){
        //初期設定
        $question_id = 30205;
        $blanks = 8;
        $option = $this->option;

        //変数の設定
        $p = rand(1,5);
        $a = rand(2,7);
        do { $b = rand(-5,5); } while($b==0);
        $k = pow(rand(1,6),2);
        $c = $k - $b*$b*$p*$p;

        $x = $a*4*$a*$p;
        $y = $b*4*$a*$p;
        $z = $c;

        $s = gmp_gcd($x,gmp_gcd($y,$z));
        list($x,$y,$z) = array($x/$s,$y/$s,$z/$s);

        //答えの計算
        $right_answers[0] = $k + $b*$b*$p*$p + 2*$b*$p*sqrt($k);
        $right_answers[1] = 4*$a*$a*$p;
        $right_answers[2] = -1*$b*$p - sqrt($k);
        $right_answers[3] = 2*$a;
        $right_answers[4] = $k + $b*$b*$p*$p - 2*$b*$p*sqrt($k);
        $right_answers[5] = 4*$a*$a*$p;
        $right_answers[6] = -1*$b*$p + sqrt($k);
        $right_answers[7] = 2*$a;

        list($right_answers[0],$right_answers[1]) = gcd((int)$right_answers[0],(int)$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd((int)$right_answers[2],(int)$right_answers[3]);
        list($right_answers[4],$right_answers[5]) = gcd((int)$right_answers[4],(int)$right_answers[5]);
        list($right_answers[6],$right_answers[7]) = gcd((int)$right_answers[6],(int)$right_answers[7]);

        //問題テキストの設定
        $text = '$$ 放物線\\ y^{2}='.d1($p,'x').'と、\\ 直線\\ '.d1($x,'x').d2($y,'y').'='.$z.'\\ の共有点は、\\\\
                y座標の小さい順に、\\\\';

        //空欄テキストの設定
        $item[0] = '('.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}},';
        $item[1] = ($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}}),';
        $item[2] = '('.($right_answers[4]*$right_answers[5]<0?'-':'').'\frac{\fbox{オ}}{\fbox{カ}},';
        $item[3] = ($right_answers[6]*$right_answers[7]<0?'-':'').'\frac{\fbox{キ}}{\fbox{ク}})';

        for($i=0;$i<4;$i++){
            list($right_answers,$option,$blanks,$item[$i]) = l_frac($right_answers,$option,2*$i+1,$blanks,$item[$i]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //２次曲線と接線の方程式
    public function unit302_q06($unit_id){
        //初期設定
        $question_id = 30206;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(2,7);
        do { $b = rand(1,8); } while($a==$b);
        $c = rand(1,10);
        do { $p = rand(-8,8); } while(abs($p) < $a);

        $s = gmp_gcd($a,gmp_gcd($b,$c));
        list($a,$b,$c) = array($a/$s,$b/$s,$c/$s);

        //答えの計算
        $right_answers[0] = 1;
        $right_answers[1] = $b*$c*($a*$b*$p*$p - $a*$c);
        $right_answers[2] = $b*$c;
        $right_answers[3] = $p;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);
        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);

        //問題テキストの設定
        $text = '$$ 点(0,'.$p.')から楕円\\ '.d1($a,'x^{2}').d2($b,'y^{2}').'='.$c.'\\ \\\\ に引いた接線の方程式は、\\\\';

        //空欄テキストの設定
        $item[0] = 'y=\pm \frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}x';
        $item[1] = ($p<0?'-':'+').'\fbox{エ}';

        list($right_answers,$option,$blanks,$item[0]) = l_root($right_answers,$option,0,1,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,3,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //媒介変数表示
    public function unit302_q07($unit_id){
        //初期設定
        $question_id = 30207;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-7,7); } while($a==0);
        do { $b = rand(-7,7); } while($b==0);
        do { $c = rand(-7,7); } while($c==0);

        //答えの計算
        $right_answers[0] = -1*$a;
        $right_answers[1] = $c;

        //問題テキストの設定
        $text = '$$ 放物線\\ y='.d1($a,'x^{2}').d2($b.'tx').d4($c).'\\ の\\\\
                 頂点(x,y)が描く曲線は、\\\\';

        //空欄テキストの設定
        $item[0] = 'y= '.($right_answers[0]<0?'-':'').'\fbox{ア}x^{2}';
        $item[1] = ($right_answers[1]<0?'-':'+').'\fbox{イ}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //極座標と直交座標
    public function unit302_q08($unit_id){
        //初期設定
        $question_id = 30208;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $theta = [0,30,45,60,90,120,135,150,180];
        $alpha = rand(1,8);

        $r = rand(1,5)*2;

        list($a,$b) = d_cos($theta[$alpha]);
        list($c,$d) = d_sin($theta[$alpha]);
        $b = $r/$b;
        $d = $r/$d;

        list($b,$a) = root($b,$a);
        list($d,$c) = root($d,$c);

        //答えの計算
        $right_answers[0] = $r;
        $right_answers[1] = $theta[$alpha];
        $right_answers[2] = 180;

        list($right_answers[1],$right_answers[2]) = gcd($right_answers[1],$right_answers[2]);

        //問題テキストの設定
        if($a == 1){
            $li_1 = $b;
        }else{
            if(abs($b)==1){
                $li_1 = ($b>0?'':'-').'\sqrt{'.$a.'}';
            }else{
                $li_1 = $b.'\sqrt{'.$a.'}';
            }
        }
        if($a==0 || $b==0){
            $li_1 = 0;
        }

        if($c == 1){
            $li_2 = $d;
        }else{
            if(abs($d)==1){
                $li_2 = ($d>0?'':'-').'\sqrt{'.$c.'}';
            }else{
                $li_2 = $d.'\sqrt{'.$c.'}';
            }
        }
        if($c==0 || $d==0){
            $li_2 = 0;
        }

        $text = '$$ 直交座標が('.$li_1.','.$li_2.')である点Pの\\\\
                 極座標を(r,\theta)とすると、\\\\';

        //空欄テキストの設定
        $item[0] = '(r,\theta) = ';
        $item[1] = '(\fbox{ア},\frac{\fbox{イ}}{\fbox{ウ}}\pi)\\\\';
        $item[2] = 'ただし、0 \lt \theta \lt 2\pi';

        list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,2,$blanks,$item[1]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //関数
    //分数関数
    public function unit303_q01($unit_id){
        //初期設定
        $question_id = 30301;
        $blanks = 5;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(-5,5); } while( $b==0 || gmp_gcd($a,$b)!=1);
        do { $c = rand(-5,5); } while( $c==0 );

        //答えの計算
        $right_answers[0] = $b-$a*$c;
        $right_answers[1] = $c;
        $right_answers[2] = $a;
        $right_answers[3] = -1*$c;
        $right_answers[4] = $a;

        //問題テキストの設定
        $text = '$$ y=\frac{'.d1($a,'x').d4($b).'}{x'.d4($c).'}は、\\\\';

        //空欄テキストの設定
        $item[0] = 'y = '.($right_answers[0]>0?'':'-').'\frac{\fbox{ア}}{x'.($right_answers[1]>0?'+':'-').'\fbox{イ}}';
        $item[1] = ($right_answers[2]>0?'+':'-').'\fbox{ウ}\\ と変形でき、\\\\';
        $item[2] = '漸近線は、\\ ';
        $item[3] = 'x = '.($right_answers[3]>=0?'':'-').'\fbox{エ}、';
        $item[4] = 'y = '.($right_answers[4]>=0?'':'-').'\fbox{オ}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //分数関数と直線の共有点
    public function unit303_q02($unit_id){
        //初期設定
        $question_id = 30302;
        $blanks = 8;
        $option = $this->option;

        //変数の設定
        do { $b = rand(-5,5); } while( $b==0 );
        $c = 1;
        $d = rand(-7,7);
        do { $k = pow(rand(1,6),2); } while($k == $b*$c-$d);

        $x = $k - pow($b*$c-$d,2);
        $y = 4*$c;
        $z = 4*$b*$c;

        $s = gmp_gcd($x,gmp_gcd($y,$z));
        list($x,$y,$z) = array($x/$s,$y/$s,$z/$s);


        //答えの計算
        $right_answers[0] = -1*$b*$c-$d - (int)sqrt($k);
        $right_answers[1] = 2*$c;
        $right_answers[2] = -1*$b*$c + $d - (int)sqrt($k);
        $right_answers[3] = 2;
        $right_answers[4] = -1*$b*$c-$d + (int)sqrt($k);
        $right_answers[5] = 2*$c;
        $right_answers[6] = -1*$b*$c + $d + (int)sqrt($k);
        $right_answers[7] = 2;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);
        list($right_answers[6],$right_answers[7]) = gcd($right_answers[6],$right_answers[7]);

        //問題テキストの設定
        $text = '$$ y='.($x>0?'':'-').'\frac{'.abs($x).'}{'.d1($y,'x').d4($z).'}と、y='.d1($c,'x').d4($d).'の\\\\
                 共有点の座標は、x座標が小さい順に、\\\\';

        //空欄テキストの設定
        $item[0] = '('.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}},';
        $item[1] = ($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}}),';
        $item[2] = '('.($right_answers[4]*$right_answers[5]<0?'-':'').'\frac{\fbox{オ}}{\fbox{カ}},';
        $item[3] = ($right_answers[6]*$right_answers[7]<0?'-':'').'\frac{\fbox{キ}}{\fbox{ク}})';

        for($i=0;$i<4;$i++){
            list($right_answers,$option,$blanks,$item[$i]) = l_frac($right_answers,$option,2*$i+1,$blanks,$item[$i]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //無理関数
    public function unit303_q03($unit_id){
        //初期設定
        $question_id = 30303;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(-5,5); } while( $b==0 );

        $p = $a;
        $q = $a*$b;

        //答えの計算
        $right_answers[0] = -1*$b;
        $right_answers[1] = -1*$b;
        $right_answers[2] = 0;

        //問題テキストの設定
        $text = '$$ y=\sqrt{'.d1($p,'x').d4($q).'}のグラフは、\\\\';

        //空欄テキストの設定
        $item[0] = 'y =\sqrt{'.d1($p,'x').'}のグラフを、\\\\';
        $item[1] = 'x軸方向に'.($right_answers[0]<0?'-':'').'\fbox{ア}だけ移動したものであり、\\\\';
        $item[2] = '定義域は、x \geqq '.($right_answers[1]<0?'-':'').'\fbox{イ}、';
        $item[3] = 'y \geqq \fbox{ウ}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //逆関数
    public function unit303_q04($unit_id){
        //初期設定
        $question_id = 30304;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(-5,5); } while( $b==0 || gmp_gcd($a,$b)!=1);
        do { $c = rand(1,5); } while( $a==$c );
        do { $d = rand(-5,5); } while( $d==0 || gmp_gcd($c,$d)!=1);

        //答えの計算
        $right_answers[0] = -1*$d;
        $right_answers[1] = $b;
        $right_answers[2] = $c;
        $right_answers[3] = -1*$a;

        //問題テキストの設定
        $text = '$$ y=\frac{'.d1($a,'x').d4($b).'}{'.d1($c,'x').d4($d).'}の逆関数は、\\\\';

        //空欄テキストの設定
        $item[0] = 'y = \frac{';
        $item[1] = ($right_answers[0]<0?'-':'').'\fbox{ア}x';
        $item[2] = ($right_answers[1]<0?'-':'+').'\fbox{イ}';
        $item[3] = '}';
        $item[4] = '{';
        $item[5] = ($right_answers[2]<0?'-':'').'\fbox{ウ}x';
        $item[6] = ($right_answers[3]<0?'-':'+').'\fbox{エ}';
        $item[7] = '}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //合成関数
    public function unit303_q05($unit_id){
        //初期設定
        $question_id = 30305;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-5,5); } while( $d==0 );
        do { $e = rand(-5,5); } while( $e==0 );

        //答えの計算
        $right_answers[0] = $a*$d;
        $right_answers[1] = $b*$d;
        $right_answers[2] = $c*$d + $e;
        $right_answers[3] = $a*$d*$d;
        $right_answers[4] = 2*$a*$d*$e + $b*$d;
        $right_answers[5] = $a*$e*$e + $b*$e + $c;

        //問題テキストの設定
        $text = '$$ f(x) = '.d1($a,'x^{2}').d2($b,'x').d4($c).'\\\\
                 g(x) = '.d1($d,'x').d4($e).'\\\\とすると、\\\\';

        //空欄テキストの設定
        $item[0] = '(g \circ f)(x) = ';
        $item[1] = ($right_answers[0]<0?'-':'').'\fbox{ア}x^{2}';
        $item[2] = ($right_answers[1]<0?'-':'+').'\fbox{イ}x';
        $item[3] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}';
        $item[4] = '\\\\';
        $item[5] = '(f \circ g)(x) = ';
        $item[6] = ($right_answers[3]<0?'-':'').'\fbox{エ}x^{2}';
        $item[7] = ($right_answers[4]<0?'-':'+').'\fbox{オ}x';
        $item[8] = ($right_answers[5]<0?'-':'+').'\fbox{カ}';

        for($i=0;$i<3;$i++){
            if($right_answers[$i] == 0){
                $item[$i+1] = '';
                unset($right_answers[$i]);
                unset($option[$i]);
                $blanks -= 1;
            }
        }
        for($i=0;$i<3;$i++){
            if($right_answers[$i+3] == 0){
                $item[$i+6] = '';
                unset($right_answers[$i+3]);
                unset($option[$i+3]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //極限
    //数列の極限
    public function unit304_q01($unit_id){
        //初期設定
        $question_id = 30401;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        do { $b = rand(-5,5); } while( $b==0 || gmp_gcd($a,$b)!=1);
        $c = rand(1,7);
        do { $d = rand(-5,5); } while( $d==0 || gmp_gcd($c,$d)!=1);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = $c;

        //問題テキストの設定
        $text = '$$ \lim_{n \to \infty} \frac{'.d1($a,'n').d4($b).'}{'.d1($c,'n').d4($d).'}= ';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //無限等比数列の極限
    public function unit304_q02($unit_id){
        //初期設定
        $question_id = 30402;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        $a = rand(3,7);
        do { $b = rand(2,7); } while( $a<=$b );

        //答えの計算
        $right_answers[0] = $a;

        //問題テキストの設定
        $text = '$$ \lim_{n \to \infty} \frac{'.$a.'^{n+1} - '.$b.'^{n}}{'.$a.'^{n} + '.$b.'^{n}} =';

        //空欄テキストの設定
        $item[0] = '\fbox{ア}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //漸化式で定められる数列の極限
    public function unit304_q03($unit_id){
        //初期設定
        $question_id = 30403;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(-7,7);
        $b = rand(1,5);
        do{ $c = rand(2,7); } while($b>=$c);
        $d = rand(-7,7);

        list($b,$c) = gcd($b,$c);

        //答えの計算
        $right_answers[0] = $c*$d;
        $right_answers[1] = $c-$b;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ a_1 = '.$a.'、a_{n+1} = \frac{'.$b.'}{'.$c.'}a_{n}'.d4($d).'\\\\
                で定められた数列\{a_{n}\}の極限は、\\\\
                \lim_{n \to \infty} a_{n} =';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //無限等比数列
    public function unit304_q04($unit_id){
        //初期設定
        $question_id = 30404;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(-7,7);
        $b = rand(1,5);
        do{ $c = rand(2,7); } while($b>=$c);

        list($b,$c) = gcd($b,$c);

        //答えの計算
        $right_answers[0] = $a*$c;
        $right_answers[1] = $c-$b;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ 初項\\ '.$a.'、公比\\ \frac{'.$b.'}{'.$c.'}\\\\
                の等比数列\{a_{n}\}の無限級数は、\\\\
                \sum_{n=1}^{\infty} a_{n} = ';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //関数の極限
    public function unit304_q05($unit_id){
        //初期設定
        $question_id = 30405;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $p = rand(1,7);
        do{ $q = rand(-7,7); } while(gmp_gcd($p,$q)!=1);
        $r = rand(1,7);
        do{ $s = rand(-7,7); } while(gmp_gcd($r,$s)!=1);
        $t = rand(1,7);
        do{ $u = rand(-7,7); } while(gmp_gcd($t,$u)!=1);

        $a = $p*$r;
        $b = $p*$s + $q*$r;
        $c = $q*$s;
        $d = $p*$t;
        $e = $p*$u + $q*$t;
        $f = $q*$u;

        //答えの計算
        $right_answers[0] = $r;
        $right_answers[1] = $t;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ \lim_{x \to \infty} \frac{'.d1($a,'x^{2}').d2($b,'x').d4($c).'}{'.d1($d,'x^{2}').d2($e,'x').d4($f).'}= ';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角関数と極限
    public function unit304_q06($unit_id){
        //初期設定
        $question_id = 30406;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        do{ $b = rand(1,7); } while($a==$b);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = $b;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ \lim_{x \to 0} \frac{\sin{'.d1($a,'x').'}}{\sin{'.d1($b,'x').'}}= ';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //微分法
    //積の微分法
    public function unit305_q01($unit_id){
        //初期設定
        $question_id = 30501;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        do{ $b = rand(-7,7); } while($b==0);
        $c = rand(1,7);
        do{ $d = rand(-7,7); } while($d==0);

        list($a,$b) = gcd($a,$b);
        list($c,$d) = gcd($c,$d);

        //答えの計算
        $right_answers[0] = 7*$a*$c;
        $right_answers[1] = 5*$b*$c;
        $right_answers[2] = 3*$a*$d;
        $right_answers[3] = $b*$d;

        //問題テキストの設定
        $text = '$$ f(x)=('.d1($a,'x^{3}').d2($b,'x').')('.d1($c,'x^{4}').d4($d).')\\ のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'f\'(x) = ';
        $item[1] = ($right_answers[0]<0?'-':'').'\fbox{ア}x^{6}';
        $item[2] = ($right_answers[1]<0?'-':'+').'\fbox{イ}x^{4}';
        $item[3] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}x^{2}';
        $item[4] = ($right_answers[3]<0?'-':'+').'\fbox{エ}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //商の微分法
    public function unit305_q02($unit_id){
        //初期設定
        $question_id = 30502;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        do{ $b = rand(-7,7); } while($b==0);
        do{ $c = rand(-7,7); } while($c==0);

        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = -1*$a;
        $right_answers[1] = -2*$b;
        $right_answers[2] = $a*$c;
        $right_answers[3] = $c;

        //問題テキストの設定
        $text = '$$ f(x)=\frac{'.d1($a,'x').d4($b).'}{x^{2}'.d4($c).'}\\ のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'f\'(x) = \frac{';
        $item[1] = ($right_answers[0]<0?'-':'').'\fbox{ア}x^2';
        $item[2] = ($right_answers[1]<0?'-':'+').'\fbox{イ}x';
        $item[3] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}x}{';
        $item[4] = '(x^{2}';
        $item[5] = ($right_answers[3]<0?'-':'+').'\fbox{エ})^{2}}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //合成関数の微分 その１
    public function unit305_q03($unit_id){
        //初期設定
        $question_id = 30503;
        $blanks = 7;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        do{ $b = rand(-7,7); } while($b==0);
        do{ $c = rand(-7,7); } while($c==0);
        $d = rand(3,7);

        $s = gmp_gcd($a,gmp_gcd($b,$c));
        list($a,$b,$c) = array($a/$s,$b/$s,$c/$s);

        //答えの計算
        $right_answers[0] = $d;
        $right_answers[1] = 2*$a;
        $right_answers[2] = $b;
        $right_answers[3] = $a;
        $right_answers[4] = $b;
        $right_answers[5] = $c;
        $right_answers[6] = $d-1;

        $t = gmp_gcd($right_answers[1],$right_answers[2]);
        $right_answers[0] *= $t;
        list($right_answers[1],$right_answers[2]) = gcd($right_answers[1],$right_answers[2]);

        //問題テキストの設定
        $text = '$$ f(x)=('.d1($a,'x^{2}').d2($b,'x').d4($c).')^{'.$d.'}\\ のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'f\'(x) = \fbox{ア}(';
        $item[1] = ($right_answers[1]<0?'-':'').'\fbox{イ}x';
        $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ})(';
        $item[3] = ($right_answers[3]<0?'-':'').'\fbox{エ}x^{2}';
        $item[4] = ($right_answers[4]<0?'-':'+').'\fbox{オ}x';
        $item[5] = ($right_answers[5]<0?'-':'+').'\fbox{カ})';
        $item[6] = '^{\fbox{キ}}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //合成関数の微分 その２
    public function unit305_q04($unit_id){
        //初期設定
        $question_id = 30504;
        $blanks = 8;
        $option = $this->option;

        //変数の設定
        $a = rand(3,5);
        $b = rand(1,7);
        do{ $c = rand(-7,7); } while($c==0);
        do{ $d = rand(-7,7); } while($d==0);

        $s = gmp_gcd($b,gmp_gcd($c,$d));
        list($b,$c,$d) = array($b/$s,$c/$s,$d/$s);

        //答えの計算
        $right_answers[0] = 2*$b;
        $right_answers[1] = $c;
        $right_answers[2] = $a;
        $right_answers[3] = $a;
        $right_answers[4] = $b;
        $right_answers[5] = $c;
        $right_answers[6] = $d;
        $right_answers[7] = $a-1;

        $t = gmp_gcd($right_answers[0],gmp_gcd($right_answers[1],$right_answers[2]));
        list($right_answers[0],$right_answers[1],$right_answers[2]) = array($right_answers[0]/$t,$right_answers[1]/$t,$right_answers[2]/$t);

        //問題テキストの設定
        $text = '$$ f(x)=\sqrt['.$a.']{'.d1($b,'x^{2}').d2($c,'x').d4($d).'}\\ のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'f\'(x) = \frac{';
        $item[1] = ($right_answers[0]<0?'-':'').'\fbox{ア}x';
        $item[2] = ($right_answers[1]<0?'-':'+').'\fbox{イ}}{';
        $item[3] = '\fbox{ウ}\cdot ';
        $item[4] = '{}^{\fbox{エ}}\sqrt{';
        $item[5] = ($right_answers[4]<0?'-':'').'(\fbox{オ}x^{2}';
        $item[6] = ($right_answers[5]<0?'-':'+').'\fbox{カ}x';
        $item[7] = ($right_answers[6]<0?'-':'+').'\fbox{キ})';
        $item[8] = '^{\fbox{ク}}}}';

        if($right_answers[2]==1){
            $item[3] = '';
            unset($right_answers[2]);
            unset($option[3]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角関数の微分 その１
    public function unit305_q05($unit_id){
        //初期設定
        $question_id = 30505;
        $blanks = 3;
        $option = $this->option;
        $pattern = rand(1,3);

        //変数の設定
        $a = rand(1,7);
        do{ $b = rand(-7,7); } while($b==0);

        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = ($pattern==2 ? -1*$a : $a);
        $right_answers[1] = $a;
        $right_answers[2] = $b;

        //問題テキストの設定
        switch($pattern){
            case 1:
                $text = '$$ f(x)=\sin{('.d1($a,'x').d4($b).')}\\ のとき、\\\\';
                break;
            case 2:
                $text = '$$ f(x)=\cos{('.d1($a,'x').d4($b).')}\\ のとき、\\\\';
                break;
            case 3:
                $text = '$$ f(x)=\tan{('.d1($a,'x').d4($b).')}\\ のとき、\\\\';
                break;
        }

        //空欄テキストの設定
        switch($pattern){
            case 1:
                $item[0] = 'f\'(x) = \fbox{ア}';
                $item[1] = '\cos{(\fbox{イ}x';
                $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ})}';
                if($right_answers[0] == 1){
                    $item[0] =  'f\'(x) = ';
                    unset($right_answers[0]);
                    unset($option[0]);
                    $blanks -= 1;
                }
                break;
            case 2:
                $item[0] = 'f\'(x) = '.($right_answers[0]<0?'-':'').'\fbox{ア}';
                $item[1] = '\sin{(\fbox{イ}x';
                $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ})}';
                if(abs($right_answers[0]) == 1){
                    $item[0] =  'f\'(x) = '.($right_answers[0]<0?'-':'');
                    unset($right_answers[0]);
                    unset($option[0]);
                    $blanks -= 1;
                }
                break;
            case 3:
                $item[0] = 'f\'(x) = \frac{\fbox{ア}}';
                $item[1] = '{\cos^{2}{(\fbox{イ}x';
                $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ})}}';
                break;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角関数の微分 その２
    public function unit305_q06($unit_id){
        //初期設定
        $question_id = 30506;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        do{ $b = rand(-7,7); } while($b==0);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = $a-$b;

        //問題テキストの設定
        $text = '$$ f(x)='.d1($a,'x\sin{x}').d2($b,'\cos{x}').'\\ のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'f\'(x) =';
        $item[1] = ($right_answers[0]<0?'-':'').'\fbox{ア}x\cos{x}';
        $item[2] = ($right_answers[1]<0?'-':'+').'\fbox{イ}\sin{x}';

        if($right_answers[1]==0){
            $item[2] = '';
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //対数関数の微分 その１
    public function unit305_q07($unit_id){
        //初期設定
        $question_id = 30507;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(2,7);
        $b = rand(1,7);
        do{ $c = rand(-7,7); } while($c==0);

        list($b,$c) = gcd($b,$c);

        //答えの計算
        $right_answers[0] = $b;
        $right_answers[1] = $b;
        $right_answers[2] = $c;
        $right_answers[3] = $a;

        //問題テキストの設定
        $text = '$$ f(x)= \log_{'.$a.'} {('.d1($b,'x').d4($c).')}\\ のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'f\'(x) =';
        $item[1] = '\frac{\fbox{ア}}';
        $item[2] = '{(\fbox{イ}x';
        $item[3] = ($right_answers[2]<0?'-':'+').'\fbox{ウ})';
        $item[4] = 'log{\fbox{エ}}}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //対数関数の微分 その２
    public function unit305_q08($unit_id){
        //初期設定
        $question_id = 30508;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        $b = rand(2,7);

        //答えの計算
        $right_answers[0] = $b;
        $right_answers[1] = $b;
        $right_answers[2] = $b;

        //問題テキストの設定
        $text = '$$ f(x)= \log{|'.d1($a,'\sin{'.$b.'}x').'|}\\ のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'f\'(x) =';
        $item[1] = '\frac{\fbox{ア}';
        $item[2] = '\cos{\fbox{イ}x}}';
        $item[3] = '{\sin{\fbox{ウ}x}}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //指数関数の微分
    public function unit305_q09($unit_id){
        //初期設定
        $question_id = 30509;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        do{ $b = rand(-7,7); } while($b==0);

        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = $a;
        $right_answers[2] = $b;

        //問題テキストの設定
        $text = '$$ f(x)= e^{'.d1($a,'x').d4($b).'}\\ のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'f\'(x) =';
        $item[1] = '\fbox{ア}';
        $item[2] = 'e^{\fbox{イ}x';
        $item[3] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}}';

        if($right_answers[0]==1){
            $item[1] = '';
            unset($right_answers[0]);
            unset($option[0]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //媒介変数表示と微分
    public function unit305_q10($unit_id){
        //初期設定
        $question_id = 30510;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        do{ $b = rand(-7,7); } while($b==0);
        $c = rand(1,7);
        do{ $d = rand(-7,7); } while($d==0);
        do{ $e = rand(-7,7); } while($e==0);

        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = 2*$c;
        $right_answers[1] = $a;
        $right_answers[2] = $d;
        $right_answers[3] = $a;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ xの関数yが、tを媒介変数として、\\\\
                x='.d1($a,'t').d4($b).'、y='.d1($c,'t^{2}').d2($d,'t').d4($e).'\\\\
                とあらわされるとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\frac{dy}{dx} =';
        $item[1] = ($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}t';
        $item[2] = ($right_answers[2]*$right_answers[3]<0?'-':'+').'\frac{\fbox{ウ}}{\fbox{エ}}';

        list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,1,$blanks,$item[1]);
        list($right_answers,$option,$blanks,$item[2]) = l_frac($right_answers,$option,3,$blanks,$item[2]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //曲線の凹凸と変曲点
    public function unit305_q11($unit_id){
        //初期設定
        $question_id = 30511;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        do{ $p = rand(-5,5); } while($p==0);
        do{ $q = rand(-5,7); } while($q==0 || $p >= $q);

        $a = -2*($p+$q);
        $b = 6*$p*$q;
        $c = rand(-4,4);
        $d = rand(-5,5);

        //答えの計算
        $right_answers[0] = $p;
        $right_answers[1] = $p*$p*$p*$p + $a*$p*$p*$p + $b*$p*$p + $c*$p + $d;
        $right_answers[2] = $q;
        $right_answers[3] = $q*$q*$q*$q + $a*$q*$q*$q + $b*$q*$q + $c*$q + $d;
        $right_answers[4] = $p;
        $right_answers[5] = $q;

        //問題テキストの設定
        $text = '$$ y = x^{4}'.d2($a,'x^{3}').d2($b,'x^{2}').d2($c,'x').d4($d).'\\ のグラフの\\\\';

        //空欄テキストの設定
        $item[0] = '変曲点は、x座標の小さい順に\\\\(\fbox{ア},\fbox{イ}),(\fbox{ウ},\fbox{エ})\\ であり、\\\\';
        $item[1] = 'x \lt \fbox{オ}\\ で下に凸\\\\'; 
        $item[2] = '\fbox{オ} \lt x \lt \fbox{カ}\\ で上に凸\\\\'; 
        $item[3] = '\fbox{カ} \lt x\\ で下に凸'; 

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //速度と加速度
    public function unit305_q12($unit_id){
        //初期設定
        $question_id = 30512;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        do{ $a = rand(-5,5); } while($a==0);
        do{ $b = rand(-5,5); } while($b==0);
        $c = rand(-5,5);
        $d = rand(1,5);

        //答えの計算
        $right_answers[0] = 1;
        $right_answers[1] = $a*$a + 4*$b*$b*$d*$d;
        $right_answers[2] = 2*abs($b);

        //問題テキストの設定
        $text = '$$ 座標平面上を運動する点Pの\\\\時刻\\ t\\ における座標(x,y)が\\\\
                x = '.d1($a,'t').'、y='.d1($b,'t^{2}').d4($c).'\\\\で表されるとき、
                t='.$d.'における\\\\';

        //空欄テキストの設定
        $item[0] = '点Pの速さは、\fbox{ア}\sqrt{\fbox{イ}}\\\\';
        $item[1] = '点Pの加速度の大きさは、\fbox{ウ}'; 

        list($right_answers,$option,$blanks,$item[0]) = l_root($right_answers,$option,0,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //積分法
    //不定積分の基本
    public function unit306_q01($unit_id){
        //初期設定
        $question_id = 30601;
        $blanks = 5;
        $option = $this->option;

        //変数の設定
        $a = rand(3,5);
        do { $b = rand(-5,5); } while( $b==0 );

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = $a+1;
        $right_answers[2] = $a+1;
        $right_answers[3] = $a;
        $right_answers[4] = $b;

        //問題テキストの設定
        $text = '$$ \int{(\sqrt['.$a.']{x}'.($b<0?'-':'+').'\frac{'.abs($b).'}{x})}dx = ';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}';
        $item[1] = 'x^{\frac{\fbox{ウ}}{\fbox{エ}}}';
        $item[2] = ($right_answers[4]<0?'-':'+').'\fbox{オ}log{|x|}';
        $item[3] = '+C';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角関数の不定積分
    public function unit306_q02($unit_id){
        //初期設定
        $question_id = 30602;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(-5,5); } while( $b==0 );

        //答えの計算
        $right_answers[0] = -1*$a;
        $right_answers[1] = $b;

        //問題テキストの設定
        $text = '$$ \int{('.d1($a,'\sin{x}').d2($b,'\cos{x}').')}dx \\\\ =';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]<0?'-':'').'\fbox{ア}\cos{x}';
        $item[1] = ($right_answers[1]<0?'-':'+').'\fbox{イ}\sin{x}';
        $item[2] = '+C';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //指数関数の不定積分
    public function unit306_q03($unit_id){
        //初期設定
        $question_id = 30603;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        $b = rand(2,6);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = $b;
        $right_answers[2] = $b;

        //問題テキストの設定
        $text = '$$ \int{('.d1($a,'e^{x}').'+'.$b.'^{x})}dx = \\\\';

        //空欄テキストの設定
        $item[0] = '\fbox{ア}e^{x}';
        $item[1] = '+\frac{\fbox{イ}^{x}}{\log{\fbox{ウ}}}';
        $item[2] = '+C';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //置換積分法　その１
    public function unit306_q04($unit_id){
        //初期設定
        $question_id = 30604;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        $b = rand(1,5);

        //答えの計算
        $right_answers[0] = -2*$a;
        $right_answers[1] = 15;
        $right_answers[2] = 2*$b;
        $right_answers[3] = 3;
        $right_answers[4] = $b;
        $right_answers[5] = $b;

        $s = gmp_gcd($right_answers[2],$right_answers[3]);
        $right_answers[0] *= (int)$s;
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ \int{'.d1($a,'x').'\sqrt{'.$b.'-x}}\\ dx \\\\ =';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';
        $item[1] = '(\fbox{ウ} + \fbox{エ}x)';
        $item[2] = '(\fbox{オ}-x)';
        $item[3] = '\sqrt{\fbox{カ}-x}';
        $item[4] = '+C';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //置換積分法　その２
    public function unit306_q05($unit_id){
        //初期設定
        $question_id = 30605;
        $blanks = 7;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(-5,5); } while($b==0);
        do { $c = rand(-5,5); } while($c==0);

        $s = gmp_gcd($a,gmp_gcd($b,$c));
        list($a,$b,$c) = array($a/$s,$b/$s,$c/$s);

        //答えの計算
        $right_answers[0] = 2;
        $right_answers[1] = 3;
        $right_answers[2] = $a;
        $right_answers[3] = $b;
        $right_answers[4] = $c;
        $right_answers[5] = 3;
        $right_answers[6] = 2;

        //問題テキストの設定
        $text = '$$ \int{('.d1(2*$a,'x').d4($b).')\sqrt{'.d1($a,'x^{2}').d2($b,'x').d4($c).'}}\\ dx \\\\ =';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}';
        $item[1] = '('.($right_answers[2]<0?'-':'').'\fbox{ウ}x^{2}';
        $item[2] = ($right_answers[3]<0?'-':'+').'\fbox{エ}x';
        $item[3] = ($right_answers[4]<0?'-':'+').'\fbox{オ})';
        $item[4] = '^{\frac{\fbox{カ}}{\fbox{キ}}}';
        $item[5] = '+C';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //置換積分法　その３
    public function unit306_q06($unit_id){
        //初期設定
        $question_id = 30606;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        do { $b = rand(-5,5); } while($b==0);

        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = 1;
        $right_answers[1] = 2*$a;
        $right_answers[2] = $a;
        $right_answers[3] = $b;

        //問題テキストの設定
        $text = '$$ \int{\frac{x}{'.d1($a,'x^{2}').d4($b).'}}\\ dx \\\\ =';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}';
        $item[1] = '\log{|\fbox{ウ}x^{2}'.($right_answers[3]<0?'-':'+').'\fbox{エ}|}';
        $item[2] = '+C';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //部分積分法
    public function unit306_q07($unit_id){
        //初期設定
        $question_id = 30607;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        $b = rand(1,5);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = 2;
        $right_answers[2] = $b;
        $right_answers[3] = $b;
        $right_answers[4] = $a;
        $right_answers[5] = 2;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);

        //問題テキストの設定
        $text = '$$ \int{'.d1($a,'x').'\log{(x^{2}+'.$b.')}}\\ dx \\\\ =';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}';
        $item[1] = '(x^{2}+\fbox{ウ})';
        $item[2] = '\log(x^{2}+\fbox{エ})';
        $item[3] = '-\frac{\fbox{オ}}{\fbox{カ}}x^{2}';
        $item[4] = '+C';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[3]) = l_frac($right_answers,$option,5,$blanks,$item[3]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //分数関数の不定積分
    public function unit306_q08($unit_id){
        //初期設定
        $question_id = 30608;
        $blanks = 5;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        do{ $b = rand(-5,5); }while($b==0);
        do{ $c = rand(-5,5); }while($c==0);

        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = 2;
        $right_answers[2] = -1*$a*$c;
        $right_answers[3] = $b + $a*$c*$c;
        $right_answers[4] = $c;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ \int{\frac{'.d1($a,'x^{2}').d4($b).'}{x'.d4($c).'}}\\ dx \\\\ =';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}x^{2}';
        $item[1] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}x';
        $item[2] = ($right_answers[3]<0?'-':'+').'\fbox{エ}';
        $item[3] = '\log{|x'.($right_answers[4]<0?'-':'+').'\fbox{オ}|}';
        $item[4] = '+C';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        if($right_answers[3]==0){
            $item[2] = '';
            $item[3] = '';
            unset($right_answers[3]);
            unset($right_answers[4]);
            unset($option[3]);
            unset($option[4]);
            $blanks -= 2;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角関数に関する不定積分
    public function unit306_q09($unit_id){
        //初期設定
        $question_id = 30609;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        $a = rand(2,5);
        do{ $b = rand(1,4); }while($a<=$b);

        //答えの計算
        $right_answers[0] = -1;
        $right_answers[1] = 2*$a + 2*$b;
        $right_answers[2] = $a + $b;
        $right_answers[3] = -1;
        $right_answers[4] = 2*$a - 2*$b;
        $right_answers[5] = $a - $b;

        //問題テキストの設定
        $text = '$$ \int{\sin{'.d1($a,'x').'}\cos{'.d1($b,'x').'}}\\ dx \\\\ =';

        //空欄テキストの設定
        $item[0] = '-\frac{\fbox{ア}}{\fbox{イ}}\cos{\fbox{ウ}x}';
        $item[1] = '-\frac{\fbox{エ}}{\fbox{オ}}\sin{\fbox{カ}x}';
        $item[2] = '+C';

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //定積分の置換積分法
    public function unit306_q10($unit_id){
        //初期設定
        $question_id = 30610;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $k_1 = rand(0,3);
        do{ $k_2 = rand(2,4); }while($k_1>=$k_2);

        $c = rand(1,6);

        $a = $c - $k_1*$k_1;
        $b = $c - $k_2*$k_2;

        //答えの計算
        $right_answers[0] = 2*(pow($k_1,3)-pow($k_2,3)) - 6*$c*($k_1-$k_2);
        $right_answers[1] = 3;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ \int_{'.$b.'}^{'.$a.'}{\frac{x}{\sqrt{'.$c.'-x}}}\\ dx \\\\ =';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //定積分の部分積分法
    public function unit306_q11($unit_id){
        //初期設定
        $question_id = 30611;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $b = rand(1,5);
        $c = rand(1,4);

        //答えの計算
        switch($c%4){
            case 0:
                $right_answers[0] = -1*$b;
                $right_answers[1] = 2*$c;
                list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
                break;
            case 1:
                $right_answers[0] = $b;
                $right_answers[1] = $c*$c;
                list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
                break;
            case 2:
                $right_answers[0] = $b;
                $right_answers[1] = 2*$c;
                list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
                break;
            case 3:
                $right_answers[0] = -1*$b;
                $right_answers[1] = $c*$c;
                list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
                break;
        }

        //問題テキストの設定
        $text = '$$ \int_{0}^{\frac{\pi}{2}}{'.d1($b,'x').'\sin{'.d1($c,'x').'}}\\ dx \\\\ =';

        //空欄テキストの設定
        switch($c%2){
            case 0:
                $item[0] = ($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}\pi';
                list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);
                break;
            case 1:
                $item[0] = ($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';
                list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);
                break;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //回転体の体積
    public function unit306_q12($unit_id){
        //初期設定
        $question_id = 30612;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $p = rand(-1,0);
        do { $q = rand(0,3); }while($p==$q);

        $a = -1*($p+$q);
        $b = $p*$q;

        //答えの計算
        $right_answers[0] = 6*(pow($q,5)-pow($p,5)) + 15*$a*(pow($q,4)-pow($p,4)) + 10*($a*$a+2*$b)*(pow($q,3)-pow($p,3)) + 30*$a*$b*(pow($q,2)-pow($p,2)) + 30*$b*$b*($q-$p);
        $right_answers[1] = 30;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ y=x^{2}'.d2($a,'x').d4($b).'\\ と、x軸で囲まれた部分を\\\\
                x軸の周りに１回転させてできる立体の体積は、\\\\';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}\pi';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }


    //数学A
    //場合の数と確率
    //約数の個数とその和
    public function unit401_q01($unit_id){
        //初期設定
        $question_id = 40101;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $N = rand(10,20)*rand(10,20);
        list($base,$ex) = prime_factrization($N);

        //答えの計算
        $right_answers[0] = 1;
        for($i=0;$i<count($ex);$i++){
            $right_answers[0] *= ($ex[$i]+1);
        }
        $right_answers[1] = 1;
        for($i=0;$i<count($base);$i++){
            $temp = 0;
            for($j=0;$j<=$ex[$i];$j++){
                $temp += pow($base[$i],$j);
            }
            $right_answers[1] *= $temp;
        }

        //問題テキストの設定
        $text = '$$'.$N.'の';

        //空欄テキストの設定
        $item[0] = '正の約数の個数は\fbox{ア}個、';
        $item[1] = 'その和は、\fbox{イ}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //順列、組み合わせ、階乗の記号
    public function unit401_q02($unit_id){
        //初期設定
        $question_id = 40102;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $a = rand(4,8);
        do { $b = rand(2,5); } while( $a<=$b );
        $c = rand(4,8);
        do { $d = rand(2,5); } while( $c<=$d );
        $e = rand(4,8);

        //答えの計算
        $right_answers[0] = gmp_fact($a)/gmp_fact($a-$b);
        $right_answers[1] = gmp_fact($c)/(gmp_fact($d)*gmp_fact($c-$d));
        $right_answers[2] = gmp_fact($e);
        
        //問題テキストの設定
        $text = '$$ ';

        //空欄テキストの設定
        $item[0] = '{}_'.$a.' \mathrm{P}_'.$b.'=\fbox{ア}、';
        $item[1] = '{}_'.$c.' \mathrm{C}_'.$d.'=\fbox{イ}、';
        $item[2] = $e.'! = \fbox{ウ}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //順列
    public function unit401_q03($unit_id){
        //初期設定
        $question_id = 40103;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(2,5);
        $b = rand(3,5);

        //答えの計算
        $right_answers[0] = gmp_fact($a+$b);
        $right_answers[1] = 2*gmp_fact($a+$b-2);
        
        //問題テキストの設定
        $text = '$$ 男子'.$a.'人、女子'.$b.'人が一列に並ぶ。\\\\';

        //空欄テキストの設定
        $item[0] = 'この並び方の総数は、\fbox{ア}通り、\\\\';
        $item[1] = '両端が女子になる並び方は、\fbox{イ}通り';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //円順列
    public function unit401_q04($unit_id){
        //初期設定
        $question_id = 40104;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        $a = rand(4,9);

        //答えの計算
        $right_answers[0] = gmp_fact($a-1);
        
        //問題テキストの設定
        $text = '$$ '.$a.'人が円になって座るとき、その並び方は\\\\';

        //空欄テキストの設定
        $item[0] = '\fbox{ア}通り';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //重複順列
    public function unit401_q05($unit_id){
        //初期設定
        $question_id = 40105;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(4,9);

        //答えの計算
        $right_answers[0] = pow(2,$a);
        $right_answers[1] = pow(2,$a)-1;
        
        //問題テキストの設定
        $text = '$$ 異なる'.$a.'冊の本がある。\\\\';

        //空欄テキストの設定
        $item[0] = '１冊も取らなくてもいい場合、取り方は\fbox{ア}通り、\\\\';
        $item[1] = '１冊以上取る場合、取り方は\fbox{イ}通り';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //組み合わせ
    public function unit401_q06($unit_id){
        //初期設定
        $question_id = 40106;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(3,6);
        $b = rand(3,6);
        do { $c = rand(5,8); } while( $c>=$a+$b );
        do { $d = rand(2,4); } while( $a<=$d );
        do { $e = rand(2,4); } while( $b<=$e );

        //答えの計算
        $right_answers[0] = gmp_fact($a+$b)/(gmp_fact($c)*gmp_fact($a+$b-$c));
        $right_answers[1] = (gmp_fact($a)/(gmp_fact($d)*gmp_fact($a-$d)))*(gmp_fact($b)/(gmp_fact($e)*gmp_fact($b-$e)));
        
        //問題テキストの設定
        $text = '$$ 男子が'.$a.'人、女子が'.$b.'人いる。\\\\';

        //空欄テキストの設定
        $item[0] = 'この中から'.$c.'人選ぶ方法は\fbox{ア}通り、\\\\';
        $item[1] = '男子'.$d.'人、女子'.$e.'人選ぶ方法は\fbox{イ}通り';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //同じものを含む順列
    public function unit401_q07($unit_id){
        //初期設定
        $question_id = 40107;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(3,5);
        $b = rand(4,6);
        do { $d = rand(1,4); } while( $d>=$a );
        do { $c = rand(1,5); } while( $c>=$b );

        //答えの計算
        $right_answers[0] = gmp_fact($a+$b)/(gmp_fact($a)*gmp_fact($b));
        $right_answers[1] = gmp_fact($c+$d)/(gmp_fact($c)*gmp_fact($d))*gmp_fact($a-$d + $b-$c)/(gmp_fact($a-$d)*gmp_fact($b-$c));
        
        //問題テキストの設定
        $canvas = '<canvas id="canvas" width="350" height="200">
                        canvas対応のブラウザでは、ここに図形が表示されます。
                   </canvas>';

        $script = '<script type="text/javascript">
        　         window.onload = function draw() {
                        var canvas = document.getElementById(\'canvas\');
                        if (canvas.getContext) {
                            var ctx = canvas.getContext(\'2d\');
                            var point_a = canvas.getContext(\'2d\');
                            var point_b = canvas.getContext(\'2d\');
                            var point_c = canvas.getContext(\'2d\');
                            var a = canvas.getContext(\'2d\');
                            var b = canvas.getContext(\'2d\');
                            var c = canvas.getContext(\'2d\');
                            ctx.strokeRect(25, 10, 300, 180);
                            ctx.beginPath();
                            for (let step = 1; step < '.$a.'; step++) {
                                ctx.moveTo(25,10+180/'.$a.'*step);
                                ctx.lineTo(325,10+180/'.$a.'*step);
                            }
                            for (let step = 1; step < '.$b.'; step++) {
                                ctx.moveTo(25+300/'.$b.'*step,10);
                                ctx.lineTo(25+300/'.$b.'*step,190);
                            }
                            ctx.stroke();
                            point_a.beginPath();
                            point_a.arc(25,190,5,0,Math.PI*2,true);
                            point_a.fill();
                            a.font = \'15pt Arial\';
                            a.fillText(\'A\', 25+5, 190-5);
                            point_b.beginPath();
                            point_b.arc(25+'.$c.'*(300/'.$b.'),200-(10+'.$d.'*(180/'.$a.')),5,0,Math.PI*2,true);
                            point_b.fill();
                            b.font = \'15pt Arial\';
                            b.fillText(\'B\', 25+'.$c.'*(300/'.$b.')+5, 200-(10+'.$d.'*(180/'.$a.'))-5);
                            point_c.beginPath();
                            point_c.arc(325,10,5,0,Math.PI*2,true);
                            point_c.fill();
                            c.font = \'15pt Arial\';
                            c.fillText(\'C\', 325+5, 10+20);
                        }
                    }
                   </script>';
                   
        $text = '$$ 上の図のA点からC点までを最短距離を向かう。\\\\';

        //空欄テキストの設定
        $item[0] = 'このときの経路の総数は\fbox{ア}通り、\\\\';
        $item[1] = 'A点からB点を通ってC点に向かう経路数は\fbox{イ}通り';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/canvas',compact('right_answers','unit_id','question_id','text','blank_text','blanks','canvas','script'));
    }

    //確率の基本
    public function unit401_q08($unit_id){
        //初期設定
        $question_id = 40108;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        $r_1 = rand(1,6);
        $r_2 = rand(1,6);
        $a = $r_1*$r_2;
        $b = rand(3,6)*rand(1,2);
        do { $b = rand(3,6)*rand(1,2); } while( $b==$a );

        $list_1 = [1,2,3,4,5,6,8,9,10,12,15,16,18,20,24,25,30,36];
        $list_2 = [1,2,2,3,2,4,2,1,2, 4, 2, 1, 2, 2, 2, 1, 2, 1];

        //答えの計算
        $right_answers[0] = $list_2[array_search($a,$list_1)];
        $right_answers[1] = 36;
        $right_answers[2] = 0;
        $right_answers[3] = 36;
        $right_answers[4] = 0;
        $right_answers[5] = 36;
        for($i=0;$i<18;$i++){
            if($list_1[$i]%$b === 0){
                $right_answers[2] += $list_2[$i];
                if($list_1[$i] == $a){
                    $right_answers[4] -= $list_2[$i];
                }
            }
        }
        $right_answers[4] += ($right_answers[0]+$right_answers[2]);

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);

        //問題テキストの設定
        $text = '$$ さいころを２回続けて投げ、出た目の積を考える。\\\\';

        //空欄テキストの設定
        $item[0] = '積が'.$a.'になる確率は、\frac{\fbox{ア}}{\fbox{イ}}\\\\';
        $item[1] = '積が'.$b.'の倍数になる確率は、\frac{\fbox{ウ}}{\fbox{エ}}\\\\';
        $item[2] = '積が'.$b.'の倍数または'.$a.'になる確率は、\frac{\fbox{オ}}{\fbox{カ}}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //余事象の確率
    public function unit401_q09($unit_id){
        //初期設定
        $question_id = 40109;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(3,7);
        $b = rand(3,6);
        do { $c = rand(2,6); } while( $a+$b<=$c || $a<=$c );

        //答えの計算
        $right_answers[0] = gmp_fact($a-$c)*gmp_fact($a+$b)-gmp_fact($a)*gmp_fact($a+$b-$c);
        $right_answers[1] = gmp_fact($a+$b)*gmp_fact($a-$c);

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ 男子'.$a.'人、女子'.$b.'人の中から'.$c.'人を選ぶとき、\\\\
                少なくとも1人が女子である確率は、';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}\\\\';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //反復試行の確率
    public function unit401_q10($unit_id){
        //初期設定
        $question_id = 40110;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(3,5);
        $b = rand(3,5);
        $c = rand(3,6);
        do { $d = rand(1,5); } while( $c<=$d );

        //答えの計算
        $right_answers[0] = gmp_fact($c)*pow($a,$d)*pow($b,$c-$d);
        $right_answers[1] = gmp_fact($d)*gmp_fact($c-$d)*pow($a+$b,$c);

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ 袋に赤玉が'.$a.'個、白玉が'.$b.'個入っている。\\\\
                この中から1つ取り出し、色を確認してから袋に戻す。\\\\
                '.$c.'回行って、赤玉を'.$d.'回、白玉を'.($c-$d).'回引く確率は、';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}\\\\';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //条件付き確率
    public function unit401_q11($unit_id){
        //初期設定
        $question_id = 40111;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(2,9)*10;
        do { $b = rand(1,8)*10; } while( $a<=$b );

        //答えの計算
        $right_answers[0] = $b;
        $right_answers[1] = $a;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ ある鉄道の乗客のうち、全体の'.$a.'\%が定期券利用者で、\\\\
                全体の'.$b.'\%が学生の定期券利用者である。\\\\
                定期券利用者の中から1人を選んだ時、\\\\その人が学生である確率は、';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}\\\\';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //図形の性質
    //三角形の重心
    public function unit402_q01($unit_id){
        //初期設定
        $question_id = 40201;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        $a = rand(2,8);
        do { $b = rand(1,8); } while( 2*$a <= $b );

        //答えの計算
        $right_answers[0] = 1;
        $right_answers[1] = 4*$a*$a - $b*$b;
        $right_answers[2] = 2;
        $right_answers[3] = 1;
        $right_answers[4] = 4*$a*$a - $b*$b;
        $right_answers[5] = 3;

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);
        list($right_answers[3],$right_answers[4]) = root($right_answers[3],$right_answers[4]);
        list($right_answers[0],$right_answers[2]) = gcd($right_answers[0],$right_answers[2]);
        list($right_answers[3],$right_answers[5]) = gcd($right_answers[3],$right_answers[5]);

        //問題テキストの設定
        $text = '$$ AB=AC='.$a.'、BC='.$b.'である二等辺三角形ABCについて、\\\\
                 BCの中点をM、重心をGとすると、\\\\';

        //空欄テキストの設定
        $item[0] = 'AM = \frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}、';
        $item[1] = 'AG = \frac{\fbox{エ}\sqrt{\fbox{オ}}}{\fbox{カ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_root($right_answers,$option,0,1,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,2,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,3,4,$blanks,$item[1]);
        list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,5,$blanks,$item[1]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角形の内心
    public function unit402_q02($unit_id){
        //初期設定
        $question_id = 40202;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        list($a,$b,$c) = make_tri();

        //答えの計算
        $right_answers[0] = $a*$b;
        $right_answers[1] = $a+$c;
        $right_answers[2] = $a*($a+$c);
        $right_answers[3] = $a*$b;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ AB='.$a.'、BC='.$b.'、CA='.$c.'である△ABCの、\\\\
                \angle{BAC}の二等分線が辺BCと交わる点をD、\\\\
                △ABCの内心をIとするとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'BD = \frac{\fbox{ア}}{\fbox{イ}}、';
        $item[1] = 'AI:ID = \fbox{ウ}:\fbox{エ}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角形の外心
    public function unit402_q03($unit_id){
        //初期設定
        $question_id = 40203;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        do{
            $a[0] = rand(85,175);
            $a[1] = sqrt(8100-pow($a[0]-175,2))+100;
            $b[0] = rand(85,265); 
            $b[1] = -sqrt(8100-pow($b[0]-175,2))+100;
            do { $c[0] = rand(175,260); } while($b[0]==$c[0]);
            $c[1] = sqrt(8100-pow($c[0]-175,2))+100;

            $AB = sqrt(pow($a[0]-$b[0],2)+pow($a[1]-$b[1],2));
            $BC = sqrt(pow($b[0]-$c[0],2)+pow($b[1]-$c[1],2));
            $CA = sqrt(pow($c[0]-$a[0],2)+pow($c[1]-$a[1],2));

            $A = acos((pow($AB,2)+pow($CA,2)-pow($BC,2))/(2*$AB*$CA));
            $B = acos((pow($AB,2)+pow($BC,2)-pow($CA,2))/(2*$AB*$BC));
            $C = acos((pow($BC,2)+pow($CA,2)-pow($AB,2))/(2*$BC*$CA));
            $BASE = 5/12*pi();

        }while($A>$BASE || $B>$BASE || $C>$BASE);

        $r = ($BC/sin($A))/2;
        $alpha = acos((pow($r,2)+pow($r,2)-pow($AB,2))/(2*$r*$r));
        $beta = acos((pow($r,2)+pow($BC,2)-pow($r,2))/(2*$BC*$r));
        $theta_1 = acos((pow($r,2)+pow($r,2)-pow($CA,2))/(2*$r*$r)) + atan(abs(100-$c[1])/abs(175-$c[0]));;
        $theta_2 = atan(($b[1]-$c[1])/($b[0]-$c[0]));
        if($b[0]-$c[0]>0){
            $theta_2 += pi();
        }

        //答えの計算
        $right_answers[0] = (floor($alpha*180/pi())%2==0?floor($alpha*180/pi()):floor($alpha*180/pi())+1)/2 - floor($beta*180/pi());

        //問題テキストの設定
        $canvas = '<canvas id="canvas" width="350" height="200">
                        canvas対応のブラウザでは、ここに図形が表示されます。
                   </canvas>';
                   
        $script = '<script type="text/javascript">
        　         window.onload = function draw() {
                        var canvas = document.getElementById(\'canvas\');
                        if (canvas.getContext) {
                            var circle = canvas.getContext(\'2d\');
                            circle.beginPath();
                            circle.arc(175, 100, 90, 0, 2 * Math.PI);
                            circle.stroke() ;
                            var point = canvas.getContext(\'2d\');
                            point.beginPath();
                            point.arc(175, 100, 3, 0, 2 * Math.PI);
                            point.fill() ;

                            var point_A = canvas.getContext(\'2d\');
                            point_A.beginPath();
                            point_A.arc('.$a[0].', '.$a[1].', 3, 0, 2 * Math.PI);
                            point_A.fill() ;

                            var point_B = canvas.getContext(\'2d\');
                            point_B.beginPath();
                            point_B.arc('.$b[0].', '.$b[1].', 3, 0, 2 * Math.PI);
                            point_B.fill() ;

                            var point_C = canvas.getContext(\'2d\');
                            point_C.beginPath();
                            point_C.arc('.$c[0].', '.$c[1].', 3, 0, 2 * Math.PI);
                            point_C.fill() ;

                            var side = canvas.getContext(\'2d\');
                            side.beginPath();
                            side.moveTo('.$a[0].','.$a[1].');
                            side.lineTo('.$b[0].', '.$b[1].');
                            side.lineTo('.$c[0].', '.$c[1].');
                            side.lineTo('.$a[0].', '.$a[1].');
                            side.lineTo(175,100);
                            side.lineTo('.$b[0].', '.$b[1].');
                            side.moveTo('.$c[0].', '.$c[1].');
                            side.lineTo(175,100);
                            side.stroke();

                            
                            var alpha = canvas.getContext(\'2d\');
                            alpha.beginPath();
                            alpha.strokeStyle = \'red\';
                            alpha.arc(175,100,15,'.$theta_1.','.($theta_1+$alpha).');
                            alpha.stroke();
                            
                            var beta = canvas.getContext(\'2d\');
                            beta.beginPath();
                            beta.strokeStyle = \'red\';
                            beta.arc('.$b[0].','.$b[1].',15,'.$theta_2.','.($theta_2+$beta).');
                            beta.stroke();

                            var A = canvas.getContext(\'2d\');
                            A.fillStyle = \'blue\';
                            A.font = \'15pt Arial\';
                            A.fillText(\'A\', '.$a[0].'-20, '.$a[1].');

                            var B = canvas.getContext(\'2d\');
                            B.fillStyle = \'blue\';
                            B.font = \'15pt Arial\';
                            B.fillText(\'B\', '.$b[0].'-20, '.$b[1].'+10);

                            var C = canvas.getContext(\'2d\');
                            C.fillStyle = \'blue\';
                            C.font = \'15pt Arial\';
                            C.fillText(\'C\', '.$c[0].'+5, '.$c[1].');

                            var O = canvas.getContext(\'2d\');
                            O.fillStyle = \'blue\';
                            O.font = \'15pt Arial\';
                            O.fillText(\'O\',180,100);

                            var a = canvas.getContext(\'2d\');
                            a.fillStyle = \'red\';
                            a.font = \'10pt Arial\';
                            a.clearRect(148,90,10,10);
                            a.fillText(\'α\',150,100);

                            var b = canvas.getContext(\'2d\');
                            b.fillStyle = \'red\';
                            b.font = \'10pt Arial\';
                            b.clearRect('.$b[0].','.$b[1].'+20,10,10);
                            b.fillText(\'β\','.$b[0].','.$b[1].'+30);
                        }
                    }
                   </script>';

        $text = '$$ 上図において、Oは\triangle{ABC}の外心である。\\\\
                 \alpha = '.(floor($alpha*180/pi())%2==0?floor($alpha*180/pi()):floor($alpha*180/pi())+1).'^\circ、\beta = '.floor($beta*180/pi()).'^\circのとき、';

        //空欄テキストの設定
        $item[0] = '\angle{OCA} = \fbox{ア}^\circである。';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/canvas',compact('right_answers','unit_id','question_id','text','blank_text','blanks','canvas','script'));
    }

    //チェバ、メネラウスの定理
    public function unit402_q04($unit_id){
        //初期設定
        $question_id = 40204;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        $b = rand(1,5);
        $c = rand(1,5);
        $d = rand(1,5);

        list($a,$b) = gcd($a,$b);
        list($c,$d) = gcd($c,$d);

        //答えの計算
        $right_answers[0] = $b*$c;
        $right_answers[1] = $a*$d;
        $right_answers[2] = $b*$c+$a*$d;
        $right_answers[3] = $b*$d;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ △ABCの辺AB、AC上にそれぞれ\\\\
                 AP:PB='.$a.':'.$b.'、AQ:QC='.$c.':'.$d.'となる点P,Qをとる。\\\\
                 BQとPCの交点をO、AOとBCの交点をRとすると、\\\\';

        //空欄テキストの設定
        $item[0] = 'BR:RC=\fbox{ア}:\fbox{イ}\\\\';
        $item[1] = 'AO:OR=\fbox{ウ}:\fbox{エ}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //三角形の面積比
    public function unit402_q05($unit_id){
        //初期設定
        $question_id = 40205;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
        $b = rand(1,5);
        $c = rand(1,5);
        $d = rand(1,5);

        list($a,$b) = gcd($a,$b);
        list($c,$d) = gcd($c,$d);

        //答えの計算
        $right_answers[0] = $a*($c+$d);
        $right_answers[1] = $b*$d;
        $right_answers[2] = ($a*($c+$d)+$b*$d)*($a+$b);
        $right_answers[3] = $a*$b*$c;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ △ABCの辺AB、BC上にそれぞれ\\\\
                 AP:PB='.$a.':'.$b.'、BQ:QC='.$c.':'.$d.'となる点P,Qをとる。\\\\
                 AQとCPの交点をRとすると、\\\\';

        //空欄テキストの設定
        $item[0] = 'AR:RQ=\fbox{ア}:\fbox{イ}より、\\\\';
        $item[1] = '\triangle{ABC}:\triangle{BPR}=\fbox{ウ}:\fbox{エ}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //円に内接する四角形
    public function unit402_q06($unit_id){
        //初期設定
        $question_id = 40206;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        $a[0] = rand(85,175);
        $a[1] = sqrt(8100-pow($a[0]-175,2))+100;
        $b[0] = rand(85,175); 
        $b[1] = -sqrt(8100-pow($b[0]-175,2))+100;
        $c[0] = rand(176,260);
        $c[1] = sqrt(8100-pow($c[0]-175,2))+100;
        $d[0] = rand(176,260);
        $d[1] = -sqrt(8100-pow($d[0]-175,2))+100;

        $AD = sqrt(pow($a[0]-$d[0],2)+pow($a[1]-$d[1],2));

        $AB = sqrt(pow($a[0]-$b[0],2)+pow($a[1]-$b[1],2));
        $BD = sqrt(pow($b[0]-$d[0],2)+pow($b[1]-$d[1],2));
        $DC = sqrt(pow($d[0]-$c[0],2)+pow($d[1]-$c[1],2));
        $CA = sqrt(pow($c[0]-$a[0],2)+pow($c[1]-$a[1],2));

        $alpha = acos((pow($BD,2)+pow($AB,2)-pow($AD,2))/(2*$BD*$AB));
        $beta = acos((pow($CA,2)+pow($DC,2)-pow($AD,2))/(2*$CA*$DC));
        $theta_1 = atan(abs($b[1]-$d[1])/abs($b[0]-$d[0]));
        if($b[1]-$d[1]>0){
            $theta_1 *= -1;
        }
        $theta_2 = atan(abs($a[1]-$c[1])/abs($a[0]-$c[0]));
        if($a[1]-$c[1]>=0){
            $theta_2 = pi() - $theta_2;
        }else{
            $theta_2 = pi() + $theta_2;
        }


        //答えの計算
        $right_answers[0] = 180-floor($alpha*180/pi());

        //問題テキストの設定
        $canvas = '<canvas id="canvas" width="350" height="200">
                        canvas対応のブラウザでは、ここに図形が表示されます。
                   </canvas>';
                   
        $script = '<script type="text/javascript">
        　         window.onload = function draw() {
                        var canvas = document.getElementById(\'canvas\');
                        if (canvas.getContext) {
                            var circle = canvas.getContext(\'2d\');
                            circle.beginPath();
                            circle.arc(175, 100, 90, 0, 2 * Math.PI);
                            circle.stroke() ;

                            var side = canvas.getContext(\'2d\');
                            side.beginPath();
                            side.moveTo('.$a[0].','.$a[1].');
                            side.lineTo('.$b[0].', '.$b[1].');
                            side.lineTo('.$d[0].', '.$d[1].');
                            side.lineTo('.$c[0].', '.$c[1].');
                            side.lineTo('.$a[0].','.$a[1].');
                            side.stroke();

                            var alpha = canvas.getContext(\'2d\');
                            alpha.beginPath();
                            alpha.strokeStyle = \'red\';
                            alpha.arc('.$b[0].','.$b[1].',10,'.$theta_1.','.($theta_1+$alpha).');
                            alpha.stroke();
                            var beta = canvas.getContext(\'2d\');
                            beta.beginPath();
                            beta.strokeStyle = \'red\';
                            beta.arc('.$c[0].','.$c[1].',10,'.$theta_2.','.($theta_2+$beta).');
                            beta.stroke();

                            var a = canvas.getContext(\'2d\');
                            a.fillStyle = \'red\';
                            a.font = \'10pt Arial\';
                            a.clearRect('.$b[0].'+3,'.$b[1].'+12,10,10);
                            a.fillText(\'α\','.$b[0].'+5,'.$b[1].'+20);

                            var b = canvas.getContext(\'2d\');
                            b.fillStyle = \'red\';
                            b.font = \'10pt Arial\';
                            b.clearRect('.$c[0].'-22,'.$c[1].'-10,10,10);
                            b.fillText(\'β\','.$c[0].'-20,'.$c[1].');
                        }
                    }
                   </script>';

        $text = '$$ 上図において、\alpha = '.floor($alpha*180/pi()).'^\circであるとき、\\\\';

        //空欄テキストの設定
        $item[0] = '\beta = \fbox{ア}^\circ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/canvas',compact('right_answers','unit_id','question_id','text','blank_text','blanks','canvas','script'));
    }

    //円の接線
    public function unit402_q07($unit_id){
        //初期設定
        $question_id = 40207;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        $a = rand(5,12);
        do{ $b = rand(2,6); } while($a<=$b);
        $c = rand(3,8);

        //答えの計算
        $right_answers[0] = $a-$b+$c;

        //問題テキストの設定
        $text = '$$ △ABCとその内接円について、\\\\
                 辺BC,CA,ABと内接円の接点ををそれぞれP,Q,Rとおく。\\\\
                 AB='.$a.'、BP='.$b.'、PC='.$c.'のとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'AC = \fbox{ア}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //接線と弦のつくる角
    public function unit402_q08($unit_id){
        //初期設定
        $question_id = 40208;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a[0] = rand(85,160);
        $a[1] = sqrt(8100-pow($a[0]-175,2))+100;
        $b[0] = rand(85,160); 
        $b[1] = -sqrt(8100-pow($b[0]-175,2))+100;
        $c[0] = rand(180,260);
        $c[1] = sqrt(8100-pow($c[0]-175,2))+100;
        do{ $d[0] = rand(180,260); } while($d[0]==$c[0]);
        $d[1] = -sqrt(8100-pow($d[0]-175,2))+100;

        $AD = sqrt(pow($a[0]-$d[0],2)+pow($a[1]-$d[1],2));

        $AB = sqrt(pow($a[0]-$b[0],2)+pow($a[1]-$b[1],2));
        $BD = sqrt(pow($b[0]-$d[0],2)+pow($b[1]-$d[1],2));
        $DC = sqrt(pow($d[0]-$c[0],2)+pow($d[1]-$c[1],2));
        $CA = sqrt(pow($c[0]-$a[0],2)+pow($c[1]-$a[1],2));

        $alpha = acos((pow($BD,2)+pow($AB,2)-pow($AD,2))/(2*$BD*$AB));
        $beta = acos((pow($AD,2)+pow($DC,2)-pow($CA,2))/(2*$AD*$DC));
        $theta_1 = atan(abs($b[1]-$d[1])/abs($b[0]-$d[0]));
        if($b[1]-$d[1]>0){
            $theta_1 *= -1;
        }
        $theta_2 = atan(abs($c[1]-$d[1])/abs($c[0]-$d[0]));
        if($c[0]-$d[0]>=0){
            $theta_2;
        }else{
            $theta_2 = pi() - $theta_2;
        }

        $l = (175-$c[0])/($c[1]-100);

        $a_text = floor(180/pi()*$alpha).'°';
        $b_text = floor(180/pi()*$beta).'°';

        $e[0] = $c[0] + 100;
        $e[1] = $l*($e[0]-$c[0])+$c[1];
        $f[0] = $c[0] - 100;
        $f[1] = $l*($f[0]-$c[0])+$c[1];

        $CE = sqrt(pow($c[0]-$e[0],2)+pow($c[1]-$e[1],2));
        $DE = sqrt(pow($d[0]-$e[0],2)+pow($d[1]-$e[1],2));

        $CF = sqrt(pow($c[0]-$f[0],2)+pow($c[1]-$f[1],2));
        $AF = sqrt(pow($a[0]-$f[0],2)+pow($a[1]-$f[1],2));
        
        $gamma = acos((pow($DC,2)+pow($CE,2)-pow($DE,2))/(2*$DC*$CE));
        $phai = acos((pow($CF,2)+pow($CA,2)-pow($AF,2))/(2*$CF*$CA));

        $theta_3 = 2*pi() - atan(abs($d[1]-$c[1])/abs($d[0]-$c[0]));
        if($d[0]-$c[0]<0){
            $theta_3 = pi() + atan(abs($d[1]-$c[1])/abs($d[0]-$c[0]));
        }
        $theta_4 = pi() - atan(abs($f[1]-$c[1])/abs($f[0]-$c[0]));


        //答えの計算
        $right_answers[0] = floor($beta*180/pi());
        $right_answers[1] = floor($alpha*180/pi()) - floor($beta*180/pi());

        //問題テキストの設定
        $canvas = '<canvas id="canvas" width="350" height="200">
                        canvas対応のブラウザでは、ここに図形が表示されます。
                   </canvas>';
                   
        $script = '<script type="text/javascript">
        　         window.onload = function draw() {
                        var canvas = document.getElementById(\'canvas\');
                        if (canvas.getContext) {
                            var circle = canvas.getContext(\'2d\');
                            circle.beginPath();
                            circle.arc(175, 100, 90, 0, 2 * Math.PI);
                            circle.stroke() ;

                            var side = canvas.getContext(\'2d\');
                            side.beginPath();
                            side.moveTo('.$a[0].','.$a[1].');
                            side.lineTo('.$b[0].', '.$b[1].');
                            side.lineTo('.$d[0].', '.$d[1].');
                            side.lineTo('.$c[0].', '.$c[1].');
                            side.lineTo('.$a[0].','.$a[1].');

                            side.moveTo('.$a[0].','.$a[1].');
                            side.lineTo('.$d[0].','.$d[1].');

                            side.moveTo(0,'.$l.'*(0-'.$c[0].')+'.$c[1].');
                            side.lineTo(350,'.$l.'*(350-'.$c[0].')+'.$c[1].');
                            side.stroke();

                            var point_A = canvas.getContext(\'2d\');
                            point_A.beginPath();
                            point_A.arc('.$c[0].', '.$c[1].', 3, 0, 2 * Math.PI);
                            point_A.fill() ;
                            var A = canvas.getContext(\'2d\');
                            A.fillStyle = \'blue\';
                            A.font = \'15pt Arial\';
                            A.fillText(\'A\', '.$c[0].'+5, '.$c[1].'+10);

                            var alpha = canvas.getContext(\'2d\');
                            alpha.beginPath();
                            alpha.strokeStyle = \'red\';
                            alpha.arc('.$b[0].','.$b[1].',10,'.$theta_1.','.($theta_1+$alpha).');
                            alpha.stroke();
                            var beta = canvas.getContext(\'2d\');
                            beta.beginPath();
                            beta.strokeStyle = \'red\';
                            beta.arc('.$d[0].','.$d[1].',10,'.$theta_2.','.($theta_2+$beta).');
                            beta.stroke();

                            var gamma = canvas.getContext(\'2d\');
                            gamma.beginPath();
                            gamma.strokeStyle = \'red\';
                            gamma.arc('.$c[0].','.$c[1].',15,'.$theta_3.','.($theta_3+$gamma).');
                            gamma.stroke();
                            var phai = canvas.getContext(\'2d\');
                            phai.beginPath();
                            phai.strokeStyle = \'red\';
                            phai.arc('.$c[0].','.$c[1].',15,'.$theta_4.','.($theta_4+$phai).');
                            phai.stroke();

                            var a = canvas.getContext(\'2d\');
                            a.fillStyle = \'red\';
                            a.font = \'10pt Arial\';
                            a.clearRect('.$b[0].'+6,'.$b[1].'+10,15,10);
                            a.fillText(\''.$a_text.'\','.$b[0].'+5,'.$b[1].'+20);

                            var b = canvas.getContext(\'2d\');
                            b.fillStyle = \'red\';
                            b.font = \'10pt Arial\';
                            b.clearRect('.$d[0].'+8,'.$d[1].'-10,15,15);
                            b.fillText(\''.$b_text.'\','.$d[0].'+10,'.$d[1].'+5);

                            var c = canvas.getContext(\'2d\');
                            c.fillStyle = \'red\';
                            c.font = \'10pt Arial\';
                            c.clearRect('.$c[0].'-32,'.$c[1].'-4,10,10);
                            c.fillText(\'α\','.$c[0].'-30,'.$c[1].'+5);

                            var d = canvas.getContext(\'2d\');
                            d.fillStyle = \'red\';
                            d.font = \'10pt Arial\';
                            d.clearRect('.$c[0].'+7,'.$c[1].'-26,12,12);
                            d.fillText(\'β\','.$c[0].'+10,'.$c[1].'-15);
                        }
                    }
                   </script>';

        $text = '$$ 上図において、直線は点Aにおける接線である。\\\\このとき、';

        //空欄テキストの設定
        $item[0] = '\alpha = \fbox{ア}^\circ、';
        $item[1] = '\beta = \fbox{イ}^\circ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/canvas',compact('right_answers','unit_id','question_id','text','blank_text','blanks','canvas','script'));
    }

    //方べきの定理
    public function unit402_q09($unit_id){
        //初期設定
        $question_id = 40209;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a[0] = rand(85,160);
        $a[1] = sqrt(8100-pow($a[0]-175,2))+100;
        $b[0] = rand(85,160); 
        $b[1] = -sqrt(8100-pow($b[0]-175,2))+100;
        $c[0] = rand(180,260);
        $c[1] = sqrt(8100-pow($c[0]-175,2))+100;
        $d[0] = rand(180,260);
        $d[1] = -sqrt(8100-pow($d[0]-175,2))+100;

        $a_l = ($a[1]-$d[1])/($a[0]-$d[0]);
        $b_l = ($a[1]-($a[1]-$d[1])/($a[0]-$d[0])*$a[0]);
        $c_l = ($c[1]-$b[1])/($c[0]-$b[0]);
        $d_l = ($c[1]-($c[1]-$b[1])/($c[0]-$b[0])*$c[0]);
        $o[0] = ($b_l-$d_l)/($c_l-$a_l);
        $o[1] = ($b_l*$c_l-$a_l*$d_l)/($c_l-$a_l);

        $AO = (int)floor(sqrt(pow($a[0]-$o[0],2)+pow($a[1]-$o[1],2))/10);
        $OD = (int)floor(sqrt(pow($o[0]-$d[0],2)+pow($o[1]-$d[1],2))/10);
        $BO = (int)floor(sqrt(pow($b[0]-$o[0],2)+pow($b[1]-$o[1],2))/10);

        //答えの計算
        $right_answers[0] = $AO*$OD;
        $right_answers[1] = $BO;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $canvas = '<canvas id="canvas" width="350" height="200">
                        canvas対応のブラウザでは、ここに図形が表示されます。
                   </canvas>';
                   
        $script = '<script type="text/javascript">
        　         window.onload = function draw() {
                        var canvas = document.getElementById(\'canvas\');
                        if (canvas.getContext) {
                            var circle = canvas.getContext(\'2d\');
                            circle.beginPath();
                            circle.arc(175, 100, 90, 0, 2 * Math.PI);
                            circle.stroke() ;

                            var side = canvas.getContext(\'2d\');
                            side.beginPath();
                            side.moveTo('.$a[0].','.$a[1].');
                            side.lineTo('.$d[0].', '.$d[1].');
                            side.moveTo('.$c[0].', '.$c[1].');
                            side.lineTo('.$b[0].', '.$b[1].');
                            side.stroke();

                            var a = canvas.getContext(\'2d\');
                            a.beginPath();
                            a.arc('.$a[0].','.$a[1].', 3, 0, 2 * Math.PI);
                            a.fill() ;
                            var b = canvas.getContext(\'2d\');
                            b.beginPath();
                            b.arc('.$b[0].','.$b[1].', 3, 0, 2 * Math.PI);
                            b.fill() ;
                            var c = canvas.getContext(\'2d\');
                            c.beginPath();
                            c.arc('.$c[0].','.$c[1].', 3, 0, 2 * Math.PI);
                            c.fill() ;
                            var d = canvas.getContext(\'2d\');
                            d.beginPath();
                            d.arc('.$d[0].','.$d[1].', 3, 0, 2 * Math.PI);
                            d.fill() ;
                            var o = canvas.getContext(\'2d\');
                            o.beginPath();
                            o.arc('.$o[0].','.$o[1].', 3, 0, 2 * Math.PI);
                            o.fill() ;

                            var A = canvas.getContext(\'2d\');
                            A.fillStyle = \'blue\';
                            A.font = \'13pt Arial\';
                            A.fillText(\'A\','.$a[0].'+5,'.$a[1].');
                            var B = canvas.getContext(\'2d\');
                            B.fillStyle = \'blue\';
                            B.font = \'13pt Arial\';
                            B.fillText(\'B\','.$b[0].'+5,'.$b[1].'+10);
                            var C = canvas.getContext(\'2d\');
                            C.fillStyle = \'blue\';
                            C.font = \'13pt Arial\';
                            C.fillText(\'C\','.$c[0].'+5,'.$c[1].');
                            var D = canvas.getContext(\'2d\');
                            D.fillStyle = \'blue\';
                            D.font = \'13pt Arial\';
                            D.fillText(\'D\','.$d[0].'+5,'.$d[1].'+10);
                            var O = canvas.getContext(\'2d\');
                            O.fillStyle = \'blue\';
                            O.font = \'13pt Arial\';
                            O.fillText(\'O\','.$o[0].'+5,'.$o[1].'+5);

                        }
                    }
                   </script>';

        $text = '$$ 上図において、AO='.$AO.'、BO='.$BO.'、DO='.$OD.'であるとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'CO = \frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/canvas',compact('right_answers','unit_id','question_id','text','blank_text','blanks','canvas','script'));
    }

    //２円の関係
    public function unit402_q10($unit_id){
        //初期設定
        $question_id = 40210;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(3,10);
        do { $b = rand(2,9); } while( $a==$b );

        //答えの計算
        $right_answers[0] = abs($a-$b);
        $right_answers[1] = $a+$b;
        $right_answers[2] = $a+$b;
        $right_answers[3] = abs($a-$b);

        //問題テキストの設定
        $text = '$$ 半径\\ '.$a.'の円O_{1}と半径\\ '.$b.'の円O_{2}がある。\\\\
                 この2円の位置関係と、中心間の距離dを考える。\\\\';

        //空欄テキストの設定
        $item[0] = '2円が異なる2点で交わるとき、\fbox{ア} \lt d \lt \fbox{イ}\\\\';
        $item[1] = '2円が外接するとき、d = \fbox{ウ}\\\\';
        $item[2] = '2円が内接するとき、d = \fbox{エ}\\\\';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    
    //整数の性質
    //素因数分解
    public function unit403_q01($unit_id){
        //初期設定
        $question_id = 40301;
        $option = $this->option;

        //変数の設定
        $a = rand(2,12)*rand(2,12)*rand(2,12);
        list($base,$ex) = prime_factrization($a);

        //答えの計算
        $blanks = 2*count($base);
        for($i=0;$i<count($base);$i++){
            $right_answers[2*$i] = $base[$i];
            $right_answers[2*$i+1] = $ex[$i];
        }


        //問題テキストの設定
        $text = '$$'.$a.'を素因数分解すると、\\\\';

        //空欄テキストの設定
        $item[0] = $a.'=\fbox{ア}^{\fbox{イ}}';

        for($i=1;$i<count($base);$i++)
        {
            $item[0] .= '×\fbox{'.$option[2*$i].'}^{\fbox{'.$option[2*$i+1].'}}';
        }

        if(count($base) != 1){
            $item[1] = '\\\\ ただし、' ;
            for($i=0;$i<count($base);$i++)
            {
                $item[1] .= '\fbox{'.$option[2*$i].'} \lt';
            }
            $item[1] = rtrim($item[1],'\lt');
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //最大公約数・最小公倍数
    public function unit403_q02($unit_id){
        //初期設定
        $question_id = 40302;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $g = rand(2,13)*rand(2,13);
        $a = $g*rand(2,5)*rand(2,5);
        do { $b = $g*rand(2,7)*rand(2,7); } while( $a==$b );
        $g = gmp_gcd($a,$b);
        $l = $a*$b/$g;

        //答えの計算
        $right_answers[0] = $g;
        $right_answers[1] = $l;


        //問題テキストの設定
        $text = '$$'.$a.'と'.$b.'の';

        //空欄テキストの設定
        $item[0] = '最大公約数は\fbox{ア}\\\\';
        $item[1] = '最小公倍数は\fbox{イ}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //余り
    public function unit403_q03($unit_id){
        //初期設定
        $question_id = 40303;
        $blanks = 1;
        $option = $this->option;

        //変数の設定
        $a = rand(2,5);
        do { $b = rand(1,4); } while( $a<=$b );
        $c = rand(2,5);
        do { $d = rand(1,4); } while( $c<=$d );
        $g = gmp_lcm($a,$c);
        $e = $g/$a*rand(1,3);
        $f = $g/$c*rand(1,3);

        //答えの計算
        $right_answers[0] = ($e*$b + $f*$d)%$g;


        //問題テキストの設定
        $text = '$$ m,nを自然数とする。\\\\
                mを'.$a.'で割った余りが'.$b.'、nを'.$c.'で割った余りが'.$d.'となるとき、\\\\
                '.d1($e,'m').d2($f,'n').'を'.$g.'で割った余りは、';

        //空欄テキストの設定
        $item[0] = '\fbox{ア}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //ユークリッドの互除法と１次不定方程式
    public function unit403_q04($unit_id){
        //初期設定
        $question_id = 40304;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(11,61);
        $b = rand(11,61);

        list($a,$b) = gcd($a,$b);

        //答えの計算
        list($x,$y) = d_equ($a,$b);
        $right_answers[0] = $b;
        $right_answers[1] = $x;
        $right_answers[2] = -1*$a;
        $right_answers[3] = $y;


        //問題テキストの設定
        $text = '$$'.d1($a,'x').d2($b,'y').'=1\\ の整数解は、\\\\
                 整数kを用いて、\\\\';

        //空欄テキストの設定
        $item[0] = 'x = '.($right_answers[0]<0?'-':'').'\fbox{ア}k'.($right_answers[1]<0?'-':'+').'\fbox{イ}、';
        $item[1] = 'y = '.($right_answers[2]<0?'-':'').'\fbox{ウ}k'.($right_answers[3]<0?'-':'+').'\fbox{エ}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //余り
    public function unit403_q05($unit_id){
        //初期設定
        $question_id = 40305;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $n = rand(2,6);
        $m = rand(2,6);
        $a = rand(1,$n-1); $b = rand(0,$n-1); $c = rand(0,$n-1);
        $N = rand(20,50);

        //答えの計算
        $right_answers[0] = $a*$n*$n + $b*$n + $c;
        $right_answers[1] = n_ary($N,$m);

        //問題テキストの設定
        $text = '$$ ';

        //空欄テキストの設定
        $item[0] = $n.'進数\\ '.$a.$b.$c.'_{('.$n.')}を10進数で表すと、\fbox{ア}\\\\';
        $item[1] = '10進数\\ '.$N.'を'.$m.'進数で表すと、\fbox{イ}_{('.$m.')}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //数学B
    //ベクトル
    //分点の位置ベクトル
    public function unit501_q01($unit_id){
        //初期設定
        $question_id = 50101;
        $blanks = 8;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        $b = rand(1,7);
        $c = rand(1,7);
        do{ $d = rand(1,7); } while($c==$d);

        list($a,$b) = gcd($a,$b);
        list($c,$d) = gcd($c,$d);

        //答えの計算
        $right_answers[0] = $b;
        $right_answers[1] = $a+$b;
        $right_answers[2] = $a;
        $right_answers[3] = $a+$b;
        $right_answers[4] = -1*$d;
        $right_answers[5] = $c-$d;
        $right_answers[6] = $c;
        $right_answers[7] = $c-$d;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);
        list($right_answers[6],$right_answers[7]) = gcd($right_answers[6],$right_answers[7]);

        //問題テキストの設定
        $text = '$$ \triangle{ABC}の辺BCを'.$a.':'.$b.'に内分する点をD、\\\\
                辺BCを'.$c.':'.$d.'に外分する点をEとすると、\\\\';

        //空欄テキストの設定
        $item[0] = '\vec{AD} = \frac{\fbox{ア}}{\fbox{イ}}\vec{AB}+';
        $item[1] = '\frac{\fbox{ウ}}{\fbox{エ}}\vec{AC}\\\\';
        $item[2] = '\vec{AE} = '.($right_answers[4]*$right_answers[5]<0?'-':'').'\frac{\fbox{オ}}{\fbox{カ}}\vec{AB}';
        $item[3] = ($right_answers[6]*$right_answers[7]<0?'-':'+').'\frac{\fbox{キ}}{\fbox{ク}}\vec{AC}\\\\';

        for($i=0;$i<4;$i++){
            list($right_answers,$option,$blanks,$item[$i]) = l_frac($right_answers,$option,2*$i+1,$blanks,$item[$i]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //分点の位置ベクトル
    public function unit501_q02($unit_id){
        //初期設定
        $question_id = 50102;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        $b = rand(1,7);
        $c = rand(1,7);
        $d = rand(1,7);

        list($a,$b) = gcd($a,$b);
        list($c,$d) = gcd($c,$d);

        //答えの計算
        $right_answers[0] = $a*($c+$d) + $d*($a+$b);
        $right_answers[1] = 3*($a+$b)*($c+$d);
        $right_answers[2] = $c;
        $right_answers[3] = 3*($c+$d);

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ \triangle{ABC}の辺ABを'.$a.':'.$b.'に内分する点をD、\\\\
                辺BCを'.$c.':'.$d.'に内分する点をEとする。\\\\
                \triangle{ADE}の重心をGとすると、\\\\';

        //空欄テキストの設定
        $item[0] = '\vec{AG} = '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}\vec{AB}';
        $item[1] = ($right_answers[2]*$right_answers[3]<0?'-':'+').'\frac{\fbox{ウ}}{\fbox{エ}}\vec{AC}\\\\';

        for($i=0;$i<2;$i++){
            list($right_answers,$option,$blanks,$item[$i]) = l_frac($right_answers,$option,2*$i+1,$blanks,$item[$i]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //ベクトルの成分と大きさ
    public function unit501_q03($unit_id){
        //初期設定
        $question_id = 50103;
        $blanks = 5;
        $option = $this->option;

        //変数の設定
        $a = rand(-7,7);
        $b = rand(-7,7);
        $c = rand(-7,7);
        $d = rand(-7,7);
        $e = rand(-7,7);
        do { $f = rand(1,7); } while($a==$d && $b==$e && $c==$f);

        //答えの計算
        $right_answers[0] = $d-$a;
        $right_answers[1] = $e-$b;
        $right_answers[2] = $f-$c;
        $right_answers[3] = 1;
        $right_answers[4] = pow($d-$a,2)+pow($e-$b,2)+pow($f-$c,2);

        list($right_answers[3],$right_answers[4]) = root($right_answers[3],$right_answers[4]);

        //問題テキストの設定
        $text = '$$ 空間内の点A('.$a.','.$b.','.$c.')、点B('.$d.','.$e.','.$f.')に対して、\\\\';

        //空欄テキストの設定
        $item[0] = '\vec{AB} = (\fbox{ア},\fbox{イ},\fbox{ウ})\\\\';
        $item[1] = '|\vec{AB}| = \fbox{エ}\sqrt{\fbox{オ}}';

        list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,3,4,$blanks,$item[1]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //一直線上にある条件
    public function unit501_q04($unit_id){
        //初期設定
        $question_id = 50104;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(-7,7);
        $b = rand(-7,7);
        $c = rand(-7,7);
        do{ $d = rand(-7,7); } while($b==$d);
        do{ $e = rand(-7,7); } while($d==$e);

        //答えの計算
        $right_answers[0] = ($c-$a)*($e-$b)+$a*($d-$b);
        $right_answers[1] = $d-$b;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ ３点A('.$a.','.$b.')、B('.$c.','.$d.')、C(x,'.$e.')が\\\\
                 同一直線状にあるとき、';

        //空欄テキストの設定
        $item[0] = 'x = '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //交点の位置ベクトル
    public function unit501_q05($unit_id){
        //初期設定
        $question_id = 50105;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,7);
        $b = rand(1,7);
        $c = rand(1,7);
        $d = rand(1,7);
        list($a,$b) = gcd($a,$b);
        list($c,$d) = gcd($c,$d);

        //答えの計算
        $right_answers[0] = $a*$d;
        $right_answers[1] = ($a+$b)*($c+$d)-$a*$c;
        $right_answers[2] = $b*$c;
        $right_answers[3] = ($a+$b)*($c+$d)-$a*$c;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ \triangle{ABC}の辺ABを'.$a.':'.$b.'に内分する点をD、\\\\
                辺ACを'.$c.':'.$d.'に内分する点をEとする。\\\\
                CDとBEの交点をFとすると、\\\\';

        //空欄テキストの設定
        $item[0] = '\vec{AF} = '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}\vec{AB}';
        $item[1] = ($right_answers[2]*$right_answers[3]<0?'-':'+').'\frac{\fbox{ウ}}{\fbox{エ}}\vec{AC}\\\\';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,3,$blanks,$item[1]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //内積と角の大きさ
    public function unit501_q06($unit_id){
        //初期設定
        $question_id = 50106;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        list($a,$b,$c) = make_tri();
        $cos[0] = $a*$a+$b*$b-$c*$c;
        $cos[1] = 2*$a*$b;

        $in[0] = $cos[0]*$a*$b;
        $in[1] =  $cos[1];
        list($in[0],$in[1]) = gcd($in[0],$in[1]);

        do{ $d=rand(-3,3); } while($d==0);
        do{ $e=rand(-3,3); } while($e==0 || $d==$e);

        //答えの計算
        $right_answers[0] = $cos[0];
        $right_answers[1] = $cos[1];
        $right_answers[2] = 1;
        $right_answers[3] = $a*$a*$d*$d + $d*$e*($a*$a+$b*$b-$c*$c) + $b*$b*$e*$e;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = root($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ ３点O,A,Bについて、\\\\ 
                |\vec{OA}|='.$a.'、|\vec{OB}|='.$b.'、';
        if(abs($in[1]) == 1){
            $text .= '\vec{OA} \cdot \vec{OB}='.$in[0].'のとき、\\\\';
        }else{
            $text .= '\vec{OA} \cdot \vec{OB}='.($in[0]*$in[1]<0?'-':'').'\frac{'.abs($in[0]).'}{'.$in[1].'}のとき、\\\\';
        }

        //空欄テキストの設定
        $item[0] = 'cos{\angle{AOB}} = '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}\\\\';
        $item[1] = '|'.d1($d,'\vec{OA}').d2($e,'\vec{OB}').'|=\fbox{ウ}\sqrt{\fbox{エ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[1]) = l_root($right_answers,$option,2,3,$blanks,$item[1]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //成分と内積
    public function unit501_q07($unit_id){
        //初期設定
        $question_id = 50107;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $a = rand(-7,7);
        $b = rand(-7,7);
        $c = rand(-7,7);
        do{ $d=rand(-7,7); } while($c==$d);

        //答えの計算
        $right_answers[0] = $a*$c + $b*$d;
        $right_answers[1] = -1*$a*$a - $b*$b;
        $right_answers[2] = $a*$c + $b*$d;

        list($right_answers[1],$right_answers[2]) = gcd($right_answers[1],$right_answers[2]);

        //問題テキストの設定
        $text = '$$ \vec{a}=('.$a.','.$b.')、\vec{b}=('.$c.','.$d.')とする。\\\\ また、\vec{p} = \vec{a}+t\vec{b}\\ とおく。\\\\';

        //空欄テキストの設定
        $item[0] = 'このとき、\vec{a}\cdot\vec{b} = '.($right_answers[0]<0?'-':'').'\fbox{ア}\\\\';
        $item[1] = 'また、\vec{a}と\vec{p}が垂直であるとき、t='.($right_answers[1]*$right_answers[2]<0?'-':'').'\frac{\fbox{イ}}{\fbox{ウ}}';

        list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,2,$blanks,$item[1]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //数列
    //等差数列
    public function unit502_q01($unit_id){
        //初期設定
        $question_id = 50201;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        $a = rand(-7,7);
        do{ $d=rand(-7,7); } while($d==0 || $d==1);

        //答えの計算
        $right_answers[0] = $d;
        $right_answers[1] = $a - $d;
        $right_answers[2] = $d;
        $right_answers[3] = 2;
        $right_answers[4] = 2*$a - $d;
        $right_answers[5] = 2;

        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);

        //問題テキストの設定
        $text = '$$ 初項\\ '.$a.'、公差\\ '.$d.'の等差数列の一般項\\ a_{n}\\\\
                およびこの等差数列の初項から第n項までの和S_{n}は、\\\\';

        //空欄テキストの設定
        $item[0] = 'a_{n} = '.($right_answers[0]<0?'-':'').'\fbox{ア}n'.($right_answers[1]>=0?'+':'-').'\fbox{イ}';
        $item[1] = '\\\\ S_{n} = '.($right_answers[2]*$right_answers[3]>0?'':'-').'\frac{\fbox{ウ}}{\fbox{エ}}n^{2}';
        $item[2] = ($right_answers[4]*$right_answers[5]>0?'+':'-').'\frac{\fbox{オ}}{\fbox{カ}}n';

        if($right_answers[1] == 0){
            $item[0] = 'a_{n} = \fbox{ア}n';
            unset($right_answers[1]);
            unset($option[1]);
            $blanks -= 1;
        }

        list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,3,$blanks,$item[1]);
        
        if($right_answers[4]==0){
            $item[2] = '';
            unset($right_answers[4]);
            unset($option[4]);
            unset($right_answers[5]);
            unset($option[5]);
            $blanks -= 2;
        } else{
            list($right_answers,$option,$blanks,$item[2]) = l_frac($right_answers,$option,5,$blanks,$item[2]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //等比数列
    public function unit502_q02($unit_id){
        //初期設定
        $question_id = 50202;
        $blanks = 7;
        $option = $this->option;

        //変数の設定
        do{ $a=rand(-7,7); } while($a==0);
        do{ $r=rand(2,7); } while($a == $r);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = $r;
        $right_answers[2] = 1;
        $right_answers[3] = $a;
        $right_answers[4] = $r-1;
        $right_answers[5] = $r;
        $right_answers[6] = 1;

        list($right_answers[3],$right_answers[4]) = gcd($right_answers[3],$right_answers[4]);

        //問題テキストの設定
        $text = '$$ 初項\\ '.$a.'、公比\\ '.$r.'の等比数列の一般項\\ a_{n}\\\\
                およびこの等比数列の初項から第n項までの和S_{n}は、\\\\';

        //空欄テキストの設定
        $item[0] = 'a_{n} = '.($right_answers[0]<0?'-':'').'\fbox{ア} \cdot \fbox{イ}^{n-\fbox{ウ}}';
        $item[1] = '\\\\ S_{n} = '.($right_answers[3]*$right_answers[4]<0?'-':'').'\frac{\fbox{エ}}{\fbox{オ}}';
        $item[2] = '(\fbox{カ}^{n} - \fbox{キ})';

        if(abs($right_answers[3])==1 && $right_answers[4]==1){
            $item[1] = '\\\\ S_{n} = ';
            $item[2] = ($right_answers[3]==1?'\fbox{カ}^{n} - \fbox{キ}':'-(\fbox{カ}^{n} - \fbox{キ})');
            unset($right_answers[3]);
            unset($option[3]);
            unset($right_answers[4]);
            unset($option[4]);
            $blanks -= 2;
        }else{
            list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,4,$blanks,$item[1]);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //Σの計算　その１
    public function unit502_q03($unit_id){
        //初期設定
        $question_id = 50203;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        do{ $a=rand(-7,7); } while($a==0);
        $b = rand(-7,7);
        $c = rand(-7,7);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = 3;
        $right_answers[2] = $a+$b;
        $right_answers[3] = 2;
        $right_answers[4] = $a+3*$b+6*$c;
        $right_answers[5] = 6;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);
        list($right_answers[4],$right_answers[5]) = gcd($right_answers[4],$right_answers[5]);

        //問題テキストの設定
        $text = '$$ \sum_{k=1}^{n}('.d1($a,'k^{2}').d2($b,'k').d4($c).')=';

        //空欄テキストの設定
        $item[0] = ($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}n^{3}';
        $item[1] = ($right_answers[2]*$right_answers[3]<0?'-':'+').'\frac{\fbox{ウ}}{\fbox{エ}}n^{2}';
        $item[2] = ($right_answers[4]*$right_answers[5]<0?'-':'+').'\frac{\fbox{オ}}{\fbox{カ}}n';

        for($i=0;$i<3;$i++){
            if($right_answers[2*$i]==0){
                $item[$i] = '';
                unset($right_answers[2*$i]);
                unset($right_answers[2*$i+1]);
                unset($option[2*$i]);
                unset($option[2*$i+1]);
                $blanks -= 2;
            }else{
                list($right_answers,$option,$blanks,$item[$i]) = l_frac($right_answers,$option,2*$i+1,$blanks,$item[$i]);
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //Σの計算　その２
    public function unit502_q04($unit_id){
        //初期設定
        $question_id = 50204;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(3,8);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = 1;
        $right_answers[2] = $a;
        $right_answers[3] = $a-1;

        //問題テキストの設定
        $text = '$$ \sum_{k=1}^{n}'.$a.'^{k}=';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}^{n+\fbox{イ}}-\fbox{ウ}}{\fbox{エ}}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //分数の数列の和
    public function unit502_q05($unit_id){
        //初期設定
        $question_id = 50205;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(1,2);
        $b = rand(5,10);

        switch($a){
            case 1:
                //答えの計算
                $right_answers[0] = $b;
                $right_answers[1] = $b+1;
                break;
            case 2:
                //答えの計算
                $right_answers[0] = $b*(3*$b+5);
                $right_answers[1] = 4*($b+1)*($b+2);
                break;
        }

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

        //問題テキストの設定
        $text = '$$ \sum_{k=1}^{'.$b.'}\frac{1}{k(k+'.$a.')}=';

        //空欄テキストの設定
        $item[0] = '\frac{\fbox{ア}}{\fbox{イ}}';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //階差数列
    public function unit502_q06($unit_id){
        //初期設定
        $question_id = 50206;
        $blanks = 5;
        $option = $this->option;

        //変数の設定
        $a = rand(-7,7);
        do{ $b = rand(-5,5); } while($b==0);
        $c = rand(-5,5);

        //答えの計算
        $right_answers[0] = $b;
        $right_answers[1] = 2;
        $right_answers[2] = -1*$b+2*$c;
        $right_answers[3] = 2;
        $right_answers[4] = $a-$c;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ ある数列\{a_{n}\}は初項'.$a.'で、その階差数列\{b_{n}\}の一般項が\\\\
                 b_{n} = '.d1($b,'n').d4($c).'で表されるとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'a_{n} = '.($right_answers[0]*$right_answers[1]<0?'-':'+').'\frac{\fbox{ア}}{\fbox{イ}}n^{2}';
        $item[1] = ($right_answers[2]*$right_answers[3]<0?'-':'+').'\frac{\fbox{ウ}}{\fbox{エ}}n';
        $item[2] = ($right_answers[4]<0?'-':'+').'\fbox{オ}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        if($right_answers[2]==0){
            $item[1] = '';
            unset($right_answers[2]);
            unset($right_answers[3]);
            unset($option[2]);
            unset($option[3]);
            $blanks -= 2;
        }else{
            list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,3,$blanks,$item[1]);
        }

        if($right_answers[4] == 0){
            $item[2] = 0;
            unset($right_answers[4]);
            unset($option[4]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //和から一般項
    public function unit502_q07($unit_id){
        //初期設定
        $question_id = 50207;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        do{ $x = rand(-7,7); } while($x==0);
        do{ $y = rand(-5,5); } while($y==0);

        $a[0] = $x;         $a[1] = 2;
        $b[0] = $x+2*$y;    $b[1] = 2; 

        list($a[0],$a[1]) = gcd($a[0],$a[1]);
        list($b[0],$b[1]) = gcd($b[0],$b[1]);

        //答えの計算
        $right_answers[0] = $x+$y;
        $right_answers[1] = $x;
        $right_answers[2] = $y;

        //問題テキストの設定
        $text = '$$ ある数列\{a_{n}\}の初項から第n項までの和S_{n}が\\\\
                 S_{n} = '.($a[0]<0?'-':'').($a[1]==1?d1(abs($a[0]),'n^{2}'):'\frac{'.abs($a[0]).'}{'.$a[1].'}n^{2}').($b[0]<0?'-':($b[0]==0?'':'+')).($b[1]==1?d1(abs($b[0]),'n'):'\frac{'.abs($b[0]).'}{'.$b[1].'}n').'で表されるとき、\\\\';

        //空欄テキストの設定
        $item[0] = 'a_{1} = '.($right_answers[0]<0?'-':'').'\fbox{ア}\\\\';
        $item[1] = 'a_{n} = '.($right_answers[1]<0?'-':'').'\fbox{イ}n';
        $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //群数列
    public function unit502_q08($unit_id){
        //初期設定
        $question_id = 50208;
        $blanks = 7;
        $option = $this->option;

        //変数の設定
        do{ $a = rand(-7,7); } while($a==0);
        $b = rand(-5,5);

        //答えの計算
        $right_answers[0] = $a;
        $right_answers[1] = -2*$a;
        $right_answers[2] = 2*$a + $b;
        $right_answers[3] = 2*$a;
        $right_answers[4] = -3*$a;
        $right_answers[5] = 3*$a + 2*$b;
        $right_answers[6] = -1*$a - $b;

        //問題テキストの設定
        $text = '$$ ある等差数列\{a_{n}\}の一般項は、a_{n} = '.d1($a,'n').d4($b).'である。\\\\
                 この数列を次のように、1,3,5,…,(2n-1)と群に分ける。\\\\
                 a_{1}\\ |\\ a_{2} \\ a_{3} \\ a_{4} \\ |\\ a_{5} \\ a_{6} \\ a_{7} \\ a_{8} \\ a_{9} \\ | \\ …\\\\';

        //空欄テキストの設定
        $item[0] = 'このとき、第n群の最初の項は、';
        $item[1] = ($right_answers[0]<0?'-':'').'\fbox{ア}n^{2}';
        $item[2] = ($right_answers[1]<0?'-':'+').'\fbox{イ}n';
        $item[3] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}\\\\';
        $item[4] = 'また、第n群に含まれる項の和は、';
        $item[5] = ($right_answers[3]<0?'-':'').'\fbox{エ}n^{3}';
        $item[6] = ($right_answers[4]<0?'-':'+').'\fbox{オ}n^{2}';
        $item[7] = ($right_answers[5]<0?'-':'+').'\fbox{カ}n';
        $item[8] = ($right_answers[6]<0?'-':'+').'\fbox{キ}';


        if($right_answers[2]==0){
            $item[3] = '';
            unset($right_answers[2]);
            unset($option[2]);
            $blanks -= 1;
        }

        if($right_answers[5]==0){
            $item[7] = '';
            unset($right_answers[5]);
            unset($option[5]);
            $blanks -= 1;
        }

        if($right_answers[6]==0){
            $item[8] = '';
            unset($right_answers[6]);
            unset($option[6]);
            $blanks -= 1;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    //漸化式
    public function unit502_q09($unit_id){
        //初期設定
        $question_id = 50209;
        $blanks = 5;
        $option = $this->option;

        //変数の設定
        do{
            $a=rand(-7,7);
            do{ $b=rand(-7,7); } while($b==1 || $b==0);
            do{ $c=rand(-7,7); } while($c==0);
        }while($a-($c/(1-$b)) == 0);

        //答えの計算
        $right_answers[0] = $a*(1-$b) - $c;
        $right_answers[1] = 1-$b;
        $right_answers[2] = $b;
        $right_answers[3] = $c;
        $right_answers[4] = 1-$b;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        //問題テキストの設定
        $text = '$$ 数列\{a_{n}\}は、a_{1} = '.$a.'\\ で、a_{n+1}='.d1($b,'a_{n}').d4($c).'を満たす。\\\\
                このとき、';

        //空欄テキストの設定
        $item[0] = 'a_{n} = '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}} \cdot';
        $item[1] = ($right_answers[2]>0?'\fbox{ウ}^{n-1}':'(-\fbox{ウ})^{n-1}');
        $item[2] = ($right_answers[3]*$right_answers[4]<0?'-':'+').'\frac{\fbox{エ}}{\fbox{オ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[1]) = l_frac($right_answers,$option,4,$blanks,$item[1]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }


    /*テンプレ
    public function unit000_q00($unit_id){
        //初期設定
        $question_id = 00000;
        $blanks = 2;
        $option = $this->option;
        $pattern = rand(1,2);

        switch($pattern){
            case 1:
                break;
            case 2:
                break;
        }

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(1,5); } while( $b==0 );

        //答えの計算
        $right_answers[0] = $a;

        //問題テキストの設定
        $text = '$$ ';

        //空欄テキストの設定
        $item[0] = '';

        list($right_answers,$option,$blanks,$item[0]) = l_root($right_answers,$option,0,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    */

}
