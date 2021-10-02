<?php

//最大公約数
if (! function_exists('gmp')) {
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
        if(abs($b) === 1){
            $text = $a*$b>0 ? '+'.$a :'-'.$a;
        } else {
            $text = ($a*$b>0 ? '+' :'-').'\frac{'.abs($a).'}{'.abs($b).'}';
        }
        if($a === 0){
            $text = 'NULL';
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

//項の表示処理３　文字のない項 その１
if (! function_exists('d3')) {
    function d3($a)
    {
        $text = $a>0 ? '+'.$a : $a;
        return $text;
    }
}

//項の表示処理４　文字のない項 その２
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





