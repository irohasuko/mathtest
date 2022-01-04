<?php

//最大公約数
if (! function_exists('gcd')) {
    function gcd($a,$b)
    {
        $c = gmp_gcd($a,$b);
        $a /= $c;   $b /= $c;
        return array(gmp_intval($a), gmp_intval($b));
    }
}

//数式の先頭の項の処理
if (! function_exists('fo')) {
    function fo($text)
    {
        if(substr($text,0,1) === '+'){
            $text = substr($text,1);
        }
        return $text;
    }
}

//数式の先頭以外の項の処理（プラスの場合符号をつける）
if (! function_exists('sign')) {
    function sign($a)
    {
        if(abs($a)===1){
            $text = $a>0 ? '+' : '-';
        } else {
            $text = $a>0 ? '+'.$a : $a;
        }
        return $text;
    }
}

//係数の処理（１の場合に表示しない）
if (! function_exists('co')) {
    function co($a)
    {
        $text = $a==1 ? '' :$a;
        return $text;
    }
}

//文字式の表示処理
if (! function_exists('li')) {
    function li($text, $literal)
    {
        if($text == 'NULL' || $text === 0){
            $text = '';
        } elseif(substr($text,1,1)==='1'){
            $text = substr($text,0,1).substr($text,2).$literal;
        } elseif($text===1) {
            $text = $literal;
        } else {
            $text .= $literal;
        }
        return $text;
    }
}

//分数の表示処理
if (! function_exists('frac')) {
    function frac($a,$b)
    {
        list($a,$b) = gcd($a,$b);
        if(abs($b) === 1){
            $text = $a*$b>0 ? '+'.$a :'-'.$a;
        } else {
            $text = ($a*$b>0 ? '+' :'-').'\frac{'.abs($a).'}{'.abs($b).'}';
        }
        if($a === 0){
            $text = '';
        }

        return $text;
    }
}

//分数の表示処理1 先頭の係数
if (! function_exists('f1')) {
    function f1($a,$b,$d='')
    {
        list($a,$b) = gcd($a,$b);
        if(abs($b) === 1){
            if(abs($a)==1){
                $text = ($a*$b>0 ? '' : '-').$d;
            }else{
                $text = ($a*$b>0 ? abs($a) :'-'.abs($a)).$d;
            }
        } else {
            $text = ($a*$b>0 ? '' :'-').'\frac{'.abs($a).'}{'.abs($b).'}'.$d;
        }
        if($a === 0){
            $text = '0';
        }

        return $text;
    }
}

//分数の表示処理2 先頭以外の係数
if (! function_exists('f2')) {
    function f2($a,$b,$d='')
    {
        list($a,$b) = gcd($a,$b);
        if(abs($b) === 1){
            if(abs($a)==1){
                $text = ($a*$b>0?'+':'-').$d;
            }else{
                $text = ($a*$b>0 ? '+'.abs($a) :'-'.abs($a)).$d;
            }
        } else {
            $text = ($a*$b>0 ? '+' :'-').'\frac{'.abs($a).'}{'.abs($b).'}'.$d;
        }
        if($a === 0){
            $text = '';
        }

        return $text;
    }
}

//分数の表示処理3 数字のみ、
if (! function_exists('f3')) {
    function f3($a,$b)
    {
        list($a,$b) = gcd($a,$b);
        if(abs($b) === 1){
            $text = ($a*$b>0 ? '' :'-').abs($a);
        } else {
            $text = ($a*$b>0 ? '' :'-').'\frac{'.abs($a).'}{'.abs($b).'}';
        }
        if($a === 0){
            $text = '0';
        }

        return $text;
    }
}

//ルートの表示処理
if (! function_exists('rt')) {
    function rt($a,$b)  //a√b
    {
        list($a,$b) = root($a,$b);
        if($b == 1){
            $text = ($a>0 ? '+'.$a :$a);
        }
        else{
            if(abs($a) === 1){
                $text = ($a>0 ? '+' :'-').'\sqrt{'.$b.'}';
            } else {
                $text = ($a>0 ? '+'.$a :$a).'\sqrt{'.$b.'}';
            }
        }
        if($a === 0 || $b === 0){
            $text = '';
        }

        return $text;
    }
}

