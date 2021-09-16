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

        $text = '$$ ('.li($a,'x') .sign($b).')('.li($c,'x').sign($d).')';
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
                    $right_answer = 2;
                } else {
                    $right_answer = 1;
                }
                break;
            case 2:
                if($a > 0){
                    $right_answer = 1;
                } else {
                    $right_answer = 2;
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

        $options[0] = '①　なし';
        $options[1] = '②　すべての実数';

        return view('question/select',compact('right_answer','unit_id','question_id','text','options','blanks'));
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
        $pattern = rand(1,2);

        //変数の設定
        $x = array();
        $y = array();
        for($j=0;$j<10;$j++){
            array_push($x,rand(1,100)/10);
        }
        switch($pattern){
            case 1:
                for($j=0;$j<10;$j++){
                    array_push($y,round($x[$j]/2+rand(-5,5)*0.1,1));
                }
                break;
            case 2:
                for($j=0;$j<10;$j++){
                    array_push($y,round(-1*$x[$j]/2+rand(-5,5)*0.1+10,1));
                }
                break;
        }

        //答えの設定
        switch($pattern){
            case 1:
                $right_answer = 4;
                break;
            case 2:
                $right_answer = 1;
                break;
        }

        //正解テキストの設定
        $text = '$$ 以上のデータがある。\\\\';
        $text .= 'このデータの相関係数に一番近いのは、\\\\';

        $options[0] = '①　-0.9';
        $options[1] = '②　-0.2';
        $options[2] = '③　0.2';
        $options[3] = '④　0.9';

        return view('question/data_select',compact('x','y','right_answer','unit_id','question_id','text','options','blanks'));
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
        do { $c = rand(-5,5); } while( $c==0 || $b*$b+$c == 0);

        //答えの設定
        $right_answers[0] = 2*$b;
        $right_answers[1] = 2;
        $right_answers[2] = $b*$b + $c;
        $right_answers[3] = 2*$b;
        $right_answers[4] = 2;
        $right_answers[5] = $b*$b + $c;

        list($right_answers[1],$right_answers[2]) = root($right_answers[1],$right_answers[2]);
        list($right_answers[4],$right_answers[5]) = root($right_answers[4],$right_answers[5]);

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
        $blanks = 8;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-11,11); } while( $a==0 );
        do { $b = rand(2,6); } while( $b==5 );
        list($a,$b) = gcd($a,$b);

        //答えの計算
        $right_answers[0] = 1;
        list($right_answers[1],$right_answers[2]) = d_sin(rad_to_deg(rad($a,$b)));
        $right_answers[3] = 1;
        list($right_answers[4],$right_answers[5]) = d_cos(rad_to_deg(rad($a,$b)));
        $right_answers[6] = $right_answers[5];
        $right_answers[7] = $right_answers[1]*$right_answers[4];
        $right_answers[8] = $right_answers[2]*$right_answers[4];

        for($i=0;$i<3;$i++){
            list($right_answers[3*$i],$right_answers[3*$i+1]) = root($right_answers[3*$i],$right_answers[3*$i+1]);
            list($right_answers[3*$i],$right_answers[3*$i+2]) = root($right_answers[3*$i],$right_answers[3*$i+2]);
        }

        //正解テキストの設定
        $text = '$$';
        $radian = $b==1?'':($a*$b<0?'-':'').'\frac{'.abs($a).'}{'.abs($b).'}';

        //空欄テキストの設定
        $item[0] = '\sin{('.$radian.'\pi)} = \frac{\fbox{ア}\sqrt{\fbox{イ}}}{\fbox{ウ}}、';
        $item[1] = '\cos{('.$radian.'\pi)} = \frac{\fbox{エ}\sqrt{\fbox{オ}}}{\fbox{カ}}、\\\\';
        $item[2] = '\tan{('.$radian.'\pi)} = \frac{\fbox{キ}\sqrt{\fbox{ク}}}{\fbox{ケ}}';

        for($i=0;$i<3;$i++){
            if($right_answers[3*$i+1] == 0){
                $item[$i] = str_replace(['\frac{\fbox{'.$option[3*$i].'}\sqrt{','}}{\fbox{'.$option[3*$i+2].'}}'],['',''],$item[$i]);
                unset($right_answers[3*$i]);
                unset($right_answers[3*$i+2]);
                unset($option[3*$i]);
                unset($option[3*$i+2]);
            }elseif($right_answers[3*$i+1] == 1){
                
            }
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }


    /*テンプレ
    public function unit000?q00($unit_id){
        //初期設定
        $question_id = ;
        $blanks = 2;
        $option = $this->option;
        $pattern = rand(1,2);

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        do { $b = rand(1,5); } while( $b==0 );

        //答えの計算
        $right_answers[0]
        $right_answers[1]

        //正解テキストの設定

        //空欄テキストの設定

        return view('question/sentence',compact('right_answers','unit_id','question_id','text','blank_text','blanks'));
    }

    */

}
