<?php

//最大公約数
if (! function_exists('gmp')) {
    function gcd($a,$b)
    {
        $c = gmp_gcd($a,$b);
        return array($a/$c, $b/$c);
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

//sinの処理(0°≦Θ≦180°)
if (! function_exists('d_sin')) {
    function d_sin($degree)
    {
        $deg = [0,30,45,60,90,120,135,150,180];
        $numerator = [0,1,2,3,1,3,2,1,0];    //すべてルートをつけていると仮定
        $denominator = [1,2,2,2,1,2,2,2,1];  //有理化済み

        $k = array_search($degree,$deg);

        return array($numerator[$k],$denominator[$k]);
    }
}

//cosの処理(0°≦Θ≦180°)
if (! function_exists('d_cos')) {
    function d_cos($degree)
    {
        $deg = [0,30,45,60,90,120,135,150,180];
        $numerator = [1,3,2,1,0,1,2,3,1];    //すべてルートをつけていると仮定
        $denominator = [1,2,2,2,1,-2,-2,-2,-1];  //有理化済み

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