//ルートの表示処理
if (! function_exists('rt2')) {
    function rt2($a,$b)  //a√b
    {
        list($a,$b) = root($a,$b);
        if(abs($a) === 1){
            $text = ($a>0 ? '' :'-').'\sqrt{'.$b.'}';
        } else {
            $text = ($a>0 ? ''.$a :$a).'\sqrt{'.$b.'}';
        }
        if($b==1){
            $text = $a;
        }
        if($a === 0 || $b === 0){
            $text = '0';
        }

        return $text;
    }
}

//ルートと分数混合の表示処理1
if (! function_exists('fr_rt')) {
    function fr_rt($a,$b,$c,$d)  //(a+b√c)/d
    {
        list($b,$c) = root($b,$c);
        $g = gmp_gcd($a,gmp_gcd($b,$d));
        $a /= $g; $b /= $g; $d /= $g;

        if(abs($d) == 1){
            if($c === 1){
                $text = $a+$b;
            }else{
                $text = ($a=0?'':$a).d2($b,'\sqrt{'.$c.'}');
            }
        } else {
            if($c === 1){
                $text = f3($a+$b,$d);
            }else{
                $text = '\frac{'.($a=0?'':$a).rt($b,$c).'}{'.$d.'}';
            }
        }

        return $text;
    }
}

//ルートと分数混合の表示処理2
if (! function_exists('fr_rt2')) {
    function fr_rt2($a,$b,$c)  //a√b/c
    {
        list($a,$b) = root($a,$b);
        list($a,$c) = gcd($a,$c);

        if(abs($c) == 1){
            if($b === 1){
                $text = ($a*$c<0?'-':'').abs($a);
            }else{
                $text = ($a*$c<0?'-':'').substr(rt($a,$b),1);
            }
        } else {
            if($b === 1){
                $text = f3($a,$c);
            }else{
                $text = ($a*$c<0?'-':'').'\frac{'.fo(rt(abs($a),$b)).'}{'.abs($c).'}';
            }
        }

        if($a == 0 || $b == 0){
            $text = 0;
        }

        return $text;
    }
}

//ルートと分数混合の表示処理3 複素数を含む
if (! function_exists('fr_rt3')) {
    function fr_rt3($a,$b,$c,$d)  //a+b√c/d
    {
        if($c >= 0){    //実数
            list($b,$c) = root($b,$c);
            $g = gmp_gcd($a,gmp_gcd($b,$d));
            $a /= $g; $b /= $g; $d /= $g;
            $sign = $d/abs($d);

            if(abs($d)==1){
                if($c==1){
                    $text = ($a+$b)*$sign;
                }else{
                    $text = ($sign*$a).rt($sign*$b,$c);
                }
            }else{
                if($c==1){
                    $text = f3($a+$b,$d);
                }else{
                    $text = fr_rt2($a,$b,$c,$d);
                }
            }
        }else{  //虚数
            list($b,$c) = root($b,$c);
            $g = gmp_gcd($a,gmp_gcd($b,$d));
            $a /= $g; $b /= $g; $d /= $g;
            $sign = $d/abs($d);
            if(abs($d)==1){
                if($c==1){
                    $text = ($sign*$a).d2($sign*$b,'i');
                }else{
                    $text = ($sign*$a).d2($sign*$b,'\sqrt{'.$c.'}i');
                }
            }else{
                if($c==1){
                    $text = '\frac{'.($sign*$a).d2($sign*$b,'i').'}{'.abs($d).'}';
                }else{
                    $text = '\frac{'.($sign*$a).d2($sign*$b,'\sqrt{'.$c.'}i').'}{'.abs($d).'}';
                }
            }
        }

        return $text;
    }
}

