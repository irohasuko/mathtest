<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Record;
use App\Models\Unit;

class QuestionController extends Controller
{
    //ユーザ認証
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    public function question($unit_id,$q_id)
    {
        $question = Question::where('q_id',$q_id)->first();
        $unit = Unit::where('id',$unit_id)->first();
        $func = 'unit'.substr($q_id, 0,3).'_q'.substr($q_id, 3);
        echo $this->$func($unit,$question);
    }

    public $option = ['ア','イ','ウ','エ','オ','カ','キ','ク','ケ','コ'];

    //数学Ⅰ
    //数と式
    //式の展開　その１
    public function unit101_q01($unit,$question){

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

        $sample_text = 
            '\begin{eqnarray}'.
            '('.d1($a,'x').d4($b).')('.d1($c,'x').d4($d).') &=& '.d1($a*$c,'x^{2}').d2($a*$d,'x').d2($b*$c,'x').d4($b*$d).'\\\\
                                                            &=& '.d1($a*$c,'x^{2}').d2($a*$d+$b*$c,'x').d4($b*$d).
            '\end{eqnarray}';

        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //式の展開　その２
    public function unit101_q02($unit,$question){

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

        $sample_text = 
            '('.d1($a,'x').d2($b,'y').')('.d1($c,'x').d2($d,'y').') - ('.d1($e,'x').d2($f,'y').')('.d1($g,'x').d2($h,'y').')\\\\'.
            '\begin{eqnarray}
                &=& ('.d1($a*$c,'x^{2}').d2($a*$d+$b*$c,'xy').d2($b*$d,'y^{2}').') - ('.d1($e*$g,'x^{2}').d2($e*$h+$f*$g,'xy').d2($f*$h,'y^{2}').')\\\\
                &=& '.d1($a*$c-$e*$g,'x^{2}').d2($a*$d+$b*$c - ($e*$h+$f*$g),'xy').d2($b*$d - $f*$h,'y^{2}').
            '\end{eqnarray}';

        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //係数が分数の場合の展開
    public function unit101_q03($unit,$question){

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

        $sample_text = 
            '\begin{eqnarray}
                ('.fo(li(frac($a,$b),'x').li(frac($c,$d),'y')).')('.fo(li(frac($e,$f),'x').li(frac($g,$h),'y')).')
                    &=& '.f1($a*$e,$b*$f,'x^{2}').'+('.f1($a*$g,$b*$h).f2($c*$e,$d*$f).')xy'.f2($c*$g,$d*$h,'y^{2}').'\\\\
                    &=& '.f1($a*$e,$b*$f,'x^{2}').f2($a*$g*$d*$f+$c*$e*$b*$h,$b*$d*$f*$h,'xy').f2($c*$g,$d*$h,'y^{2}').
            '\end{eqnarray}';

        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //３項の展開
    public function unit101_q04($unit,$question){

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

        $sample_text = 
            '('.fo(li($a,'x')).li(sign($b),'y').li(sign($c),'z').')^{2}\\\\'.
            '\begin{eqnarray}
                &=& \{('.d1($a,'x').d2($b,'y').')'.d2($c,'z').'\}^{2}\\\\
                &=& ('.d1($a,'x').d2($b,'y').')^{2}'.d2(2*$c,'z').'('.d1($a,'x').d2($b,'y').')+('.d1($c,'z').')^{2}\\\\
                &=& ('.d1($a*$a,'x^{2}').d2(2*$a*$b,'xy').d2($b*$b,'y^{2}').') + ('.d1(2*$a*$c,'zx').d2(2*$b*$c,'yz').') '.d2($c*$c,'z^{2}').'\\\\
                &=& '.d1($a*$a,'x^{2}').d2($b*$b,'y^{2}').d2($c*$c,'z^{2}').d2(2*$a*$b,'xy').d2(2*$b*$c,'yz').d2(2*$c*$a,'zx').'\\\\'.
            '\end{eqnarray}';

        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //３乗の展開
    public function unit101_q05($unit,$question){

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

        $sample_text = 
            '('.fo(li($a,'x')).li(sign($b),'y').')^{3}\\\\'.
            '\begin{eqnarray}
                &=& ('.d1($a,'x').')^{3}+3('.d1($a,'x').')^{2}('.d1($b,'y').')+3('.d1($a,'x').')('.d1($b,'y').')^{2}+('.d1($b,'y').')^{3}\\\\
                &=& '.d1($a*$a*$a,'x^{3}').d2(3*$a*$a*$b,'x^{2}y').d2(3*$a*$b*$b,'xy^{2}').d2($b*$b*$b,'y^{3}').'\\\\'.
            '\end{eqnarray}';

        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //因数分解　その１
    public function unit101_q06($unit,$question){

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

        $r = $right_answers;
        if(!isset($r[2])){
            $r[2] = $r[0]; $r[3] = $r[1];
        }

        $sample_text = '
            \def\Tasuki#1#2#3#4#5#6#7{
                \begin{array}{cccc}
                    {#1} & \diagdown \\ \diagup & {#2} & \rightarrow & {#3} \\\\
                    {#4} & \diagup \\ \diagdown & {#5} & \rightarrow & {#6} \\\\
                    \hline
                         & &      &             & {#7}
                \end{array} 
            }

            '.d1($a,'x^{2}').d2($b,'xy').d2($c,'y^{2}').'
                = ('.d1($r[0],'x').d2($r[1],'y').')('.d1($r[2],'x').d2($r[3],'y').')\\\\
        
            \Tasuki{'.$r[0].'}{'.$r[1].'}{'.($r[1]*$r[2]).'}{'.$r[2].'}{'.$r[3].'}{'.($r[0]*$r[3]).'}{'.$b.'}\\\\';

        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //因数分解　その２
    public function unit101_q07($unit,$question){

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

        $r = $right_answers;
        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        $sample_text = '
            \def\Tasuki#1#2#3#4#5#6#7{
                \begin{array}{|cccc|}
                    \hline
                    {#1} & \diagdown \\ \diagup & {#2} & \rightarrow & {#3} \\\\
                    {#4} & \diagup \\ \diagdown & {#5} & \rightarrow & {#6} \\\\
                    \hline
                         & &      &             & {#7} \\\\
                    \hline
                \end{array} 
            }

            '.d1($a,'x^{2}').d2($b,'y^{2}').d2($c,'xy').d2($d,'x').d2($e,'y').d4($f).'\\\\
            \begin{eqnarray}
                &=& '.d1($a,'x^{2}').d2($c,'xy').d2($d,'x').d2($b,'y^{2}').d2($e,'y').d4($f).'\\\\
                && \Tasuki{'.$r[0].'}{'.$r[1].'}{'.($r[1]*$r[3]).'}{'.$r[3].'}{'.$r[4].'}{'.($r[0]*$r[4]).'}{'.$e.'}\\\\
                &=& '.d1($a,'x^{2}').d2($c,'xy').d2($d,'x').'+('.d1($r[0],'y').d4($r[1]).')('.d1($r[3],'y').d4($r[4]).')\\\\
                &=& '.d1($a,'x^{2}').'+('.d1($c,'y').d4($d).')x+('.d1($r[0],'y').d4($r[1]).')('.d1($r[3],'y').d4($r[4]).')\\\\
                && \Tasuki{1}{'.d1($r[0],'y').d4($r[1]).'}{'.d1($r[0]*$r[2],'y').d4($r[1]*$r[2]).'}{'.$r[2].'}{'.d1($r[3],'y').d4($r[4]).'}{'.d1($r[3],'y').d4($r[4]).'}{'.d1($c,'y').d4($d).'}\\\\
                &=& (x'.d2($r[0],'y').d4($r[1]).')('.d1($r[2],'x').d2($r[3],'y').d4($r[4]).')\\\\
            \end{eqnarray}';

        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //３乗の因数分解
    public function unit101_q08($unit,$question){

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

                $r = $right_answers;
                $sample_text = 
                    d1($a,'x^{3}').d2($b,'x^{2}y').d2($c,'xy^{2}').d2($d,'y^{3}').'\\\\'.
                    '\begin{eqnarray}
                        &=& ('.d1($r[0],'x').')^{3}+3\cdot('.d1($r[0],'x').')^{2}\cdot('.d1($r[1],'y').')+3\cdot('.d1($r[0],'x').')\cdot('.d1($r[1],'y').')^{2}+('.d1($r[1],'y').')^{3}\\\\
                        &=& ('.d1($r[0],'x').d2($r[1],'y').')^{3}\\\\'.
                    '\end{eqnarray}';

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

                $r = $right_answers;
                $sample_text = 
                    '\begin{eqnarray}
                        '.d1($a*$a*$a,'x^{3}').d2($b*$b*$b,'y^{3}').'
                        &=& ('.d1($a,'x').')^{3}+('.d1($b,'y').')^{3}\\\\
                        &=& ('.d1($a,'x').d2($b,'y').')\{('.d1($a,'x').')^{2}-('.d1($a,'x').')\cdot('.d1($b,'y').')+('.d1($b,'y').')^{2}\}\\\\
                        &=& ('.d1($a,'x').d2($b,'y').')('.d1($a*$a,'x^{2}').d2(-1*$a*$b,'xy').d2($b*$b,'y^{2}').')\\\\'.
                    '\end{eqnarray}';
                break;
        }


        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';

        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }
    
    //分母の有理化
    public function unit101_q09($unit,$question){

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

        $r = $right_answers;
        $sample_text = 
            '\begin{eqnarray}
                \frac{'.$a.'+\sqrt{'.$b.'}}{'.$c.'+\sqrt{'.$b.'}}
                &=& \frac{('.$a.'+\sqrt{'.$b.'})('.$c.'-\sqrt{'.$b.'})}{('.$c.'+\sqrt{'.$b.'})('.$c.'-\sqrt{'.$b.'})}\\\\
                &=& \frac{'.($a*$c).rt(-1*$a,$b).rt($c,$b).'-'.($b).'}{'.($c*$c-$b).'}\\\\
                &=& \frac{'.($a*$c-$b).rt(-1*$a+$c,$b).'}{'.($c*$c-$b).'}\\\\'.
                ($g!=1?'&=& '.fr_rt($a*$c-$b,$c-$a,$b,$c*$c-$b):'').
            '\end{eqnarray}';

        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //対称式
    public function unit101_q10($unit,$question){

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

        $sample_text = 
            '\begin{eqnarray}
                x^{2}y+xy^{2} &=& xy(x+y)\\\\
                &=& '.$b.'×'.$a.'\\\\
                &=& '.($b*$a).'\\\\
                x^{2}+y^{2} &=& (x+y)^{2} -2xy\\\\
                &=& ('.$a.')^{2} - 2 \cdot '.$b.'\\\\
                &=& '.$right_answers[1].
           '\end{eqnarray}';

        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //絶対値を含む1次不等式
    public function unit101_q11($unit,$question){

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
                $sample_text = 
                    '|x'.d3($a).'| ≦ '.$b.'\\ より、\\\\
                    '.(-1*$b).'\leqq x'.d3($a).'\leqq '.$b.'\\\\
                    '.(-1*$b-$a).'\leqq x \leqq '.($b-$a);
                break;
            case 2:    //大なり
                $text = '$$ |x'.d3($a).'| > '.$b.'  のとき、';
                $blank_text = 'x < \fbox{ア} 、\fbox{イ} < x $$';
                $sample_text = 
                    '|x'.d3($a).'| > '.$b.'\\ より、\\\\
                    x'.d3($a).'\lt'.(-1*$b).',\\ '.$b.'\lt x'.d3($a).'\\\\
                    x \lt '.(-1*$b-$a).',\\ '.($b-$a).'\lt x';
                break;
        }

        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //連立1次不等式
    public function unit101_q12($unit,$question){

        //初期設定
        $question_id = 10112;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(1,5);
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
        $text =   '$$ \begin{cases}'.d1($a).'x'.d3($b).'\geqq '.$c.' \\\\ '.d1($d).'x'.d3($e).'\leqq '.$f.' \end{cases}を解くと、\\\ ';

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

            $sample_text = 
                    '\begin{cases}'
                        .d1($a).'x'.d3($b).' \geqq '.$c.' \quad \cdots \quad (1) \\\\ '
                        .d1($d).'x'.d3($e).' \leqq '.$f.' \quad \cdots \quad (2) \\\\
                    \end{cases} \\\\[15pt]'.
                    '\begin{eqnarray}
                        (1)より、'.d1($a,'x').' & \geqq & '.($c-$b).'\\\\
                                    x & \geqq & '.f3($c-$b,$a).'\\\\[5pt]
                        (2)より、'.d1($d,'x').' & \leqq & '.($f-$e).'\\\\
                                    x & \leqq & '.f3($f-$e,$d).'\\\\
                    \end{eqnarray}\\\\'.
                    '(1),(2)の共通範囲から、\\\\ '.f3($c-$b,$a).' \leqq x \leqq '.f3($f-$e,$d);

        } else {
            $blanks = 2;
            $item[0] = 'x \geqq ';
            $item[1] = ($right_answers[2]*$right_answers[3]>=0 ? '' : '-').'\frac{\fbox{'.$option[0].'}}{\fbox{'.$option[1].'}}';
            $right_answers[0] = $right_answers[2];
            $right_answers[1] = $right_answers[3];
            unset($right_answers[2]);
            unset($right_answers[3]);

            if(abs($right_answers[1]) == 1){
                unset($right_answers[1]);
                $item[1] = str_replace(['\frac{','}{\fbox{'.$option[1].'}}'],['',''],$item[1]);
                unset($option[1]);
                $blanks -= 1;
            }

            $sample_text = 
                    '\begin{cases}'
                        .d1($a).'x'.d3($b).' \geqq '.$c.' \quad \cdots \quad (1) \\\\ '
                        .d1($d).'x'.d3($e).' \leqq '.$f.' \quad \cdots \quad (2) \\\\
                    \end{cases} \\\\[15pt]'.
                    '\begin{eqnarray}
                        (1)より、'.d1($a,'x').' & \geqq & '.($c-$b).'\\\\
                                    x & \geqq & '.f3($c-$b,$a).'\\\\[5pt]
                        (2)より、'.d1($d,'x').' & \leqq & '.($f-$e).'\\\\
                                    x & \geqq & '.f3($f-$e,$d).'\\\\
                    \end{eqnarray}\\\\'.
                    '(1),(2)の共通範囲から、\\\\ x \geqq '.f3($f-$e,$d);
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //２次関数（102）
    //放物線の軸、頂点
    public function unit102_q01($unit,$question){
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
            if(abs($right_answers[2*$i+1]) == 1){
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

        $sample_text = 
            '\begin{eqnarray}
                y &=& '.d1($a).'x^{2}'.d2($b).'x'.d3($c).'\\\\
                  &=& '.d1($a,'(x^{2}'.f2($b,$a).'x)').d4($c).' \\\\
                  &=& '.d1($a,'\{(x'.f2($b,2*$a).')^{2}'.f2(-1*$b*$b,4*$a*$a).'\}').d4($c).'\\\\
                  &=& '.d1($a,'(x'.f2($b,2*$a).')^{2}').f2(-1*$b*$b,4*$a).d4($c).'\\\\
                  &=& '.d1($a,'(x'.f2($b,2*$a).')^{2}').f2(-1*$b*$b+4*$a*$c,4*$a).'\\\\
           \end{eqnarray}\\\\'.
           'よって、軸は \quad x='.f1(-1*$b,2*$a).'\\\\
           頂点は \quad ('.f1(-1*$b,2*$a).','.f1(-1*$b*$b+4*$a*$c,4*$a).')';

        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //平行移動
    public function unit102_q02($unit,$question){
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

        $sample_text = 
            '放物線 \\ y='.d1($a).'x^{2}'.d2($b).'x'.d3($c).'\\ を\\\\
             x軸方向に'.$d.'、y軸方向に'.$e.'だけ平行移動した式は、\\\\'.
            '\begin{eqnarray}
                y'.d4(-1*$e).' &=& '.d1($a).'(x'.d4(-1*$d).')^{2}'.d2($b).'(x'.d4(-1*$d).')'.d3($c).'\\\\
                y  &=& '.d1($a,'(x^{2}'.d2(-2*$d,'x').d4($d*$d).')').d2($b,'(x'.d4(-1*$d).')').d4($c+$e).' \\\\
                   &=& '.d1($a,'x^{2}').d2(-2*$a*$d,'x').d4($a*$d*$d).d2($b,'x').d4(-1*$b*$d).d4($c+$e).'\\\\
                   &=& '.d1($a,'x^{2}').d2(-2*$a*$d+$b,'x').d4($a*$d*$d-$b*$d+$c+$e).'\\\\
           \end{eqnarray}\\\\';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //対称移動
    public function unit102_q03($unit,$question){
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
                $right_answers[0] = -1*$a;
                $right_answers[1] = -1*$b;
                $right_answers[2] = -1*$c;
                break;
            case 2:
                $right_answers[0] = $a;
                $right_answers[1] = -1*$b;
                $right_answers[2] = $c;
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
                $text.= 'x軸に関して対称移動すると、\\\\';
                $sample_text = 
                    'x軸に関して対称移動すると、\\\\
                    \begin{eqnarray}
                        -y &=& '.d1($a,'x^{2}').d2($b,'x').d3($c).'\\\\
                        y  &=& '.d1(-1*$a,'x^{2}').d2(-1*$b,'x').d4(-1*$c).'\\\\
                    \end{eqnarray}\\\\';
                break;
            case 2:
                $text.= 'y軸に関して対称移動すると、\\\\';
                $sample_text = 
                    'y軸に関して対称移動すると、\\\\
                    \begin{eqnarray}
                        y &=& '.d1($a,'(-x)^{2}').d2($b,'(-x)').d4($c).'\\\\
                          &=& '.d1($a,'x^{2}').d2(-1*$b,'x').d4($c).'\\\\
                    \end{eqnarray}\\\\';
                break;
            case 3:
                $text.= '原点に関して対称移動すると、\\\\';
                $sample_text = 
                    '原点に関して対称移動すると、\\\\
                    \begin{eqnarray}
                        -y &=& '.d1($a,'(-x)^{2}').d2($b,'(-x)').d4($c).'\\\\
                           &=& '.d1($a,'x^{2}').d2(-1*$b,'x').d4($c).'\\\\
                         y &=& '.d1(-1*$a,'x^{2}').d2($b,'x').d4(-1*$c).'\\\\
                    \end{eqnarray}\\\\';
                break;
        }

        //空欄テキストの設定
        $item[0] = 'y='.($right_answers[0]<0?'-':'').'\fbox{ア}x^{2}';
        $item[1] = ($right_answers[1]<0?'-':'+').'\fbox{イ}x';
        $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}';

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //２次関数の最大・最小　その１
    public function unit102_q04($unit,$question){
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

        $sample_text = 
            '\begin{eqnarray}
                y &=& '.d1($a).'x^{2}'.d2($b).'x'.d3($c).'\\\\
                    &=& '.d1($a,'(x^{2}'.f2($b,$a).'x)').d4($c).' \\\\
                    &=& '.d1($a,'(x'.f2($b,2*$a).')^{2}').f2(-1*$b*$b+4*$a*$c,4*$a).'\\\\
            \end{eqnarray}\\\\'.
            'よって、頂点は \quad ('.f1(-1*$b,2*$a).','.f1(-1*$b*$b+4*$a*$c,4*$a).')より、\\\\';
        if($a > 0){
            $sample_text .= 'x='.f1(-1*$b,2*$a).'のとき最小値'.f1(-1*$b*$b+4*$a*$c,4*$a); 
        } else {
            $sample_text .= 'x='.f1(-1*$b,2*$a).'のとき最大値'.f1(-1*$b*$b+4*$a*$c,4*$a); 
        }

        $x = -1*$b/(2*$a);
        $y = -1*$b*$b/(4*$a)+$c;
        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:['.($x-5<-1?$x-5:-1).','.($y+5>1?$y+5:1).','.($x+5>1?$x+5:1).','.($y-5<-1?$y-5:-1).'],
                    axis: true,
                    showNavigation: false,
                    showCopyright: false 
                });

                function bezier(t) {
                    return '.$a.'*t*t + '.$b.'*t + '.$c.';
                }
                let graph = board.create(\'functiongraph\', [bezier, '.($x-5).', '.($x+5).']);
                board.create(\'point\',['.$x.','.$y.'] , {name:\' \', face:\'o\', size:1, fixed:true});
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //２次関数の最大・最小　その２
    public function unit102_q05($unit,$question){
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

        //問題テキストの設定
        $text = '$$ ２次関数 \\ y='.d1($a).'x^{2}'.d2($b).'x'.d3($c).'\\ ('.$d.'\leqq x \leqq'.$e.')\\ は、\\\\';

        //空欄テキストの設定
        $item[0] = 'x='.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}のとき、';
        $item[1] = '最大値'.($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}}をとり、\\\\';
        $item[2] = 'x='.($right_answers[4]*$right_answers[5]<0?'-':'').'\frac{\fbox{オ}}{\fbox{カ}}のとき、';
        $item[3] = '最小値'.($right_answers[6]*$right_answers[7]<0?'-':'').'\frac{\fbox{キ}}{\fbox{ク}}をとる';

        $r = $right_answers;
        $sample_text = 
            '\begin{eqnarray}
                y &=& '.d1($a).'x^{2}'.d2($b).'x'.d3($c).'\\\\
                  &=& '.d1($a,'(x'.f2($b,2*$a).')^{2}').f2(-1*$b*$b+4*$a*$c,4*$a).'\\\\
            \end{eqnarray}\\\\'.
            'よって、図形と範囲は下図のようになるので、\\\\
            x='.f3($r[0],$r[1]).'のとき最大値'.f3($r[2],$r[3]).'を、\\\\
            x='.f3($r[4],$r[5]).'のとき最小値'.f3($r[6],$r[7]).'をとる\\\\';

        for($i=0;$i<4;$i++){
            if(abs($right_answers[2*$i+1]) == 1){
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


        $f_axis = (-1*$b*$b+4*$a*$c)/(4*$a);
        if($f_d > $f_e && $f_d >= $f_axis){ //下に凸かつx=dで最大
            $f_max = $f_d;
            $max = $d;
            if($d < $axis && $axis < $e){   //範囲に軸が含まれている
                $f_min = $f_axis;
                $min = $axis;
            }else{  //範囲に軸が含まれていない
                $f_min = $f_e;
                $min = $e;
            }
        }elseif($f_e >= $f_axis){ //下に凸かつx=eで最大
            $f_max = $f_e;
            $max = $e;
            if($d < $axis && $axis < $e){   //範囲に軸が含まれている
                $f_min = $f_axis;
                $min = $axis;
            }else{  //範囲に軸が含まれていない
                $f_min = $f_d;
                $min = $d;
            }
        }else{  //上に凸
            if($d < $axis && $axis < $e){   //範囲に軸が含まれている
                $f_max = $f_axis;
                $max = $axis;
                if($f_d > $f_e){
                    $f_min = $f_e;
                    $min = $e;
                }else{
                    $f_min = $f_d;
                    $min = $d;
                }
            }else{  //範囲に軸が含まれていない
                if($f_d > $f_e){
                    $f_max = $f_d;
                    $max = $d;
                    $f_min = $f_e;
                    $min = $e;
                }else{
                    $f_max = $f_e;
                    $max = $e;
                    $f_min = $f_d;
                    $min = $d;
                }
            }
        }

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:['.($d-3).','.($f_max+2).','.($e+3).','.($f_min-2).'],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return '.$a.'*t*t + '.$b.'*t + '.$c.';
                }
                board.create(\'functiongraph\', [bezier, -20, '.($d).'],{dash:1,strokeColor:\'black\'});
                board.create(\'functiongraph\', [bezier, '.($e).', 20],{dash:1,strokeColor:\'black\'});
                board.create(\'functiongraph\', [bezier, '.($d).', '.($e).']);
                board.create(\'point\',['.$max.','.$f_max.'] , {name:\' \', face:\'o\', size:1, fixed:true});
                board.create(\'point\',['.$min.','.$f_min.'] , {name:\' \', face:\'o\', size:1, fixed:true});
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //２次関数の決定
    public function unit102_q06($unit,$question){
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

        $r = $right_answers;
        $sample_text = 
            'y=ax^{2}+bx+cとおく\\\\'.
            '\begin{eqnarray}
                &(&'.$a.',0)を通るので、0='.d1($a*$a,'a').d2($a,'b').'+c \quad ・・・ ①\\\\
                &(&0,'.$b.')を通るので、'.$b.'=c \quad ・・・ ②\\\\
                &(&'.$c.','.$d.')を通るので、'.$d.'='.d1($c*$c,'a').d2($c,'b').'+c \quad ・・・ ③\\\\
            \end{eqnarray}\\\\'.
            '①、②、③を連立して解くと、\\\\
            a='.f3($r[0],$r[1]).',\quad b='.f3($r[2],$r[3]).',\quad c='.$r[4].'\\\\
            したがって、求める二次関数は、\\\\
            y='.f1($r[0],$r[1],'x^{2}').f2($r[2],$r[3],'x').d4($r[4]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //２次方程式
    public function unit102_q07($unit,$question){
        //初期設定
        $question_id = 10207;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $p = rand(1,5);
        do { $q = rand(-7,7); } while( $p==0 || gmp_gcd($p,$q)!=1 );
        $r = rand(1,5);
        do { $s = rand(-7,7); } while( 
            $s==0 || gmp_gcd($r,$s)!=1 ||
            ($p == $r && $q == $s));

        $a = $p*$r;
        $b = $p*$s + $r*$q;
        $c = $q*$s;

        //答えの設定
        $right_answers[0] = -1*$q;
        $right_answers[1] = $p;
        $right_answers[2] = -1*$s;
        $right_answers[3] = $r;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

        if($right_answers[0]/$right_answers[1] > $right_answers[2]/$right_answers[3]){
            $right_answers = array($right_answers[2],$right_answers[3],$right_answers[0],$right_answers[1]);
        }

        //正解テキストの設定
        $text = '$$ ２次方程式:\\ '.d1($a).'x^{2}'.d2($b,'x').d3($c).'=0 \\ の解は、\\\\';

        //空欄テキストの設定
        $item[0] = 'x='.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}、';
        $item[1] = ($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}} \\ ';
        $item[2] = '(ただし、'.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}} \lt '.($right_answers[2]*$right_answers[3]<0?'-':'').'\frac{\fbox{ウ}}{\fbox{エ}})';

        $ans = $right_answers;
        $sample_text = '
        \def\Tasuki#1#2#3#4#5#6#7{
            \begin{array}{|cccc|}
            \hline
                {#1} & \diagdown \\ \diagup & {#2} & \rightarrow & {#3} \\\\
                {#4} & \diagup \\ \diagdown & {#5} & \rightarrow & {#6} \\\\
                \hline
                     & &      &             & {#7} \\\\
            \hline
            \end{array} 
        }

        '.d1($a,'x^{2}').d2($b,'x').d4($c).'= 0\\\\
        \Tasuki{'.$p.'}{'.$q.'}{'.($q*$r).'}{'.$r.'}{'.$s.'}{'.($p*$s).'}{'.$b.'}\\\\

        \begin{eqnarray}
            ('.d1($p,'x').d4($q).')('.d1($r,'x').d4($s).') &=& 0\\\\
            x &=& '.f3($ans[0],$ans[1]).','.f3($ans[2],$ans[3]).'\\\\'.
        '\end{eqnarray}';

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
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //判別式
    public function unit102_q08($unit,$question){
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
                $text .= '異なる二つの実数解を持つとき、';
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

        $sample_text = 
            '判別式をDとすると、\\\\
            \begin{array}{cc}
                D &=& ('.$b.')^{2} -4 \cdot ('.($a).')\cdot(k'.d4($c).')\\\\
                  &=& '.($b*$b).d2(-4*$a,'k').d4(-4*$a*$c).'\\\\
            \end{array}
            \\\\';

        switch($pattern){
            case 1:
                $sample_text .= 
                    '異なる二つの実数解をもつとき、D \gt 0 \\ より、\\\\
                    \begin{eqnarray}
                        '.($b*$b).d2(-4*$a,'k').d4(-4*$a*$c).'& \gt & 0\\\\
                        '.d1(-4*$a,'k').'& \gt & '.(-1*$b*$b+4*$a*$c).'\\\\
                        k &\lt& '.f3($b*$b-4*$a*$c,4*$a).'\\\\
                    \end{eqnarray}';
                break;
            case 2:
                $sample_text .= 
                    '重解をもつとき、D = 0 \\ より、\\\\
                    \begin{eqnarray}
                        '.($b*$b).d2(-4*$a,'k').d4(-4*$a*$c).'&=& 0\\\\
                        '.d1(-4*$a,'k').'&=& '.(-1*$b*$b+4*$a*$c).'\\\\
                        k &=& '.f3($b*$b-4*$a*$c,4*$a).'\\\\
                    \end{eqnarray}';
                break;
            case 3:
                $sample_text .= 
                    '実数解をもたないとき、D \lt 0 \\ より、\\\\
                    \begin{eqnarray}
                        '.($b*$b).d2(-4*$a,'k').d4(-4*$a*$c).'& \lt & 0\\\\
                        '.d1(-4*$a,'k').'& \lt & '.(-1*$b*$b+4*$a*$c).'\\\\
                        k & \gt & '.f3($b*$b-4*$a*$c,4*$a).'\\\\
                    \end{eqnarray}';
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
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //２次不等式　その１
    public function unit102_q09($unit,$question){
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

        $sample_text = 
            d1($a,'x^{2}').d2($b,'x').d3($c).'=0\\ を解くと、\\\\
            x = '.fr_rt(-1*$b,-1,$b*$b-4*$a*$c,2*$a).',\quad'.fr_rt(-1*$b,1,$b*$b-4*$a*$c,2*$a).'\\\\[10pt]
            よって、下図より、解は\\\\[5pt]';

        switch($pattern){
            case 1:
                $item[0] = 'x \lt \frac{'.($right_answers[0]<0?'-':'').'\fbox{ア}-\fbox{イ}\sqrt{\fbox{ウ}}}{\fbox{エ}}、';
                $item[1] = '\frac{'.($right_answers[4]<0?'-':'').'\fbox{オ}+\fbox{カ}\sqrt{\fbox{キ}}}{\fbox{ク}} \lt x';
                $sample_text .= 
                    'x \lt '.fr_rt(-1*$b,-1,$b*$b-4*$a*$c,2*$a).',\quad'.fr_rt(-1*$b,1,$b*$b-4*$a*$c,2*$a).'\lt x';
                break;
            case 2:
                $item[0] = '\frac{'.($right_answers[0]<0?'-':'').'\fbox{ア}-\fbox{イ}\sqrt{\fbox{ウ}}}{\fbox{エ}} \lt x \lt';
                $item[1] = '\frac{'.($right_answers[4]<0?'-':'').'\fbox{オ}+\fbox{カ}\sqrt{\fbox{キ}}}{\fbox{ク}}';
                $sample_text .= 
                    fr_rt(-1*$b,-1,$b*$b-4*$a*$c,2*$a).'\lt x \lt'.fr_rt(-1*$b,1,$b*$b-4*$a*$c,2*$a);
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

        $x_l = (-1*$b - sqrt($b*$b-4*$a*$c))/(2*$a);
        $x_m = (-1*$b + sqrt($b*$b-4*$a*$c))/(2*$a);
        $axis = -1*$b/(2*$a);
        $f_axis = $a*$axis*$axis + $b*$axis + $c;
        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:['.($axis-5).','.($f_axis+7>-1?$f_axis+7:-1).','.($axis+5).','.($f_axis-3<-1?$f_axis-3:-1).'],
                    axis: true,
                    showNavigation: false,
                    showCopyright: false,
                    fixed:true
                });

                function bezier(t) {
                    return '.$a.'*t*t + '.$b.'*t + '.$c.';
                }

                board.create(\'functiongraph\', [bezier, '.($axis-5).', '.($axis+5).']);

                '.($pattern==1?
                            '
                                board.create(\'line\',[['.($axis-5).',0],['.($x_l).',0]], {straightFirst:false,straightLast:false,strokeColor:\'#00ff00\',strokeWidth:2,fixed:true});
                                board.create(\'line\',[['.($axis+5).',0],['.($x_m).',0]], {straightFirst:false,straightLast:false,strokeColor:\'#00ff00\',strokeWidth:2,fixed:true});
                            '
                        :
                            '
                                board.create(\'line\',[['.($x_l).',0],['.($x_m).',0]], {straightFirst:false,straightLast:false,strokeColor:\'#00ff00\',strokeWidth:2,fixed:true})
                            '
                        ).'

            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //２次不等式　その２
    public function unit102_q10($unit,$question){
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

        $sample_text = '
            判別式をDとおくと、\\\\
            D = ('.$b.')^{2}-4\cdot('.$a.')\cdot('.$c.') = '.($b*$b-4*$a*$c).'\lt 0\\\\
            よって、y = '.d1($a,'x^{2}').d2($b,'x').d3($c).'とおくと、\\\\
            下図のように、x軸との交点を持たないので、\\\\
            不等式を満たすxは、
            '.($right_answers[0]==1?'存在しない':'すべての実数').'
        ';

        $axis = -1*$b/(2*$a);
        $f_axis = $a*$axis*$axis + $b*$axis + $c;
        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:['.($axis-5).','.($f_axis+7>-1?$f_axis+7:-1).','.($axis+5).','.($f_axis-3<-1?$f_axis-3:-1).'],
                    axis: true,
                    showNavigation: false,
                    showCopyright: false
                });

                function bezier(t) {
                    return '.$a.'*t*t + '.$b.'*t + '.$c.';
                }
                board.create(\'functiongraph\', [bezier, '.($axis-5).', '.($axis+5).']);

                var p1 = board.create(\'point\',['.($axis-5).',0], {name:\'\', size:0, fixed:true});
                var p2 = board.create(\'point\',['.($axis+5).',0], {name:\'\', size:0, fixed:true});
                if('.$pattern.' == 1){
                    var p3 = board.create(\'point\',['.($axis+5).','.($f_axis+7>-1?$f_axis+7:-1).'], {name:\'\', size:0, fixed:true});
                    var p4 = board.create(\'point\',['.($axis-5).','.($f_axis+7>-1?$f_axis+7:-1).'], {name:\'\', size:0, fixed:true});
                }else{
                    var p3 = board.create(\'point\',['.($axis+5).','.($f_axis-3<-1?$f_axis-3:-1).'], {name:\'\', size:0, fixed:true});
                    var p4 = board.create(\'point\',['.($axis-5).','.($f_axis-3<-1?$f_axis-3:-1).'], {name:\'\', size:0, fixed:true});
                }
                board.create(\'polygon\',[p1,p2,p3,p4],{borders:{strokeColor:\'black\'}});
            </script>
        ';

        $blank_text = implode($item).'$$';
        $start = time();
        return view('question/select',compact('right_answers','unit','question','text','options','blanks','start','blank_text','sample_text','plot'));
    }

    //放物線と軸の関係
    public function unit102_q11($unit,$question){
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

        $sample_text = '
            '.d1($a,'x^{2}').d2($b,'kx').d4($c).'+k=0とすると、判別式Dは、\\\\
            \begin{eqnarray}
                D &=& ('.d1($b,'k').')^{2}-4\cdot('.$a.')\cdot('.d4($c).'+k)\\\\
                  &=& '.d1($b*$b,'k^{2}').d2(-4*$a,'k').d4(-4*$a*$c).'\\\\
            \end{eqnarray}\\\\[15pt]
            x軸に接するとき、D=0より、\\\\
            '.d1($b*$b,'k^{2}').d2(-4*$a,'k').d4(-4*$a*$c).'=0\\\\
            これを解いて、k='.fr_rt(2*$a,-1,4*$a*$a + 4*$a*$b*$b*$c,$b*$b).',\quad'.fr_rt(2*$a,1,4*$a*$a + 4*$a*$b*$b*$c,$b*$b).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //図形と計量（103）
    //三角比の相互関係
    public function unit103_q01($unit,$question){
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
        $item[1] = '\tan \alpha ='.($a<0?'-':'').'\frac{\fbox{エ}\sqrt{\fbox{オ}}}{\fbox{カ}}';

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

        $sample_text = '
            \sin^{2}{\alpha} + \cos^{2}{\alpha} = 1 \quad より、\\\\
            \begin{eqnarray}
                \sin^{2}{\alpha} &=& 1 - \cos^{2}{\alpha}\\\\
                                 &=& 1 - '.f3($a*$a,$b*$b).'\\\\
                                 &=& '.f3($b*$b-$a*$a,$b*$b).'\\\\
            \end{eqnarray}\\\\[15pt]
            0° \leqq \alpha \leqq 180° より、\sin{\alpha} \gt 0 なので、\\\\
            \sin{\alpha} = '.fr_rt2(1,$b*$b-$a*$a,$b).'\\\\
            \tan{\alpha} = \frac{\sin{\alpha}}{\cos{\alpha}} = '.fr_rt2(1,$b*$b-$a*$a,$a).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //三角方程式
    public function unit103_q02($unit,$question){
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
        $text = '$$ 0° \leqq \theta \leqq 180° で、'.d1($a,'\cos \theta').'+\sqrt{'.$b.'}=0 \\ のとき、\\\\';
        if($b == 1){
            $text = str_replace('\sqrt{'.$b.'}',$b,$text);
        } elseif($b == 0){
            $text = str_replace('+\sqrt{'.$b.'}','',$text);
        }

        $sample_text = '
            \begin{eqnarray}
                '.d1($a,'\cos{\theta}').rt(1,$b).' &=& 0\\\\
                                    \cos{\theta} &=& '.fr_rt2(-1,$b,$a).'\\\\
                                         \theta  &=& '.$degree.'°\\\\
            \end{eqnarray}\\\\
        ';

        //空欄テキストの設定
        $blank_text = '\theta = \fbox{ア}° $$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //特別な角度の三角比
    public function unit103_q03($unit,$question){
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

        $sample_text = '
            0° \lt \theta \lt 180° より、\sin{\theta} \gt 0 なので\\\\
            \sin{\theta} = \sqrt{1-\frac{'.($a*$a).'}{'.($b*$b).'}} = '.fr_rt2(1,$b*$b-$a*$a,$b).'\\\\
            したがって、\\\\
            \sin (90°-\theta) = \cos{\theta} = '.f3($a,$b).'\\\\
            \cos (90°-\theta) = \sin{\theta} = '.fr_rt2(1,$b*$b-$a*$a,$b).'\\\\
            \sin (180°-\theta) = \sin{\theta} = '.fr_rt2(1,$b*$b-$a*$a,$b).'\\\\
            \cos (180°-\theta) = -\cos{\theta} = '.f3(-1*$a,$b).'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //正弦定理　その１
    public function unit103_q04($unit,$question){
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

        $sample_text = '
            三角形の内角の合計は180°なので、\\\\
            \angle{C} = 180° - (\angle{A}+\angle{B}) = '.$dC.'°\\\\
            正弦定理より、\\\\
            \begin{eqnarray}
                \frac{AC}{\sin{B}} &=& \frac{AB}{\sin{C}}\\\\
                                AC &=& \frac{AB}{\sin{C}} \cdot \sin{B}\\\\
                                   &=& \frac{'.$a.'}{'.text_sin($dC).'} \cdot '.text_sin($dB).'\\\\
                                   &=& '.fr_rt2($a*$c_d,$b_n*$c_n,$b_d*$c_n).'
            \end{eqnarray}\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //正弦定理　その２
    public function unit103_q05($unit,$question){
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

        $sample_text = '
            三角形の内角の合計は180°なので、\\\\
            \angle{C} = 180° - (\angle{A}+\angle{B}) = '.$dC.'°\\\\
            正弦定理より、\\\\
            \begin{eqnarray}
                2R &=& \frac{AB}{\sin{C}}\\\\[8pt]
                   &=& \frac{'.$a.'}{'.text_sin($dC).'}\\\\[8pt]
                   &=& '.fr_rt2($a*$c_d,$c_n,$c_n).'\\\\[8pt]
                R  &=& '.fr_rt2($a*$c_d,$c_n,2*$c_n).'\\\\
            \end{eqnarray}\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //余弦定理　その１
    public function unit103_q06($unit,$question){
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

        $sample_text = '
            余弦定理より、\\\\
            \begin{eqnarray}
                AC^{2} &=& AB^{2}+BC^{2}-2 \cdot AB \cdot BC \cdot \cos{B}\\\\[7pt]
                       &=& '.$a.'^{2}+'.$b.'^{2} -2\cdot'.$a.'\cdot'.$b.'\cdot '.f3($c,$d).'\\\\[7pt]
                       &=& '.f3($a*$a*$d + $b*$b*$d - 2*$a*$b*$c,$d).'\\\\[7pt]
            \end{eqnarray}\\\\[10pt]
            AC \gt 0 より、AC='.fr_rt2(1,$a*$a*$d*$d + $b*$b*$d*$d - 2*$a*$b*$c*$d,$d,$d).'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //余弦定理　その２
    public function unit103_q07($unit,$question){
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
        $text = '$$ △ABCにおいて、\\\\AB='.$a.'、BC='.$b.'、CA='.$c.'のとき、\\\\';

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

        $sample_text = '
            余弦定理より、\\\\
            \begin{eqnarray}
                \cos{B} &=& \frac{AB^{2}+BC^{2}-CA^{2}}{2 \cdot AB \cdot BC}\\\\[5pt]
                        &=& \frac{'.($a*$a).'+'.($b*$b).'-'.($c*$c).'}{2\cdot'.($a).'\cdot'.($b).'}\\\\[5pt]
                        &=& '.f3($a*$a+$b*$b-$c*$c,2*$a*$b).'\\\\[5pt]
            \end{eqnarray}\\\\[10pt]
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //三角形の面積
    public function unit103_q08($unit,$question){
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

        $sample_text = '
            余弦定理より、\\\\
            \cos{B} = \frac{AB^{2}+BC^{2}-CA^{2}}{2 \cdot AB \cdot BC} = '.f3($a*$a+$b*$b-$c*$c,2*$a*$b).'\\\\
            Bは三角形の内角であり、\\\\0° \lt B \lt 180°より、\sin{B} \gt 0なので、\\\\
            \sin{B} = \sqrt{1-\cos^{2}{B}} = '.fr_rt2(1,4*$a*$a*$b*$b-pow($a*$a+$b*$b-$c*$c,2),2*$a*$b).'\\\\
            よって、三角形の面積Sは、\\\\
            \begin{eqnarray}
                S &=& \frac{1}{2} \cdot AB \cdot BC \cdot \sin{B}\\\\[5pt]
                  &=& \frac{1}{2} \cdot '.$a.' \cdot '.$b.' \cdot '.fr_rt2(1,4*$a*$a*$b*$b-pow($a*$a+$b*$b-$c*$c,2),2*$a*$b).'\\\\[5pt]
                  &=& '.fr_rt2(1,4*$a*$a*$b*$b-pow($a*$a+$b*$b-$c*$c,2),4).'\\\\[5pt]
            \end{eqnarray}\\\\[10pt]
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //内接円の半径
    public function unit103_q09($unit,$question){
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

        $sample_text = '
            余弦定理より、\\\\
            \cos{B} = \frac{AB^{2}+BC^{2}-CA^{2}}{2 \cdot AB \cdot BC} = '.f3($a*$a+$b*$b-$c*$c,2*$a*$b).'\\\\
            Bは三角形の内角であり、\\\\0° \lt B \lt 180°より、\sin{B} \gt 0なので、\\\\
            \sin{B} = \sqrt{1-\cos^{2}{B}} = '.fr_rt2(1,4*$a*$a*$b*$b-pow($a*$a+$b*$b-$c*$c,2),2*$a*$b).'\\\\
            よって、三角形の面積Sは、\\\\
            \begin{eqnarray}
                S &=& \frac{1}{2} \cdot AB \cdot BC \cdot \sin{B}\\\\[5pt]
                &=& \frac{1}{2} \cdot '.$a.' \cdot '.$b.' \cdot '.fr_rt2(1,4*$a*$a*$b*$b-pow($a*$a+$b*$b-$c*$c,2),2*$a*$b).'\\\\[5pt]
                &=& '.fr_rt2(1,4*$a*$a*$b*$b-pow($a*$a+$b*$b-$c*$c,2),4).'\\\\[5pt]
            \end{eqnarray}\\\\[10pt]
            また、内接円の半径rを用いて三角形の面積Sを表すと、\\\\
            S = \frac{1}{2}r(AB+BC+CA) = '.f1($a+$b+$c,2,'r').'\\\\
            よって、\\\\
            '.f1($a+$b+$c,2,'r').' = '.fr_rt2(1,4*$a*$a*$b*$b-pow($a*$a+$b*$b-$c*$c,2),4).'\\\\
            r = '.fr_rt2(1,4*$a*$a*$b*$b-pow($a*$a+$b*$b-$c*$c,2),2*($a+$b+$c)).'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //データの分析(104)
    //代表値、範囲
    public function unit104_q01($unit,$question){
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

        $sample_text = '
            データを昇順に並び替えると、\\\\
            '.implode('　',$r_data).'\\\\
            よって、平均値は、\\\\
            \frac{'.implode('+',$r_data).'}{8} = '.$right_answers[0].'\\\\
            中央値は、\frac{'.$r_data[3].'+'.$r_data[4].'}{2} = '.$right_answers[1].'\\\\
            データの範囲は、'.$r_data[7].'-'.$r_data[0].' = '.$right_answers[2].'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/data',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //四分位数(と箱ひげ図)
    public function unit104_q02($unit,$question){
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

        $sample_text = '
            データを昇順に並び替えると、\\\\
            '.implode('　',$r_data).'\\\\
            よって、第1四分位数は、\frac{'.$r_data[1].'+'.$r_data[2].'}{2} = '.$right_answers[0].'\\\\
            第3四分位数は、\frac{'.$r_data[5].'+'.$r_data[6].'}{2} = '.$right_answers[1].'\\\\
            四分位範囲は、'.$right_answers[1].'-'.$right_answers[0].' = '.$right_answers[2].'\\\\
            四分位偏差は、は、\frac{'.$right_answers[2].'}{2} = '.$right_answers[3].'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/data',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //分散
    public function unit104_q03($unit,$question){
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

        $sample_text = '
            まず、データの平均をとると、\\\\
            \bar{x} = \frac{'.implode('+',$data).'}{5} = '.$ave.'\\\\
            また、データの2乗の平均を考える。\\\\
            データをすべて2乗すると、'.implode('　',$data_2).'\\\\
            これの平均をとると、\\\\
            \bar{x^{2}} = \frac{'.implode('+',$data_2).'}{5} = '.$ave_2.'\\\\
            よって、分散S_xは、\\\\
            \begin{eqnarray}
                S_x &=& \bar{x^{2}} - (\bar{x})^{2}\\\\
                    &=& '.$ave_2.' - '.$ave.'^{2}\\\\
                    &=& '.$s_2.'\\\\
            \end{eqnarray}\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/data',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //相関係数の読み取り
    public function unit104_q04($unit,$question){
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

        $sample_text = '
            一方の変量が増加すると、他方の変量も増加する傾向があれば正の相関、\\\\
            つまり、データが右上がりの直線に近いほど、正の相関が強い。\\\\
            一方の変量が増加すると、他方の変量は減少する傾向があれば負の相関、\\\\
            つまり、データが右下がりの直線に近いほど、負の相関が強い。\\\\
            今回のデータは、
            '.($right_answers[0]==4 ?
                '正の相関が強い傾向にあるので、\\\\
                相関係数は1に近い。'
            :
                '負の相関が強い傾向にあるので、\\\\
                相関係数は-1に近い。'
             ).'
        ';

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';
        $start = time();
        return view('question/data_select',compact('right_answers','unit','question','text','blank_text','blanks','start','canvas','script','options','sample_text'));

        //return view('question/data_select',compact('x','y','right_answer','unit','question','text','options','blanks'));
    }

    //数学Ⅱ
    //式と証明
    //二項定理
    public function unit201_q01($unit,$question){
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

        $sample_text = '
            二項定理より、x^{'.$c.'}y^{'.$d.'}の項は、\\\\
            {}_'.$b.' C_'.$c.' \cdot x^{'.$c.'} \cdot ('.d1($a,'y').')^{'.$d.'}
                = '.text_c($b,$c).' \cdot ('.$a.')^{'.$d.'} \cdot x^{'.$c.'}y^{'.$d.'}
                = '.d1($right_answers[0],'x^{'.$c.'}y^{'.$d.'}').'
        ';

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //整式の割り算
    public function unit201_q02($unit,$question){
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

        $sample_text = '
        \begin{array}{cccccc}
             & & x & '.d4($a-$d).' &  & \\\\
             \hline
            x^{2}'.d2($d,'x').d4($e).' & \large{)} & x^{3} & '.d2($a,'x^{2}').' & '.d2($b,'x').' & '.d4($c).'\\\\
             &  & x^{3} & '.d2($d,'x^{2}').' & '.d2($e,'x').' & \\\\
             \hline
             &  &  & '.d1($a-$d,'x^{2}').' & '.d2($b-$e,'x').' & '.d4($c).'\\\\
             '.($a-$d == 0 ?
                ''
                :
                '&  &  & '.d1($a-$d,'x^{2}').' & '.d2(($a-$d)*$d,'x').' & '.d4(($a-$d)*$e).'\\\\
                \hline
                &  &  & & '.d1($b-$e-$a*$d+$d*$d,'x').' & '.d4($c-$a*$e+$d*$e).'\\\\'
                ).'
        \end{array}\\\\
        よって、商はx'.d4($a-$d).'、余りは'.fo(d1($b-$e-$a*$d+$d*$d,'x').d4($c-$a*$e+$d*$e)).'
        ';

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //割り算の基本公式
    public function unit201_q03($unit,$question){
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
        $item[0] = '\alpha = '.($right_answers[0]<0?'-':'').'\fbox{ア}、';
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

        $sample_text = '
            割る式が1次式なので、余りは定数項になる。\\\\
            その余りをrとおくと、\\\\
            \begin{eqnarray}
                '.$a.'x^{3} + \alpha x^{2}+\alpha\beta x +\beta -1 &=& ('.d1($a,'x^{2}').d2($c,'x').d4($d).')(x'.d4($b).')+r\\\\
                                                                   &=& '.d1($a,'x^{3}').d2($a*$b+$c,'x^{2}').d2($b*$c+$d,'x').d4($b*$d).'+r
            \end{eqnarray}\\\\
            両辺を比較して、\\\\
            \alpha = '.($a*$b+$c).' \quad \alpha\beta = '.($b*$c+$d).' \quad \beta-1 = '.($b*$d).'+r\\\\
            これらを解いて、\\\\
            \alpha = '.($a*$b+$c).' \quad \beta = '.f3($b*$c+$d,$a*$b+$c).' \quad r = '.f3($b*$c + $d - $a*$b*$b*$d - $b*$c*$d - $a*$b - $c, $a*$b+$c).'\\\\
        ';

        $blank_text = fo(str_replace($option,$this->option,implode($item))).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //恒等式
    public function unit201_q04($unit,$question){
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

        $sample_text = '
            xについての恒等式となるとき、\\\\
            xに何を代入しても、この関係が成立するので、\\\\
            \begin{eqnarray}
                &x=2&を代入して、\quad &&'.d1($a,' \cdot 2^{3} ').d2($b,' \cdot 2^{2} ').d2($c,' \cdot 2').d4($d).'= 3\beta+\gamma\\\\
                &&                &&'.($a*2*2*2+$b*2*2+$c*2+$d).' = 3\beta+\gamma\\\\
                &x=-1&を代入して、\quad &&'.d1($a,' \cdot (-1)^{3} ').d2($b,' \cdot (-1)^{2} ').d2($c,' \cdot (-1)').d4($d).'= '.d1($a,' \cdot (-3)^{3} ').'+\alpha \cdot (-3)^2 +\gamma\\\\
                &&                &&'.(-1*$a+$b-$c+$d+27*$a).' = 9\alpha+\gamma\\\\
                &x=0&を代入して、\quad &&'.($d).'='.d1($a,' \cdot (-2)^{3}').'+\alpha \cdot (-2)^{2} +\beta+\gamma\\\\
                &&                &&'.($d+8*$a).' = 4\alpha+\beta+\gamma\\\\  
            \end{eqnarray}\\\\
            これら3つの式を連立して解くと、\\\\
            \begin{array}{rcl}
                \alpha & = & '.(6*$a+$b).'\\\\
                \beta  & = & '.(12*$a+4*$b+$c).'\\\\
                \gamma & = & '.(-28*$a-8*$b-$c+$d).'\\\\
            \end{array}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //相加平均、相乗平均の大小関係
    public function unit201_q05($unit,$question){
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

        $sample_text = '
            a \gt 0 より、\frac{'.$a.'}{a} \gt 0\\\\
            よって、相加平均と相乗平均の大小関係より、\\\\
            a+\frac{'.$a.'}{a} \geqq 2\sqrt{a \cdot \frac{'.$a.'}{a}} = '.rt2(2,$a).'\\\\
            よって、a+\frac{'.$a.'}{a}の最小値は'.rt2(2,$a).'\\\\
            上式の等号が成立するのは、a=\frac{'.$a.'}{a}のときなので、\\\\
            \begin{eqnarray}
            a &=& \frac{'.$a.'}{a}\\\\
            a^{2} &=& '.($a).'
            \end{eqnarray}\\\\
            a>0より、a='.rt2(1,$a).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //複素数と方程式(202)
    //複素数の基本
    public function unit202_q01($unit,$question){
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
        
        $sample_text = '
            与式を変形し、実部と虚部に分けると、\\\\
            ('.d1($a,'x').d2($c,'y').d4($e).') + ('.d1($b,'x').d2($d,'y').d4($f).')i = 0\\\\
            よって、\\\\
            '.d1($a,'x').d2($c,'y').d4($e).' = 0, \quad '.d1($b,'x').d2($d,'y').d4($f).'=0\\\\
            これを解いて、\\\\
            x = '.f3($c*$f-$d*$e,$a*$d-$b*$c).', \quad y='.f3($b*$e-$a*$f,$a*$d-$b*$c).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //虚数解をもつ条件
    public function unit202_q02($unit,$question){
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

        list($s,$t) = root(1,$b*$b+$c);

        $sample_text = '
            判別式をDとおくと、\\\\
            D=a^{2}-4('.d1($b,'a').d4($c).') = a^{2}'.d2(-4*$b,'a').d4(-4*$c).'\\\\
            異なる2つの虚数解をもつとき、D \lt 0 より、\\\\
            a^{2}'.d2(-4*$b,'a').d4(-4*$c).' \lt 0\\\\
            a^{2}'.d2(-4*$b,'a').d4(-4*$c).'=0とすると、\\\\
            '.($t==1 ?'
                \begin{eqnarray}
                    (a'.d4(-2*$b+2*sqrt($b*$b+$c)).')(a'.d4(-2*$b-2*sqrt($b*$b+$c)).') &=& 0\\\\
                       a &=& '.(2*$b-2*sqrt($b*$b+$c)).', \quad '.(2*$b+2*sqrt($b*$b+$c)).'
                \end{eqnarray}\\\\
            ':'
                \begin{eqnarray}
                    a &=& '.(2*$b).'\pm \sqrt{('.(2*$b).')^{2}-1 \cdot ('.(-4*$c).')}\\\\
                    &=& '.(2*$b).'\pm \sqrt{'.(4*$b*$b+4*$c).'}\\\\
                    &=& '.(2*$b).'\pm '.rt2(2,$b*$b+$c).'
                \end{eqnarray}\\\\
            ').'
            
            よって、これを満たすaの範囲は、\\\\
            '.fr_rt(2*$b,-2,$b*$b+$c,1).'\lt a \lt '.fr_rt(2*$b,2,$b*$b+$c,1).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //解と係数の関係　その１
    public function unit202_q03($unit,$question){
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

        $sample_text = '
            解と係数の関係より、\\\\
            \alpha + \beta = '.f3(-1*$b,$a).'、\alpha\beta = '.f3($c,$a).'\\\\
            また、\\\\
            \begin{eqnarray}
                \alpha^{2}+\beta^{2} &=& (\alpha+\beta)^{2}-2\alpha\beta\\\\
                                     &=& ('.f3(-1*$b,$a).')^{2}-2 \cdot ('.f3($c,$a).')\\\\
                                     &=& '.f3($b*$b-2*$a*$c,$a*$a).'\\\\
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //解と係数の関係　その２
    public function unit202_q04($unit,$question){
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

        $sample_text = '
            ('.$a.d2($b,'i').')+('.$a.d2(-1*$b,'i').') = '.(2*$a).'\\\\
            ('.$a.d2($b,'i').') \cdot ('.$a.d2(-1*$b,'i').') = '.($a*$a+$b*$b).'\\\\
            よって、解と係数の関係より、\\\\この２つを解に持つ２次方程式の一つは、\\\\
            x^{2}'.d2(-2*$a,'x').d4($a*$a+$b*$b).'=0
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //剰余の定理
    public function unit202_q05($unit,$question){
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

        $sample_text = '
            '.d1($a,'x^{3}').d2($b,'x^{2}').d2($c,'x').d3($d).'をx'.d4(-1*$e).'で割ったときの\\\\
            商をQ(x)、余りをrとおくと、\\\\
            '.d1($a,'x^{3}').d2($b,'x^{2}').d2($c,'x').d3($d).' = Q(x)(x'.d4(-1*$e).')+r\\\\
            これは、xについての恒等式となるため、x='.$e.'を代入して、\\\\
            \begin{eqnarray}
                r &=& '.d1($a,'\cdot').'('.$e.')^{3}'.d2($b,'\cdot').'('.$e.')^{2}'.d2($c,'\cdot').'('.$e.')'.d4($d).'\\\\
                  &=& '.$right_answers[0].'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }
    
    //因数定理
    public function unit202_q06($unit,$question){
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

        $sample_text = '
            '.d1($a,'x^{3}').'+ax^{2}'.d2($b,'(a-2)x').d4($c).'\\ を\\  x'.d4(-1*$d).'で\\\\
            割ったときの商をQ(x)とおくと、\\\\
            '.d1($a,'x^{3}').'+ax^{2}'.d2($b,'(a-2)x').d4($c).'=Q(x)(x'.d4(-1*$d).')\\\\
            これは、xについての恒等式となるため、x='.$d.'を代入して、\\\\
            \begin{eqnarray}
                '.d1($a,'\cdot').'('.$d.')^{3}+\alpha \cdot ('.$d.')^{2}'.d2($b,'(\alpha-2)').'\cdot('.$d.')'.d4($c).' &=& 0\\\\
                '.d1($d*$d+$b*$d,'\alpha').' &=& '.d3(-1*$a*$d*$d*$d+2*$b*$d-$c).'\\\\
                \alpha &=& '.f3(-1*$a*$d*$d*$d+2*$b*$d-$c,$d*$d+$b*$d).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //３次方程式
    public function unit202_q07($unit,$question){
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

                $r = $right_answers;

                //答えの設定
                $a = -1*($right_answers[0]+$right_answers[1]+$right_answers[2]);
                $b = $right_answers[0]*$right_answers[1] + $right_answers[1]*$right_answers[2] + $right_answers[2]*$right_answers[0];
                $c = -1*$right_answers[0]*$right_answers[1]*$right_answers[2];

                //空欄テキストの設定
                $item[0] = 'x='.($right_answers[0]<0?'-':'').'\fbox{ア}、';
                $item[1] = ($right_answers[1]<0?'-':'').'\fbox{イ}、';
                $item[2] = ($right_answers[2]<0?'-':'').'\fbox{ウ} \\\\';
                $item[3] = 'ただし、'.($right_answers[0]<0?'-':'').'\fbox{ア} \lt '.($right_answers[1]<0?'-':'').'\fbox{イ} \lt '.($right_answers[2]<0?'-':'').'\fbox{ウ}';

                $sample_text = '
                    f(x) = x^{3}'.d2($a,'x^{2}').d2($b,'x').($c==0?'':d3($c)).'とすると、\\\\
                    f('.$r[0].')=0より、f(x)はx'.d4(-1*$r[0]).'を因数に持ち、\\\\
                    \begin{array}{|cccccc|}
                        \hline
                        & 1 & '.$a.' & '.$b.' & '.d4($c).' & |'.$r[0].'\\\\
                        +)  & & '.$r[0].' & '.(-1*$r[0]*$r[1]-$r[0]*$r[2]).' & '.d4(-1*$c).' &\\\\
                        \hline
                        & 1 & '.(-1*$r[1]-$r[2]).' & '.($r[1]*$r[2]).' & 0 & \\\\
                        \hline
                    \end{array}\\\\
                    \begin{eqnarray}
                        (x'.d4(-1*$r[0]).')(x^{2}'.d2(-1*$r[1]-$r[2],'x').d4($r[1]*$r[2]).') &=& 0\\\\
                        (x'.d4(-1*$r[0]).')(x'.d4(-1*$r[1]).')(x'.d4(-1*$r[2]).') &=& 0\\\\
                        x &=& '.$r[0].',\quad'.$r[1].',\quad'.$r[2].'
                    \end{eqnarray}
                ';
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

                $sample_text = '
                    f(x) = x^{3}'.d2($a,'x^{2}').d2($b,'x').($c==0?'':d3($c)).'とすると、\\\\
                    f('.($a_c).')=0より、f(x)はx'.d4(-1*$a_c).'を因数に持ち、\\\\
                    \begin{array}{|cccccc|}
                        \hline
                        & 1 & '.$a.' & '.$b.' & '.$c.' & |'.$a_c.'\\\\
                        +)  & & '.$a_c.' & '.($a_c*$b_c).' & '.(-1*$c).' &\\\\
                        \hline
                        & 1 & '.($b_c).' & '.($c_c).' & 0 & \\\\
                        \hline
                    \end{array}\\\\
                    \begin{eqnarray}
                        (x'.d4(-1*$a_c).')(x^{2}'.d2($b_c,'x').d4($c_c).') &=& 0\\\\
                        x &=& '.$a_c.',\quad '.quadratic(1,$b_c,$c_c).'
                    \end{eqnarray}
                ';

                break;
        }

        //問題テキストの設定
        $text = '$$ ３次方程式\\ x^{3}'.d2($a,'x^{2}').d2($b,'x').($c==0?'':d3($c)).'=0\\ の解は、\\\\';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //図形と方程式(203)
    //内分点・外分点の座標
    public function unit203_q01($unit,$question){
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
                $sample_text = '
                    (\frac{'.$a.'\cdot'.$f.'+'.$c.'\cdot'.$e.'}{'.$e.'+'.$f.'}, \frac{'.$b.'\cdot'.$f.'+'.$d.'\cdot'.$e.'}{'.$e.'+'.$f.'})
                        = ('.f3($a*$f + $c*$e,$e+$f).','.f3($b*$f + $d*$e,$e+$f).')
                ';
                break;
            case 2:
                $text .= '外分する点の座標は、\\\\';
                $sample_text = '
                    (\frac{'.$a.'\cdot-'.$f.'+'.$c.'\cdot'.$e.'}{'.$e.'+'.$f.'}, \frac{'.$b.'\cdot-'.$f.'+'.$d.'\cdot'.$e.'}{'.$e.'+'.$f.'})
                        = ('.f3(-1*$a*$f + $c*$e,$e-$f).','.f3(-1*$b*$f + $d*$e,$e-$f).')
                ';
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
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //重心の座標
    public function unit203_q02($unit,$question){
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

        $sample_text = '
            ( \frac{('.$a.')+('.$c.')+('.$e.')}{3}, \frac{('.$b.')+('.$d.')+('.$f.')}{3}) 
                = ( '.f3($a+$c+$e,3).', '.f3($b+$d+$f,3).')
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //直線の方程式
    public function unit203_q03($unit,$question){
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
        $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ}';
        $item[3] = '=0 \\\\';
        $item[4] = 'm:\fbox{エ}x';
        $item[5] = ($right_answers[4]<0?'-':'+').'\fbox{オ}y';
        $item[6] = ($right_answers[5]<0?'-':'+').'\fbox{カ}';
        $item[7] = '=0 \\\\';

        $sample_text = '
            A,Bを通る直線の傾きは、\\\\
            \frac{('.$d.')-('.$b.')}{('.$c.')-('.$a.')} = '.f3($d-$b,$c-$a).'\\\\
            これが、A('.$a.','.$b.')を通るので、\\\\
            y'.d4(-1*$b).' = '.f3($d-$b,$c-$a).'(x'.d4(-1*$a).')\\\\
            '.d1($right_answers[0],'x').d2($right_answers[1],'y').d4($right_answers[2]).'=0\\\\
            \\\\
            A,Bの中点は、( \frac{('.$a.')+('.$c.')}{2}, \frac{('.$b.')+('.$d.')}{2}) = ( '.f3($a+$c,2).', '.f3($b+$d,2).')\\\\
            また、直線ABに垂直な傾きは、'.f3($a-$c,$d-$b).'\\\\
            よって、線分ABの垂直二等分線は、\\\\
            ( '.f3($a+$c,2).', '.f3($b+$d,2).')を通る傾き'.f3($a-$c,$d-$b).'の直線なので、\\\\
            y'.f2($b+$d,-2).' = '.f3($a-$c,$d-$b).'(x'.f2($a+$c,-2).')\\\\
            '.d1($right_answers[3],'x').d2($right_answers[4],'y').d4($right_answers[5]).'=0\\\\
        ';

        if($right_answers[2]==0){
            unset($right_answers[2]);
            unset($option[2]);
            unset($item[2]);
            $blanks -= 1;
        }
        if($right_answers[5]==0){
            unset($right_answers[5]);
            unset($option[5]);
            unset($item[6]);
            $blanks -= 1;
        }
        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //対称な点
    public function unit203_q04($unit,$question){
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
        $text = '$$ A('.$a.','.$b.')\\ と、直線\\ '.d1($c,'x').d2($d,'y').d3($e).'=0 \\\\ に関して対称な点の座標は、\\\\';

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

        $sample_text = '
            対称な点をP(x,y)とおくと、\\\\
            ('.$a.','.$b.')と(x,y)の中点は、直線上にあるので、\\\\
            (\frac{'.$a.'+x}{2}, \frac{'.$b.'+y}{2})は直線上にあり、\\\\
            \frac{'.$a.'+x}{2} \cdot '.$c.'+\frac{'.$b.'+y}{2} '.d4($e).'=0\\\\
            '.d1($c,'x').d2($d,'y').d4($a*$c+$b*$d+2*$e).'=0 \cdots ①\\\\
            また、APと直線'.d1($c,'x').d2($d,'y').d3($e).'=0\\ は垂直なので、\\\\
            '.f3(-1*$c,$d).'\cdot \frac{y'.d4(-1*$b).'}{x'.d4(-1*$a).'} = -1\\\\
            '.d1($d,'x').d2(-1*$c,'y').d4($b*$c-$a*$d).'=0 \cdots ②\\\\
            ①、②を解いて、
            x = '.f3(-1*($a*$c*$c + 2*$b*$c*$d + 2*$c*$e - $a*$d*$d),$c*$c + $d*$d).'\quad y = '.f3(-1*($a*$c*$d + $b*$d*$d + 2*$d*$e - $b*$c*$c + $a*$c*$d),$c*$c + $d*$d).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //点と直線の距離
    public function unit203_q05($unit,$question){
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

        $sample_text = '
            直線'.d1($a,'x').d2($b,'y').d3($c).'=0 \\ と点\\ ('.$d.','.$e.')との距離は\\\\
            \frac{|'.$a.'\cdot'.$d.d2($b,'\cdot'.$e).d3($c).'|}{\sqrt{('.$d.')^{2}+('.$e.')^{2}}} = '.fr_rt2(abs($a*$d+$b*$e+$c),$a*$a+$b*$b,$a*$a+$b*$b).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //円の方程式　その１
    public function unit203_q06($unit,$question){
        //初期設定
        $question_id = 20306;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(-5,5);
        $b = rand(-5,5);
        do { $c = rand(-5,5); } while( $a*$a+$b*$b-$c <= 0);

        //答えの設定
        $right_answers[0] = 1;
        $right_answers[1] = $a*$a+$b*$b-$c;
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

        $sample_text = '
            \begin{eqnarray}
                x^{2}+y^{2}'.d2(2*$a,'x').d2(2*$b,'y').d4($c).' &=& 0\\\\
                x^{2}'.d2(2*$a,'x').'+y^{2}'.d2(2*$b,'y').d4($c).' &=& 0\\\\
                (x'.d4($a).')^{2}'.d4(-1*$a*$a).'+(y'.d4($b).')^{2}'.d4(-1*$b*$b).d4($c).' &=& 0\\\\
                (x'.d4($a).')^{2}+(y'.d4($b).')^{2} &=& '.($a*$a+$b*$b-$c).'\\\\
            \end{eqnarray}\\\\
            これは半径'.fo(rt(1,$a*$a+$b*$b-$c)).'、中心('.(-1*$a).','.(-1*$b).')の円を表す
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //円の方程式　その２
    public function unit203_q07($unit,$question){
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

        $sample_text = '
            求める円の中心は、線分ABの中点なので、\\\\
            (\frac{'.$a.d3($c).'}{2},\frac{'.$b.d3($d).'}{2}) = ('.f3($a+$c,2).','.f3($b+$d,2).')\\\\
            また、直径の長さは、線分ABの長さなので、\\\\
            \sqrt{('.$c.d3(-1*$a).')^{2}+('.$d.d3(-1*$b).')^{2}} = '.fo(rt(1,($c-$a)*($c-$a)+($d-$b)*($d-$b))).'\\\\
            よって、半径の長さは、'.fr_rt2(1,($c-$a)*($c-$a)+($d-$b)*($d-$b),2).'\\\\
            したがって、求める円の方程式は、\\\\
            (x'.f2($a+$c,-2).')^{2}+(y'.f2($b+$d,-2).')^{2} = '.f3(($c-$a)*($c-$a)+($d-$b)*($d-$b),4).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //円の接線
    public function unit203_q08($unit,$question){
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

        $sample_text = '
            接するとき、直線と円の中心間の距離の長さが\\\\
            円の半径と等しくなるので、\\\\
            y='.d1($c,'x').d4($d).'を変形して、\\\\
            '.d1($c,'x').'-y'.d4($d).'=0 \quad とすると、\\\\
            点と直線の距離の公式より、半径rは、\\\\
            r = \frac{|'.$c.'\cdot '.$a.d4(-1*$b).d4($d).'|}{\sqrt{('.$c.')^{2}+(-1)^{2}}} = '.fr_rt2(abs($c*$a-$b+$d),$c*$c+1,$c*$c+1).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //弧度法
    public function unit204_q01($unit,$question){
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

        $table = '
            \begin{array}{|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|c|}
                \hline
                \theta & 0 & \frac{\pi}{6} & \frac{\pi}{4} & \frac{\pi}{3} & \frac{\pi}{2} & \frac{2}{3}\pi & \frac{3}{4}\pi & \frac{5}{6}\pi & \pi & \frac{7}{6}\pi & \frac{5}{4}\pi & \frac{4}{3}\pi & \frac{3}{2}\pi & \frac{5}{3}\pi & \frac{7}{4}\pi & \frac{11}{6}\pi\\\\
                \hline
                \sin{\theta} & 0 & \frac{1}{2} & \frac{1}{\sqrt{2}} & \frac{\sqrt{3}}{2} & 1 & \frac{\sqrt{3}}{2} & \frac{1}{\sqrt{2}} & \frac{1}{2} & 0 & -\frac{1}{2} & -\frac{1}{\sqrt{2}} & -\frac{\sqrt{3}}{2} & -1 & -\frac{\sqrt{3}}{2} & -\frac{1}{\sqrt{2}} & -\frac{1}{2}\\\\
                \hdashline
                \cos{\theta} & 1 & \frac{\sqrt{3}}{2} & \frac{1}{\sqrt{2}} & \frac{1}{2} & 0 & -\frac{1}{2} & -\frac{1}{\sqrt{2}} & -\frac{\sqrt{3}}{2} & -1 & -\frac{\sqrt{3}}{2} & -\frac{1}{\sqrt{2}} & -\frac{1}{2} & 0 & \frac{1}{2} & \frac{1}{\sqrt{2}} & \frac{\sqrt{3}}{2}\\\\
                \hdashline
                \tan{\theta} & 0 & \frac{1}{\sqrt{3}} & 1 & \sqrt{3} & × & -\sqrt{3} & -1 & -\frac{1}{\sqrt{3}} & 0 & \frac{1}{\sqrt{3}} & 1 & \sqrt{3} & × & -\sqrt{3} & -1 & -\frac{1}{\sqrt{3}}\\\\
                \hline
            \end{array}
        ';

        $x = $a; $y = $b;
        $count = 0;
        while($x/$y < 0){
            $x += 2*$y;
            $count += 1;
            $flag = 1;
        }
        while($x/$y >= 2){
            $x -= 2*$y;
            $count -= 1;
            $flag = 1;
        }

        if(isset($flag)){
            $sample_text = '
                \begin{eqnarray}
                    \sin({'.fo(f2($a,$b,'\pi')).'}) &=& \sin('.fo(f2($a,$b,'\pi')).d2(2*$count,'\pi').')\\\\
                                            &=& \sin({'.fo(f2($x,$y,'\pi')).'})\\\\
                    \cos({'.fo(f2($a,$b,'\pi')).'}) &=& \cos('.fo(f2($a,$b,'\pi')).d2(2*$count,'\pi').')\\\\
                                            &=& \cos({'.fo(f2($x,$y,'\pi')).'})
                \end{eqnarray}\\\\
            '.$table;
        }else{
            $sample_text = $table;
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //三角関数のグラフ
    public function unit204_q02($unit,$question){
        //初期設定
        $question_id = 20402;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(2,4);
        do { $b = rand(-5,5); } while( $b==0 );
        do { $c = rand(-5,5); } while( $c==0 );
        do { $d = rand(-2,2); } while( $d==0 );
        list($b,$c) = gcd($b,$c);

        //答えの計算
        $right_answers[0] = -1*$a*$b;
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

        $sample_text = '
            y=2\sin{(\frac{x}{'.$a.'}'.f2($b,$c,'\pi').')}'.d3($d).'=2\sin{\frac{1}{'.$a.'}(x'.f2($a*$b,$c,'\pi').')'.d3($d).'}\\\\
            したがって、このグラフは、y=2\sin{\frac{x}{'.$a.'}}のグラフを\\\\
            x軸方向に'.f1(-1*$a*$b,$c,'\pi').'、y軸方向に'.$d.'だけ移動させたものである。\\\\
            周期は\\ y=2\sin{\frac{x}{'.$a.'}}と同様で、'.d1(2*$a,'\pi').'\\\\
        ';

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-1,'.(2+$d>3?3+$d:3).',7*'.$a.','.(-2+$d<-3?-3+$d:-3).'],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return 2*Math.sin(t/'.$a.');
                }
                function bezier2(t) {
                    return 2*Math.sin((t+'.($a*$b/$c).'*Math.PI)/'.$a.')+'.$d.';
                }
                board.create(\'functiongraph\', [bezier,-100,100],{dash:1});
                board.create(\'functiongraph\', [bezier2,-100,100]);
                board.create(\'line\',[['.$a.'*Math.PI/2,2],['.(($a*($c-2*$b)*pi())/(2*$c)).',2]], {straightFirst:false, straightLast:false, lastArrow:true, strokeColor:"red",strokeWidth:1});
                board.create(\'line\',[['.(($a*($c-2*$b)*pi())/(2*$c)).',2],['.(($a*($c-2*$b)*pi())/(2*$c)).',2+'.$d.']], {straightFirst:false, straightLast:false, lastArrow:true, strokeColor:"red",strokeWidth:1});
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //加法定理
    public function unit204_q03($unit,$question){
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

        $sample_text = '
            0 \lt \alpha \lt \frac{\pi}{2} \\ と \\ \sin{\alpha}=\frac{'.$a.'}{'.$b.'}より、\\\\
            \cos{\alpha} = \sqrt{1-(\frac{'.$a.'}{'.$b.'})^2} = '.fr_rt2(1,$b*$b-$a*$a,$b).'\\\\
            0 \lt \beta \lt \frac{2}{\pi} \\ と \\ \cos{\beta}=\frac{'.$c.'}{'.$d.'}より、\\\\
            \sin{\beta} = \sqrt{1-(\frac{'.$c.'}{'.$d.'})^2} = '.fr_rt2(1,$d*$d-$c*$c,$d).'\\\\

            よって、\\\\
            \begin{eqnarray}
                \sin{(\alpha+\beta)} &=& \sin{\alpha}\cos{\beta} + \cos{\alpha}\sin{\beta}\\\\
                                     &=& '.f3($a,$b).'\cdot'.f3($c,$d).'+'.fr_rt2(1,$d*$d-$c*$c,$d).'\cdot'.fr_rt2(1,$b*$b-$a*$a,$b).'\\\\
                                     &=& '.fr_rt($a*$c,1,($b*$b-$a*$a)*($d*$d-$c*$c),$b*$d).'\\\\
                \cos{(\alpha+\beta)} &=& \cos{\alpha}\cos{\beta} - \sin{\alpha}\sin{\beta}\\\\
                                     &=& '.fr_rt2(1,$b*$b-$a*$a,$b).'\cdot'.f3($c,$d).'-'.f3($a,$b).'\cdot'.fr_rt2(1,$d*$d-$c*$c,$d).'\\\\
                                     &=& '.fr_rt4($c,$b*$b-$a*$a,-1*$a,$d*$d-$c*$c,$b*$d).'\\\\
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //2倍角の公式
    public function unit204_q04($unit,$question){
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

        $sample_text = '
            0 \lt \alpha \lt \frac{\pi}{2} \\ と \\ \sin{\alpha}=\frac{'.$a.'}{'.$b.'}より、\\\\
            \cos{\alpha} = \sqrt{1-(\frac{'.$a.'}{'.$b.'})^2} = '.fr_rt2(1,$b*$b-$a*$a,$b).'\\\\
            よって、\\\\
            \begin{eqnarray}
                \sin{2\alpha} &=& 2\sin{\alpha}\cos{\alpha}\\\\
                              &=& 2 \cdot '.f3($a,$b).'\cdot '.fr_rt2(1,$b*$b-$a*$a,$b).'\\\\
                              &=& '.fr_rt2(2*$a,$b*$b-$a*$a,$b*$b).'\\\\
                \cos{2\alpha} &=& 1-2\sin^2{\alpha}\\\\
                              &=& 1-2\cdot('.f3($a,$b).')^2\\\\
                              &=& '.f3($b*$b-2*$a*$a,$b*$b).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //三角不等式　その１
    public function unit204_q05($unit,$question){
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

        $theta = $nu[$n]/$de[$n]*pi();

        $sample_text = '下図より、不等式の満たす範囲は、\\\\';
        switch($pattern){
            case 1:
                if($n < 3){
                    $sample_text .= f1($nu[$n],$de[$n],'\pi').'\leqq \theta \leqq'.f1($de[$n]-$nu[$n],$de[$n],'\pi');
                }else{
                    $sample_text .= '0 \leqq \theta \leqq'.f1($nu[$n],$de[$n],'\pi').'、'.f1(3*$de[$n]-$nu[$n],$de[$n],'\pi').'\leqq \theta \lt 2\pi';
                }
                break;
            case 2:
                $sample_text .= f1($nu[$n],$de[$n],'\pi').'\lt \theta \lt'.f1(2*$de[$n]-$nu[$n],$de[$n],'\pi');
                break;
        }


        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-2,1.4,2,-1.4],
                    axis: true,
                    showNavigation: false,
                    showCopyright: false
                });
                function bezier(t) {
                    return -1*Math.sqrt(1-Math.pow(t,2));
                }
                function bezier2(t) {
                    return Math.sqrt(1-Math.pow(t,2));
                }
                board.create(\'functiongraph\', [bezier,-1,1]);
                board.create(\'functiongraph\', [bezier2,-1,1]);
        ';

        switch($pattern){
            case 1:
                $plot .= '
                        var p1 = board.create(\'point\',[Math.cos('.$theta.'),Math.sin('.$theta.')],{name:\'\',size:0,fixed:true});
                        var p2 = board.create(\'point\',[-1*Math.cos('.$theta.'),Math.sin('.$theta.')],{name:\'\',size:0,fixed:true});
                        var o = board.create(\'point\',[0,0],{name:\'\',size:0,fixed:true});
                        var r = board.create(\'point\',[1,0],{name:\'\',size:0,fixed:true});
                        board.create(\'line\',[p1,[0,0]],{straightFirst:false, straightLast:false,fixed:true});
                        board.create(\'line\',[p2,[0,0]],{straightFirst:false, straightLast:false,fixed:true});
                        board.create(\'line\',[p1,p2],{dash:2,fixed:true});
                        board.create(\'angle\',[r,o,p1],{name:\'\'});
                        board.create(\'angle\',[r,o,p2],{name:\'\', radius:0.5});
                        '.($n<3
                            ?'board.create(\'functiongraph\', [bezier2,-1*Math.cos('.$theta.'),Math.cos('.$theta.')],{strokecolor:\'red\',strokeWidth:2});'
                            :'board.create(\'functiongraph\', [bezier2,-1,1],{strokecolor:\'red\',strokeWidth:2});
                              board.create(\'functiongraph\', [bezier,-1,Math.cos('.$theta.')],{strokecolor:\'red\',strokeWidth:2});
                              board.create(\'functiongraph\', [bezier,-1*Math.cos('.$theta.'),1],{strokecolor:\'red\',strokeWidth:2});').'
                    </script>
                ';
                break;
            case 2:
                $plot .= '
                        var p1 = board.create(\'point\',[Math.cos('.$theta.'),Math.sin('.$theta.')],{name:\'\',size:0,fixed:true});
                        var p2 = board.create(\'point\',[Math.cos('.$theta.'),-1*Math.sin('.$theta.')],{name:\'\',size:0,fixed:true});
                        var o = board.create(\'point\',[0,0],{name:\'\',size:0,fixed:true});
                        var r = board.create(\'point\',[1,0],{name:\'\',size:0,fixed:true});
                        board.create(\'line\',[p1,[0,0]],{straightFirst:false, straightLast:false,fixed:true});
                        board.create(\'line\',[p2,[0,0]],{straightFirst:false, straightLast:false,fixed:true});
                        board.create(\'line\',[p1,p2],{dash:2,fixed:true});
                        board.create(\'angle\',[r,o,p1],{name:\'\'});
                        board.create(\'angle\',[r,o,p2],{name:\'\', radius:0.5});
                        board.create(\'functiongraph\', [bezier2,-1,Math.cos('.$theta.')],{strokecolor:\'red\',strokeWidth:2});
                        board.create(\'functiongraph\', [bezier,-1,Math.cos('.$theta.')],{strokecolor:\'red\',strokeWidth:2});
                    </script>
                ';
                break;
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //三角不等式　その２
    public function unit204_q06($unit,$question){
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

        $angle = $theta[0]/$theta[1]*pi();

        $sample_text = '
            \begin{eqnarray}
                '.d1($a,'\sin^2{\theta}').d2(-1*($a*$c+$b),'\cos{\theta}').d3(-1*($a+$b*$c)).' &\gt& 0\\\\
                '.d1($a,'(1-\cos^2{\theta})').d2(-1*($a*$c+$b),'\cos{\theta}').d3(-1*($a+$b*$c)).' &\gt& 0\\\\
                '.d1($a,'\cos{\theta}').d2($a*$c+$b,'\cos{\theta}').d3($b*$c).' &\lt& 0\\\\
                ('.d1($a,'\cos{\theta}').d3($b).')(\cos{\theta}'.d3($c).')&\lt& 0\\\\
            \end{eqnarray}\\\\
        ';
        if($c > 0){
           $sample_text .= '
                -1 \leqq \cos{\theta} \leqq 1 \quad より、\\\\
                (\cos{\theta}'.d3($c).') \gt 0 \quad なので、\\\\
                '.d1($a,'\cos{\theta}').d3($b).' \lt 0\\\\
                \cos{\theta} \lt '.f3(-1*$b,$a).'\\\\
                下図より、'.f1($theta[0],$theta[1],'\pi').' \lt \theta \lt '.f1(2*$theta[1]-$theta[0],$theta[1],'\pi').'
           ';
        }else{
            $sample_text .= '
                -1 \leqq \cos{\theta} \leqq 1 \quad より、\\\\
                (\cos{\theta}'.d3($c).') \lt 0 \quad なので、\\\\
                '.d1($a,'\cos{\theta}').d3($b).' \gt 0\\\\
                \cos{\theta} \gt '.f3(-1*$b,$a).'\\\\
                下図より、\\\\
                0 \leqq \theta \lt '.f1($theta[0],$theta[1],'\pi').'、'.f1(2*$theta[1]-$theta[0],$theta[1],'\pi').' \lt \theta \lt 2\pi
           ';
        }

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-2,1.4,2,-1.4],
                    axis: true,
                    showNavigation: false,
                    showCopyright: false
                });
                function bezier(t) {
                    return -1*Math.sqrt(1-Math.pow(t,2));
                }
                function bezier2(t) {
                    return Math.sqrt(1-Math.pow(t,2));
                }
                board.create(\'functiongraph\', [bezier,-1,1]);
                board.create(\'functiongraph\', [bezier2,-1,1]);
                var p1 = board.create(\'point\',[Math.cos('.$angle.'),Math.sin('.$angle.')],{name:\'\',size:0,fixed:true});
                var p2 = board.create(\'point\',[Math.cos('.$angle.'),-1*Math.sin('.$angle.')],{name:\'\',size:0,fixed:true});
                var o = board.create(\'point\',[0,0],{name:\'\',size:0,fixed:true});
                var r = board.create(\'point\',[1,0],{name:\'\',size:0,fixed:true});
                board.create(\'line\',[p1,[0,0]],{straightFirst:false, straightLast:false,fixed:true});
                board.create(\'line\',[p2,[0,0]],{straightFirst:false, straightLast:false,fixed:true});
                board.create(\'line\',[p1,p2],{dash:2,fixed:true});
                board.create(\'angle\',[r,o,p1],{name:\'\'});
                board.create(\'angle\',[r,o,p2],{name:\'\', radius:0.5});
        ';

        if($c>0){
            $plot .= '
                    board.create(\'functiongraph\', [bezier2,-1,Math.cos('.$angle.')],{strokecolor:\'red\',strokeWidth:2});
                    board.create(\'functiongraph\', [bezier,-1,Math.cos('.$angle.')],{strokecolor:\'red\',strokeWidth:2});
                </script>
            ';
        }else{
            $plot .= '
                    board.create(\'functiongraph\', [bezier2,Math.cos('.$angle.'),1],{strokecolor:\'red\',strokeWidth:2});
                    board.create(\'functiongraph\', [bezier,Math.cos('.$angle.'),1],{strokecolor:\'red\',strokeWidth:2});
                </script>
            ';
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //半角の公式
    public function unit204_q07($unit,$question){
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

        $sample_text = '
            半角の公式より、\\\\
            \sin^2{\frac{\theta}{2}} = \frac{1-\cos{\theta}}{2} = '.f3($b-$a,2*$b).'\\\\
            0 \lt \theta \lt \pi \quad から、0 \lt \frac{\theta}{2} \lt \frac{\pi}{2} \quad なので、\\\\
            \sin{\frac{\theta}{2}} \gt 0 \\\\
            よって、\sin{\frac{\theta}{2}} = \sqrt{'.f3($b-$a,2*$b).'} = '.fr_rt2(1,2*$b*($b-$a),2*$b).'\\\\
            同様に半角の公式より、\\\\
            \cos^2{\frac{\theta}{2}} = \frac{1+\cos{\theta}}{2} = '.f3($b+$a,2*$b).'\\\\
            0 \lt \theta \lt \pi \quad から、0 \lt \frac{\theta}{2} \lt \frac{\pi}{2} \quad なので、\\\\
            \cos{\frac{\theta}{2}} \gt 0 \\\\
            よって、\cos{\frac{\theta}{2}} = \sqrt{'.f3($b+$a,2*$b).'} = '.fr_rt2(1,2*$b*($b+$a),2*$b).'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //三角関数の合成
    public function unit204_q08($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                f(\theta) &=& '.d1($a,'\sin{\theta}').($rad[$pattern]<0?'-':'+').d1($a).($b[$pattern]==1?'':'\sqrt{'.$b[$pattern].'}').'\cos{\theta}\\\\
                          &=& '.rt2(1,$a*$a + $a*$a*$b[$pattern]).'\{\sin{(\theta'.f2(1,$rad[$pattern],'\pi').')}\}\\\\
            \end{eqnarray}\\\\
            よって、f(\theta)は、
            \theta'.f2(1,$rad[$pattern],'\pi').'=\frac{\pi}{2}\\ つまり\\\\
            \theta = '.f1($rad[$pattern]-2,2*$rad[$pattern],'\pi').'\\ で最大値'.rt2(1,$a*$a + $a*$a*$b[$pattern]).'を、\\\\
            \theta'.f2(1,$rad[$pattern],'\pi').'=\frac{3}{2}\pi\\ つまり\\\\
            \theta = '.f1(3*$rad[$pattern]-2,2*$rad[$pattern],'\pi').'\\ で最大値'.rt2(-1,$a*$a + $a*$a*$b[$pattern]).'をとる
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }
    
    //指数関数・対数関数
    //指数の計算
    public function unit205_q01($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                2^{'.$a.'} \times \sqrt['.$b.']{4} \div \sqrt{2^{'.$c.'}} &=& 2^{'.$a.'} \times (2^2)^\frac{1}{'.$b.'} \div (2^{'.$c.'})^\frac{1}{2}\\\\
                                                                          &=& 2^{'.$a.'} \times 2^\frac{2}{'.$b.'} \div 2^\frac{'.$c.'}{2}\\\\
                                                                          &=& 2^{'.$a.'+\frac{2}{'.$b.'}-\frac{'.$c.'}{2}}\\\\
                                                                          &=& 2^{'.f3(2*$a*$b+4-$b*$c,2*$b).'}
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //指数の式の値
    public function unit205_q02($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                a^{2x} + a^{-2x} &=& (a^x)^2 + (a^{-x})^2\\\\
                                 &=& (a^x-a^{-x})^2 +2 \cdot a^x \cdot a^{-x}\\\\
                                 &=& '.$a.'^2 +2\\\\
                                 &=& '.($a*$a+2).'\\\\
                a^{3x} - a^{-3x} &=& (a^x)^3 - (a^{-x})^3\\\\
                                 &=& (a^x-a^{-x})(a^{2x}+a^x \cdot a^{-x} + a^{-2x})\\\\
                                 &=& (a^x-a^{-x})(a^{2x}+a^{-2x}+1)\\\\
                                 &=& '.$a.'\cdot ('.($a*$a+2).'^2 + 1)\\\\
                                 &=& '.($a*$a*$a+3*$a).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //指数方程式
    public function unit205_q03($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                9^{x}'.d2($a,'\cdot 3^{x}').d3($b).' &=& 0\\\\
                (3^x)^2'.d2($a,'\cdot 3^{x}').d3($b).' &=& 0\\\\
                3^x = t とおくと、\\\\
                t^2'.d2($a,'t').d3($b).' &=& 0\\\\
                (t'.d3(-1*$x).')(t'.d3(-1*$y).') &=& 0\\\\
                t &=& '.$x.',\\ '.$y.'\\\\
                3^x &=& '.$x.',\\ '.$y.'\\\\
                x &=& '.log_text(3,$x).',\\ '.log_text(3,$y).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //指数不等式
    public function unit205_q04($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                4^{x}'.d2($a,(abs($a)!=1?'\cdot':'').'2^{x}').d3($b).' & \gt & 0\\\\
                (2^x)^2'.d2($a,(abs($a)!=1?'\cdot':'').'2^{x}').d3($b).' & \gt & 0\\\\
                2^x = t とおくと、t \gt 0 \cdots ①\\\\
                t^2'.d2($a,'t').d3($b).' & \gt & 0\\\\
                (t'.d3(-1*$x).')(t'.d3(-1*$y).') & \gt & 0\\\\
            \end{eqnarray}\\\\
            t \lt '.$x.',\\ '.$y.' \lt t \cdots ②\\\\
            ①、②より、\\\\
        ';
        if($x > 0){
            $sample_text .= '
                0 \lt t \lt '.$x.',\\ '.$y.' \lt t\\\\
                2^x \lt '.$x.',\\ '.$y.' \lt t\\\\
                x \lt '.log_text(2,$x).',\\ '.log_text(2,$y).' \lt x\\\\
            ';
        }else{
            $sample_text .= '
                '.$y.' \lt t\\\\
                2^x \gt '.$y.'\\\\
                x \gt '.log_text(2,$y).'\\\\
            ';
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //対数の計算
    public function unit205_q05($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                \log_2 '.$a.'- \log_4 '.$b.' &=& \log_2{'.$a.'} - \frac{\log_2{'.$b.'}}{\log_2{4}}\\\\
                                             &=& \log_2{'.$a.'} - \frac{1}{2}\log_2{'.$b.'}\\\\
                                             &=& \log_2{'.$a.'} - \log_2{'.rt2(1,$b).'}\\\\
                                             &=& \log_2{\frac{'.$a.'}{'.rt2(1,$b).'}}\\\\
                                             &=& \log_2{'.pow(2,$y).'}\\\\
                                             &=& '.$y.'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //対数の式の値
    public function unit205_q06($unit,$question){
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
        $text .= '\log_{10} '.($b==1?$a:'\frac{'.$a.'}{'.$b.'}');

        //空欄テキストの設定
        $item[0] = '\fbox{ア} - ';
        $item[1] = '\fbox{イ}a';

        $sample_text = '
            \begin{eqnarray}
                \log_{10} '.($b==1?$a:'\frac{'.$a.'}{'.$b.'}').' &=& \log_{10}{\frac{'.pow(10,$x).'}{'.pow(2,$y).'}}\\\\
                                                                 &=& \log_{10}{'.pow(10,$x).'} - \log_{10}{'.pow(2,$y).'}\\\\
                                                                 &=& '.$x.'- '.d1($y,'\log_{10}{2}').'\\\\
                                                                 &=& '.$x.'- '.d1($y,'a').'\\\\
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/equation',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //対数方程式
    public function unit205_q07($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                \log_'.$a.' (x'.d4($b).') &=& '.$c.'\\\\
                x'.d4($b).' &=& '.$a.'^{'.$c.'}\\\\
                x &=& '.(pow($a,$c) - $b).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //対数不等式
    public function unit205_q08($unit,$question){
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

        $sample_text = '
            真数条件より、x'.d4($b).' \gt 0\\\\
            \therefore x \gt '.fo(d4(-1*$b)).' \\ \cdots ①\\\\
            \begin{eqnarray}
                \log_{'.$a.'}{(x'.d4($b).')} &\lt& '.$c.'\\\\
                \log_{'.$a.'}{(x'.d4($b).')} &\lt& \log_{'.$a.'}{'.pow($a,$c).'}\\\\
                '.$a.' \gt 1 \\ より、\\\\
                x'.d4($b).' &\lt& '.pow($a,$c).'\\\\
                x &\lt& '.(pow($a,$c)-$b).' \\ \cdots ②\\\\
            \end{eqnarray}\\\\
            ①、②より、'.(-1*$b).'\lt x \lt '.(pow($a,$c)-$b).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //大小関係
    public function unit205_q09($unit,$question){
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

        $sample_text = '
            aとbに関して、\\\\
            b = \log_{'.$c.'}'.$d.' = \frac{\log_{'.$x.'}{'.$x.'}}{\log_{'.$x.'}{'.$y.'}} = \frac{1}{\log_{'.$x.'}{'.$y.'}}\\\\
            よって、a '.(log($b,$a) > log($d,$c)?'\gt':'\lt').' b\\\\
            また、c = \frac{\log_{'.$x.'}{'.$f.'}}{\log_{'.$x.'}{'.$e.'}} = \frac{3}{2} \\ より、\\\\
            aとcに関して、\\\\
            \frac{3}{2} = \log_{'.$x.'}{'.$x.'^{\frac{3}{2}}} = \log_{'.$x.'}{\sqrt{'.$f.'}} \\ なので、\\\\
            '.(log($b,$a)>log($f,$e) ? 'a \gt c' : 'a \lt c' ).'\\\\
            bとcに関して、\\\\
            \frac{3}{2} = \log_{'.$y.'}{'.$y.'^{\frac{3}{2}}} = \log_{'.$y.'}{\sqrt{'.($y*$y*$y).'}} \\ なので、\\\\
            '.(log($d,$c)>log($f,$e) ? 'b \gt c' : 'b \lt c' ).'\\\\
            したがって、'.implode(' \lt ',$right_answers).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/alphabet',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //桁数
    public function unit205_q10($unit,$question){
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

        $b = $a*0.3010;

        $sample_text = '
            \log_{10}{2^{'.$a.'}} = '.$a.'\log_{10}{2} = '.$b.'\\ より、\\\\
            '.floor($b).' \lt \log_{10}{2^{'.$a.'}} \lt '.(floor($b)+1).'\\\\
            \log_{10}{10^{'.floor($b).'}} \lt \log_{10}{2^{'.$a.'}} \lt \log_{10}{10^{'.(floor($b)+1).'}}\\\\
            10^{'.floor($b).'} \lt 2^{'.$a.'} \lt 10^{'.(floor($b)+1).'}\\\\
            よって、2^{'.$a.'}は'.(floor(0.3010*$a)+1).'桁の整数
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //微分法
    //平均変化率
    public function unit206_q01($unit,$question){
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

        $sample_text = '
            f('.$e.') = '.dot3($a,$e,3).'+'.dot3($b,$e,2).'+'.dot3($c,$e,1).d3($d).'='.($a*$e*$e*$e+$b*$e*$e+$c*$e+$d).'\\\\
            f('.$f.') = '.dot3($a,$f,3).'+'.dot3($b,$f,2).'+'.dot3($c,$f,1).d3($d).'='.($a*$f*$f*$f+$b*$f*$f+$c*$f+$d).'\\\\
            よって、平均変化率は、\\\\
            \frac{f('.$f.')-f('.$e.')}{'.dot3(1,$f,1).'-'.dot3(1,$e,1).'} 
            = \frac{'.dot3(1,$a*$f*$f*$f+$b*$f*$f+$c*$f+$d,1).'-'.dot3(1,$a*$e*$e*$e+$b*$e*$e+$c*$e+$d,1).'}{'.dot3(1,$f,1).'-'.dot3(1,$e,1).'}
            = '.$right_answers[0].'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //公式による微分
    public function unit206_q02($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                f\'(x) &=& 3 \cdot '.($a>0?d1($a,'x^2'):'('.d1($a,'x^2').')').'+2 \cdot '.($b>0?d1($b,'x'):'('.d1($b,'x').')').d4($c).'\\\\
                       &=& '.d1(3*$a,'x^2').d2(2*$b,'x').d4($c).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //接線の方程式
    public function unit206_q03($unit,$question){
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

        $sample_text = '
            f\'(x) = '.d1(2*$a,'x').d4($b).'\\ より、\\\\
            x='.$d.'における接線の傾きは、\\\\
            f\'('.$d.') = '.dot3(2*$a,$d,1).d4($b).' = '.(2*$a*$d+$b).'\\\\
            よって、接線の方程式は、\\\\
            \begin{eqnarray}
                y &=& '.(2*$a*$d+$b).($d!=0?'(x'.d4(-1*$d).')':'x').d4($a*$d*$d+$b*$d+$c).'\\\\
                '.($d!=0? '&=& '.d1(2*$a*$d+$b,'x').'+'.dot3(-1*$d,2*$a*$d+$b,1).d4($a*$d*$d+$b*$d+$c).'\\\\
                           &=&' .d1(2*$a*$d+$b,'x').d4(-1*$a*$d*$d+$c)
                :'').'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //曲線上にない点から引いた接線
    public function unit206_q04($unit,$question){
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
                unset($right_answers[3*$i]);
                unset($option[3*$i]);
                $blanks -= 1;
            }
            list($right_answers,$option,$blanks,$item[2*$i+1]) = l_frac($right_answers,$option,3*$i+2,$blanks,$item[2*$i+1]);
            if($right_answers[3*$i+1] == 0){
                $item[2*$i+1] = '';
                unset($right_answers[3*$i+1]);
                unset($option[3*$i+1]);
                $blanks -= 1;
            }
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $p[0] = $a;  $p[1] = $a*$d-$f;  list($p[0],$p[1])=gcd($p[0],$p[1]);
        $q[0] = $a;  $q[1] = $a*$d+$f;  list($q[0],$q[1])=gcd($q[0],$q[1]);

        $sample_text = '
            接点を(t,f(t))とおく。\\\\
            このとき、f\'(t) = '.d1(2*$a,'t').d4($b).'\\\\
            よって、接線の方程式は、\\\\
            \begin{eqnarray}
                y &=& f\'(t)(x-t) + f(t)\\\\
                  &=& ('.d1(2*$a,'t').d4($b).')(x-t)'.d2($a,'t^2').d2($b,'t').d4($c).'\\\\
                  &=& ('.d1(2*$a,'t').d4($b).')x'.d2(-1*$a,'t^2').d4($c).'\\\\
            \end{eqnarray}\\\\
            これが、('.$d.','.f3($e[0],$e[1]).')を通るので、\\\\
            '.f3($e[0],$e[1]).' = ('.d1(2*$a,'t').d4($b).') \cdot '.dot3(1,$d,1).d2(-1*$a,'t^2').d4($c).'\\\\
            '.d1($a,'t^2').d2(-2*$a*$d,'t').d4(-1*$b*$d-$c).f2($e[0],$e[1]).'=0\\\\
            '.(abs($e[1])!=1 ? d1($e[1]*$a,'t^2').d2(-2*$a*$d*$e[1],'t').d4(-1*$b*$d*$e[1]-$c*$e[1]+$e[0]).'=0\\\\' : '' ).'
            ('.d1($p[0],'t').d4(-1*$p[1]).')('.d1($q[0],'t').d4(-1*$q[1]).') = 0\\\\
            \quad \quad t = '.f3($a*$d-$f,$a).','.f3($a*$d+$f,$a).'\\\\
            t='.f3($a*$d-$f,$a).'のとき、接線は、\\\\
            y = ('.(2*$a).' \cdot '.f3($a*$d-$f,$a).d4($b).')x '.d4($a).' \cdot ('.f3($a*$d-$f,$a).')^2 '.d4($c).'\\\\
            \therefore y = '.d1(2*$a*$d-2*$f+$b,'x').f2(-1*pow($a*$d-$f,2)+$a*$c,$a).'\\\\
            t='.f3($a*$d+$f,$a).'のとき、接線は、\\\\
            y = ('.(2*$a).' \cdot '.f3($a*$d+$f,$a).d4($b).')x '.d4($a).' \cdot ('.f3($a*$d+$f,$a).')^2 '.d4($c).'\\\\
            \therefore y = '.d1(2*$a*$d+2*$f+$b,'x').f2(-1*pow($a*$d+$f,2)+$a*$c,$a).'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //極値
    public function unit206_q05($unit,$question){
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
        $item[3] = '極小値\fbox{エ}をとる。';

        $sample_text = '
            \begin{eqnarray}
                f\'(x) &=& '.d1(3*$a,'x^2').d2(2*$b,'x').d4($c).'\\\\
                       &=& '.d1(6*$x,'(x'.d4(-1*$y).')(x'.d4(-1*$z).')').'\\\\
            \end{eqnarray}\\\\
            よって、f(x)は、\\\\
            x = '.$right_answers[0].'で極大値'.$right_answers[1].'を、\\\\
            x = '.$right_answers[2].'で極小値'.$right_answers[3].'をとる\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //極値から係数の決定
    public function unit206_q06($unit,$question){
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

        $sample_text = '
            f\'(x) = 3ax^2'.d2(2*$p,'bx').d4($q).'\\\\
            x='.$r.','.$s.'で極値を取るので、f\'('.$r.') = f\'('.$s.') = 0\\\\
            よって、\\\\
            '.d1(3*$r*$r,'a').d2(2*$p*$r,'b').d4($q).' = 0\\\\
            '.d1(3*$s*$s,'a').d2(2*$p*$s,'b').d4($q).' = 0\\\\
            これを解いて、a='.f3($q,3*$r*$s).',\\ b='.f3($q*($s+$r),-2*$p*$r*$s).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //方程式の解の個数
    public function unit206_q07($unit,$question){
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

        $sample_text = '
            f(x) = '.d1($a,'x^{3}').d2($b,'x^{2}').d2($c,'x').d4($d).'\\ とおくと、\\\\
            \begin{eqnarray}
                f\'(x) &=& '.d1(3*$a,'x^2').d2(2*$b,'x').d4($c).'\\\\
                       &=& '.d1(6*$x,'(x'.d4(-1*$y).')(x'.d4(-1*$z).')').'\\\\
            \end{eqnarray}\\\\
            よって、増減表は以下のようになる。\\\\
            \begin{array}{c||ccccc}
                \hline
                x & \cdots & '.$y.' & \cdots & '.$z.' & \cdots \\\\
                \hline
                f\'(x) & '.($a>0?'+':'-').' & 0 & '.($a>0?'-':'+').' & 0 & '.($a>0?'+':'-').'\\\\
                \hline
                f(x) & '.($a>0?'\nearrow':'\searrow').' & '.$f_y.' & '.($a>0?'\searrow':'\nearrow').' & '.$f_z.' & '.($a>0?'\nearrow':'\searrow').' \\\\
                \hline
            \end{array}\\\\
            したがって、グラフは以下のようになるので、\\\\
            f(x)=0の実数解の個数は、'.$right_answers[0].'個
        ';

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-10,10,10,-10],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return '.$a.'*t*t*t + '.$b.'*t*t + '.$c.'*t + '.$d.';
                }

                board.create(\'functiongraph\', [bezier, -10, 10]);
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //積分法
    //不定積分
    public function unit207_q01($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                && \int{('.d1($a,'x^{2}').d2($b,'x').d4($c).')}dx\\\\
                &=& \frac{1}{3} \cdot '.dot3(1,$a,1).'x^3 +\frac{1}{2} \cdot '.dot3(1,$b,1).'x^2'.d2($c,'x').'+C\\\\
                &=& '.f1($a,3,'x^3').f2($b,2,'x^2').d2($c,'x').'+C
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //定積分
    public function unit207_q02($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                && \int_{'.$f.'}^{'.$e.'}{('.d1($a,'x^{2}').d2($b,'x').d4($c).')}dx\\\\
                &=& \left['.f1($a,3,'x^3').f2($b,2,'x^2').d2($c,'x').'\right]_{'.$f.'}^{'.$e.'}\\\\
                &=& ('.f1($a,3,' \cdot '.dot3(1,$e,3)).f2($b,2,' \cdot '.dot3(1,$e,2)).d2($c,' \cdot '.dot3(1,$e,1)).') - ('.f1($a,3,' \cdot '.dot3(1,$f,3)).f2($b,2,' \cdot '.dot3(1,$f,2)).d2($c,' \cdot '.dot3(1,$f,1)).')\\\\
                &=& '.f3(2*$a*$e*$e*$e + 3*$b*$e*$e + 6*$c*$e - 2*$a*$f*$f*$f - 3*$b*$f*$f - 6*$c*$f,6).'
            \end{eqnarray}
        ';
        

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //定積分と微分
    public function unit207_q03($unit,$question){
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

        $sample_text = '
            \int_{a}^{x}{f(t)}dt='.d1($p,'x^{2}').d2($q,'x').d4($r).' \cdots (*)\\\\
            (*)の両辺をxで微分すると、\\\\
            f(x) = '.d1(2*$p,'x').d4($q).'\\\\
            また、x=aのとき(*)は、\\\\
            \begin{eqnarray}
                0 &=& '.d1($p,'a^2').d2($q,'a').d4($r).'\\\\
                0 &=& '.d1($x,'(a'.d4(-1*$y).')(a'.d4(-1*$z).')').'\\\\
                a &=& '.$y.','.$z.'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //絶対値を含む関数の定積分
    public function unit207_q04($unit,$question){
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

        $sample_text = '
            f(x) = x'.d4(-1*$c).'\\ とおく。\\\\
            '.$a.' \leqq x \leqq '.$b.'\\ において、\\\\
            '.$a.' \leqq x \lt '.$c.'\\ のとき、f(x) \lt 0\\\\
            '.$c.' \leqq x \leqq '.$b.'\\ のとき、f(x) \geqq 0\\\\
            よって、\\\\
            \begin{eqnarray}
                && \int_{'.$a.'}^{'.$b.'}{|x'.d4(-1*$c).'|}dx \\\\
                \\ &=& \int_{'.$a.'}^{'.$c.'}{(-x'.d4($c).')}dx + \int_{'.$c.'}^{'.$b.'}{(x'.d4(-1*$c).')}dx\\\\
                \\ &=& \left[-\frac{1}{2}x^2'.d2($c,'x').'\right]_{'.$a.'}^{'.$c.'} + \left[\frac{1}{2}x^2'.d2(-1*$c,'x').'\right]_{'.$c.'}^{'.$b.'}\\\\
                \\ &=& \left\\{(-\frac{1}{2} \cdot '.dot3(1,$c,2).d2($c,' \cdot '.dot3(1,$c,1)).')-(-\frac{1}{2} \cdot '.dot3(1,$a,2).d2($c,' \cdot '.dot3(1,$a,1)).')\right\\}
                        + \left\\{(\frac{1}{2} \cdot '.dot3(1,$b,2).d2(-1*$c,' \cdot '.dot3(1,$b,1)).')-(\frac{1}{2} \cdot '.dot3(1,$c,2).d2(-1*$c,' \cdot '.dot3(1,$c,1)).')\right\\}\\\\
                \\ &=& '.f3($a*$a + $b*$b + 2*$c*$c - 2*$a*$c - 2*$b*$c,2).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //曲線とx軸で囲まれた図形の面積
    public function unit207_q05($unit,$question){
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

        $sample_text = '
            '.d1($a,'x^{2}').d2($b,'x').d4($c).' = '.d1($x,'(x'.d4(-1*$y).')(x'.d4(-1*$z).')').'\\\\
            よって、y='.d1($a,'x^{2}').d2($b,'x').d4($c).'\\ は\\\\
            x='.$y.','.$z.'\\ でx軸と交わるので、囲まれる部分の面積Sは、\\\\
        ';
        if($a > 0){
            $sample_text .= '
            \begin{eqnarray}
                S &=& -\int_{'.$y.'}^{'.$z.'} {('.d1($a,'x^{2}').d2($b,'x').d4($c).')}dx\\\\
                  &=& -\left['.f1($a,3,'x^3').f2($b,2,'x^2').d2($c,'x').'\right]_{'.$y.'}^{'.$z.'}\\\\
                  &=& -('.f1($a,3,' \cdot '.dot3(1,$z,3)).f2($b,2,' \cdot '.dot3(1,$z,2)).d2($c,' \cdot '.dot3(1,$z,1)).') + ('.f1($a,3,' \cdot '.dot3(1,$y,3)).f2($b,2,' \cdot '.dot3(1,$y,2)).d2($c,' \cdot '.dot3(1,$y,1)).')\\\\
                  &=& '.f3(abs($a)*pow($z-$y,3),6).'\\\\
            \end{eqnarray}
            ';
        }else{
            $sample_text .= '
            \begin{eqnarray}
                S &=& \int_{'.$y.'}^{'.$z.'} {('.d1($a,'x^{2}').d2($b,'x').d4($c).')}dx\\\\
                  &=& \left['.f1($a,3,'x^3').f2($b,2,'x^2').d2($c,'x').'\right]_{'.$y.'}^{'.$z.'}\\\\
                  &=& ('.f1($a,3,' \cdot '.dot3(1,$z,3)).f2($b,2,' \cdot '.dot3(1,$z,2)).d2($c,' \cdot '.dot3(1,$z,1)).') - ('.f1($a,3,' \cdot '.dot3(1,$y,3)).f2($b,2,' \cdot '.dot3(1,$y,2)).d2($c,' \cdot '.dot3(1,$y,1)).')\\\\
                  &=& '.f3(abs($a)*pow($z-$y,3),6).'\\\\
            \end{eqnarray}
            ';
        }

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-10,10,10,-10],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return '.$a.'*t*t + '.$b.'*t + '.$c.';
                }

                board.create(\'functiongraph\', [bezier, -10, 10]);
                board.create(\'functiongraph\', [bezier, '.$y.', '.$z.'],{color:\'red\'});
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //直線と曲線で囲まれた図形の面積
    public function unit207_q06($unit,$question){
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

        $sample_text = '
            直線と曲線の共有点のx座標は、\\\\
            '.d1($a,'x').d4($b).' = '.d1($c,'x^{2}').d2($d,'x').d4($e).'\\\\
            '.d1($c,'x^{2}').d2($d-$a,'x').d4($e-$b).' = 0\\\\
            '.d1($x,'(x'.d4(-1*$y).')(x'.d4(-1*$z).')').' = 0\\\\
            x='.$y.','.$z.'\\\\
            よって、囲まれる部分の面積Sは、\\\\
        ';
        if($c > 0){
            $sample_text .= '
            \begin{eqnarray}
                S &=& \int_{'.$y.'}^{'.$z.'} {\left\{('.d1($a,'x').d4($b).') - ('.d1($c,'x^{2}').d2($d,'x').d4($e).')\right\}}dx\\\\
                  &=& \int_{'.$y.'}^{'.$z.'} {('.d1(-1*$c,'x^{2}').d2($a-$d,'x').d4($b-$e).')}dx\\\\
                  &=& \left['.f1(-1*$c,3,'x^3').f2($a-$d,2,'x^2').d2($b-$e,'x').'\right]_{'.$y.'}^{'.$z.'}\\\\
                  &=& ('.f1(-1*$c,3,' \cdot '.dot3(1,$z,3)).f2($a-$d,2,' \cdot '.dot3(1,$z,2)).d2($b-$e,' \cdot '.dot3(1,$z,1)).') + ('.f1(-1*$c,3,' \cdot '.dot3(1,$y,3)).f2($a-$d,2,' \cdot '.dot3(1,$y,2)).d2($b-$e,' \cdot '.dot3(1,$y,1)).')\\\\
                  &=& '.f3(abs($c)*pow($z-$y,3),6).'\\\\
            \end{eqnarray}
            ';
        }else{
            $sample_text .= '
            \begin{eqnarray}
                S &=& \int_{'.$y.'}^{'.$z.'} {\left\{('.d1($c,'x^{2}').d2($d,'x').d4($e).') - ('.d1($a,'x').d4($b).')\right\}}dx\\\\
                  &=& \int_{'.$y.'}^{'.$z.'} {('.d1($c,'x^{2}').d2($d-$a,'x').d4($e-$b).')}dx\\\\
                  &=& \left['.f1($c,3,'x^3').f2($d-$a,2,'x^2').d2($e-$b,'x').'\right]_{'.$y.'}^{'.$z.'}\\\\
                  &=& ('.f1($c,3,' \cdot '.dot3(1,$z,3)).f2($d-$a,2,' \cdot '.dot3(1,$z,2)).d2($e-$b,' \cdot '.dot3(1,$z,1)).') + ('.f1($c,3,' \cdot '.dot3(1,$y,3)).f2($d-$a,2,' \cdot '.dot3(1,$y,2)).d2($e-$b,' \cdot '.dot3(1,$y,1)).')\\\\
                  &=& '.f3(abs($c)*pow($z-$y,3),6).'\\\\
            \end{eqnarray}
            ';
        }

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-10,10,10,-10],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return '.$a.'*t + '.$b.';
                }
                function bezier2(t) {
                    return '.$c.'*t*t + '.$d.'*t + '.$e.';
                }

                board.create(\'functiongraph\', [bezier, -10, 10]);
                board.create(\'functiongraph\', [bezier2, -10, 10]);
                board.create(\'functiongraph\', [bezier2, '.$y.', '.$z.'],{color:\'red\'});
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //３次関数ととx軸で囲まれた図形の面積
    public function unit207_q07($unit,$question){
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

        $sample_text = '
            x^{3}'.d2($a,'x^{2}').d2($b,'x').d4($c).' = (x'.d4($x).')(x'.d4($y).')(x'.d4($z).')\\\\
            よって、y=x^{3}'.d2($a,'x^{2}').d2($b,'x').d4($c).'\\ は\\\\
            x='.$x.','.$y.','.$z.'\\ でx軸と共有点を持つ\\\\
            グラフの概形は以下のようになるので、\\\\
            曲線とx軸で囲まれる部分の面積Sは、\\\\
            \begin{eqnarray}
                S &=& \int_{'.$x.'}^{'.$y.'} {(x^{3}'.d2($a,'x^{2}').d2($b,'x').d4($c).')}dx - \int_{'.$y.'}^{'.$z.'} {(x^{3}'.d2($a,'x^{2}').d2($b,'x').d4($c).')}dx\\\\
                  &=& \left[\frac{1}{4}x^4'.f2($a,3,'x^3').f2($b,2,'x^2').d2($c,'x').'\right]_{'.$x.'}^{'.$y.'} - \left[\frac{1}{4}x^4'.f2($a,3,'x^3').f2($b,2,'x^2').d2($c,'x').'\right]_{'.$y.'}^{'.$z.'}\\\\
                  &=& \left\{(\frac{1}{4} \cdot '.dot3(1,$y,4).f2($a,3,' \cdot '.dot3(1,$y,3)).f2($b,2,' \cdot '.dot3(1,$y,2)).d2($c,' \cdot '.dot3(1,$y,1)).') - (\frac{1}{4} \cdot '.dot3(1,$x,4).f2($a,3,' \cdot '.dot3(1,$x,3)).f2($b,2,' \cdot '.dot3(1,$x,2)).d2($c,' \cdot '.dot3(1,$x,1)).')\right\}\\\\
                  && - \left\{(\frac{1}{4} \cdot '.dot3(1,$z,4).f2($a,3,' \cdot '.dot3(1,$z,3)).f2($b,2,' \cdot '.dot3(1,$z,2)).d2($c,' \cdot '.dot3(1,$z,1)).') - (\frac{1}{4} \cdot '.dot3(1,$y,4).f2($a,3,' \cdot '.dot3(1,$y,3)).f2($b,2,' \cdot '.dot3(1,$y,2)).d2($c,' \cdot '.dot3(1,$y,1)).')\right\}\\\\
                  &=& '.f3($right_answers[0],$right_answers[1]).'\\\\
            \end{eqnarray}
        ';

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-10,10,10,-10],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return t*t*t + '.$a.'*t*t + '.$b.'*t + '.$c.';
                }

                board.create(\'functiongraph\', [bezier, -10, 10]);
                board.create(\'functiongraph\', [bezier, '.$x.', '.$y.'],{color:\'red\'});
                board.create(\'functiongraph\', [bezier, '.$y.', '.$z.'],{color:\'red\'});
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //数学Ⅲ
    //複素数平面
    //極形式
    public function unit301_q01($unit,$question){
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

        $sample_text = '
            下図より、r='.rt2($right_answers[0],$right_answers[1]).',\\ \theta='.f1($theta[0][$s],$theta[1][$s],'\pi').'\\\\
            よって、'.complex($t*$a_sign[$s],$u,$v,$w).'= '.rt2($right_answers[0],$right_answers[1]).'(\cos{'.f1($theta[0][$s],$theta[1][$s],'\pi').'}+i\sin{'.f1($theta[0][$s],$theta[1][$s],'\pi').'})
        ';

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-6,6,6,-1],
                    axis: true,
                    showNavigation: false,
                    showCopyright: false
                });

                var p1 = board.create(\'point\',['.($t*$a_sign[$s]*sqrt($u)).',0],{name:\'\',size:1,fixed:true});
                var p2 = board.create(\'point\',[0,'.($v*sqrt($w)).'],{name:\'\',size:1,fixed:true});
                var o = board.create(\'point\',[0,0],{name:\'\',size:0,fixed:true});
                var b = board.create(\'point\',[1,0],{name:\'\',size:0,fixed:true});
                var r = board.create(\'point\',['.($t*$a_sign[$s]*sqrt($u)).','.($v*sqrt($w)).'],{name:\'\',size:0,fixed:true});
                board.create(\'line\',[o,r],{straightFirst:false, straightLast:false, lastarrow:true, fixed:true,name:\'r\'});
                board.create(\'line\',[p1,r],{dash:1,straightFirst:false, straightLast:false,fixed:true});
                board.create(\'line\',[p2,r],{dash:1,straightFirst:false, straightLast:false,fixed:true});
                board.create(\'angle\',[b,o,r],{name:\'Θ\'});
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //複素数の積と商
    public function unit301_q02($unit,$question){
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

        $sample_text = '
            それぞれを極形式にして、\\\\
            \alpha = '.complex($b,$a,$d,$c).' = '.d1($r_1,'(\cos{'.f1($theta[$alpha],180,'\pi').'}+i\sin{'.f1($theta[$alpha],180,'\pi').'})').'\\\\
            \beta = '.complex($f,$e,$h,$g).' = '.d1($r_2,'(\cos{'.f1($theta[$beta],180,'\pi').'}+i\sin{'.f1($theta[$beta],180,'\pi').'})').'\\\\
            よって、\\\\
            \begin{eqnarray}
                \alpha\beta &=& '.dot3($r_1,$r_2,1).'(\cos{('.f1($theta[$alpha],180,'\pi').'+'.f1($theta[$beta],180,'\pi').')}+i\sin{('.f1($theta[$alpha],180,'\pi').'+'.f1($theta[$beta],180,'\pi').')})\\\\
                &=& '.d1($r_1*$r_2,'(\cos{'.f1($p,180,'\pi').'}+i\sin{'.f1($p,180,'\pi').'})').'\\\\
                \frac{\alpha}{\beta} &=& \frac{'.$r_1.'}{'.$r_2.'}(\cos{('.f1($theta[$alpha],180,'\pi').'-'.f1($theta[$beta],180,'\pi').')}+i\sin{('.f1($theta[$alpha],180,'\pi').'-'.f1($theta[$beta],180,'\pi').')})\\\\
                &=& '.f1($r_1,$r_2,'(\cos{'.f1($theta[$alpha]-$theta[$beta],180,'\pi').'}+i\sin{'.f1($theta[$alpha]-$theta[$beta],180,'\pi').'})').'\\\\
                '.($p<$q ? '&=& '.f1($r_1,$r_2,'(\cos{'.f1($q,180,'\pi').'}+i\sin{'.f1($q,180,'\pi').'})') :'').'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //複素数の回転
    public function unit301_q03($unit,$question){
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

        $sample_text = '
            \alpha = '.complex($b,$a,$d,$c).' = '.d1($r_1,'(\cos{'.f1($theta[$alpha],180,'\pi').'}+i\sin{'.f1($theta[$alpha],180,'\pi').'})').'\\\\
            よって、これを'.f1($y[0],$y[1],'\pi').'だけ回転させた点B(\beta)は、\\\\
            \begin{eqnarray}
                \beta &=& '.d1($r_1,'\left\{\cos{('.f1($theta[$alpha],180,'\pi').'+'.f1($y[0],$y[1],'\pi').')}+i\sin{('.f1($theta[$alpha],180,'\pi').'+'.f1($y[0],$y[1],'\pi').')}\right\}').'\\\\
                      &=& '.d1($r_1,'(\cos{'.f1($theta[$alpha]+$theta[$beta],180,'\pi').'}+i\sin{'.f1($theta[$alpha]+$theta[$beta],180,'\pi').'})').'\\\\
                      &=& '.complex($f,$e,$h,$g).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //ド・モアブルの定理
    public function unit301_q04($unit,$question){
        //初期設定
        $question_id = 30104;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $theta = [30,45,60,90,120,135,150];
        $alpha = rand(0,6);
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

        $sample_text = '
            \begin{eqnarray}
                ('.complex($b,$a,$d,$c).')^{'.$z.'} &=& \left\{'.d1($r_1,'(\cos{'.f1($theta[$alpha],180,'\pi').'}+i\sin{'.f1($theta[$alpha],180,'\pi').'})').'\right\}^{'.$z.'}\\\\
                                                    &=& '.dot3(1,$r_1,$z).'(\cos{('.$z.' \cdot '.f1($theta[$alpha],180,'\pi').')}+i\sin{('.$z.' \cdot '.f1($theta[$alpha],180,'\pi').')})\\\\
                                                    &=& '.d1(pow($r_1,$z),'(\cos{'.f1($x[0],$x[1],'\pi').'}+i\sin{'.f1($x[0],$x[1],'\pi').'})').'\\\\
                                                    &=& '.complex($f,$e,$h,$g).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //方程式の表す図形
    public function unit301_q05($unit,$question){
        //初期設定
        $question_id = 30105;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        do { $a = rand(-5,5); } while( $a==0 );
        $b = rand(2,5);

        //答えの計算
        $right_answers[0] = -1*$a;
        $right_answers[1] = $b*$b-1;
        $right_answers[2] = abs($a)*$b;
        $right_answers[3] = $b*$b-1;

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);
        list($right_answers[2],$right_answers[3]) = gcd($right_answers[2],$right_answers[3]);

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

        $sample_text = '
            \begin{eqnarray}
                |z'.d4($a).'| &=& '.d1($b,'|z|').'\\\\
                |z'.d4($a).'|^2 &=& '.d1($b*$b,'|z|^2').'\\\\
                (z'.d4($a).')\overline{(z'.d4($a).')} &=& '.d1($b*$b,'z\bar{z}').'\\\\
                (z'.d4($a).')(\bar{z}'.d4($a).') &=& '.d1($b*$b,'z\bar{z}').'\\\\
                z\bar{z}'.d2($a,'z').d2($a,'\bar{z}').d4($a*$a).' &=& '.d1($b*$b,'z\bar{z}').'\\\\
                '.d1($b*$b-1,'z\bar{z}').d2(-1*$a,'(z+\bar{z})').' &=& '.($a*$a).'\\\\
                z\bar{z}'.f2(-1*$a,$b*$b-1,'(z+\bar{z})').' &=& '.f3($a*$a,$b*$b-1).'\\\\
                z\bar{z}'.f2(-1*$a,$b*$b-1,'(z+\bar{z})').'+ ('.f3(abs($a),$b*$b-1).')^2 &=& '.f3($a*$a,$b*$b-1).'+('.f3(abs($a),$b*$b-1).')^2\\\\
                (z'.f2($a,$b*$b-1).')(\bar{z}'.f2($a,$b*$b-1).') &=& '.f3($a*$a*$b*$b,pow($b*$b-1,2)).'\\\\
                |z'.f2($a,$b*$b-1).'|^2 &=& ('.f3(abs($a)*$b,$b*$b-1).')^2\\\\
                |z'.f2($a,$b*$b-1).'| &=& '.f3(abs($a)*$b,$b*$b-1).'\\\\ 
            \end{eqnarray}\\\\
            よって、これは点'.f3(-1*$a,$b*$b-1).'を中心とする半径'.f3(abs($a)*$b,$b*$b-1).'の円を表す。
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //なす角
    public function unit301_q06($unit,$question){
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

        $sample_text = '
            \frac{\gamma-\alpha}{\beta-\alpha} = '.complex($b,$a,$d,$c).' = '.d1($r_1,'(\cos{'.f1($theta[$alpha],180,'\pi').'}+i\sin{'.f1($theta[$alpha],180,'\pi').'})').'\\\\
            よって、\angle{\beta \alpha \gamma}='.f1($theta[$alpha],180,'\pi').'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //式と曲線
    //放物線
    public function unit302_q01($unit,$question){
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

        $sample_text = '
            y^{2}='.d1(4*$a,'x').'=4 \cdot '.d1($a,'x').'\\\\
            よって、焦点は('.$a.',0)\\\\
            準線は、x = '.(-1*$a).'\\\\
        ';

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-10,10,10,-10],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return Math.sqrt(4*'.$a.'*t);
                }
                function bezier2(t) {
                    return -1*Math.sqrt(4*'.$a.'*t);
                }

                board.create(\'functiongraph\', [bezier, -10, 10]);
                board.create(\'functiongraph\', [bezier2, -10, 10]);
                var p = board.create(\'point\',['.$a.',0],{name:\'\',size:1,fixed:true});
                var q = board.create(\'point\',['.(-1*$a).',0],{name:\'\',size:0,fixed:true});
                var r = board.create(\'point\',['.(-1*$a).',1],{name:\'\',size:0,fixed:true});
                board.create(\'line\',[q,r],{fixed:true});
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //楕円
    public function unit302_q02($unit,$question){
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
            $s[0] = sqrt($a*$a-$b*$b);
            $s[1] = 0;
            $s[2] = -1*sqrt($a*$a-$b*$b);
            $s[3] = 0;
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
            $s[0] = 0;
            $s[1] = sqrt($b*$b-$a*$a);
            $s[2] = 0;
            $s[3] = -1*sqrt($b*$b-$a*$a);
        }

        //問題テキストの設定
        $text = '$$ 楕円\\ \frac{x^{2}}{'.($a*$a).'}+\frac{y^{2}}{'.($b*$b).'}=1\\ は、\\\\';

        $sample_text = '
            \begin{eqnarray}
                \frac{x^{2}}{'.($a*$a).'}+\frac{y^{2}}{'.($b*$b).'} &=& 1\\\\
                \frac{x^{2}}{'.$a.'^2}+\frac{y^{2}}{'.$b.'^2} &=& 1\\\\
            \end{eqnarray}\\\\
            よって、図は以下のようになるので、\\\\
            長軸の長さは\\ '.$right_answers[0].'、短軸の長さは\\ '.$right_answers[1].'\\\\
            焦点は、\\\\
        ';

        if($a>$b){
            $sample_text .= '
            ('.rt2($right_answers[2],$right_answers[3]).','.$right_answers[4].'),('.rt2($right_answers[5],$right_answers[6]).','.$right_answers[7].')
            ';
        }else{
            $sample_text .= '
                ('.$right_answers[2].','.rt2($right_answers[3],$right_answers[4]).'),('.$right_answers[5].','.rt2($right_answers[6],$right_answers[7]).')
            ';
        }

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-1*'.$a.'-1,'.$b.'+1,'.$a.'+1,-1*'.$b.'-1],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return '.$b.'/'.$a.'*Math.sqrt('.$a.'*'.$a.'-t*t);
                }
                function bezier2(t) {
                    return -1*'.$b.'/'.$a.'*Math.sqrt('.$a.'*'.$a.'-t*t);
                }

                var p = board.create(\'point\',['.$s[0].','.$s[1].'],{name:\'\',size:1,fixed:true});
                var q = board.create(\'point\',['.$s[2].','.$s[3].'],{name:\'\',size:1,fixed:true});
                board.create(\'functiongraph\', [bezier, -1*'.$a.', '.$a.']);
                board.create(\'functiongraph\', [bezier2, -1*'.$a.', '.$a.']);
            </script>
        ';

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
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //双曲線
    public function unit302_q03($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                \frac{x^{2}}{'.($a*$a).'}-\frac{y^{2}}{'.($b*$b).'} &=& 1\\\\
                \frac{x^{2}}{'.$a.'^2}-\frac{y^{2}}{'.$b.'^2} &=& 1\\\\
            \end{eqnarray}\\\\
            よって、図は以下のようになり、\\\\
            頂点は、('.$a.',0),('.(-1*$a).',0)\\\\
            焦点は、('.rt2(1,$a*$a+$b*$b).',0),('.rt2(-1,$a*$a+$b*$b).',0)\\\\
        ';

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-10,10,10,-10],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return '.$b.'/'.$a.'*Math.sqrt(t*t-'.$a.'*'.$a.');
                }
                function bezier2(t) {
                    return -1*'.$b.'/'.$a.'*Math.sqrt(t*t-'.$a.'*'.$a.');
                }

                board.create(\'point\',['.$a.',0],{name:\'\',size:1,fixed:true});
                board.create(\'point\',['.(-1*$a).',0],{name:\'\',size:1,fixed:true});
                board.create(\'point\',['.sqrt($a*$a+$b*$b).',0],{name:\'\',size:1,fixed:true});
                board.create(\'point\',['.(-1*sqrt($a*$a+$b*$b)).',0],{name:\'\',size:1,fixed:true});
                board.create(\'functiongraph\', [bezier, -20,'.(-1*$a).']);
                board.create(\'functiongraph\', [bezier, '.$a.',20]);
                board.create(\'functiongraph\', [bezier2, -20,'.(-1*$a).']);
                board.create(\'functiongraph\', [bezier2, '.$a.',20]);
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //２次曲線の平行移動
    public function unit302_q04($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                '.d1($a,'x^{2}').d2($b,'y^{2}').d2($c,'x').d2($d,'y').d4($e).' &=& 0\\\\
                '.d1($a,'(x^2'.f2($c,$a,'x').')').d2($b,'(y^2'.f2($d,$b,'y').')').d4($e).' &=& 0\\\\
                '.d1($a,'(x'.f2($c,2*$a).')^2').f2(-1*$c*$c,4*$a).d2($b,'(y'.f2($d,2*$b,'y').')^2').f2(-1*$d*$d,4*$b).d4($e).' &=& 0\\\\
                '.d1($a,'(x'.f2($c,2*$a).')^2').d2($b,'(y'.f2($d,2*$b,'y').')^2').' &=& '.($p*$q).'\\\\
                \frac{(x'.d4(-1*$r).')^2}{'.$p.'} + \frac{(y'.d4(-1*$s).')^2}{'.$q.'} &=& 1\\\\
            \end{eqnarray}\\\\
            よってこれは、楕円\frac{x^2}{'.$p.'}+\frac{y^2}{'.$q.'}=1を\\\\
            x軸方向に'.$r.',\\ y軸方向に'.$s.'\\ だけ平行移動したもの
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //２次曲線と直線の共有点
    public function unit302_q05($unit,$question){
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

        $s_2 = gmp_gcd($x,gmp_gcd($p*$y,-1*$p*$z));
        list($d[0],$d[1],$d[2]) = array($x/$s_2,$p*$y/$s_2,-1*$p*$z/$s_2);

        $sample_text = '
            y^2 = '.d1($p,'x').'\\ より、x='.f1(1,$p,'y^2').' \cdots (*)\\\\
            これを直線の方程式に代入して、\\\\
            '.$x.' \cdot '.f1(1,$p,'y^2').d2($y,'y').' = '.$z.'\\\\
            '.d1($d[0],'y^2').d2($d[1],'y').d4($d[2]).' = 0\\\\
            ('.d1($right_answers[3],'y').d4(-1*$right_answers[2]).')('.d1($right_answers[7],'y').d4(-1*$right_answers[6]).') = 0\\\\
            \therefore y = '.f3($right_answers[2],$right_answers[3]).','.f3($right_answers[6],$right_answers[7]).'\\\\
            これらを(*)に代入して、\\\\
            x = '.f3($right_answers[0],$right_answers[1]).','.f3($right_answers[4],$right_answers[5]).'\\\\
            したがって共有点は、\\\\
            ('.f3($right_answers[0],$right_answers[1]).','.f3($right_answers[2],$right_answers[3]).'),('.f3($right_answers[4],$right_answers[5]).','.f3($right_answers[6],$right_answers[7]).')
        ';

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
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //２次曲線と接線の方程式
    public function unit302_q06($unit,$question){
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
        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,2,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $sample_text = '
            接線は(0,'.$p.')を通るので、切片は'.$p.'\\\\
            よって接線の方程式を\\ y=mx'.d4($p).'\\ とおくと、\\\\
            これを楕円の式に代入して、\\\\
            '.d1($a,'x^{2}').d2($b,'(mx'.d4($p).')^2').'='.$c.'\\\\
            ('.d1($b,'m^2').d4($a).')x^2'.d2(2*$b*$p,'mx').d4($b*$p*$p-$c).' = 0\\\\
            この式の判別式をDとすると、\\\\
            D/4 = ('.d1($b*$p,'m').')^2 - ('.d1($b,'m^2').d4($a).') \cdot ('.($b*$p*$p-$c).')\\\\
            \quad = '.d1($b*$c,'m^2').d4(-1*$a*$b*$p*$p+$a*$c).'\\\\
            楕円と直線が接するとき、D=0\\ となるので、\\\\
            \begin{eqnarray}
                '.d1($b*$c,'m^2').d4(-1*$a*$b*$p*$p+$a*$c).' &=& 0\\\\
                m^2 &=& '.f3($a*$b*$p*$p-$a*$c,$b*$c).'\\\\
                m &=& \pm'.fr_rt2(1,$b*$c*($a*$b*$p*$p-$a*$c),$b*$c).'\\\\
            \end{eqnarray}\\\\
            よって、接線の方程式は、\\\\
            y = \pm'.fr_rt2(1,$b*$c*($a*$b*$p*$p-$a*$c),$b*$c).'x'.d4($p).'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //媒介変数表示
    public function unit302_q07($unit,$question){
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

        $sample_text = '
            y='.d1($a,'x^{2}').d2($b.'tx').d4($c).' = '.d1($a,'(x'.f2($b,2*$a,'t').')^2').f2(-1*$b*$b,4*$a,'t^2').d4($c).'\\\\
            よって頂点は、('.f1(-1*$b,2*$a,'t').',\\ '.f1(-1*$b*$b,4*$a,'t^2').d4($c).')\\\\
            x = '.f1(-1*$b,2*$a,'t').',\\ y = '.f1(-1*$b*$b,4*$a,'t^2').d4($c).'\\ とおくと、\\\\
            t = '.f1(-2*$a,$b,'x').'より、yの式に代入して、\\\\
            y = '.f1(-1*$b*$b,4*$a,'('.f1(-2*$a,$b,'x').')^2').d4($c).'\\\\
            \quad = '.d1(-1*$a,'x^2').d4($c).'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //極座標と直交座標
    public function unit302_q08($unit,$question){
        //初期設定
        $question_id = 30208;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $theta = [0,30,45,60,120,135,150,180];
        $alpha = rand(1,7);

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

        $sample_text = '
            r = \sqrt{('.rt2($b,$a).')^2+('.rt2($d,$c).')^2} = '.rt2(1,$b*$b*$a+$d*$d*$c).'\\\\
            \tan{\theta} = \frac{'.rt2($d,$c).'}{'.rt2($b,$a).'} = '.fr_rt2($d,$a*$c,$b).'\\ より、\\\\
            \theta = '.f1($theta[$alpha],180,'\pi').'\\\\
        ';

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-6,6,6,-1],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                var p1 = board.create(\'point\',['.($b*sqrt($a)).',0],{name:\'\',size:1,fixed:true});
                var p2 = board.create(\'point\',[0,'.($d*sqrt($c)).'],{name:\'\',size:1,fixed:true});
                var o = board.create(\'point\',[0,0],{name:\'\',size:0,fixed:true});
                var b = board.create(\'point\',[1,0],{name:\'\',size:0,fixed:true});
                var r = board.create(\'point\',['.($b*sqrt($a)).','.($d*sqrt($c)).'],{name:\'\',size:0,fixed:true});
                board.create(\'line\',[o,r],{straightFirst:false, straightLast:false, lastarrow:true, fixed:true,name:\'r\'});
                board.create(\'line\',[p1,r],{dash:1,straightFirst:false, straightLast:false,fixed:true});
                board.create(\'line\',[p2,r],{dash:1,straightFirst:false, straightLast:false,fixed:true});
                board.create(\'angle\',[b,o,r],{name:\'Θ\'});
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //関数
    //分数関数
    public function unit303_q01($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                y &=& \frac{'.d1($a,'x').d4($b).'}{x'.d4($c).'}\\\\
                  &=& \frac{'.d1($a,'x').d4($a*$c).d4(-1*$a*$c).d4($b).'}{x'.d4($c).'}\\\\
                  &=& '.($b-$a*$c>0?'':'-').'\frac{'.abs($b-$a*$c).'}{x'.d4($c).'} + \frac{'.d1($a,'(x'.d4($c)).')}{x'.d4($c).'}\\\\
                  &=& '.($b-$a*$c>0?'':'-').'\frac{'.abs($b-$a*$c).'}{x'.d4($c).'}'.d4($a).'\\\\
            \end{eqnarray}\\\\
            図より、漸近線は、\\\\
            x='.(-1*$c).', \\ y = '.$a.'
        ';

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:['.$c.'-10,'.$a.'+10,'.(-1*$c).'+10,'.$a.'-10],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return ('.$a.'*t+'.$b.')/(t+'.$c.');
                }

                board.create(\'functiongraph\', [bezier, -20, 20]);
                var o = board.create(\'point\',['.(-1*$c).','.$a.'],{name:\'\',size:0,fixed:true});
                var x = board.create(\'point\',['.(-1*$c).',0],{name:\'\',size:0,fixed:true});
                var y = board.create(\'point\',[0,'.$a.'],{name:\'\',size:0,fixed:true});
                board.create(\'line\',[o,x],{fixed:true,dash:1,color:\'red\'});
                board.create(\'line\',[o,y],{fixed:true,dash:1,color:\'red\'});
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //分数関数と直線の共有点
    public function unit303_q02($unit,$question){
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

        $sample_text = '
            2つの式を連立させて、\\\\
            '.($x>0?'':'-').'\frac{'.abs($x).'}{'.d1($y,'x').d4($z).'} = '.d1($c,'x').d4($d).'\\\\
            '.$x.' = '.d1($c*$y,'x^2').d2($d*$y+$c*$z).d4($z*$d).'\\\\
            '.d1($c*$y,'x^2').d2($d*$y+$c*$z).d4($z*$d-$x).' = 0\\\\
            ('.d1($right_answers[1],'x').d4(-1*$right_answers[0]).')('.d1($right_answers[5],'x').d4(-1*$right_answers[4]).') = 0\\\\
            \therefore \\ x = '.f3($right_answers[0],$right_answers[1]).','.f3($right_answers[4],$right_answers[5]).'\\\\
            y= '.d1($c,'x').d4($d).'\\ に代入して、\\\\
            y = '.f3($right_answers[2],$right_answers[3]).','.f3($right_answers[6],$right_answers[7]).'\\\\
            よって、共有点は、\\\\
            ('.f3($right_answers[0],$right_answers[1]).','.f3($right_answers[2],$right_answers[3]).'),('.f3($right_answers[4],$right_answers[5]).','.f3($right_answers[6],$right_answers[7]).')
        ';

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
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //無理関数
    public function unit303_q03($unit,$question){
        //初期設定
        $question_id = 30303;
        $blanks = 3;
        $option = $this->option;

        //変数の設定
        $a = rand(2,5);
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
        $item[2] = '定義域は\\ x \geqq '.($right_answers[1]<0?'-':'').'\fbox{イ}、';
        $item[3] = '値域は\\ y \geqq \fbox{ウ}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $sample_text = '
            y =\sqrt{'.d1($p,'x').d4($q).'} = \sqrt{'.d1($p,'(x'.d4($b).')').'}\\\\
            よって、これはy =\sqrt{'.d1($p,'x').'}のグラフを、\\\\
            x軸方向に'.(-1*$b).'だけ平行移動させたものである。\\\\
            (根号の中) \geqq 0\\ より、'.d1($p,'x').d4($q).' \geqq 0\\\\
            \therefore \\ x \geqq '.(-1*$b).'\\\\
            \sqrt{'.d1($p,'x').d4($q).'} \geqq 0\\ より、y \geqq 0
        ';

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:['.(-1*$b).'-3,5,'.(-1*$b).'+3,-1],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return Math.sqrt('.$p.'*t+'.$q.');
                }

                board.create(\'functiongraph\', [bezier, '.(-1*$b).', 20]);
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //逆関数
    public function unit303_q04($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                y &=& \frac{'.d1($a,'x').d4($b).'}{'.d1($c,'x').d4($d).'}\\\\
                y('.d1($c,'x').d4($d).') &=& '.d1($a,'x').d4($b).'\\\\
                ('.d1($c,'y').d4(-1*$a).')x &=& '.d1(-1*$d,'y').d4($b).'\\\\
                x &=& \frac{'.d1(-1*$d,'y').d4($b).'}{'.d1($c,'y').d4(-1*$a).'}\\\\
            \end{eqnarray}\\\\
            xとyを入れ替えて、\\\\
            y = \frac{'.d1(-1*$d,'x').d4($b).'}{'.d1($c,'x').d4(-1*$a).'}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //合成関数
    public function unit303_q05($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                (g \circ f)(x) &=& g(f(x))\\\\
                               &=& g('.d1($a,'x^{2}').d2($b,'x').d4($c).')\\\\
                               &=& '.d1($d,'('.d1($a,'x^{2}').d2($b,'x').d4($c).')').d4($e).'\\\\
                               &=& '.d1($a*$d,'x^{2}').d2($b*$d,'x').d4($c*$d+$e).'\\\\
                (f \circ g)(x) &=& f(g(x))\\\\
                               &=& f('.d1($d,'x').d4($e).')\\\\
                               &=& '.d1($a,'('.d1($d,'x').d4($e).')^2').d2($b,'('.d1($d,'x').d4($e).')').d4($c).'\\\\
                               &=& '.d1($a*$d*$d,'x^{2}').d2(2*$a*$d*$e+$b*$d,'x').d4($a*$e*$e+$b*$e+$c).'\\\\
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //極限
    //数列の極限
    public function unit304_q01($unit,$question){
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

        list($right_answers[0],$right_answers[1]) = gcd($right_answers[0],$right_answers[1]);

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

        $sample_text = '
            \lim_{n \to \infty} \frac{'.d1($a,'n').d4($b).'}{'.d1($c,'n').d4($d).'} = 
            \lim_{n \to \infty} \frac{'.$a.'+ \frac{'.$b.'}{n}}{'.$c.'+ \frac{'.$d.'}{n}} = '.f3($a,$c).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //無限等比数列の極限
    public function unit304_q02($unit,$question){
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

        $sample_text = '
            \lim_{n \to \infty} \frac{'.$a.'^{n+1} - '.$b.'^{n}}{'.$a.'^{n} + '.$b.'^{n}} =
            \lim_{n \to \infty} \frac{'.$a.' - ('.f3($b,$a).')^{n}}{1 + ('.f3($b,$a).')^{n}} = '.$a.'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //漸化式で定められる数列の極限
    public function unit304_q03($unit,$question){
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

        $sample_text = '
            a_{n+1} = \frac{'.$b.'}{'.$c.'}a_{n}'.d4($d).'\\ より、\\\\
            a_{n+1}'.f2(-1*$c*$d,$c-$b).' = '.f1($b,$c,'(a_n'.f2(-1*$c*$d,$c-$b).')').'\\\\
            数列 \left\{a_{n}'.f2(-1*$c*$d,$c-$b).'\right\}は、\\\\
            初項a_1'.f2(-1*$c*$d,$c-$b).'='.f3($a*$c-$a*$b-$c*$d,$c-$b).',\\ 公比'.f3($b,$c).'\\ の等比数列なので、\\\\
            \begin{eqnarray}
                a_{n}'.f2(-1*$c*$d,$c-$b).' &=& '.f3($a*$c-$a*$b-$c*$d,$c-$b).' \cdot ('.f3($b,$c).')^{n-1}\\\\
                a_{n} &=& '.f3($a*$c-$a*$b-$c*$d,$c-$b).' \cdot ('.f3($b,$c).')^{n-1}'.f2($c*$d,$c-$b).'\\\\
            \end{eqnarray}\\\\
            よって極限は、\\\\
            \lim_{n \to \infty} a_{n} = \lim_{n \to \infty} \left\{'.f3($a*$c-$a*$b-$c*$d,$c-$b).' \cdot ('.f3($b,$c).')^{n-1}'.f2($c*$d,$c-$b).'\right\} =
            '.f3($c*$d,$c-$b).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //無限等比数列
    public function unit304_q04($unit,$question){
        //初期設定
        $question_id = 30404;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        do{ $a = rand(-7,7); } while($a==0);
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

        $sample_text = '
            この等比数列の第n項までの和S_nは、\\\\
            S_n = \frac{'.d1($a,'\left\{1-('.f3($b,$c).')^n\right\}').'}{1-'.f3($b,$c).'}\\\\
            よって、\\\\
            \begin{eqnarray}
                \sum_{n=1}^\infty a_n &=& \lim_{n \to \infty} \frac{'.d1($a,'\left\{1-('.f3($b,$c).')^n\right\}').'}{1-'.f3($b,$c).'}\\\\
                    &=& \frac{'.$a.'}{1-'.f3($b,$c).'}\\\\
                    &=& '.f3($a*$c,$c-$b).'\\\\
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //関数の極限
    public function unit304_q05($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                \lim_{x \to \infty} \frac{'.d1($a,'x^{2}').d2($b,'x').d4($c).'}{'.d1($d,'x^{2}').d2($e,'x').d4($f).'} &=& \lim_{x \to \infty} \frac{('.d1($p,'x').d4($q).')('.d1($r,'x').d4($s).')}{('.d1($p,'x').d4($q).')('.d1($t,'x').d4($t).')}\\\\
                    &=& \lim_{x \to \infty} \frac{'.d1($r,'x').d4($s).'}{'.d1($t,'x').d4($u).'}\\\\
                    &=& \lim_{x \to \infty} \frac{'.$r.'+\frac{'.$s.'}{x}}{'.$t.'+\frac{'.$u.'}{x}}\\\\
                    &=& '.f3($r,$t).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //三角関数と極限
    public function unit304_q06($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                \lim_{x \to 0} \frac{\sin{'.d1($a,'x').'}}{\sin{'.d1($b,'x').'}} &=& \lim_{x \to 0} \frac{'.$a.'}{'.$b.'} \cdot \frac{'.$b.'}{'.$a.'} \cdot \frac{\sin{'.d1($a,'x').'}}{\sin{'.d1($b,'x').'}}\\\\
                    &=& \lim_{x \to 0} '.f3($a,$b).' \cdot \frac{\sin{'.d1($a,'x').'}}{'.$a.'} \cdot \frac{'.$b.'}{\sin{'.d1($b,'x').'}}\\\\
                    &=& '.f3($a,$b).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //微分法
    //積の微分法
    public function unit305_q01($unit,$question){
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

        $sample_text = '
            積の微分より、\\\\
            \begin{eqnarray}
                f\'(x) &=& ('.d1($a,'x^{3}').d2($b,'x').')\'('.d1($c,'x^{4}').d4($d).') + ('.d1($a,'x^{3}').d2($b,'x').')('.d1($c,'x^{4}').d4($d).')\'\\\\
                       &=& ('.d1(3*$a,'x^{2}').d4($b).')('.d1($c,'x^{4}').d4($d).')+('.d1($a,'x^{3}').d2($b,'x').')('.d1(4*$c,'x^{3}').')\\\\
                       &=& '.d1(3*$a*$c,'x^{6}').d2(3*$a*$d,'x^{2}').d2($b*$c,'x^{4}').d4($b*$d).d2(4*$a*$c,'x^{6}').d2(4*$b*$c,'x^{4}').'\\\\
                       &=& '.d1(7*$a*$c,'x^{6}').d2(5*$b*$c,'x^{4}').d2(3*$a*$d,'x^{2}').d4($b*$d).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //商の微分法
    public function unit305_q02($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                f\'(x) &=& \frac{('.d1($a,'x').d4($b).')\'(x^{2}'.d4($c).')-('.d1($a,'x').d4($b).')(x^{2}'.d4($c).')\'}{(x^{2}'.d4($c).')^{2}}\\\\
                       &=& \frac{'.d1($a,'(x^{2}'.d4($c).')-('.d1($a,'x').d4($b).') \cdot 2x').'}{(x^{2}'.d4($c).')^{2}}\\\\
                       &=& \frac{('.d1($a,'x^{2}').d4($a*$c).')-('.d1(2*$a,'x^{2}').d2(2*$b,'x').')}{(x^{2}'.d4($c).')^{2}}\\\\
                       &=& \frac{'.d1(-1*$a,'x^{2}').d2(-2*$b,'x').d4($a*$c).'}{(x^{2}'.d4($c).')^{2}}
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //合成関数の微分 その１
    public function unit305_q03($unit,$question){
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

        $sample_text = '
            合成関数の微分より、\\\\
            \begin{eqnarray}
                f\'(x) &=& '.$d.'('.d1($a,'x^{2}').d2($b,'x').d4($c).')^{'.($d-1).'} \cdot ('.d1($a,'x^{2}').d2($b,'x').d4($c).')\'\\\\
                       &=& '.$d.'('.d1(2*$a,'x').d4($b).')('.d1($a,'x^{2}').d2($b,'x').d4($c).')^{'.($d-1).'}\\\\
                       '.($t==1?'':'&=& '.($d*$t).'('.d1(2*$a/$t,'x').d4($b/$t).')('.d1($a,'x^{2}').d2($b,'x').d4($c).')^{'.($d-1).'}').'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //合成関数の微分 その２
    public function unit305_q04($unit,$question){
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

        $sample_text = '
            f(x) = \sqrt['.$a.']{'.d1($b,'x^{2}').d2($c,'x').d4($d).'} = ('.d1($b,'x^{2}').d2($c,'x').d4($d).')^{\frac{1}{'.$a.'}}\\\\
            合成関数の微分より、\\\\
            \begin{eqnarray}
                f\'(x) &=& \frac{1}{'.$a.'} \cdot ('.d1($b,'x^{2}').d2($c,'x').d4($d).')^{'.fo(frac(1-$a,$a)).'} \cdot ('.d1(2*$b,'x').d4($c).')\\\\
                       &=& \frac{1}{'.$a.'} \cdot \frac{1}{('.d1($b,'x^{2}').d2($c,'x').d4($d).')^{'.fo(frac($a-1,$a)).'}} \cdot ('.d1(2*$b,'x').d4($c).')\\\\
                       &=& \frac{'.d1(2*$b,'x').d4($c).'}{'.$a.'\sqrt['.$a.']{('.d1($b,'x^{2}').d2($c,'x').d4($d).')^{'.($a-1).'}}}\\\\
                       '.($t==1?'':'&=& \frac{'.d1(2*$b/$t,'x').d4($c/$t).'}{'.$a/$t.'\sqrt['.$a.']{('.d1($b,'x^{2}').d2($c,'x').d4($d).')^{'.($a-1).'}}}').'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //三角関数の微分 その１
    public function unit305_q05($unit,$question){
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

                $sample_text = '
                    \begin{eqnarray}
                        f\'(x) &=& \cos{('.d1($a,'x').d4($b).')} \cdot ('.d1($a,'x').d4($b).')\'\\\\
                               &=& '.d1($a,'\cos{('.d1($a,'x').d4($b).')}').'
                    \end{eqnarray}
                ';
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

                $sample_text = '
                    \begin{eqnarray}
                        f\'(x) &=& -\sin{('.d1($a,'x').d4($b).')} \cdot ('.d1($a,'x').d4($b).')\'\\\\
                               &=& '.d1(-1*$a,'\sin{('.d1($a,'x').d4($b).')}').'
                    \end{eqnarray}
                ';
                break;
            case 3:
                $item[0] = 'f\'(x) = \frac{\fbox{ア}}';
                $item[1] = '{\cos^{2}{(\fbox{イ}x';
                $item[2] = ($right_answers[2]<0?'-':'+').'\fbox{ウ})}}';

                $sample_text = '
                    \begin{eqnarray}
                        f\'(x) &=& \frac{1}{\cos^{2}{('.d1($a,'x').d4($b).')}} \cdot ('.d1($a,'x').d4($b).')\'\\\\
                               &=& \frac{'.($a).'}{\cos^{2}{('.d1($a,'x').d4($b).')}}
                    \end{eqnarray}
                ';

                break;
        }

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //三角関数の微分 その２
    public function unit305_q06($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                f\'(x) &=& ('.d1($a,'x').')\'\sin{x} + '.d1($a,'x').'(\sin{x})\' '.d2($b,'(\cos{x})\'').'\\\\
                       &=& '.d1($a,'\sin{x}').d2($a,'x\cos{x}').d2(-1*$b,'\sin{x}').'\\\\
                       &=& '.d1($a,'x\cos{x}').d2($a-$b,'\sin{x}').'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //対数関数の微分 その１
    public function unit305_q07($unit,$question){
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
        $item[4] = '\log{\fbox{エ}}}';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $sample_text = '
            \begin{eqnarray}
                f\'(x) &=& \frac{1}{('.d1($b,'x').d4($c).')\log{'.$a.'}} \cdot ('.d1($b,'x').d4($c).')\'\\\\
                       &=& \frac{'.$b.'}{('.d1($b,'x').d4($c).')\log{'.$a.'}}
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //対数関数の微分 その２
    public function unit305_q08($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                f\'(x) &=& \frac{('.d1($a,'\sin{'.$b.'}x').')\'}{'.d1($a,'\sin{'.$b.'}x').'}\\\\[5pt]
                       &=& \frac{'.d1($a*$b,'\cos{'.$b.'}x').'}{'.d1($a,'\sin{'.$b.'}x').'}\\\\[5pt]
                       &=& \frac{'.d1($b,'\cos{'.$b.'}x').'}{\sin{'.d1($b,'x').'}}
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //指数関数の微分
    public function unit305_q09($unit,$question){
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

        $sample_text = '
            f\'(x) = ('.d1($a,'x').d4($b).')\' \cdot e^{'.d1($a,'x').d4($b).'} = '.d1($a,'e^{'.d1($a,'x').d4($b).'}').'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //媒介変数表示と微分
    public function unit305_q10($unit,$question){
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

        $sample_text = '
            \frac{dy}{dx} = \frac{\frac{dy}{dt}}{\frac{dx}{dt}}\\\\
            \frac{dx}{dt} = '.($a).'、\frac{dy}{dt} = '.d1(2*$c,'t').d4($d).'より、\\\\
            \begin{eqnarray}
                \frac{dx}{dy} &=& \frac{'.d1(2*$c,'t').d4($d).'}{'.$a.'}\\\\
                              &=& '.f1(2*$c,$a,'t').f2($d,$a).'
            \end{eqnarray} 
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //曲線の凹凸と変曲点
    public function unit305_q11($unit,$question){
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

        $sample_text = '
            y = x^{4}'.d2($a,'x^{3}').d2($b,'x^{2}').d2($c,'x').d4($d).'より、\\\\
            y\' = 4x^{3}'.d2(3*$a,'x^{2}').d2(2*$b,'x').d4($c).'\\\\
            y\'\' = 12x^{2}'.d2(6*$a,'x').d4(2*$b).'\\\\
            \\\\
            y\'\' = 12x^{2}'.d2(6*$a,'x').d4(2*$b).' = 12(x'.d4($p).')(x'.d4($q).')\\\\
            x='.$p.'のとき\\ y = '.$right_answers[1].'、x='.$q.'のとき\\ y = '.$right_answers[3].'\\\\
            よって、変曲点は、('.$p.','.$right_answers[1].'),('.$q.','.$right_answers[3].')\\\\
            また、y\'\'は、
            \begin{array}{ccc}
                x \lt '.$p.' &で & y\'\' \gt 0\\\\
                '.$p.' \lt x \lt '.$q.' &で & y\'\' \lt 0\\\\
                '.$q.' \lt x &で & y\'\' \gt 0\\\\
            \end{array}\\\\
            よって、yのグラフは、
            \begin{array}{ccc}
                x \lt '.$p.' &で & 下に凸\\\\
                '.$p.' \lt x \lt '.$q.' &で & 上に凸\\\\
                '.$q.' \lt x &で & 下に凸\\\\
            \end{array}\\\\
            である。グラフの概形は以下のようになる。\\\\
        ';

        $plot = '
            <script>
                var board = JXG.JSXGraph.initBoard(\'plot\', {
                    boundingbox:[-10,10,10,-10],
                    axis: true,
                    showNavigation: true,
                    showCopyright: false
                });

                function bezier(t) {
                    return t*t*t*t + '.$a.'*t*t*t + '.$b.'*t*t + '.$c.'*t + '.$d.';
                }

                board.create(\'functiongraph\', [bezier, -10, 10]);
                board.create(\'point\',['.$p.','.$right_answers[1].'] , {name:\' \', face:\'o\', size:1, fixed:true});
                board.create(\'point\',['.$q.','.$right_answers[3].'] , {name:\' \', face:\'o\', size:1, fixed:true});
            </script>
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','plot'));
    }

    //速度と加速度
    public function unit305_q12($unit,$question){
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

        list($right_answers[0],$right_answers[1]) = root($right_answers[0],$right_answers[1]);

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

        $sample_text = '
            \frac{dx}{dt} = '.$a.'、\frac{dy}{dt} = '.d1(2*$b,'t').'、\frac{d^{2}x}{dt^{2}} = 0、\frac{d^{2}y}{dt^{2}} = '.(2*$b).'\\\\
            時間tにおける速さは、\\\\
            \sqrt{(\frac{dx}{dt})^{2}+(\frac{dy}{dt})^{2}} = \sqrt{('.$a.')^{2}+('.d1(2*$b,'t').')^{2}} = \sqrt{'.($a*$a).d2(4*$b*$b,'t^{2}').'}\\\\
            よって、t='.$d.'における速さは、'.rt2(1,$a*$a+4*$b*$b*$d*$d).'\\\\
            時間tにおける加速度の大きさは、\\\\
            \sqrt{(\frac{d^{2}x}{dt^{2}})^{2}+(\frac{d^{2}y}{dt^{2}})^{2}} = \sqrt{('.(2*$b).')^{2}} = '.abs(2*$b).'\\\\
            よって、tにかかわらず、加速度の大きさは、'.abs(2*$b).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //積分法
    //不定積分の基本
    public function unit306_q01($unit,$question){
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
        $item[2] = ($right_answers[4]<0?'-':'+').'\fbox{オ}\log{|x|}';
        $item[3] = '+C';

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $sample_text = '
            \begin{eqnarray}
                \int{(\sqrt['.$a.']{x}'.($b<0?'-':'+').'\frac{'.abs($b).'}{x})}dx &=& \int{\sqrt['.$a.']{x}}dx '.($b<0?'-':'+').'\int{\frac{'.abs($b).'}{x}}dx\\\\
                                    &=& \int{x^{\frac{1}{'.$a.'}}}dx '.($b<0?'-':'+').'\int{\frac{'.abs($b).'}{x}}dx\\\\
                                    &=& '.f1($a,$a+1,'x^{\frac{'.($a+1).'}{'.$a.'}}').d2($b,'\log{|x|}').'+C\\\\
            \end{eqnarray}
        ';


        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //三角関数の不定積分
    public function unit306_q02($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                \int{('.d1($a,'\sin{x}').d2($b,'\cos{x}').')}dx &=& \int{'.d1($a,'\sin{x}').'}dx'.($b>0?'+':'-').'\int{'.d1(abs($b),'\cos{x}').'}dx\\\\
                                &=& '.d1(-1*$a,'\cos{x}').d2($b,'\sin{x}').'+C\\\\
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //指数関数の不定積分
    public function unit306_q03($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                \int{('.d1($a,'e^{x}').'+'.$b.'^{x})}dx &=& \int{'.d1($a,'e^{x}').'}dx + \int{'.$b.'^{x}}dx\\\\
                        &=& '.d1($a,'e^{x}').'+\frac{'.$b.'^{x}}{\log{'.$b.'}}+C
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //置換積分法　その１
    public function unit306_q04($unit,$question){
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

        $sample_text = '
            \sqrt{'.$b.'-x} = t \quad とおくと、\\\\
            '.$b.'-x=t^{2} \quad x=-t^{2}'.d4($b).'より、\\\\
            \frac{dx}{dt} = -2t \quad \therefore dx = -2tdt\\\\
            したがって、\\\\
            \begin{eqnarray}
                \int{'.d1($a,'x').'\sqrt{'.$b.'-x}}\\ dx &=& \int{\{'.d1($a,'(-t^{2}'.d4($b).')t').'\}}(-2t)dt\\\\
                        &=& \int{('.d1(-1*$a,'t^{3}').d2($a*$b,'t').')(-2t)}dt\\\\
                        &=& \int{('.d1(2*$a,'t^{4}').d2(-2*$a*$b,'t^{2}').')}dt\\\\
                        &=& '.(2*$a).'\int{(t^{4}'.d2(-1*$b,'t^{2}').')}dt\\\\
                        &=& '.(2*$a).'('.f1(1,5,'t^{5}').f2($b,3,'t^{3}').')+C\\\\
                        &=& '.f1(2*$a,15,'t^{3}(3t^{2}'.d2(-5*$b).')').'+C\\\\
                        &=& '.f1(2*$a,15,'('.$b.'-x)\sqrt{'.$b.'-x}').'\{3('.$b.'-x)'.d2(-5*$b).'\}+C\\\\
                        &=& '.f1(-2*$a,15).'('.(2*$b).'+3x)('.$b.'-x)\sqrt{'.$b.'-x}+C\\\\
                        '.($s==1?'':'&=& '.f1(-2*$a*$s,15).'('.(2*$b/$s).d2(3/$s,'x').')('.$b.'-x)\sqrt{'.$b.'-x}+C').'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //置換積分法　その２
    public function unit306_q05($unit,$question){
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

        $sample_text = '
            '.d1($a,'x^{2}').d2($b,'x').d4($c).' = u\\ とおくと、\\\\
            両辺をxで微分して、\\\\
            '.d1(2*$a,'x').d4($b).' = \frac{du}{dx}\\\\
            \therefore ('.d1(2*$a,'x').d4($b).')dx = du\\\\
            したがって、\\\\
            \begin{eqnarray}
                \int{('.d1(2*$a,'x').d4($b).')\sqrt{'.d1($a,'x^{2}').d2($b,'x').d4($c).'}}\\ dx &=& \int{\sqrt{u}}du\\\\
                        &=& \frac{2}{3}u^{\frac{3}{2}}\\\\
                        &=& \frac{2}{3}('.d1($a,'x^{2}').d2($b,'x').d4($c).')^{\frac{3}{2}}
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //置換積分法　その３
    public function unit306_q06($unit,$question){
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

        $sample_text = '
            '.d1($a,'x^{2}').d4($b).' = u\\ とおくと、\\\\
            両辺をxで微分して、\\\\
            '.d1(2*$a,'x').' = \frac{du}{dx}\\\\
            \therefore xdx = \frac{1}{'.(2*$a).'}du\\\\
            したがって、\\\\
            \begin{eqnarray}
                \int{\frac{x}{'.d1($a,'x^{2}').d4($b).'}}\\ dx &=& \int{\frac{1}{u} \cdot \frac{1}{'.(2*$a).'}}du\\\\
                        &=& \frac{1}{'.(2*$a).'}\int{\frac{1}{u}}du\\\\
                        &=& \frac{1}{'.(2*$a).'}\log{|u|}+C\\\\
                        &=& \frac{1}{'.(2*$a).'}\log{|'.d1($a,'x^{2}').d4($b).'|}+C
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //部分積分法
    public function unit306_q07($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                && \int{'.d1($a,'x').'\log{(x^{2}+'.$b.')}}dx\\\\[5pt]
                 &=& '.f1($a,2,'x^{2}').'\log{(x^{2}'.d4($b).')} - \int{'.f1($a,2,'x^{2}').' \cdot \frac{2x}{x^{2}'.d4($b).'}}dx\\\\[5pt]
                 &=& '.f1($a,2,'x^{2}').'\log{(x^{2}'.d4($b).')} - \int{\frac{'.d1($a,'x^{3}').'}{x^{2}'.d4($b).'}}dx\\\\[5pt]
                 &=& '.f1($a,2,'x^{2}').'\log{(x^{2}'.d4($b).')} - \int{('.d1($a,'x').'- \frac{'.d1($a*$b,'x').'}{x^{2}'.d4($b).'})}dx\\\\[5pt]
                 &=& '.f1($a,2,'x^{2}').'\log{(x^{2}'.d4($b).')} - \{'.f1($a,2,'x^{2}').f2($a*$b,-2,'\log{(x^{2}'.d4($b).')}').'\}+C\\\\[5pt]
                 &=& '.f1($a,2,'x^{2}').'\log{(x^{2}'.d4($b).')}  '.f1($a,-2,'x^{2}').f2($a*$b,2,'\log{(x^{2}'.d4($b).')}').'+C\\\\[5pt]
                 &=& '.f1($a,2,'(x^{2}'.d4($b).')').'\log{(x^{2}'.d4($b).')} '.f2($a,-2,'x^{2}').'+C
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //分数関数の不定積分
    public function unit306_q08($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                && \int{\frac{'.d1($a,'x^{2}').d4($b).'}{x'.d4($c).'}}dx\\\\
                    &=& \int{('.d1($a,'x').d4(-1*$a*$c).($b+$a*$c*$c>0?'+':'-').'\frac{'.abs($b+$a*$c*$c).'}{x'.d4($c).'})}dx\\\\
                    &=& '.f1($a,2,'x^{2}').d2(-1*$a*$c,'x').d2($b+$a*$c*$c,'\log{|x'.d4($c).'|}').'+C
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //三角関数に関する不定積分
    public function unit306_q09($unit,$question){
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
        $item[1] = '-\frac{\fbox{エ}}{\fbox{オ}}\cos{\fbox{カ}x}';
        $item[2] = '+C';

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $sample_text = '
            \sin{('.$a.d4($b).')x} = \sin{'.d1($a,'x').'}\cos{'.d1($b,'x').'} + \cos{'.d1($a,'x').'}\sin{'.d1($b,'x').'}\\\\
            \sin{('.$a.d4(-1*$b).')x} = \sin{'.d1($a,'x').'}\cos{'.d1($b,'x').'} - \cos{'.d1($a,'x').'}\sin{'.d1($b,'x').'}\\\\
            これらの両辺を足して、\\\\
            \sin{'.d1($a+$b,'x').'} + \sin{'.d1($a-$b,'x').'} = 2\sin{'.d1($a,'x').'}\cos{'.d1($b,'x').'}\\\\
            \therefore \sin{'.d1($a,'x').'}\cos{'.d1($b,'x').'} = \frac{1}{2}\sin{'.d1($a+$b,'x').'} + \frac{1}{2}\sin{'.d1($a-$b,'x').'}\\\\
            したがって、\\\\
            \begin{eqnarray}
                && \int{\sin{'.d1($a,'x').'}\cos{'.d1($b,'x').'}}\\ dx\\\\
                    &=& \int{(\frac{1}{2}\sin{'.d1($a+$b,'x').'} + \frac{1}{2}\sin{'.d1($a-$b,'x').'})}dx\\\\
                    &=& '.f1(-1,2*($a+$b),'\cos{'.d1($a+$b,'x').'}').f2(-1,2*($a-$b),'\cos{'.d1($a-$b,'x').'}').'+C
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //定積分の置換積分法
    public function unit306_q10($unit,$question){
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

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $sample_text = '
            \sqrt{'.$c.'-x}=t \quad とおくと、\\\\
            '.$c.'-x = t^{2} \quad より、 x = -t^{2}'.d4($c).'\\\\
            両辺をtで微分して、\frac{dx}{dt} = -2t \quad \therefore dx = -2tdt\\\\
            \begin{array}{|c|ccc|}
                \hline
                x & '.$a.' & \rightarrow & '.$b.'\\\\
                \hline
                t & '.$k_1.' & \rightarrow & '.$k_2.'\\\\
                \hline
            \end{array}\\\\
            したがって、\\\\
            \begin{eqnarray}
                && \int_{'.$b.'}^{'.$a.'}{\frac{x}{\sqrt{'.$c.'-x}}}dx\\\\
                    &=& \int_{'.$k_2.'}^{'.$k_1.'}{\frac{-t^{2}'.d4($c).'}{t}}\cdot(-2t)dt\\\\
                    &=& \int_{'.$k_2.'}^{'.$k_1.'}{(2t^{2}'.d4(-2*$c).')}dt\\\\
                    &=& 2\int_{'.$k_2.'}^{'.$k_1.'}{(t^{2}'.d4(-1*$c).')}dt\\\\
                    &=& 2\left[ \frac{1}{3}t^{3}'.d2(-1*$c,'t').' \right]_{'.$k_2.'}^{'.$k_1.'}\\\\
                    &=& 2\{(\frac{1}{3} \cdot ('.$k_1.')^{3} '.d2(-1*$c,'\cdot ('.$k_1.')').') - (\frac{1}{3} \cdot ('.$k_2.')^{3} '.d2(-1*$c,'\cdot('.$k_2.')').')\}\\\\
                    &=& '.f3(2*(pow($k_1,3)-pow($k_2,3)) - 6*$c*($k_1-$k_2),3).'\\\\
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //定積分の部分積分法
    public function unit306_q11($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                && \int_{0}^{\frac{\pi}{2}}{'.d1($b,'x').'\sin{'.d1($c,'x').'}}\\ dx\\\\
                    &=& \left[ '.f1(-1*$b,$c,'x\cos{'.d1($c,'x').'}').' \right]_{0}^{\frac{\pi}{2}} - \int_{0}^{\frac{\pi}{2}}{('.f1(-1*$b,$c,'\cos{'.d1($c,'x').'}').')}dx \\\\
                    &=& \left[ '.f1(-1*$b,$c,'x\cos{'.d1($c,'x').'}').' \right]_{0}^{\frac{\pi}{2}} + \left[ '.f1($b,$c*$c,'\sin{'.d1($c,'x').'}').' \right]_{0}^{\frac{\pi}{2}}\\\\
                    &=& '.f1(-1*$b,$c,''.(abs(-1*$b/$c)==1?'':'\cdot').' \frac{\pi}{2}\cos{'.f1($c,2,'\pi').'}').' '.f2($b,$c*$c,'\sin{'.f1($c,2,'\pi').'}').'\\\\
        ';

        switch($c%4){
            case 0:
                $sample_text .= '
                        &=& '.f1(-1*$b,2*$c,'\pi').'
                    \end{eqnarray}
                ';
                break;
            case 1:
                $sample_text .= '
                        &=& '.fo(frac($b,$c*$c)).'
                    \end{eqnarray}
                ';
                break;
            case 2:
                $sample_text .= '
                        &=& '.f1($b,2*$c,'\pi').'
                    \end{eqnarray}
                ';
                break;
            case 3:
                $sample_text .= '
                        &=& '.fo(frac(-1*$b,$c*$c)).'
                    \end{eqnarray}
                ';
                break;
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //回転体の体積
    public function unit306_q12($unit,$question){
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

        $sample_text = '
            y=x^{2}'.d2($a,'x').d4($b).'\\ と、x軸の共有点は、\\\\
            x^{2}'.d2($a,'x').d4($b).'=0を解いて、x='.$p.',\\ '.$q.'\\\\
            したがって、求める体積Vは、\\\\
            \begin{eqnarray}
                V &=& \pi\int_{'.$p.'}^{'.$q.'}{(x^{2}'.d2($a,'x').d4($b).')^{2}}dx\\\\
                  &=& \pi\int_{'.$p.'}^{'.$q.'}{(x^{4}'.d2(2*$a,'x^{3}').d2($a*$a+2*$b,'x^{2}').d2(2*$a*$b,'x').d4($b*$b).')}dx\\\\
                  &=& \pi\left[ \frac{1}{5}x^{5}'.f2($a,2,'x^{4}').f2($a*$a+2*$b,3,'x^{3}').d2($a*$b,'x^{2}').d2($b*$b,'x').' \right]_{'.$p.'}^{'.$q.'}\\\\
                  &=& '.f1(6*(pow($q,5)-pow($p,5)) + 15*$a*(pow($q,4)-pow($p,4)) + 10*($a*$a+2*$b)*(pow($q,3)-pow($p,3)) + 30*$a*$b*(pow($q,2)-pow($p,2)) + 30*$b*$b*($q-$p),30,'\pi').'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }


    //数学A
    //場合の数と確率
    //約数の個数とその和
    public function unit401_q01($unit,$question){
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

        $p = '';    $q = '';    $r = '';
        for($i=0;$i<count($ex);$i++){
            $p .= $base[$i].'^{'.$ex[$i].'}';
            if($i != count($ex)-1){
                $p .= ' \cdot ';
            }
            $q .= '('.$ex[$i].'+1)';
            
            $r .= '(1';
            for($j=1;$j<=$ex[$i];$j++){
                $r .= '+'.$base[$i].'^{'.$j.'}';
            }
            $r .= ')';
        }

        $sample_text = '
            '.$N.'を素因数分解して、'.$N.' = '.$p.'\\\\
            よって、約数の個数は、\\\\
            '.$q.' = '.$right_answers[0].'\\\\
            また、約数の総和は、\\\\
            '.$r.' = '.$right_answers[1].'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //順列、組み合わせ、階乗の記号
    public function unit401_q02($unit,$question){
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

        $p = '';    $q = '';    $r = '';    $s = '';

        for($i=$a;$i>$a-$b;$i--){
            $p .= $i;
            if($i!=$a-$b+1){
                $p .= ' \cdot ';
            }
        }
        for($i=$c;$i>$c-$d;$i--){
            $q .= $i;
            if($i!=$c-$d+1){
                $q .= ' \cdot ';
            }
        }
        for($i=$d;$i>=1;$i--){
            $r .= $i;
            if($i!=1){
                $r .= ' \cdot ';
            }
        }
        for($i=$e;$i>=1;$i--){
            $s .= $i;
            if($i!=1){
                $s .= ' \cdot ';
            }
        }


        $sample_text = '
            {}_'.$a.' \mathrm{P}_'.$b.' = '.$p.' = '.$right_answers[0].'\\\\
            {}_'.$c.' \mathrm{C}_'.$d.' = \frac{'.$q.'}{'.$r.'} = '.$right_answers[1].'\\\\
            '.$e.'! = '.$s.' = '.$right_answers[2].'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //順列
    public function unit401_q03($unit,$question){
        //初期設定
        $question_id = 40103;
        $blanks = 2;
        $option = $this->option;

        //変数の設定
        $a = rand(2,5);
        $b = rand(3,5);

        //答えの計算
        $right_answers[0] = gmp_fact($a+$b);
        $right_answers[1] = $b*($b-1)*gmp_fact($a+$b-2);
        
        //問題テキストの設定
        $text = '$$ 男子'.$a.'人、女子'.$b.'人が一列に並ぶ。\\\\';

        //空欄テキストの設定
        $item[0] = 'この並び方の総数は、\fbox{ア}通り、\\\\';
        $item[1] = '両端が女子になる並び方は、\fbox{イ}通り';

        $sample_text = '
            合計'.($a+$b).'人が並ぶ並び方の総数は、'.($a+$b).'! = '.$right_answers[0].'\\\\
            端が女子になる並び方は、\\\\
            女子'.$b.'人のうち端になる2人を選んで並べる総数が、{}_'.$b.' \mathrm{P}_2 = '.($b*($b-1)).'\\\\
            残りの'.($a+$b-2).'人の並び方の総数が、'.($a+$b-2).'! = '.gmp_fact($a+$b-2).'\\\\
            よって、'.($b*($b-1)).' \cdot '.gmp_fact($a+$b-2).' = '.$right_answers[1].'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //円順列
    public function unit401_q04($unit,$question){
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

        $sample_text = '
            '.$a.'人での円順列になるので、その並び方の総数は、\\\\
            ('.$a.'-1)! = '.($a-1).'! = '.$right_answers[0].'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //重複順列
    public function unit401_q05($unit,$question){
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

        $sample_text = '
            1冊も取らなくてもいい場合、\\\\
            それぞれの本に対して、取られるか取られないかの2通り\\\\
            よって、取り方の総数は、2^'.$a.' = '.$right_answers[0].'\\\\
            1冊以上取る場合、\\\\
            すべて取らない場合が1通りあるので、\\\\
            その取り方の総数は、'.$right_answers[0].'-1 = '.$right_answers[1].'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //組み合わせ
    public function unit401_q06($unit,$question){
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

        $sample_text = '
            合計'.($a+$b).'人から'.$c.'人を選ぶ選び方の総数は、\\\\
            {}_{'.($a+$b).'} \mathrm{C}_{'.$c.'} = '.$right_answers[0].'\\\\
            男子'.$a.'人から'.$d.'人を、女子'.$b.'人から'.$e.'人を選ぶ選び方の総数は、\\\\
            {}_{'.$a.'} \mathrm{C}_{'.$d.'} \cdot {}_{'.$b.'} \mathrm{C}_{'.$e.'} = '.(gmp_fact($a)/(gmp_fact($d)*gmp_fact($a-$d))).' \cdot '.(gmp_fact($b)/(gmp_fact($e)*gmp_fact($b-$e))).'
             = '.$right_answers[1].'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //同じものを含む順列
    public function unit401_q07($unit,$question){
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

        $sample_text = '
            AからCまで最短距離で向かうとき、\\\\
            上に'.$a.'回、右に'.$b.'回進む。\\\\
            上に行くことを\uparrow、右に行くことを\rightarrowを表すと、\\\\
            経路の総数は\uparrow'.$a.'個と\rightarrow'.$b.'個を並び替える総数と等しく、\\\\
            その経路数は、\\\\
            \frac{'.($a+$b).'!}{'.$a.'! \cdot '.$b.'!} = '.$right_answers[0].'\\\\
            AからBを通ってCまで最短距離で向かうとき、\\\\
            AからBまでは、\uparrow'.$d.'個と\rightarrow'.$c.'個を\\\\
            BからCまでは、\uparrow'.($a-$d).'個と\rightarrow'.($b-$c).'個を\\\\
            それぞれ並び替える総数に等しいので、\\\\
            その経路数は、\\\\
            \frac{'.($c+$d).'!}{'.$c.'! \cdot '.$d.'!} \cdot \frac{'.($a+$b-$c-$d).'!}{'.($a-$d).'! \cdot '.($b-$c).'!} = '.$right_answers[1].'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/canvas',compact('right_answers','unit','question','text','blank_text','blanks','start','canvas','script','sample_text'));
    }

    //確率の基本
    public function unit401_q08($unit,$question){
        //初期設定
        $question_id = 40108;
        $blanks = 6;
        $option = $this->option;

        //変数の設定
        $r_1 = rand(1,6);
        $r_2 = rand(1,6);
        $a = $r_1*$r_2;
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
        $count[0] = $right_answers[2];  $count[1] = abs($right_answers[4]);
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

        $sample_text = '
            積が'.$a.'になるのは、\\\\
            '.dice_m($a).'\\\\
            の'.$list_2[array_search($a,$list_1)].'通りなので、確率は\\ '.f3($list_2[array_search($a,$list_1)],36).'\\\\
            積が'.$b.'の倍数になるのもののうち、\\\\
        ';

        for($i=0;$i<18;$i++){
            if($list_1[$i]%$b === 0){
                $sample_text .= '
                    積が'.$list_1[$i].'になるのは、\\\\
                    '.dice_m($list_1[$i]).'\\\\
                ';
            }
        }

        $sample_text .= '
            の'.$count[0].'通りなので、その確率は、'.f3($right_answers[2],$right_answers[3]).'\\\\
            積が'.$b.'の倍数かつ'.$a.'になるものは、\\\\
        ';

        $flag = 0;
        for($i=0;$i<18;$i++){
            if($list_1[$i]%$b === 0 && $list_1[$i] === $a){
                if($flag == 0){
                    $sample_text .= '
                        '.dice_m($list_1[$i]).'
                    ';
                    $flag = 1;
                }else{
                    $sample_text .= '
                        ,'.dice_m($list_1[$i]).'
                    ';
                }
            }
        }
        if($flag === 0){
            $sample_text .= '
                存在しないので、\\\\
                積が'.$b.'の倍数または'.$a.'になるときの確率は、\\\\
                \frac{'.($list_2[array_search($a,$list_1)]).' + '.$count[0].' '.($count[1] != 0 ? '-'.$count[1] : '' ).'}{36} = '.f3($right_answers[4],$right_answers[5]).'
            ';
        }else{
            $sample_text .= '
                \\\\の'.$count[1].'通りなので、\\\\
                積が'.$b.'の倍数または'.$a.'になるときの確率は、\\\\
                \frac{'.($list_2[array_search($a,$list_1)]).' + '.$count[0].' '.($count[1] =! 0 ? '-'.$count[1] : '' ).'}{36} = '.f3($right_answers[4],$right_answers[5]).'
            ';
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //余事象の確率
    public function unit401_q09($unit,$question){
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

        $sample_text = '
            全員が男子の場合の確率は、\\\\
            \frac{{}_{'.$a.'} \mathrm{C}_{'.$c.'}}{{}_{'.($a+$b).'} \mathrm{C}_{'.$c.'}} = '.f3(gmp_fact($a)*gmp_fact($a+$b-$c),gmp_fact($a-$c)*gmp_fact($a+$b)).'\\\\
            よって、少なくとも一人は女子が含まれる確率は、\\\\
            余事象を考えて、\\\\
            1 - '.f3(gmp_fact($a)*gmp_fact($a+$b-$c),gmp_fact($a-$c)*gmp_fact($a+$b)).' = '.f3($right_answers[0],$right_answers[1]).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //反復試行の確率
    public function unit401_q10($unit,$question){
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

        $sample_text = '
            赤玉を引く確率は\\ '.f3($a,$a+$b).'\\\\
            白玉を引く確率は\\ '.f3($b,$a+$b).'\\\\
            よって、赤玉を'.$d.'回、白玉を'.($c-$d).'回引く確率は、\\\\
            順番も考慮して、\\\\
            \frac{'.$c.'!}{'.$d.'! \cdot '.($c-$d).'!} \cdot ('.f3($a,$a+$b).')^{'.$d.'} \cdot ('.f3($b,$a+$b).')^{'.($c-$d).'}
                = '.f3($right_answers[0],$right_answers[1]).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //条件付き確率
    public function unit401_q11($unit,$question){
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

        $sample_text = '
            定期券利用者の確率をP(A)\\\\
            学生の利用者の確率をP(B)とおくと、\\\\
            P(A) = '.f3($a,100).',\\ P(B) = '.f3($b,100).'\\\\
            よって、定期券利用者を選んだ時、その人が学生である\\\\
            条件付き確率P_A(B)は、\\\\
            P_A(B) = \frac{P(A \cap B)}{P(A)} = '.f3($b,$a).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //図形の性質
    //三角形の重心
    public function unit402_q01($unit,$question){
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

        $sample_text = '
            三平方の定理より、\\\\
            AM = \sqrt{('.$a.')^2 - ('.f3($b,2).')^2} = '.fr_rt2(1,4*$a*$a-$b*$b,2).'\\\\
            重心は、各点から対辺の中点へ引いた\\\\
            線分を2:1に内分するので、\\\\
            AG = \frac{2}{3}AM = '.fr_rt2(1,4*$a*$a-$b*$b,3).'
        ';

        $a_script = '
            <script type="text/javascript">
                window.onload = function draw() {
                    var canvas = document.getElementById(\'canvas\');
                    if (canvas.getContext) {
                        var point_A = canvas.getContext(\'2d\');
                        point_A.beginPath();
                        point_A.arc(175,20, 3, 0, 2 * Math.PI);
                        point_A.fill() ;

                        var point_B = canvas.getContext(\'2d\');
                        point_B.beginPath();
                        point_B.arc(50,170, 3, 0, 2 * Math.PI);
                        point_B.fill() ;

                        var point_C = canvas.getContext(\'2d\');
                        point_C.beginPath();
                        point_C.arc(300,170, 3, 0, 2 * Math.PI);
                        point_C.fill() ;

                        var point_G = canvas.getContext(\'2d\');
                        point_G.beginPath();
                        point_G.arc(175,120, 3, 0, 2 * Math.PI);
                        point_G.fill() ;

                        var point_M = canvas.getContext(\'2d\');
                        point_M.beginPath();
                        point_M.arc(175,170, 3, 0, 2 * Math.PI);
                        point_M.fill() ;

                        var tri = canvas.getContext(\'2d\');
                        tri.beginPath();
                        tri.moveTo(175,20);
                        tri.lineTo(50,170);
                        tri.lineTo(300,170);
                        tri.lineTo(175,20);
                        tri.stroke();

                        var dash = canvas.getContext(\'2d\');
                        dash.beginPath();
                        dash.setLineDash([2, 2]);
                        dash.moveTo(175,20);
                        dash.lineTo(175,170);
                        dash.stroke();

                        var A = canvas.getContext(\'2d\');
                        A.fillStyle = \'blue\';
                        A.font = \'15pt Arial\';
                        A.fillText(\'A\', 180, 20);

                        var B = canvas.getContext(\'2d\');
                        B.fillStyle = \'blue\';
                        B.font = \'15pt Arial\';
                        B.fillText(\'B\', 40, 160);

                        var C = canvas.getContext(\'2d\');
                        C.fillStyle = \'blue\';
                        C.font = \'15pt Arial\';
                        C.fillText(\'C\', 310, 160);

                        var G = canvas.getContext(\'2d\');
                        G.fillStyle = \'blue\';
                        G.font = \'15pt Arial\';
                        G.fillText(\'G\',180,120);

                        var M = canvas.getContext(\'2d\');
                        M.fillStyle = \'blue\';
                        M.font = \'15pt Arial\';
                        M.fillText(\'M\',180,180);
                    }
                }
            </script>';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','a_script'));
    }

    //三角形の内心
    public function unit402_q02($unit,$question){
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

        $sample_text = '
            角の二等分線と辺の比の関係より、\\\\
            BD:DC = AB:AC = '.$a.':'.$c.' '.(gmp_gcd($a,$c)!=1 ?'= '.($a/gmp_gcd($a,$c)).':'.($c)/gmp_gcd($a,$c).'':'').'\\\\
            よって、BD = \frac{'.($a/gmp_gcd($a,$c)).'}{'.($a/gmp_gcd($a,$c)).'+'.($c/gmp_gcd($a,$c)).'}BC = '.f3($a*$b,$a+$c).'\\\\
            三角形の頂点と内心をつなぐ線分は、角の二等分線となるので、\\\\
            BIは \angle{ABC} の二等分線となる。\\\\
            よって、\triangle{ABD} に着目すると、\\\\
            AI:ID = BA:BD = '.$a.':'.f3($a*$b,$a+$c).' = '.$right_answers[2].':'.$right_answers[3].'
        ';

        //空欄テキストの設定
        $item[0] = 'BD = \frac{\fbox{ア}}{\fbox{イ}}、';
        $item[1] = 'AI:ID = \fbox{ウ}:\fbox{エ}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        $p[0] = 120;    $p[1] = 20;
        $q = 50;     $r = 300;
        $s = 170;

        $A = 250;   $B = sqrt(180*180+140*140);     $C = sqrt(70*70+140*140);
        $i[0] = ($A*$p[0]+$B*$q+$C*$r)/($A+$B+$C);
        $i[1] = ($A*$p[1]+$B*$s+$C*$s)/($A+$B+$C);

        $a_script = '
            <script type="text/javascript">
                window.onload = function draw() {
                    var canvas = document.getElementById(\'canvas\');
                    if (canvas.getContext) {
                        var point_A = canvas.getContext(\'2d\');
                        point_A.beginPath();
                        point_A.arc('.$p[0].','.$p[1].', 3, 0, 2 * Math.PI);
                        point_A.fill() ;

                        var point_B = canvas.getContext(\'2d\');
                        point_B.beginPath();
                        point_B.arc('.$q.','.$s.', 3, 0, 2 * Math.PI);
                        point_B.fill() ;

                        var point_C = canvas.getContext(\'2d\');
                        point_C.beginPath();
                        point_C.arc('.$r.','.$s.', 3, 0, 2 * Math.PI);
                        point_C.fill() ;

                        var point_D = canvas.getContext(\'2d\');
                        point_D.beginPath();
                        point_D.arc('.(($B*$q+$C*$r)/($B+$C)).','.$s.', 3, 0, 2 * Math.PI);
                        point_D.fill() ;

                        var point_I = canvas.getContext(\'2d\');
                        point_I.beginPath();
                        point_I.arc('.$i[0].','.$i[1].', 3, 0, 2 * Math.PI);
                        point_I.fill() ;

                        var tri = canvas.getContext(\'2d\');
                        tri.beginPath();
                        tri.moveTo('.$p[0].','.$p[1].');
                        tri.lineTo('.$q.','.$s.');
                        tri.lineTo('.$r.','.$s.');
                        tri.lineTo('.$p[0].','.$p[1].');
                        tri.stroke();

                        var dash_A = canvas.getContext(\'2d\');
                        dash_A.beginPath();
                        dash_A.setLineDash([2, 2]);
                        dash_A.moveTo('.$p[0].','.$p[1].');
                        dash_A.lineTo('.(($B*$q+$C*$r)/($B+$C)).','.$s.');
                        dash_A.stroke();

                        var dash_B = canvas.getContext(\'2d\');
                        dash_B.beginPath();
                        dash_B.setLineDash([2, 2]);
                        dash_B.moveTo('.$q.','.$s.');
                        dash_B.lineTo('.(($A*$p[0]+$C*$r)/($A+$C)).','.(($A*$p[1]+$C*$s)/($A+$C)).');
                        dash_B.stroke();

                        var dash_C = canvas.getContext(\'2d\');
                        dash_C.beginPath();
                        dash_C.setLineDash([2, 2]);
                        dash_C.moveTo('.$r.','.$s.');
                        dash_C.lineTo('.(($A*$p[0]+$B*$q)/($A+$B)).','.(($A*$p[1]+$B*$s)/($A+$B)).');
                        dash_C.stroke();

                        var A = canvas.getContext(\'2d\');
                        A.fillStyle = \'blue\';
                        A.font = \'15pt Arial\';
                        A.fillText(\'A\', 130, 20);

                        var B = canvas.getContext(\'2d\');
                        B.fillStyle = \'blue\';
                        B.font = \'15pt Arial\';
                        B.fillText(\'B\', 40, 160);

                        var C = canvas.getContext(\'2d\');
                        C.fillStyle = \'blue\';
                        C.font = \'15pt Arial\';
                        C.fillText(\'C\', 310, 160);

                        var D = canvas.getContext(\'2d\');
                        D.fillStyle = \'blue\';
                        D.font = \'15pt Arial\';
                        D.fillText(\'D\', '.(($B*$q+$C*$r)/($B+$C)).','.$s.'+20);

                        var I = canvas.getContext(\'2d\');
                        I.fillStyle = \'blue\';
                        I.font = \'15pt Arial\';
                        I.fillText(\'I\','.$i[0].'+10,'.$i[1].'+10);
                    }
                }
            </script>';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','a_script'));
    }

    //三角形の外心
    public function unit402_q03($unit,$question){
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

    
        $alpha = (int)(floor($alpha*180/pi())%2==0?floor($alpha*180/pi()):floor($alpha*180/pi())+1);
        $beta = (int)floor($beta*180/pi());
        $text = '$$ 上図において、Oは\triangle{ABC}の外心である。\\\\
                 \alpha = '.$alpha.'^\circ、\beta = '.$beta.'^\circのとき、';

        //空欄テキストの設定
        $item[0] = '\angle{OCA} = \fbox{ア}^\circである。';

        
        $sample_text = '
            中心角と円周角の関係より、\\\\
            \angle{ACB} = \frac{1}{2}\angle{AOB} = '.f3($alpha,2).'^\circ\\\\
            \triangle{AOC}は二等辺三角形なので、\\\\
            \angle{OCA} = \angle{OAC} = '.$beta.'^\circ\\\\
            よって、\\\\
            \angle{BCO} = \angle{ACB} - \angle{OCA} = '.f3($alpha-2*$beta,2).'\\\\
        ';

        $a_script = $script;

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/canvas',compact('right_answers','unit','question','text','blank_text','blanks','start','canvas','script','sample_text','a_script'));
    }

    //チェバ、メネラウスの定理
    public function unit402_q04($unit,$question){
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

        $sample_text = '
            チェバの定理より、\\\\
            \frac{BR}{RC} \cdot \frac{CQ}{QA} \cdot \frac{AP}{PB} = 1\\\\
            \frac{BR}{RC} \cdot \frac{'.$d.'}{'.$c.'} \cdot \frac{'.$a.'}{'.$b.'} = 1\\\\
            \therefore \frac{BR}{RC} = '.f3($b*$c,$a*$d).'\\\\
            よって、BR:RC = '.$right_answers[0].':'.$right_answers[1].'\\\\
            また、メネラウスの定理より、\\\\
            \frac{AP}{PB} \cdot \frac{BC}{CR} \cdot \frac{RO}{OA} = 1\\\\
            \frac{'.$a.'}{'.$b.'} \cdot \frac{'.($right_answers[0]+$right_answers[1]).'}{'.$right_answers[1].'} \cdot \frac{RO}{OA} = 1\\\\
            \therefore \frac{AO}{OR} = '.f3($b*$c+$a*$d,$b*$d).'\\\\
            よって、AO:OR = '.$right_answers[2].':'.$right_answers[3].'\\\\
        ';

        $x[0] = 120;    $x[1] = 20;
        $y[0] = 50;     $z[0] = 300;
        $y[1] = 170;    $z[1] = 170;

        $e = $right_answers[0];     $f = $right_answers[1];

        $p[0] = ($b*$x[0]+$a*$y[0])/($a+$b);    $p[1] = ($b*$x[1]+$a*$y[1])/($a+$b);
        $q[0] = ($d*$x[0]+$c*$z[0])/($c+$d);    $q[1] = ($d*$x[1]+$c*$z[1])/($c+$d);
        $r[0] = ($f*$y[0]+$e*$z[0])/($e+$f);    $r[1] = ($f*$y[1]+$e*$z[1])/($e+$f);

        $o[0] = ($right_answers[3]*$x[0]+$right_answers[2]*$r[0])/($right_answers[2]+$right_answers[3]);    $o[1] = ($right_answers[3]*$x[1]+$right_answers[2]*$r[1])/($right_answers[2]+$right_answers[3]);

        $a_script = '
            <script type="text/javascript">
                window.onload = function draw() {
                    var canvas = document.getElementById(\'canvas\');
                    if (canvas.getContext) {
                        var point_A = canvas.getContext(\'2d\');
                        point_A.beginPath();
                        point_A.arc('.$x[0].','.$x[1].', 3, 0, 2 * Math.PI);
                        point_A.fill() ;

                        var point_B = canvas.getContext(\'2d\');
                        point_B.beginPath();
                        point_B.arc('.$y[0].','.$y[1].', 3, 0, 2 * Math.PI);
                        point_B.fill() ;

                        var point_C = canvas.getContext(\'2d\');
                        point_C.beginPath();
                        point_C.arc('.$z[0].','.$z[1].', 3, 0, 2 * Math.PI);
                        point_C.fill() ;

                        var point_P = canvas.getContext(\'2d\');
                        point_P.beginPath();
                        point_P.arc('.$p[0].','.$p[1].', 3, 0, 2 * Math.PI);
                        point_P.fill() ;

                        var point_Q = canvas.getContext(\'2d\');
                        point_Q.beginPath();
                        point_Q.arc('.$q[0].','.$q[1].', 3, 0, 2 * Math.PI);
                        point_Q.fill() ;

                        var point_R = canvas.getContext(\'2d\');
                        point_R.beginPath();
                        point_R.arc('.$r[0].','.$r[1].', 3, 0, 2 * Math.PI);
                        point_R.fill() ;

                        var point_O = canvas.getContext(\'2d\');
                        point_O.beginPath();
                        point_O.arc('.$o[0].','.$o[1].', 3, 0, 2 * Math.PI);
                        point_O.fill() ;

                        var tri = canvas.getContext(\'2d\');
                        tri.beginPath();
                        tri.moveTo('.$x[0].','.$x[1].');
                        tri.lineTo('.$y[0].','.$y[1].');
                        tri.lineTo('.$z[0].','.$z[1].');
                        tri.lineTo('.$x[0].','.$x[1].');
                        tri.stroke();

                        var dash_A = canvas.getContext(\'2d\');
                        dash_A.beginPath();
                        dash_A.setLineDash([2, 2]);
                        dash_A.moveTo('.$x[0].','.$x[1].');
                        dash_A.lineTo('.$r[0].','.$r[1].');
                        dash_A.stroke();

                        var dash_B = canvas.getContext(\'2d\');
                        dash_B.beginPath();
                        dash_B.setLineDash([2, 2]);
                        dash_B.moveTo('.$y[0].','.$y[1].');
                        dash_B.lineTo('.$q[0].','.$q[1].');
                        dash_B.stroke();

                        var dash_C = canvas.getContext(\'2d\');
                        dash_C.beginPath();
                        dash_C.setLineDash([2, 2]);
                        dash_C.moveTo('.$z[0].','.$z[1].');
                        dash_C.lineTo('.$p[0].','.$p[1].');
                        dash_C.stroke();

                        var A = canvas.getContext(\'2d\');
                        A.fillStyle = \'blue\';
                        A.font = \'15pt Arial\';
                        A.fillText(\'A\', 130, 20);

                        var B = canvas.getContext(\'2d\');
                        B.fillStyle = \'blue\';
                        B.font = \'15pt Arial\';
                        B.fillText(\'B\', 40, 160);

                        var C = canvas.getContext(\'2d\');
                        C.fillStyle = \'blue\';
                        C.font = \'15pt Arial\';
                        C.fillText(\'C\', 310, 160);

                        var P = canvas.getContext(\'2d\');
                        P.fillStyle = \'blue\';
                        P.font = \'15pt Arial\';
                        P.fillText(\'P\', '.$p[0].', '.$p[1].');

                        var Q = canvas.getContext(\'2d\');
                        Q.fillStyle = \'blue\';
                        Q.font = \'15pt Arial\';
                        Q.fillText(\'Q\', '.$q[0].', '.$q[1].');

                        var R = canvas.getContext(\'2d\');
                        R.fillStyle = \'blue\';
                        R.font = \'15pt Arial\';
                        R.fillText(\'R\', '.$r[0].', '.$r[1].');

                        var O = canvas.getContext(\'2d\');
                        O.fillStyle = \'blue\';
                        O.font = \'15pt Arial\';
                        O.fillText(\'O\', '.$o[0].', '.$o[1].');
                    }
                }
            </script>';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','a_script'));
    }

    //三角形の面積比
    public function unit402_q05($unit,$question){
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

        $sample_text = '
            メネラウスの定理より、\\\\
            \frac{AP}{PB} \cdot \frac{BC}{CQ} \cdot \frac{QR}{RA} = 1\\\\
            \frac{'.$a.'}{'.$b.'} \cdot \frac{'.($c+$d).'}{'.$d.'} \cdot \frac{QR}{RA} = 1\\\\
            \therefore \frac{AR}{RQ} = '.f3($a*($c+$d),$b*$d).'\\\\
            よって、\\\\
            \begin{eqnarray}
                \triangle{BPR} &=& '.f3($b,$a+$b).'\triangle{ABR}\\\\
                               &=& '.f3($b,$a+$b).' \cdot '.f3($a*($c+$d),$a*($c+$d)+$b*$d).' \triangle{ABQ}\\\\
                               &=& '.f3($b,$a+$b).' \cdot '.f3($a*($c+$d),$a*($c+$d)+$b*$d).' \cdot '.f3($c,$c+$d).' \triangle{ABC}\\\\
                               &=& '.f3($right_answers[3],$right_answers[2]).' \triangle{ABC}\\\\
            \end{eqnarray}\\\\
            したがって、\triangle{ABC}:\triangle{BPR} = '.$right_answers[2].':'.$right_answers[3].'\\\\
        ';

        $x[0] = 120;    $x[1] = 20;
        $y[0] = 50;     $z[0] = 300;
        $y[1] = 170;    $z[1] = 170;

        $p[0] = ($b*$x[0]+$a*$y[0])/($a+$b);    $p[1] = ($b*$x[1]+$a*$y[1])/($a+$b);
        $q[0] = ($d*$y[0]+$c*$z[0])/($c+$d);    $q[1] = ($d*$y[1]+$c*$z[1])/($c+$d);
        $r[0] = ($right_answers[1]*$x[0]+$right_answers[0]*$q[0])/($right_answers[0]+$right_answers[1]);    $r[1] = ($right_answers[1]*$x[1]+$right_answers[0]*$q[1])/($right_answers[0]+$right_answers[1]);

        $a_script = '
            <script type="text/javascript">
                window.onload = function draw() {
                    var canvas = document.getElementById(\'canvas\');
                    if (canvas.getContext) {
                        var point_A = canvas.getContext(\'2d\');
                        point_A.beginPath();
                        point_A.arc('.$x[0].','.$x[1].', 3, 0, 2 * Math.PI);
                        point_A.fill() ;

                        var point_B = canvas.getContext(\'2d\');
                        point_B.beginPath();
                        point_B.arc('.$y[0].','.$y[1].', 3, 0, 2 * Math.PI);
                        point_B.fill() ;

                        var point_C = canvas.getContext(\'2d\');
                        point_C.beginPath();
                        point_C.arc('.$z[0].','.$z[1].', 3, 0, 2 * Math.PI);
                        point_C.fill() ;

                        var point_P = canvas.getContext(\'2d\');
                        point_P.beginPath();
                        point_P.arc('.$p[0].','.$p[1].', 3, 0, 2 * Math.PI);
                        point_P.fill() ;

                        var point_Q = canvas.getContext(\'2d\');
                        point_Q.beginPath();
                        point_Q.arc('.$q[0].','.$q[1].', 3, 0, 2 * Math.PI);
                        point_Q.fill() ;

                        var point_R = canvas.getContext(\'2d\');
                        point_R.beginPath();
                        point_R.arc('.$r[0].','.$r[1].', 3, 0, 2 * Math.PI);
                        point_R.fill() ;

                        var tri = canvas.getContext(\'2d\');
                        tri.beginPath();
                        tri.moveTo('.$x[0].','.$x[1].');
                        tri.lineTo('.$y[0].','.$y[1].');
                        tri.lineTo('.$z[0].','.$z[1].');
                        tri.lineTo('.$x[0].','.$x[1].');
                        tri.stroke();

                        var tri_2 = canvas.getContext(\'2d\');
                        tri_2.beginPath();
                        tri_2.moveTo('.$y[0].','.$y[1].');
                        tri_2.lineTo('.$r[0].','.$r[1].');
                        tri_2.lineTo('.$p[0].','.$p[1].');
                        tri_2.lineTo('.$y[0].','.$y[1].');
                        tri_2.fill();

                        var dash_A = canvas.getContext(\'2d\');
                        dash_A.beginPath();
                        dash_A.setLineDash([2, 2]);
                        dash_A.moveTo('.$x[0].','.$x[1].');
                        dash_A.lineTo('.$q[0].','.$q[1].');
                        dash_A.stroke();

                        var dash_C = canvas.getContext(\'2d\');
                        dash_C.beginPath();
                        dash_C.setLineDash([2, 2]);
                        dash_C.moveTo('.$z[0].','.$z[1].');
                        dash_C.lineTo('.$p[0].','.$p[1].');
                        dash_C.stroke();

                        var A = canvas.getContext(\'2d\');
                        A.fillStyle = \'blue\';
                        A.font = \'15pt Arial\';
                        A.fillText(\'A\', 130, 20);

                        var B = canvas.getContext(\'2d\');
                        B.fillStyle = \'blue\';
                        B.font = \'15pt Arial\';
                        B.fillText(\'B\', 40, 160);

                        var C = canvas.getContext(\'2d\');
                        C.fillStyle = \'blue\';
                        C.font = \'15pt Arial\';
                        C.fillText(\'C\', 310, 160);

                        var P = canvas.getContext(\'2d\');
                        P.fillStyle = \'blue\';
                        P.font = \'15pt Arial\';
                        P.fillText(\'P\', '.$p[0].', '.$p[1].');

                        var Q = canvas.getContext(\'2d\');
                        Q.fillStyle = \'blue\';
                        Q.font = \'15pt Arial\';
                        Q.fillText(\'Q\', '.$q[0].', '.$q[1].');

                        var R = canvas.getContext(\'2d\');
                        R.fillStyle = \'blue\';
                        R.font = \'15pt Arial\';
                        R.fillText(\'R\', '.$r[0].', '.$r[1].');

                    }
                }
            </script>';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','a_script'));
    }

    //円に内接する四角形
    public function unit402_q06($unit,$question){
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

        $sample_text = '
            円に内接する四角形の対角は足して180^\circになるので、\\\\
            \beta = 180^\circ - \alpha = '.$right_answers[0].'^\circ
        ';

        $a_script = $script;

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/canvas',compact('right_answers','unit','question','text','blank_text','blanks','start','canvas','script','sample_text','a_script'));
    }

    //円の接線
    public function unit402_q07($unit,$question){
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

        $sample_text = '
            BR = BP = '.$b.'\\ より、\\\\
            AR = '.$a.' - '.$b.' = '.($a-$b).'\\\\
            よって、AQ = AR = '.($a-$b).'\\\\
            また、CQ = CP = '.$c.'\\\\
            したがって、AC = AQ + CQ = '.$right_answers[0].'
        ';

        $x[0] = 120;    $x[1] = 20;
        $y[0] = 50;     $y[1] = 170;
        $z[0] = 300;    $z[1] = 170;

        $A = 250;   $B = sqrt(180*180+150*150);     $C = sqrt(70*70+150*150);
        $i[0] = ($A*$x[0]+$B*$y[0]+$C*$z[0])/($A+$B+$C);
        $i[1] = ($A*$x[1]+$B*$y[1]+$C*$z[1])/($A+$B+$C);
        $p[0] = $i[0];
        $p[1] = (($i[0]-$y[0])*($z[1]-$y[1]))/($z[0]-$y[0]) + $y[1];
        $q[0] = (pow($z[0]-$x[0],2))/($B*$B)*$i[0] + ($z[0]-$x[0])*($z[1]-$x[1])*($i[1]-$x[1])/($B*$B) + pow(($z[1]-$x[1])/$B,2)*$x[0];
        $q[1] = ($z[1]-$x[1])/($z[0]-$x[0])*($q[0]-$x[0]) + $x[1];
        $r[0] = (pow($y[0]-$x[0],2))/($C*$C)*$i[0] + ($y[0]-$x[0])*($y[1]-$x[1])*($i[1]-$x[1])/($C*$C) + pow(($y[1]-$x[1])/$C,2)*$x[0];
        $r[1] = ($y[1]-$x[1])/($y[0]-$x[0])*($r[0]-$x[0]) + $x[1];
        $s = sqrt(pow($i[0]-$p[0],2)+pow($i[1]-$p[1],2));

        $a_script = '
            <script type="text/javascript">
                window.onload = function draw() {
                    var canvas = document.getElementById(\'canvas\');
                    if (canvas.getContext) {
                        var point_A = canvas.getContext(\'2d\');
                        point_A.beginPath();
                        point_A.arc('.$x[0].','.$x[1].', 3, 0, 2 * Math.PI);
                        point_A.fill() ;

                        var point_B = canvas.getContext(\'2d\');
                        point_B.beginPath();
                        point_B.arc('.$y[0].','.$y[1].', 3, 0, 2 * Math.PI);
                        point_B.fill() ;

                        var point_C = canvas.getContext(\'2d\');
                        point_C.beginPath();
                        point_C.arc('.$z[0].','.$z[1].', 3, 0, 2 * Math.PI);
                        point_C.fill() ;

                        var point_I = canvas.getContext(\'2d\');
                        point_I.beginPath();
                        point_I.arc('.$i[0].','.$i[1].', 3, 0, 2 * Math.PI);
                        point_I.fill() ;

                        var point_P = canvas.getContext(\'2d\');
                        point_P.beginPath();
                        point_P.arc('.$p[0].','.$p[1].', 3, 0, 2 * Math.PI);
                        point_P.fill() ;

                        var point_Q = canvas.getContext(\'2d\');
                        point_Q.beginPath();
                        point_Q.arc('.$q[0].','.$q[1].', 3, 0, 2 * Math.PI);
                        point_Q.fill() ;

                        var point_R = canvas.getContext(\'2d\');
                        point_R.beginPath();
                        point_R.arc('.$r[0].','.$r[1].', 3, 0, 2 * Math.PI);
                        point_R.fill() ;

                        var tri = canvas.getContext(\'2d\');
                        tri.beginPath();
                        tri.moveTo('.$x[0].','.$x[1].');
                        tri.lineTo('.$y[0].','.$y[1].');
                        tri.lineTo('.$z[0].','.$z[1].');
                        tri.lineTo('.$x[0].','.$x[1].');
                        tri.stroke();

                        var circle = canvas.getContext(\'2d\');
                        circle.beginPath();
                        circle.arc('.$i[0].','.$i[1].', '.$s.', 0, 2 * Math.PI);
                        circle.stroke() ;

                        var dash_A = canvas.getContext(\'2d\');
                        dash_A.beginPath();
                        dash_A.setLineDash([2, 2]);
                        dash_A.moveTo('.$i[0].','.$i[1].');
                        dash_A.lineTo('.$p[0].','.$p[1].');
                        dash_A.stroke();

                        var dash_B = canvas.getContext(\'2d\');
                        dash_B.beginPath();
                        dash_B.setLineDash([2, 2]);
                        dash_B.moveTo('.$i[0].','.$i[1].');
                        dash_B.lineTo('.$q[0].','.$q[1].');
                        dash_B.stroke();

                        var dash_C = canvas.getContext(\'2d\');
                        dash_C.beginPath();
                        dash_C.setLineDash([2, 2]);
                        dash_C.moveTo('.$i[0].','.$i[1].');
                        dash_C.lineTo('.$r[0].','.$r[1].');
                        dash_C.stroke();

                        var A = canvas.getContext(\'2d\');
                        A.fillStyle = \'blue\';
                        A.font = \'15pt Arial\';
                        A.fillText(\'A\', 130, 20);

                        var B = canvas.getContext(\'2d\');
                        B.fillStyle = \'blue\';
                        B.font = \'15pt Arial\';
                        B.fillText(\'B\', 40, 160);

                        var C = canvas.getContext(\'2d\');
                        C.fillStyle = \'blue\';
                        C.font = \'15pt Arial\';
                        C.fillText(\'C\', 310, 160);

                        var I = canvas.getContext(\'2d\');
                        I.fillStyle = \'blue\';
                        I.font = \'15pt Arial\';
                        I.fillText(\'I\','.$i[0].'+10,'.$i[1].'+10);

                        var P = canvas.getContext(\'2d\');
                        P.fillStyle = \'blue\';
                        P.font = \'15pt Arial\';
                        P.fillText(\'P\','.$p[0].'+5,'.$p[1].'-5);

                        var Q = canvas.getContext(\'2d\');
                        Q.fillStyle = \'blue\';
                        Q.font = \'15pt Arial\';
                        Q.fillText(\'Q\','.$q[0].'+10,'.$q[1].');

                        var R = canvas.getContext(\'2d\');
                        R.fillStyle = \'blue\';
                        R.font = \'15pt Arial\';
                        R.fillText(\'R\','.$r[0].'-20,'.$r[1].'+5);
                    }
                }
            </script>';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text','a_script'));
    }

    //接線と弦のつくる角
    public function unit402_q08($unit,$question){
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
                            var point_D = canvas.getContext(\'2d\');
                            point_D.beginPath();
                            point_D.arc('.$d[0].', '.$d[1].', 3, 0, 2 * Math.PI);
                            point_D.fill() ;
                            var A = canvas.getContext(\'2d\');
                            A.fillStyle = \'blue\';
                            A.font = \'15pt Arial\';
                            A.fillText(\'A\', '.$a[0].'-15, '.$a[1].'+10);
                            var B = canvas.getContext(\'2d\');
                            B.fillStyle = \'blue\';
                            B.font = \'15pt Arial\';
                            B.fillText(\'B\', '.$b[0].'-20, '.$b[1].'+10);
                            var C = canvas.getContext(\'2d\');
                            C.fillStyle = \'blue\';
                            C.font = \'15pt Arial\';
                            C.fillText(\'C\', '.$c[0].'+5, '.$c[1].'+10);
                            var D = canvas.getContext(\'2d\');
                            D.fillStyle = \'blue\';
                            D.font = \'15pt Arial\';
                            D.fillText(\'D\', '.$d[0].'-20, '.$d[1].'+5);

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

        $text = '$$ 上図において、直線は点Cにおける接線である。\\\\このとき、';

        //空欄テキストの設定
        $item[0] = '\alpha = \fbox{ア}^\circ、';
        $item[1] = '\beta = \fbox{イ}^\circ';

        $sample_text = '
            接弦定理より、\alpha = '.$right_answers[0].'^\circ\\\\
            円に内接する四角形の対角は足して180^\circなので、\\\\
            \angle{ACD} = 180^\circ - '.$a_text.' = '.(180-floor($alpha*180/pi())).'^\circ\\\\
            よって、\beta = 180^\circ - ('.$b_text.'+'.(180-floor($alpha*180/pi())).'^\circ) = '.$right_answers[1].'^\circ
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/canvas',compact('right_answers','unit','question','text','blank_text','blanks','start','canvas','script','sample_text'));
    }

    //方べきの定理
    public function unit402_q09($unit,$question){
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

        $sample_text = '
            方べきの定理より、\\\\
            \begin{eqnarray}
                AO \cdot DO &=& BO \cdot CO\\\\
                '.$AO.' \cdot '.$OD.' &=& '.$BO.' \cdot CO\\\\
                CO &=& '.f3($AO*$OD,$BO).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/canvas',compact('right_answers','unit','question','text','blank_text','blanks','start','canvas','script','sample_text'));
    }

    //２円の関係
    public function unit402_q10($unit,$question){
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

        $sample_text = '
            2円が異なる2点で交わるとき、\\\\
            |'.$a.'-'.$b.'| \lt d\\ より、'.(-1*abs($a-$b)).' \lt d \lt '.abs($a-$b).'\\\\
            外接するとき、\\\\
            d = '.$a.'+'.$b.' = '.($a+$b).'\\\\
            内接するとき、\\\\
            d = |'.$a.'-'.$b.'| = '.abs($a-$b).'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    
    //整数の性質
    //素因数分解
    public function unit403_q01($unit,$question){
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
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start'));
    }

    //最大公約数・最小公倍数
    public function unit403_q02($unit,$question){
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

        list($base[0],$ex[0]) = prime_factrization($a);
        list($base[1],$ex[1]) = prime_factrization($b);
        list($base[2],$ex[2]) = prime_factrization($g);
        list($base[3],$ex[3]) = prime_factrization($l);

        for($j=0;$j<4;$j++){
            for($i=0;$i<count($base[$j]);$i++){
                if($i==0){
                    $p[$j] = $base[$j][$i].'^{'.$ex[$j][$i].'}';
                }else{
                    $p[$j] = $p[$j] . ' \cdot '.$base[$j][$i].'^{'.$ex[$j][$i].'}';
                }
            }
        }

        $sample_text = '
            '.$a.' = '.$p[0].'\\\\
            '.$b.' = '.$p[1].'\\\\
            したがって、\\\\
            最大公約数は\\ '.$p[2].' = '.$g.'\\\\
            最小公倍数は\\ '.$p[3].' = '.$l.'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //余り
    public function unit403_q03($unit,$question){
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

        $sample_text = '
            ある自然数k,l\\ を用いて、\\\\
            m='.d1($a,'k').d4($b).',\\ n='.d1($c,'l').d4($d).'\\ とおく。\\\\
            このとき、\\\\
            \begin{eqnarray}
                '.d1($e,'m').d2($f,'n').' &=& '.d1($e,'('.d1($a,'k').d4($b).')').d2($f,'('.d1($c,'l').d4($d).')').'\\\\
                    &=& '.d1($e*$a,'k').d2($f*$c,'l').d4($e*$b+$f*$d).'\\\\
                    &=& '.d1($g,'('.f1($e*$a,$g,'k').f2($f*$c,$g,'l').d4(floor(($e*$b+$f*$d)/$g)).')').d4(($e*$b+$f*$d)%$g).'
            \end{eqnarray}\\\\
            よって、余りは\\ '.$right_answers[0].'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //ユークリッドの互除法と１次不定方程式
    public function unit403_q04($unit,$question){
        //初期設定
        $question_id = 40304;
        $blanks = 4;
        $option = $this->option;

        //変数の設定
        $a = rand(11,61);
        do { $b = rand(10,61); }while($a <= $b);

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

        $temp = '';

        $i=0;

        while($b!=1){
            $p[$i] = $a;    $q[$i] = $b;    $r[$i] = floor($a/$b);  $s[$i] = $a%$b;
            $temp .= $p[$i] . '='.$q[$i].' \times '.$r[$i].'+'.$s[$i].'\quad \rightarrow \quad '.$s[$i].' = '.$p[$i].'-'.$q[$i].' \times '.$r[$i].'\\\\';
            $a = $q[$i];  $b = $s[$i];
            $i++;
        }

        $temp_2 = '
            \begin{eqnarray}
                '.$s[$i-1].' &=& '.$p[$i-1].'\times 1+'.$q[$i-1].' \times '.dot3(1,-1*$r[$i-1],1).'\\\\
        ';
        $t = 1; $u = -1*$r[$i-1];
        for($j=($i-1);$j>0;$j--){
            $temp_2 .= '
                    &=& '.$p[$j].' \times '.dot3(1,$t,1).' + ('.$p[$j-1].'-'.$q[$j-1].' \times '.$r[$j-1].') \times '.dot3(1,$u,1).'\\\\
                    &=& '.$p[$j-1].' \times '.dot3(1,$u,1).' + '.$q[$j-1].' \times '.dot3(1,$t+$u*-1*$r[$j-1],1).'\\\\
            ';
            $tem = $t;
            $t = $u;  $u = $tem+$u*-1*$r[$j-1]; 
        }
        $temp_2 .= '
            \end{eqnarray}
        ';

        $sample_text = '
            '.$temp.'
            これらの式を下から代入していくと、\\\\
            '.$temp_2.'\\\\
            よって、この式を満たす整数解の一つは、x='.$t.',\\ y='.$u.'\\\\

            このとき、\\\\
            \begin{array}{cccccc}
                 & '.d1($p[0],'x').' & + & '.d1($q[0],'y').' & = & 1\\\\
                - ) & '.$p[0].' \cdot '.dot3(1,$t,1).' & + & '.$q[0].' \cdot '.dot3(1,$u,1).' & = & 1\\\\
                \hline
                 & '.d1($p[0],'(x'.d4(-1*$t).')').' & + & '.d1($q[0],'(y'.d4(-1*$u).')').' & = & 0\\\\
            \end{array}\\\\
            
            '.d1($p[0],'(x'.d4(-1*$t).')').' = '.d1(-1*$q[0],'(y'.d4(-1*$u).')').'\\\\
            '.$p[0].',\\ '.$q[0].'は互いに素なので、ある整数kを用いて、\\\\
            x'.d4(-1*$t).'='.d1($q[0],'k').'\quad \therefore x = '.d1($q[0],'k').d4($t).'\\\\
            y'.d4(-1*$u).'='.d1(-1*$p[0],'k').'\quad \therefore y = '.d1(-1*$p[0],'k').d4($u).'\\\\

        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //n進法
    public function unit403_q05($unit,$question){
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

        $sample_text = '
            '.$a.$b.$c.'_{('.$n.')} = '.$a.' \cdot '.$n.'^2 + '.$b.' \cdot '.$n.'^1 + '.$c.' \cdot '.$n.'^0 = '.$right_answers[0].'\\\\
            '.$N.'を'.$m.'で割った余りを考えて、\\\\
            \begin{array}{ccccc}
        ';
        $i=0;
        while($N!=0){
            $d[$i] = $N%$m;
            $sample_text .= ''.$m.' & ) & '.$N.' & \cdots & '.($N%$m).'\\\\ \hline';
            $i++;
            $N = floor($N/$m);
        }
        $temp = '';
        for($j=$i-1;$j>=0;$j--){
            $temp .= $d[$j];
        }
        $sample_text .= '
            &&0&&\\\\
            \end{array}\\\\
            余りを下から数えて、'.$temp.'_{('.$m.')}
        ';


        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //数学B
    //ベクトル
    //分点の位置ベクトル
    public function unit501_q01($unit,$question){
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

        $sample_text = '
            DはBCを'.$a.':'.$b.'に内分するので、\\\\
            \vec{AD} = \frac{'.d1($b,'\vec{AB}').d2($a,'\vec{AC}').'}{'.$a.'+'.$b.'} = '.f1($b,$a+$b,'\vec{AB}').f2($a,$a+$b,'\vec{AC}').'\\\\
            EはBCを'.$c.':'.$d.'に外分するので、\\\\
            \vec{AE} = \frac{'.d1(-1*$d,'\vec{AB}').d2($c,'\vec{AC}').'}{'.$c.'-'.$d.'} = '.f1(-$d,$c-$d,'\vec{AB}').f2($c,$c-$d,'\vec{AC}').'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //分点の位置ベクトル
    public function unit501_q02($unit,$question){
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

        $sample_text = '
            DはABを'.$a.':'.$b.'に内分するので、\\\\
            \vec{AD} = \frac{'.$a.'}{'.$a.'+'.$b.'}\vec{AB} = '.f1($a,$a+$b,'\vec{AB}').'\\\\
            EはBCを'.$c.':'.$d.'に内分するので、\\\\
            \vec{AE} = \frac{'.d1($d,'\vec{AB}').d2($c,'\vec{AC}').'}{'.$c.'+'.$d.'} = '.f1($d,$c+$d,'\vec{AB}').f2($c,$c+$d,'\vec{AC}').'\\\\
            よって、\triangle{ADE}の重心をGとすると、\\\\
            \begin{eqnarray}
                \vec{AG} &=& \frac{\vec{AA}+\vec{AD}+\vec{AE}}{3}\\\\
                         &=& '.f1($a*($c+$d) + $d*($a+$b),3*($a+$b)*($c+$d),'\vec{AB}').f2($c,3*($c+$d),'\vec{AC}').'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //ベクトルの成分と大きさ
    public function unit501_q03($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                \vec{AB} &=& \vec{OB} - \vec{OA}\\\\
                         &=& ('.$d.',\\ '.$e.',\\ '.$f.') - ('.$a.',\\ '.$b.',\\ '.$c.')\\\\
                         &=& ('.($d-$a).',\\ '.($e-$b).',\\ '.($f-$c).')\\\\
            \end{eqnarray}\\\\
            また、|\vec{AB}| = \sqrt{'.dot3(1,$d-$a,2).'+'.dot3(1,$e-$b,2).'+'.dot3(1,$f-$c,2).'} = '.rt2(1,pow($d-$a,2)+pow($e-$b,2)+pow($f-$c,2)).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //一直線上にある条件
    public function unit501_q04($unit,$question){
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
        $text = '$$ 3点A('.$a.','.$b.')、B('.$c.','.$d.')、C(x,'.$e.')が\\\\
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

        $sample_text = '
            A,B,Cが一直線上にあるとき、\\\\
            \begin{eqnarray}
                \vec{AB} &=& k\vec{AC}\\\\
                \vec{OB}-\vec{OA} &=& k(\vec{OC}-\vec{OA})\\\\
                ('.($c-$a).','.($d-$b).') &=& k(x'.d4(-1*$a).','.($e-$b).')\\\\
            \end{eqnarray}\\\\
            よって、'.($c-$a).'=k(x'.d4(-1*$a).'), \\ '.($d-$b).' = '.d1($e-$b,'k').'\\\\
            これを解いて、\\\\
            k = '.f3($d-$b,$e-$b).',\\ x = '.f3(($c-$a)*($e-$b)+$a*($d-$b),$d-$b).'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //交点の位置ベクトル
    public function unit501_q05($unit,$question){
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

        $sample_text = '
            DF:FC = t:(1-t)\\ とおくと、\\\\
            \vec{AF} = (1-t)\vec{AD} + t\vec{AC}\\\\
            \vec{AD} = '.f1($a,$a+$b,'\vec{AB}').'\\ より、\\\\
            \vec{AF} = '.f1($a,$a+$b,'(1-t)\vec{AB}').' +t\vec{AC}\\\\
            同様に、BF:FE = s:(1-s)\\ とおくと、\\\\
            \vec{AF} = (1-s)\vec{AB} + s\vec{AE}\\\\
            \vec{AE} = '.f1($c,$c+$d,'\vec{AC}').'\\ より、\\\\
            \vec{AF} = (1-s)\vec{AB} + '.f1($c,$c+$d,'s\vec{AC}').'\\\\
            \vec{AB}と\vec{AC}は一次独立なので、係数を比較して、\\\\
            '.f1($a,$a+$b,'(1-t)').' = 1-s, \quad t = '.f1($c,$c+$d,'s').'\\\\
            これを解いて、s = '.f3($b*($c+$d),($a+$b)*($c+$d)-$a*$c).',\\ t = '.f3($b*$c,($a+$b)*($c+$d)-$a*$c).'\\\\
            したがって、\vec{AF} = '.f1($a*$d,($a+$b)*($c+$d)-$a*$c,'\vec{AB}').f2($b*$c,($a+$b)*($c+$d)-$a*$c,'\vec{AC}').'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //内積と角の大きさ
    public function unit501_q06($unit,$question){
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
        $text = '$$ 3点O,A,Bについて、\\\\ 
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

        $sample_text = '
            \vec{OA} \cdot \vec{OB} = |\vec{OA}||\vec{OB}|\cos{\angle{AOB}}より、\\\\
            \cos{\angle{AOB}} = \frac{\vec{OA} \cdot \vec{OB}}{|\vec{OA}||\vec{OB}|} = '.f3($cos[0],$cos[1]).'\\\\
            また、
            \begin{eqnarray}
                |'.d1($d,'\vec{OA}').d2($e,'\vec{OB}').'|^2 &=& '.d1($d*$d,'|\vec{OA}|^2').d2(2*$d*$e,'\vec{OA} \cdot \vec{OB}').d2($e*$e,'|\vec{OB}|^2').'\\\\
                    &=& '.($d*$d*$a*$a).f2(2*$d*$e*$in[0],$in[1]).d4($e*$e*$b*$b).'\\\\
                    &=& '.($a*$a*$d*$d + $d*$e*($a*$a+$b*$b-$c*$c) + $b*$b*$e*$e).'
            \end{eqnarray}\\\\
            よって、|'.d1($d,'\vec{OA}').d2($e,'\vec{OB}').'| = '.rt2(1,$a*$a*$d*$d + $d*$e*($a*$a+$b*$b-$c*$c) + $b*$b*$e*$e).'\\\\
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //成分と内積
    public function unit501_q07($unit,$question){
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

        $sample_text = '
            \vec{a} \cdot \vec{b} = '.dot3($a,$c,1).' + '.dot3($b,$d,1).' = '.($a*$c+$b*$d).'\\\\
            \vec{a}と\vec{p}が垂直であるとき、\vec{a} \cdot \vec{p} = 0\\ より、\\\\
            \begin{eqnarray}
                \vec{a} \cdot (\vec{a}+t\vec{b}) &=& 0\\\\
                |\vec{a}|^2 + t\vec{a} \cdot \vec{b} &=& 0\\\\
                '.($a*$a+$b*$b).d2($a*$c+$b*$d,'t').' &=& 0\\\\
                t &=& '.f3(-1*($a*$a+$b*$b),$a*$c+$b*$d).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //数列
    //等差数列
    public function unit502_q01($unit,$question){
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

        $sample_text = '
            初項'.$a.',\\ 公差'.$d.'の等差数列なので、\\\\
            a_n = '.$a.' + (n-1) \cdot '.dot3(1,$d,1).'\\\\
            \quad = '.d1($d,'n').d4($a-$d).'\\\\
            この等差数列の初項から第n項までの和S_nは、\\\\
            初項'.$a.',\\ 末項'.d1($d,'n').d4($a-$d).',\\ 項数n\\ と考えて、\\\\
            \begin{eqnarray}
                S_n &=& \frac{'.$a.' + ('.d1($d,'n').d4($a-$d).')}{2}n\\\\
                    &=& '.f1($d,2,'n^2').f2(2*$a-$d,2,'n').'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //等比数列
    public function unit502_q02($unit,$question){
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

        $sample_text = '
            初項'.$a.',\\ 公比'.$r.'なので、\\\\
            a_n = '.dot3($a,$r,'n-1').'\\\\
            この等比数列の初項から第n項までの和S_nは、\\\\
            S_n = \frac{'.d1($a,'('.dot3(1,$r,'n').'-1)').'}{'.$r.'-1} = '.f1($a,$r-1,'('.dot3(1,$r,'n').'-1)').'
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //Σの計算　その１
    public function unit502_q03($unit,$question){
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

        $sample_text = '
            \begin{eqnarray}
                \sum_{k=1}^{n}('.d1($a,'k^{2}').d2($b,'k').d4($c).') &=& '.f1($a,6,'n(n+1)(2n+1)').f2($b,2,'n(n+1)').d2($c,'n').'\\\\
                    &=& '.f1($a,6,'(2n^3+3n^2+n)').f2($b,2,'(n^2+n)').d2($c,'n').'\\\\
                    &=& '.f1($a,3,'n^3').f2($a+$b,2,'n^2').f2($a+3*$b+6*$c,6,'n').'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //Σの計算　その２
    public function unit502_q04($unit,$question){
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

        $sample_text = '
            \sum_{k=1}^{n}'.$a.'^{k} = \frac{'.$a.'('.$a.'^n-1)}{'.$a.'-1} = \frac{'.$a.'^{n+1}-'.$a.'}{'.($a-1).'}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //分数の数列の和
    public function unit502_q05($unit,$question){
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

        switch($a){
            case 1:
                $sample_text = '
                    \frac{k}{k+1} = \frac{1}{k} - \frac{1}{k+1}\\\\
                    よって、\\\\
                    \begin{eqnarray}
                        && \sum_{k=1}^{'.$b.'}\frac{1}{k(k+'.$a.')}\\\\
                        &=& (\frac{1}{1}-\frac{1}{2}) + (\frac{1}{2}-\frac{1}{3}) + \cdots + (\frac{1}{'.$b.'}-\frac{1}{'.($b+1).'})\\\\
                        &=& 1 - \frac{1}{'.($b+1).'}\\\\
                        &=& '.f3($b,$b+1).'
                    \end{eqnarray}
                ';
                break;
            case 2:
                $sample_text = '
                    \frac{k}{k+2} = \frac{1}{2}(\frac{1}{k} - \frac{1}{k+2})\\\\
                    よって、\\\\
                    \begin{eqnarray}
                        && \sum_{k=1}^{'.$b.'}\frac{1}{k(k+'.$a.')}\\\\
                        &=& \frac{1}{2}\left\{(\frac{1}{1}-\frac{1}{3}) + (\frac{1}{2}-\frac{1}{4}) + \cdots + (\frac{1}{'.($b-1).'}-\frac{1}{'.($b+1).'}) +(\frac{1}{'.$b.'}-\frac{1}{'.($b+2).'})\right\}\\\\
                        &=& \frac{1}{2} \left( 1+\frac{1}{2} - \frac{1}{'.($b+1).'} - \frac{1}{'.($b+2).'} \right) \\\\
                        &=& '.f3($b*(3*$b+5),4*($b+1)*($b+2)).'
                    \end{eqnarray}
                ';
                break;
        }

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //階差数列
    public function unit502_q06($unit,$question){
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
        $item[0] = 'a_{n} = '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}}n^{2}';
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

        $sample_text = '
            n \geqq 2\\ のとき、\\\\
            \begin{eqnarray}
                a_n &=& a_1 + \sum_{k=1}^{n-1}{b_k}\\\\
                    &=& '.$a.' + \sum_{k=1}^{n-1}{('.d1($b,'k').d4($c).')}\\\\
                    &=& '.$a.'  '.f2($b,2,'(n-1)n').d2($c,'(n-1)').'\\\\
                    &=& '.f1($b,2,'n^2').f2(-1*$b+2*$c,2,'n').d4($a-$c).'
            \end{eqnarray}\\\\
            これは、n=1のときも成り立つ。
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //和から一般項
    public function unit502_q07($unit,$question){
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

        $sample_text = '
            a_1 = S_1 = '.($x+$y).'\\\\
            n \geqq 2\\ のとき、\\\\
            \begin{eqnarray}
                a_n &=& S_n - S_{n-1}\\\\
                    &=& ('.f1($a[0],$a[1],'n^2').f2($b[0],$b[1],'n').') - \left\{ '.f1($a[0],$a[1],'(n-1)^2').f2($b[0],$b[1],'(n-1)').'\right\}\\\\
                    &=& '.f1($a[0],$a[1],'n^2').f2($b[0],$b[1],'n').f2(-1*$a[0],$a[1],'(n^2-2n+1)').f2(-1*$b[0],$b[1],'(n-1)').'\\\\
                    &=& '.d1($x,'n').d4($y).'
            \end{eqnarray}\\\\
            これは、n=1のときも成り立つ
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //群数列
    public function unit502_q08($unit,$question){
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
                 この数列を次のように、1,3,5, \cdots ,(2n-1)と群に分ける。\\\\
                 a_{1}\\ |\\ a_{2} \\ a_{3} \\ a_{4} \\ |\\ a_{5} \\ a_{6} \\ a_{7} \\ a_{8} \\ a_{9} \\ | \\ \cdots \\\\';

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

        $sample_text = '
            第(n-1)群までに含まれる項の項数は、\\\\
            \sum_{k=1}^{n-1} {(2k-1)} = n^2-2n+1\\\\
            よって、第n群の最初の項は、\\\\
            (n^2-2n+1)+1 = (n^2-2n+2)番目の項なので、\\\\
            一般項\\ a_k = '.d1($a,'k').d4($b).'\\ より、\\\\
            第n群の最初の項は、\\\\
            '.d1($a,'(n^2-2n+2)').d4($b).' = '.d1($a,'n^2').d2(-2*$a,'n').d4(2*$a+$b).'\\\\
            また、第n群までに含まれる項の項数は、\\\\
            \sum_{k=1}^{n} {(2k-1)} = n^2\\\\
            よって、第n群の最後の項は、n^2番目の項なので、\\\\
            一般項\\ a_k = '.d1($a,'k').d4($b).'\\ より、\\\\
            第n群の最後の項は、'.d1($a,'n^2').d4($b).'\\\\
            したがって、第n群は、\\\\
            初項'.d1($a,'n^2').d2(-2*$a,'n').d4(2*$a+$b).',\\ 末項'.d1($a,'n^2').d4($b).',\\ \\\\
            項数2n-1\\ の等差数列とみなせるので、その和は、\\\\
            \begin{eqnarray}
                &&\frac{('.d1($a,'n^2').d2(-2*$a,'n').d4(2*$a+$b).')+('.d1($a,'n^2').d4($b).')}{2} \cdot (2n-1) \\\\
                \quad    &=& ('.d1($a,'n^2').d2(-1*$a,'n').d4($a+$b).')(2n-1)\\\\
                \quad    &=& '.d1(2*$a,'n^3').d2(-3*$a,'n^2').d2(3*$a+2*$b,'n').d4(-1*$a-$b).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }

    //漸化式
    public function unit502_q09($unit,$question){
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
        list($right_answers[3],$right_answers[4]) = gcd($right_answers[3],$right_answers[4]);

        //問題テキストの設定
        $text = '$$ 数列\{a_{n}\}は、a_{1} = '.$a.'\\ で、a_{n+1}='.d1($b,'a_{n}').d4($c).'を満たす。\\\\
                このとき、';

        //空欄テキストの設定
        $item[0] = 'a_{n} = '.($right_answers[0]*$right_answers[1]<0?'-':'').'\frac{\fbox{ア}}{\fbox{イ}} \cdot';
        $item[1] = ($right_answers[2]>0?'\fbox{ウ}^{n-1}':'(-\fbox{ウ})^{n-1}');
        $item[2] = ($right_answers[3]*$right_answers[4]<0?'-':'+').'\frac{\fbox{エ}}{\fbox{オ}}';

        list($right_answers,$option,$blanks,$item[0]) = l_frac($right_answers,$option,1,$blanks,$item[0]);
        list($right_answers,$option,$blanks,$item[2]) = l_frac($right_answers,$option,4,$blanks,$item[2]);

        $right_answers = array_values($right_answers);
        $option = array_values($option);

        for($i=0;$i<$blanks;$i++)
        {
            $right_answers[$i] = abs($right_answers[$i]);
        }

        $sample_text = '
            a_{n+1} = '.d1($b,'a_n').d4($c).'より、\\\\
            特性方程式\\ \alpha = '.d1($b,'\alpha').d4($c).'\\ を解いて、\\\\
            \alpha = '.f4($c,1-$b).'\\\\
            よって、漸化式を変形すると、\\\\
            a_{n+1}'.f4(-1*$c,1-$b).' = '.d1($b,'(a_n'.f4(-1*$c,1-$b).')').'\\\\
            数列\left\{a_n'.f4(-1*$c,1-$b).'\right\}は、\\\\
            初項'.f4($a-$a*$b-$c,1-$b).',\\ 公比'.$b.'\\ の等比数列なので、\\\\
            \begin{eqnarray}
                a_n'.f4(-1*$c,1-$b).' &=& ('.f3($a-$a*$b-$c,1-$b).') \cdot '.dot3(1,$b,'n-1').'\\\\
                    a_n &=& ('.f3($a-$a*$b-$c,1-$b).') \cdot '.dot3(1,$b,'n-1').''.f4($c,1-$b).'
            \end{eqnarray}
        ';

        $blank_text = str_replace($option,$this->option,implode($item)).'$$';
        $start = time();
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks','start','sample_text'));
    }


    /*テンプレ
    public function unit000_q00($unit,$question){
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
        return view('question/sentence',compact('right_answers','unit','question','text','blank_text','blanks'));
    }

    */

}