//2次方程式の解の計算
if (! function_exists('quadratic')) {
    function quadratic($a,$b,$c)  //ax^{2}+bx+c=0, a>0
    {
        $D = $b*$b-4*$a*$c;
        $sign = $a/abs($a);
        if($D > 0){     //実数解２つ
            list($p,$q) = root(1,$D);
            if(is_int(sqrt($D))){   //ルートの中身が1
                $text = f3(-1*$b-sqrt($D),2*$a).','.f3(-1*$b+sqrt($D),2*$a);
            }else{
                $g = gmp_gcd($b,gmp_gcd($p,2*$a));
                $b/=$g; $p/=$g; $a/=$g;
                if(2*$a < 1){
                    $text = (-1*$b).'\pm'.rt2($p,$q);
                }else{
                    $text = '\frac{'.(-1*$b).'\pm'.rt2($p,$q).'}{'.(2*$a).'}';
                }
            }
        }elseif($D==0){     //重解
            $text = f3(-1*$b,2*$a);
        }else{      //虚数解２つ
            list($p,$q) = root(1,abs($D));
            if(is_int(sqrt(abs($D)))){   //ルートの中身が1
                $g = gmp_gcd($b,gmp_gcd($p,2*$a));
                $b/=$g; $p/=$g; $a/=$g;
                if(2*$a < 1){
                    $text = (-1*$b).'\pm'.rt2($p,$q);
                }else{
                    $text = '\frac{'.(-1*$b).'\pm'.sqrt(abs($D)).'i}{'.(2*$a).'}';
                }
            }else{
                $g = gmp_gcd($b,gmp_gcd($p,2*$a));
                $b/=$g; $p/=$g; $a/=$g;
                if(2*$a < 1){
                    $text = (-1*$b).'\pm \sqrt{'.$q.'}';
                }else{
                    $text = '\frac{'.(-1*$b).'\pm '.rt2($p,$q).'i}{'.(2*$a).'}';
                }
            }
        }

        return $text;
    }
}

//項の表示処理１　先頭に来る数字（０の場合消す、１の場合符号のみ表示）
if (! function_exists('d1')) {
    function d1($a,$text='')
    {
        if($a > 0){
            $text = $a==1 ? $text : $a.$text;
        } elseif($a == 0) {
            $text = '';
        } else {
            $text = $a==-1 ? '-'.$text : $a.$text;
        }
        return $text;
    }
}

//項の表示処理２　それ以外の数字（符号をつける、０の場合消す、１の場合符号のみ表示）
if (! function_exists('d2')) {
    function d2($a,$text='')
    {
        if($a > 0){
            $text = $a==1 ? '+'.$text : '+'.$a.$text;
        } elseif($a == 0) {
            $text = '';
        } else {
            $text = $a==-1 ? '-'.$text : $a.$text;
        }
        return $text;
    }
}

//項の表示処理３　文字のない項 その１ 0の場合は0を出力
if (! function_exists('d3')) {
    function d3($a)
    {
        $text = $a>=0 ? '+'.$a : $a;
        return $text;
    }
}

//項の表示処理４　文字のない項 その２ 0の場合は表示しない
if (! function_exists('d4')) {
    function d4($a)
    {
        $text = $a>0 ? '+'.$a : $a;
        if($a == 0){
            $text = '';
        }
        return $text;
    }
}

//積の表示処理1  a・b、bがマイナスのときのみかっこをつける
if (! function_exists('dot1')) {
    function dot1($a,$b)
    {
        if($b<0){
            $text = $a.'\cdot'.'('.$b.')';
        }else{
            $text = $a.'cdot'.$b;
        }
        return $text;
    }
}

//積の表示処理2  a・b、1に加え、aが1のときは表示させない
if (! function_exists('dot2')) {
    function dot2($a,$b)
    {
        if($a == 1){
            $text = $b;
        }else{
            if($b<0){
                $text = $a.'\cdot'.'('.$b.')';
            }else{
                $text = $a.'cdot'.$b;
            }
        }
        return $text;
    }
}

//ルートの処理
if (! function_exists('root')) {
    function root($a,$b)
    {
        if($b == 0){
            return array($a,$b);
        }
        $temp = array();
        $c = 1;
        for($i=2;$b>1;$i++){
            while($b%$i == 0){
                if(in_array($i,$temp)){
                    $a *= $i;
                    $temp = array_diff($temp,[$i]);
                } else {
                    array_push($temp,$i);
                }
                $b /= $i;
            }
        }

        foreach($temp as $num){
            $c *= $num;
        }

        return array($a,$c);
    }
}

//sinの処理(0°≦Θ≦360°)
if (! function_exists('d_sin')) {
    function d_sin($degree)
    {
        $deg = [0,30,45,60,90,120,135,150,180];
        $numerator = [0,1,2,3,1,3,2,1,0];    //分子：すべてルートをつけていると仮定
        $denominator = [1,2,2,2,1,2,2,2,1];  //分母：有理化済み

        if($degree > 180){
            $degree -= 180;
            $denominator = array_map((function($a){ return $a*-1; }),$denominator);
        }
        $k = array_search($degree,$deg);

        return array($numerator[$k],$denominator[$k]);
    }
}

//cosの処理(0°≦Θ≦360°)
if (! function_exists('d_cos')) {
    function d_cos($degree)
    {
        $deg = [0,30,45,60,90,120,135,150,180];
        $numerator = [1,3,2,1,0,1,2,3,1];    //分子：すべてルートをつけていると仮定
        $denominator = [1,2,2,2,1,-2,-2,-2,-1];  //分母：有理化済み
        
        if($degree > 180){
            $degree -= 180;
            $denominator = array_map((function($a){ return $a*-1; }),$denominator);
        }

        $k = array_search($degree,$deg);

        return array($numerator[$k],$denominator[$k]);
    }
}

//sinの表示処理(0°≦Θ≦360°)
if (! function_exists('text_sin')) {
    function text_sin($degree)
    {
        $deg = [0,30,45,60,90];
        $text[0] = '0';
        $text[1] = '\frac{1}{2}';
        $text[2] = '\frac{1}{\sqrt{2}}';
        $text[3] = '\frac{\sqrt{3}}{2}';
        $text[4] = '1';

        if($degree > 180){
            $degree -= 180;
            $sign = '-';
        }else{
            $sign = '';
        }
        if($degree > 90){
            $degree = 180 - $degree;
        }
        $k = array_search($degree,$deg);

        return $sign.$text[$k];
    }
}

//sinの表示処理(0°≦Θ≦360°)
if (! function_exists('text_cos')) {
    function text_cos($degree)
    {
        $deg = [0,30,45,60,90];
        $text[0] = '1';
        $text[1] = '\frac{\sqrt{3}}{2}';
        $text[2] = '\frac{1}{\sqrt{2}}';
        $text[3] = '\frac{1}{2}';
        $text[4] = '0';

        if($degree > 180){
            $degree -= 180;
        }
        if($degree > 90){
            $degree = 180 - $degree;
            $sign = '-';
        }else{
            $sign = '';
        }
        $k = array_search($degree,$deg);

        return $sign.$text[$k];
    }
}

//三角形の三辺を決める
if (! function_exists('make_tri')) {
    function make_tri()
    {
        $a = rand(1,7);
        do{
            $b = rand(1,7);
            $c = rand(2,7);
        }while( abs($b-$c) >= $a || ($b+$c) <= $a || ($a == $b && $a == $c));

        return array($a,$b,$c);
    }
}

//配列にランダムでデータを取得する
if (! function_exists('get_data')) {
    function get_data($i)
    {
        $data = array();
        for($j=0;$j<$i;$j++){
            array_push($data,rand(1,50));
        }
        return $data;
    }
}

//弧度法を度数法に変換
if (! function_exists('rad_to_deg')) {
    function rad_to_deg(int $a,int $b)
    {
        if($a/$b < 0){
            do{
                $a += 2*$b;
            }while($a/$b < 0);
        }elseif($a/$b >= 2){
            do{
                $a -= 2*$b;
            }while($a/$b >= 2);
        }
        $degree = 180/$b*$a;
        return $degree;
    }
}

//ルートのテキスト処理
if (! function_exists('l_root')) {
    function l_root($right_answers,$option,$a,$b,$blanks,$item) //$a√$bを想定
    {
        if($right_answers[$b] == 1){
            $item = str_replace('\sqrt{\fbox{'.$option[$b].'}}','',$item);
            unset($right_answers[$b]);
            unset($option[$b]);
            $blanks -= 1;
        }elseif(abs($right_answers[$a]) == 1){
            $item = str_replace('\fbox{'.$option[$a].'}','',$item);
            unset($right_answers[$a]);
            unset($option[$a]);
            $blanks -= 1;
        }

        return array($right_answers,$option,$blanks,$item);
    }
}

//分数のテキスト処理
if (! function_exists('l_frac')) {
    function l_frac($right_answers,$option,$b,$blanks,$item) //$a/$bを想定
    {
        if(abs($right_answers[$b]) == 1){
            $item = str_replace(['\frac{','}{\fbox{'.$option[$b].'}}'],['',''],$item);
            unset($right_answers[$b]);
            unset($option[$b]);
            $blanks -= 1;
        }
        return array($right_answers,$option,$blanks,$item);
    }
}

//符号のランダム処理
if (! function_exists('rand_sign')) {
    function rand_sign() 
    {
        $sign = [-1,1];
        $sign = $sign[rand(0,1)];
        return $sign;
    }
}

//対数の処理
if (! function_exists('log_ans')) {
    function log_ans($a,$b) 
    {
        $c = 0;
        while($b%$a == 0){
            $c += 1;
            $b /= $a;
        }
        return array($c,$b);
    }
}

//素因数分解
if (! function_exists('prime_factrization')) {
    function prime_factrization($N) 
    {
        if($N == 1){
            return array([1],[1]);
        }
        $base = array();
        $ex = array();
        for($i=2;$N>1;$i++){
            while($N%$i == 0){
                if(in_array($i,$base)){
                    $ex[array_search($i,$base)] += 1;
                } else {
                    array_push($base,$i);
                    array_push($ex,1);
                }
                $N /= $i;
            }
        }

        return array($base,$ex);
    }
}

//１次不定方程式の解を一つ求める
if (! function_exists('d_equ')) {
    function d_equ($a,$b) 
    {
        if($b == 0){
            $x = 1;
            $y = 0;
            return array($x,$y);
        }
        list($s,$t) = d_equ($b,$a%$b);
        $x = $t;
        $y = $s-floor($a/$b)*$t;
        return array((int)$x,(int)$y);
    }
}

//10進数からn進数へ変換
if (! function_exists('n_ary')) {
    function n_ary($N,$b) 
    {
        $temp = array();
        $l = $b-1;
        $i = 0;
        while(pow($b,$i) <= $N){ $i++; }
        $i--;

        for($j=$i;$j>=0;$j--){
            while($l*pow($b,$j) > $N){
                $l--;
            }
            $N -= $l*pow($b,$j);
            array_push($temp,$l);
            $l = $b-1;
        }
        return implode($temp);
    }
}

//問題での複素数の表示処理
if (! function_exists('complex')) {
    function complex($a,$b,$c,$d) //$a√$b + $c√$diを想定
    {
        //$a√$b部分
        if($b == 1){
            $literal[0] = $a;
        }else{
            if(abs($a)==1){
                $literal[0] = ($a<0?'-':'').'\sqrt{'.$b.'}';
            }else{
                $literal[0] = $a.'\sqrt{'.$b.'}';
            }
        }
        if($a == 0 || $b == 0){
            $literal[0] = '';
        }

        //間の符号
        if($c>0){
            $literal[1] = '';
        }

        //$c√$di部分
        if($d == 1){
            if(abs($c)==1){
                $literal[2] = ($c<0?'-':'+').'i';
            }else{
                $literal[2] = ($c<0?'':'+').$c.'i';
            }
        }else{
            if(abs($c)==1){
                $literal[2] = ($c<0?'-':'+').'\sqrt{'.$d.'}i';
            }else{
                $literal[2] = ($c<0?'':'+').$c.'\sqrt{'.$d.'}i';
            }
        }
        if($c == 0 || $d == 0){
            $literal[2] = '0';
        }

        return implode($literal);
    }
}

//aCbの表示
if (! function_exists('text_c')) {
    function text_c($a,$b) 
    {
        $c = array();   //分子
        $d = array();   //分母
        while($b > 0){
            array_push($c,$a);
            array_push($d,$b);
            $a--; $b--;
        }
        $text = '\frac{'.implode(' \cdot ',$c).'}{'.implode(' \cdot ',$d).'}';
        return $text;
    }
}

//フォーム二重送信のガード
if (! function_exists('multiSubmitCheck')){
    function multiSubmitCheck($request)
    {
        // Sessionオブジェクト(Store.php)
        $session = $request->session();
        // Sessionオブジェクトを最新化
        $session->start();
        // csrfトークンと画面パラメータのcsrfトークンの値が異なる場合エラー
        if ($session->token() != $request->input('_token')) {
            return false;
        }
        // csrfトークンの再生成 
        // Store #regenerate によるセッションID再生成でもトークンの再生成が行われる
        $session->regenerateToken();
        // Sessionを保存
        $session->save();

        return true;
    }
}
