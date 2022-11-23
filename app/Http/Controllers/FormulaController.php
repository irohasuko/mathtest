<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unit;
use App\Models\Formula;
use Illuminate\Support\Facades\Auth;

class FormulaController extends Controller
{
    /*
    public function __construct()
    {
        $this->middleware('auth');
    }
    */

    public function formula_list(){
        $math1s = Unit::where('id','>',100)->where('id','<',200)->get();
        $math2s = Unit::where('id','>',200)->where('id','<',300)->get();
        $math3s = Unit::where('id','>',300)->where('id','<',400)->get();
        $mathAs = Unit::where('id','>',400)->where('id','<',500)->get();
        $mathBs = Unit::where('id','>',500)->where('id','<',600)->get();
        return view('formula/list',compact('math1s','math2s','math3s','mathAs','mathBs'));
    }

    public function formula_select($unit_id){
        $formulas = $this->formula_get($unit_id);
        return view('formula/select',compact('formulas','unit_id'));
    }

    public function formula_get($id){
        if(is_array($id)){  //公式を一つずつ抽出 idは公式番号
            $s = 0;
            foreach($id as $f_id){
                $func = 'unit'.substr($f_id, 0,3).'_f'.substr($f_id, 3);
                $formulas[$s] = $this->$func();
                $s++;
            }
        }else{  //公式を単元ごとに抽出 idは単元番号
            $count = Formula::where('unit_id','=',$id)->count();
            for($i=1;$i<=$count;$i++){
                $func = 'unit'.substr($id, 0,3).'_f'.str_pad($i, 2, 0, STR_PAD_LEFT);
                $formulas[$i] = $this->$func();
            }
            /*
            $s = 0;
            while(method_exists('FormulaController','unit'.substr($id, 0,3).'_f'.str_pad($s+1, 2, 0, STR_PAD_LEFT))){
                $func = 'unit'.substr($id, 0,3).'_f'.str_pad($s+1, 2, 0, STR_PAD_LEFT);
                $formulas[$s] = $this->$func();
                $s++;
            }
            */
        }
        return $formulas;
    }

    public function unit101_f01(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10101;
        $formula['name'] = '指数関数';
        $formula['content'] = '
            m,nは正の整数とする。\\\\
            \begin{array}{lc}
                1 & a^ma^n = a^{m+n}\\\\
                2 & (a^m)^n = a^{mn}\\\\
                3 & (ab)^n = a^nb^n
            \end{array}
        ';
        return $formula;
    }

    public function unit101_f02(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10102;
        $formula['name'] = '展開の公式';
        $formula['content'] = '
            \begin{array}{ll}
                1 & (a+b)^2 = a^2+2ab+b^2, \quad (a-b)^2=a^2-2ab+b^2\\\\
                2 & (a+b)(a-b)=a^2-b^2\\\\
                3 & (x+a)(x+b)=x^2+(a+b)x+ab\\\\
                4 & (ax+b)(cx+d) = acx^2+(ad+bc)x+bd
            \end{array}
        ';
        return $formula;
    }

    public function unit101_f03(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10103;
        $formula['name'] = '因数分解の公式';
        $formula['content'] = '
            \begin{array}{ll}
                1 & a^2+2ab+b^2 = (a+b)^2, \quad a^2-2ab+b^2 = (a-b)^2\\\\
                2 & a^2-b^2 = (a+b)(a-b)\\\\
                3 & x^2+(a+b)x+ab = (x+a)(x+b)\\\\
                4 & acx^2+(ad+bc)x+bd = (ax+b)(cx+d)
            \end{array}
        ';
        return $formula;
    }

    public function unit101_f04(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10104;
        $formula['name'] = '3次式の展開';
        $formula['content'] = '
            \begin{array}{lc}
                1 & (a+b)^3 = a^3+3a^2b+3ab^2+b^3\\\\
                2 & (a-b)^3 = a^3-3a^2b+3ab^2-b^3\\\\
                3 & (a+b)(a^2-ab+b^2) = a^3+b^3\\\\
                4 & (a-b)(a^2+ab+b^2) = a^3-b^3
            \end{array}
        ';
        return $formula;
    }

    public function unit101_f05(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10105;
        $formula['name'] = '3次式の因数分解';
        $formula['content'] = '
            \begin{array}{lc}
                1 & a^3+3a^2b+3ab^2+b^3 = (a+b)^3\\\\
                2 & a^3-3a^2b+3ab^2-b^3 = (a-b)^3\\\\
                3 & a^3+b^3 = (a+b)(a^2-ab+b^2)\\\\
                4 & a^3-b^3 = (a-b)(a^2+ab+b^2)
            \end{array}
        ';
        return $formula;
    }

    public function unit101_f06(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10106;
        $formula['name'] = '絶対値の性質';
        $formula['content'] = '
            \begin{array}{ll}
                1 & |a| \geqq 0\\\\
                2 & a \geqq 0 のとき \\ |a|=a, \quad a \lt 0のとき \\ |a|=-a\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit101_f07(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10107;
        $formula['name'] = '平方根の公式';
        $formula['content'] = '
            \begin{array}{ll}
                1 & a \geqq 0 のとき \\ (\sqrt{a})^2 = (-\sqrt{a})^2 = a, \\ \sqrt{a} \geqq 0\\\\
                2 & a \geqq 0 のとき \\ \sqrt{a^2}=a, \quad a \lt 0のとき \\  \sqrt{a^2}=-a\\\\
                3 & \sqrt{a}\sqrt{b} = \sqrt{ab}\\\\
                4 & \frac{\sqrt{a}}{\sqrt{b}} = \sqrt{\frac{a}{b}}\\\\
                5 & k \gt 0 のとき \quad \sqrt{k^2a} = k\sqrt{a}
            \end{array}
        ';
        return $formula;
    }

    public function unit101_f08(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10108;
        $formula['name'] = '2重根号';
        $formula['content'] = '
            a \gt 0, \\ b \gt 0\\ とする\\\\
            \begin{array}{ll}
                1 & \sqrt{(a+b)+2\sqrt{ab}} = \sqrt{a} + \sqrt{b}\\\\
                2 & a \gt b のとき \quad \sqrt{(a+b)-2\sqrt{ab}} = \sqrt{a} - \sqrt{b}\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit101_f09(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10109;
        $formula['name'] = '不等式の性質';
        $formula['content'] = '
            \begin{array}{lcl}
                1 & A \lt B & ならば & A+C \lt B+C, \\ A-C \lt B-C\\\\
                2 & A \lt B, \\ C \gt 0 & ならば & AC \lt BC, \\ \frac{A}{C} \lt \frac{B}{C}\\\\
                3 & A \lt B, \\ C \lt 0 & ならば & AC \gt BC, \\ \frac{A}{C} \gt \frac{B}{C}\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit101_f10(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10110;
        $formula['name'] = 'ド・モルガンの法則';
        $formula['content'] = '
            \overline{A \cup B} = \overline{A} \cap \overline{B}\\\\
            \overline{A \cap B} = \overline{A} \cup \overline{B}
        ';
        return $formula;
    }

    public function unit101_f11(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10111;
        $formula['name'] = '「かつ」の否定,「または」の否定';
        $formula['content'] = '
            \overline{pかつq} = \overline{p} または \overline{q}\\\\
            \overline{pまたはq} = \overline{p} かつ \overline{q}
        ';
        return $formula;
    }

    public function unit101_f12(){
        $formula['unit_id'] = 101;
        $formula['id'] = 10112;
        $formula['name'] = '命題の証明と対偶';
        $formula['content'] = '
            命題\\ p \Rightarrow q\\ とその対偶\\ \overline{q} \Rightarrow \overline{p}\\ の真偽は一致する
        ';
        return $formula;
    }

    public function unit102_f01(){
        $formula['unit_id'] = 102;
        $formula['id'] = 10201;
        $formula['name'] = '2次関数のグラフ(1)';
        $formula['content'] = '
            2次関数\\ y=ax^2\\ のグラフは、放物線である\\\\
            \begin{array}{ll}
                1 & 軸はy軸,\\ 頂点は原点\\\\
                2 & a \gt 0のとき下に凸,\\ a \lt 0のとき上に凸
            \end{array}
        ';
        return $formula;
    }

    public function unit102_f02(){
        $formula['unit_id'] = 102;
        $formula['id'] = 10202;
        $formula['name'] = '2次関数のグラフ(2)';
        $formula['content'] = '
            2次関数\\ y=a(x-p)^2+q\\ のグラフは,\\ y=ax^2\\ のグラフを\\\\
            x軸方向にp,\\ y軸方向にqだけ平行移動した放物線である\\\\
            軸は \\ 直線x=p \quad 頂点は \\ 点(p,q)
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot10202\', {
                boundingbox:[-3,5,5,-1],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            function bezier(t) {
                return t*t;
            }
            function bezier2(t) {
                return (t-3)*(t-3)+1;
            }
            board.create(\'functiongraph\', [bezier, -10, 10],{dash:1,strokeColor:\'black\'});
            board.create(\'functiongraph\', [bezier2, -10, 10]);
            p1 = board.create(\'point\',[0,0] , {name:\' \', face:\'o\', size:1, fixed:true});
            p2 = board.create(\'point\',[3,1] , {name:\' \', face:\'o\', size:1, fixed:true});
            p3 = board.create(\'point\',[3,0] , {name:\' \', face:\'o\', size:0, fixed:true});
            board.create(\'line\',[p1,p3],{straightFirst:false, straightLast:false, strokeWidth:2, dash:2,lastarrow:true});
            board.create(\'line\',[p3,p2],{straightFirst:false, straightLast:false, strokeWidth:2, dash:2,lastarrow:true});
            board.create(\'text\',[-2,4, \'y=ax^2\'], {fontSize:15});
            board.create(\'text\',[2.5,1.5, \'y=a(x-p)^2+q\'], {fontSize:15});
        </script>
        ';
        return $formula;
    }

    public function unit102_f03(){
        $formula['unit_id'] = 102;
        $formula['id'] = 10203;
        $formula['name'] = '2次関数のグラフ(3)';
        $formula['content'] = '
            2次関数\\ y=ax^2+bx+c\\ のグラフは,\\ y=ax^2\\ を平行移動した放物線である\\\\
            軸は\\ 直線x=-\frac{b}{2a} \quad 頂点は\\ 点(-\frac{b}{2a},\\ \frac{b^2-4ac}{4a})
        ';
        return $formula;
    }

    public function unit102_f04(){
        $formula['unit_id'] = 102;
        $formula['id'] = 10204;
        $formula['name'] = '2次関数の最大と最小';
        $formula['content'] = '
            2次関数\\ y=a(x-p)^2+q\\ は,\\\\
            a \gt 0 のとき,\\ x=pで最小値qをとり,最大値はない\\\\
            a \lt 0 のとき,\\ x=pで最大値qをとり,最小値はない\\\\
        ';
        $formula['canvas'] = '
            <script type="text/javascript">
                    var canvas = document.getElementById(\'canvas10204\');
                    if (canvas.getContext) {
                        var y_axis1 = canvas.getContext(\'2d\');
                        y_axis1.beginPath();
                        y_axis1.moveTo(20,180);
                        y_axis1.lineTo(20,20);
                        y_axis1.lineTo(15,25);
                        y_axis1.moveTo(20,20);
                        y_axis1.lineTo(25,25);
                        y_axis1.stroke();

                        var x_axis1 = canvas.getContext(\'2d\');
                        x_axis1.beginPath();
                        x_axis1.moveTo(10,120);
                        x_axis1.lineTo(165,120);
                        x_axis1.lineTo(160,115);
                        x_axis1.moveTo(165,120);
                        x_axis1.lineTo(160,125);
                        x_axis1.stroke();

                        var point1 = canvas.getContext(\'2d\');
                        point1.fillStyle = \'#f00\';
                        point1.beginPath()
                        point1.arc( 90, 160, 3, 0 * Math.PI / 180, 360 * Math.PI / 180) ;
                        point1.closePath();
                        point1.fill();

                        var line = canvas.getContext(\'2d\');
                        line.beginPath();
                        line.setLineDash([2, 2]);
                        line.moveTo(90,120);
                        line.lineTo(90,160);
                        line.lineTo(20,160);
                        line.moveTo(195,40);
                        line.lineTo(270,40);
                        line.lineTo(270,80);
                        line.stroke();
                        line.setLineDash([]);

                        var graph1 = canvas.getContext(\'2d\');
                        var X1 = 10;
                        var Y1 = -0.02*(X1-90)*(X1-90)+160;
                        for(i=0; i<13; i+=0.5){
                            var X2 = i + X1;
                            var Y2 = -0.02*(X2-90)*(X2-90)+160;
                            graph1.beginPath();
                            graph1.moveTo(X1, Y1);
                            graph1.lineTo(X2, Y2);
                            graph1.stroke();
                            X1 = X2;
                            Y1 = Y2;
                        }

                        var text = canvas.getContext(\'2d\');
                        text.font = \'10pt Arial\';
                        text.fillText(\'p\', 90, 115);
                        text.fillText(\'q\', 10, 160);
                        text.fillText(\'p\', 270, 90);
                        text.fillText(\'q\', 185, 40);

                        text.font = \'15pt Arial\';
                        text.fillStyle = \'black\';
                        text.fillText(\'a>0\', 75, 15);
                        text.fillText(\'a<0\', 250, 15);


                        var y_axis2 = canvas.getContext(\'2d\');
                        y_axis2.beginPath();
                        y_axis2.moveTo(195,180);
                        y_axis2.lineTo(195,20);
                        y_axis2.lineTo(190,25);
                        y_axis2.moveTo(195,20);
                        y_axis2.lineTo(200,25);
                        y_axis2.stroke();

                        var x_axis2 = canvas.getContext(\'2d\');
                        x_axis2.beginPath();
                        x_axis2.moveTo(185,80);
                        x_axis2.lineTo(340,80);
                        x_axis2.lineTo(335,75);
                        x_axis2.moveTo(340,80);
                        x_axis2.lineTo(335,85);
                        x_axis2.stroke();

                        var point2 = canvas.getContext(\'2d\');
                        point2.fillStyle = \'#f00\';
                        point2.beginPath()
                        point2.arc( 270, 40, 3, 0 * Math.PI / 180, 360 * Math.PI / 180) ;
                        point2.closePath();
                        point2.fill();

                        var graph2 = canvas.getContext(\'2d\');
                        var X1 = 190;
                        var Y1 = 0.02*(X1-270)*(X1-270)+40;
                        for(i=0; i<13; i+=0.1){
                            var X2 = i + X1;
                            var Y2 = 0.02*(X2-270)*(X2-270)+40;
                            graph2.beginPath();
                            graph2.moveTo(X1, Y1);
                            graph2.lineTo(X2, Y2);
                            graph2.stroke();
                            X1 = X2;
                            Y1 = Y2;
                        }
                    }
                </script>';
        return $formula;
    }

    public function unit102_f05(){
        $formula['unit_id'] = 102;
        $formula['id'] = 10205;
        $formula['name'] = '2次方程式の解の公式';
        $formula['content'] = '
            2次方程式\\ ax^2+bx+c=0\\ の解は,\\ b^2-4ac \geqq 0\\ のとき\\\\
            x = \frac{-b \pm \sqrt{b^2-4ac}}{2a}\\\\
            2次方程式\\ ax^2+2b\'x+c=0\\ の解は,\\ b\'^2-ac \geqq 0\\ のとき\\\\
            x = \frac{-b\' \pm \sqrt{b\'^2-ac}}{a}\\\\
        ';
        return $formula;
    }

    public function unit102_f06(){
        $formula['unit_id'] = 102;
        $formula['id'] = 10206;
        $formula['name'] = '2次関数のグラフとx軸の位置関係';
        $formula['content'] = '
            y=ax^2+bx+c\\ のグラフとx軸の位置関係について\\\\
            ax^2+bx+c=0\\ の判別式を\\ D=b^2-4ac\\ とすると\\\\
            \begin{array}{ccc}
                D \gt 0 & \iff & 異なる2点で交わる\\\\
                D = 0 & \iff & 1点で接する\\\\
                D \lt 0 & \iff & 共有点をもたない\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit103_f01(){
        $formula['unit_id'] = 103;
        $formula['id'] = 10301;
        $formula['name'] = '三角比';
        $formula['content'] = '
            下の図の直角三角形において\\\\
            \sin{\theta} = \frac{y}{r}\quad
            \cos{\theta} = \frac{x}{r}\quad
            \tan{\theta} = \frac{y}{x}
        ';
        $formula['canvas'] = '
            <script type="text/javascript">
                    var canvas = document.getElementById(\'canvas10301\');
                    if (canvas.getContext) {
                        var tri = canvas.getContext(\'2d\');
                        tri.beginPath();
                        tri.moveTo(100,170);
                        tri.lineTo(250,170);
                        tri.lineTo(250,30);
                        tri.lineTo(100,170);
                        tri.stroke();

                        var text = canvas.getContext(\'2d\');
                        text.font = \'15pt Arial\';
                        text.fillText(\'x\', 175, 185);
                        text.fillText(\'y\', 255, 100);
                        text.fillText(\'r\', 160, 100);
                        text.fillText(\'θ\', 135, 160);

                        var theta = canvas.getContext(\'2d\');
                        theta.beginPath()
                        theta.arc( 120, 170, 20, 275 * Math.PI / 180, 0 * Math.PI / 180) ;
                        theta.stroke();
                    }
            </script>';
        return $formula;
    }

    public function unit103_f02(){
        $formula['unit_id'] = 103;
        $formula['id'] = 10302;
        $formula['name'] = '三角比の相互関係';
        $formula['content'] = '
            \begin{array}{ll}
                1 & \tan{\theta} = \displaystyle \frac{\sin{\theta}}{\cos{\theta}}\\\\
                2 & \sin^2{\theta}+\cos^2{\theta} = 1\\\\
                3 & 1 + \tan^2{\theta} = \displaystyle \frac{1}{\cos^2{\theta}}
            \end{array}
        ';
        return $formula;
    }

    public function unit103_f03(){
        $formula['unit_id'] = 103;
        $formula['id'] = 10303;
        $formula['name'] = '90°-θの三角比';
        $formula['content'] = '
            \begin{array}{ll}
                1 & \sin{(90°-\theta)} = \cos{\theta}\\\\
                2 & \cos{(90°-\theta)} = \sin{\theta}\\\\
                3 & \tan{(90°-\theta)} = \displaystyle \frac{1}{\tan{\theta}}
            \end{array}
        ';
        return $formula;
    }

    public function unit103_f04(){
        $formula['unit_id'] = 103;
        $formula['id'] = 10304;
        $formula['name'] = '180°-θの三角比';
        $formula['content'] = '
            \begin{array}{ll}
                1 & \sin{(180°-\theta)} = \sin{\theta}\\\\
                2 & \cos{(180°-\theta)} = -\cos{\theta}\\\\
                3 & \tan{(180°-\theta)} = -\tan{\theta}
            \end{array}
        ';
        return $formula;
    }

    public function unit103_f05(){
        $formula['unit_id'] = 103;
        $formula['id'] = 10305;
        $formula['name'] = '正弦定理';
        $formula['content'] = '
            \triangle{ABC}の外接円の半径をRとすると\\\\
            \frac{a}{\sin{A}} = \frac{b}{\sin{B}} = \frac{c}{\sin{C}} = 2R
        ';
        return $formula;
    }

    public function unit103_f06(){
        $formula['unit_id'] = 103;
        $formula['id'] = 10306;
        $formula['name'] = '余弦定理';
        $formula['content'] = '
            \triangle{ABC}において\\\\
            a^2 = b^2+c^2-2bc\cos{A}\\\\
            b^2 = c^2+a^2-2ca\cos{B}\\\\
            c^2 = a^2+b^2-2ab\cos{C}
        ';
        return $formula;
    }

    public function unit103_f07(){
        $formula['unit_id'] = 103;
        $formula['id'] = 10307;
        $formula['name'] = '三角形の面積';
        $formula['content'] = '
            \triangle{ABC}の面積をSとすると\\\\
            S = \frac{1}{2}bc\sin{A} = \frac{1}{2}ca\sin{B} = \frac{1}{2}ab\sin{C}
        ';
        return $formula;
    }

    public function unit103_f08(){
        $formula['unit_id'] = 103;
        $formula['id'] = 10308;
        $formula['name'] = 'ヘロンの公式';
        $formula['content'] = '
            \triangle{ABC}の面積をSとすると\\\\
            S = \sqrt{s(s-a)(s-b)(s-c)}\\\\
            ただし,\\ s = \frac{a+b+c}{2}
        ';
        return $formula;
    }

    public function unit104_f01(){
        $formula['unit_id'] = 104;
        $formula['id'] = 10401;
        $formula['name'] = 'データの代表値';
        $formula['content'] = '
            \begin{array}{cl}
                平均値 & \overline{x} = \frac{1}{n}(x_1+x_2+ \cdots +x_n)\\\\
                中央値 & データを大きさの順に並べたとき,中央の位置に来る値\\\\
                最頻値 & データにおいて,もっとも個数の多い値
            \end{array}
        ';
        return $formula;
    }

    public function unit104_f02(){
        $formula['unit_id'] = 104;
        $formula['id'] = 10402;
        $formula['name'] = 'データの散らばりを表す値';
        $formula['content'] = '
            データを小さい順に左から並べたとき,左半分のデータを下位のデータ,右半分のデータを上位のデータと呼ぶことにする\\\\
            ただし,データの大きさが奇数のとき,中央の位置に来るデータはどちらにも含めない\\\\
            このとき,\\\\
            \begin{array}{cc}
                第1四分位数Q_1 & 下位のデータの中央値\\\\
                第3四分位数Q_3 & 上位のデータの中央値\\\\
                四分位範囲 & Q_3-Q_1\\\\
                四分位偏差 & \displaystyle \frac{Q_3-Q_1}{2}
            \end{array}
        ';
        return $formula;
    }

    public function unit104_f03(){
        $formula['unit_id'] = 104;
        $formula['id'] = 10403;
        $formula['name'] = '分散と標準偏差';
        $formula['content'] = '
            \begin{array}{cl}
                分散 & s^2 = \displaystyle \frac{1}{n}\left\{(x_1-\overline{x})^2+(x_2-\overline{x})^2 + \cdots (x_n-\overline{x})^2\right\}\\\\
                標準偏差 & s = \displaystyle \sqrt{\frac{1}{n}\left\{(x_1-\overline{x})^2+(x_2-\overline{x})^2 + \cdots (x_n-\overline{x})^2\right\}}
            \end{array}
        ';
        return $formula;
    }

    public function unit104_f04(){
        $formula['unit_id'] = 104;
        $formula['id'] = 10404;
        $formula['name'] = '共分散と相関係数';
        $formula['content'] = '
            2つの変量x,yのデータが,n個のx,yの値の組として与えられているとする。このとき,\\\\
            \begin{array}{cl}
                共分散 & S_{xy} = \displaystyle \frac{1}{n}\left\{(x_1-\overline{x})(y_1-\overline{y}) + \cdots (x_n-\overline{x})(y_n-\overline{y})\right\}\\\\
                標準偏差 & r = \displaystyle \frac{S_{xy}}{S_x S_y} = \frac{(x_1-\overline{x})(y_1-\overline{y}) + \cdots (x_n-\overline{x})(y_n-\overline{y})}{\sqrt{(x_1-\overline{x})^2 + \cdots (x_n-\overline{x})^2}\sqrt{(y_1-\overline{y})^2 + \cdots (y_n-\overline{y})^2}}
            \end{array}
        ';
        return $formula;
    }

    public function unit201_f01(){
        $formula['unit_id'] = 201;
        $formula['id'] = 20101;
        $formula['name'] = '二項定理';
        $formula['content'] = '
            (a+b)^n = {}_n \mathrm{ C }_0 a^n + {}_n \mathrm{ C }_1 a^{n-1}b + {}_n \mathrm{ C }_2 a^{n-2}b^2 + \cdots \\\\
            \quad \quad \cdots + {}_n \mathrm{ C }_r a^{n-r}b^r + \cdots + {}_n \mathrm{ C }_{n-1} ab^{n-1} + {}_n \mathrm{ C }_n b^n
        ';
        return $formula;
    }

    public function unit201_f02(){
        $formula['unit_id'] = 201;
        $formula['id'] = 20102;
        $formula['name'] = '整式の割り算';
        $formula['content'] = '
            AとBが同じ1つの文字についての整式で,B \neq 0とするとき,\\\\
            A=BQ+R \quad Rは0か,Bより次数の低い整式\\\\
            を満たす整式QとRがただ1通りに定まる
        ';
        return $formula;
    }

    public function unit201_f03(){
        $formula['unit_id'] = 201;
        $formula['id'] = 20103;
        $formula['name'] = '分数式の加法,減法,乗法,除法';
        $formula['content'] = '
            \frac{A}{C} + \frac{B}{C} = \frac{A+B}{C}\\\\
            \frac{A}{C} - \frac{B}{C} = \frac{A-B}{C}\\\\
            \frac{A}{B} \times \frac{C}{D} = \frac{AC}{BD}\\\\
            \frac{A}{B} \div \frac{C}{D} = \frac{AD}{BC}\\\\
        ';
        return $formula;
    }

    public function unit201_f04(){
        $formula['unit_id'] = 201;
        $formula['id'] = 20104;
        $formula['name'] = '恒等式の性質';
        $formula['content'] = '
            P,Qをxについての整式とする\\\\
            \begin{array}{ll}
                1 & P=Qが恒等式 \iff PとQの次数は等しく、両辺の同じ次数の項の係数はそれぞれ等しい\\\\
                2 & P=0が恒等式 \iff Pの各項の係数はすべて0である
            \end{array}
        ';
        return $formula;
    }

    public function unit201_f05(){
        $formula['unit_id'] = 201;
        $formula['id'] = 20105;
        $formula['name'] = '実数の大小関係の基本性質';
        $formula['content'] = '
            \begin{array}{llcl}
                1 & a \gt b, \\ b \gt c & \Rightarrow & a \gt c\\\\
                2 & a \gt b & \Rightarrow & a+c \gt b+c,\\ a-c \gt b-c\\\\
                3 & a \gt b, \\ c \gt 0 & \Rightarrow & ac \gt bc, \\ \displaystyle \frac{a}{c} \gt \frac{b}{c}\\\\
                4 & a \gt b, \\ c \lt 0 & \Rightarrow & ac \lt bc, \\ \displaystyle \frac{a}{c} \lt \frac{b}{c}\\\\
                5 & a \gt b & \iff & a-b \gt 0\\\\
                6 & a \lt b & \iff & a-b \lt 0\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit201_f06(){
        $formula['unit_id'] = 201;
        $formula['id'] = 20106;
        $formula['name'] = '実数の平方についての性質';
        $formula['content'] = '
            \begin{array}{ll}
                1 & 実数aについて \quad a^2 \geqq 0\\\\
                  & 等号が成り立つのは,\\ a=0のとき\\\\
                2 & 実数a,bについて \quad a^2+b^2 \geqq 0\\\\
                  & 等号が成り立つのは,\\ a=b=0のとき\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit201_f07(){
        $formula['unit_id'] = 201;
        $formula['id'] = 20107;
        $formula['name'] = '正の数の大小と平方の大小';
        $formula['content'] = '
            a \gt 0,\\ b \gt 0のとき,\\\\
            a^2 \gt b^2 \iff a \gt b\\\\
            a^2 \geqq b^2 \iff a \geqq b
        ';
        return $formula;
    }

    public function unit201_f08(){
        $formula['unit_id'] = 201;
        $formula['id'] = 20108;
        $formula['name'] = '相加平均と相乗平均の大小関係';
        $formula['content'] = '
            a \gt 0,\\ b \gt 0のとき,\\\\
            \frac{a+b}{2} \geqq \sqrt{ab}\\\\
            等号が成り立つのはa=bのとき
        ';
        return $formula;
    }

    public function unit202_f01(){
        $formula['unit_id'] = 202;
        $formula['id'] = 20201;
        $formula['name'] = '複素数の相等';
        $formula['content'] = '
            a+bi = c+di \iff a=c\\ かつ\\ b=d\\\\
            a+bi = 0 \iff a=0\\ かつ\\ b=0\\\\
        ';
        return $formula;
    }

    public function unit202_f02(){
        $formula['unit_id'] = 202;
        $formula['id'] = 20202;
        $formula['name'] = '負の数の平方根';
        $formula['content'] = '
            a \gt 0のとき,-aの平方根は\\ \pm\sqrt{-a} \\ すなわち\\ \pm\sqrt{a}i
        ';
        return $formula;
    }

    public function unit202_f03(){
        $formula['unit_id'] = 202;
        $formula['id'] = 20203;
        $formula['name'] = '2次方程式の解の種類の判別';
        $formula['content'] = '
            2次方程式\\ ax^2+bx+c=0\\ の解と,その判別式Dについて,\\\\
            \begin{array}{ccl}
                D \gt 0 & \iff & 異なる2つの実数解をもつ\\\\
                D = 0 & \iff & 重解を持つ\\\\
                D \lt 0 & \iff & 異なる二つの虚数解をもつ
            \end{array}
        ';
        return $formula;
    }

    public function unit202_f04(){
        $formula['unit_id'] = 202;
        $formula['id'] = 20204;
        $formula['name'] = '解と係数の関係';
        $formula['content'] = '
            2次方程式\\ ax^2+bx+c=0\\ の解を\alpha, \betaとすると,\\\\
            \alpha + \beta = -\frac{b}{a} , \quad \alpha\beta = \frac{c}{a}
        ';
        return $formula;
    }

    public function unit202_f05(){
        $formula['unit_id'] = 202;
        $formula['id'] = 20205;
        $formula['name'] = '2次式の因数分解';
        $formula['content'] = '
            2次方程式\\ ax^2+bx+c=0\\ の解を\alpha, \betaとすると,\\\\
            ax^2+bx+c = a(x-\alpha)(x-\beta)
        ';
        return $formula;
    }

    public function unit202_f06(){
        $formula['unit_id'] = 202;
        $formula['id'] = 20206;
        $formula['name'] = '2数を解とする2次方程式';
        $formula['content'] = '
            2数\alpha,\betaに対して,\\ p=\alpha+\beta,\\ q=\alpha\betaとすると,\alphaと\betaを解とする2次方程式の一つは\\\\
            x^2-px+q=0 
        ';
        return $formula;
    }

    public function unit202_f07(){
        $formula['unit_id'] = 202;
        $formula['id'] = 20207;
        $formula['name'] = '剰余の定理';
        $formula['content'] = '
            整式P(x)を1次式x-kで割ったときの余りは,\quad P(k)
        ';
        return $formula;
    }

    public function unit202_f08(){
        $formula['unit_id'] = 202;
        $formula['id'] = 20208;
        $formula['name'] = '因数定理';
        $formula['content'] = '
            1次式x-kが整式P(x)の因数である \iff P(k)=0
        ';
        return $formula;
    }

    public function unit202_f09(){
        $formula['unit_id'] = 202;
        $formula['id'] = 20209;
        $formula['name'] = '3次式の解と係数の関係';
        $formula['content'] = '
            3次方程式\\ ax^3+bx^2+cx+d=0\\ の3つの解を\alpha, \beta, \gammaとすると,\\\\
            \alpha+\beta+\gamma = -\frac{b}{a}, \quad \alpha\beta+\beta\gamma+\gamma\alpha = \frac{c}{a}, \quad \alpha\beta\gamma = -\frac{d}{a}
        ';
        return $formula;
    }

    public function unit203_f01(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20301;
        $formula['name'] = '線分の内分点,外分点';
        $formula['content'] = '
            数直線上の2点A(a),B(b)に対して,\\\\
            \begin{array}{lll}
                1 & 線分ABをm:nに内分する点の座標は & \displaystyle \frac{na+mb}{m+n}\\\\
                2 & 線分ABをm:nに外分する点の座標は & \displaystyle \frac{-na+mb}{m-n}
            \end{array}
        ';
        return $formula;
    }

    public function unit203_f02(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20302;
        $formula['name'] = '2点間の距離';
        $formula['content'] = '
            2点A(x_1,y_1),B(x_2,y_2)間の距離ABは\\\\
            AB=\sqrt{(x_2-x_1)^2+(y_2-y_1)^2}\\\\
            特に,原点Oと点A(x_1,y_1)の距離OAは\\\\
            OA=\sqrt{x_1^2+y_1^2}
        ';
        return $formula;
    }

    public function unit203_f03(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20303;
        $formula['name'] = '内分点,外分点の座標';
        $formula['content'] = '
            2点A(x_1,y_1),B(x_2,y_2)に対して,\\\\
            \begin{array}{llc}
                1 & 線分ABをm:nに内分する点の座標は & \displaystyle \left(\frac{nx_1+mx_2}{m+n}, \frac{ny_1+my_2}{m+n}\right)\\\\
                  & 特に,線分ABの中点の座標は & \displaystyle \left(\frac{x_1+x_2}{2}, \frac{y_1+y_2}{2}\right)\\\\
                2 & 線分ABをm:nに外分する点の座標は & \displaystyle \left(\frac{-nx_1+mx_2}{m-n}, \frac{-ny_1+my_2}{m-n}\right)\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit203_f04(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20304;
        $formula['name'] = '三角形の重心の座標';
        $formula['content'] = '
            3点A(x_1,y_1),B(x_2,y_2),C(x_3,y_3)を頂点とする\triangle{ABC}の重心Gの座標は\\\\
            \left(\frac{x_1+x_2+x_3}{3}, \frac{y_1+y_2+y_3}{3} \right)
        ';
        return $formula;
    }

    public function unit203_f05(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20305;
        $formula['name'] = '直線の方程式';
        $formula['content'] = '
            \begin{array}{lc}
                1 & 点(x_1,y_1)を通り,傾きがmの直線の方程式は\\\\
                  & y-y_1 = m(x-x_1)\\\\
                2 & 点(x_1,y_1)を通り,x軸に垂直な直線の方程式は\\\\
                  & x=x_1\\\\
                3 & 異なる2点A(x_1,y_1),B(x_2,y_2)を通る直線の方程式は\\\\
                  & x_1 \neq x_2 のとき \quad \displaystyle y-y_1 = \frac{y_2-y_1}{x_2-x_1}(x-x_1)\\\\
                  & x_1 = x_2 のとき \quad x=x_1
            \end{array}
        ';
        return $formula;
    }

    public function unit203_f06(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20306;
        $formula['name'] = '2直線の平行,垂直';
        $formula['content'] = '
            2直線 \quad y=m_1x+n_1, \\ y=m_2x+n_2\\ について\\\\
            \begin{array}{ccc}
                2直線が平行 & \iff & m_1=m_2\\\\
                2直線が垂直 & \iff & m_1m_2=-1
            \end{array}
        ';
        return $formula;
    }

    public function unit203_f07(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20307;
        $formula['name'] = '点と直線の距離';
        $formula['content'] = '
            点P(x_1,y_1)と直線ax+by+c=0の距離dは\\\\
            d=\frac{|ax_1+by_1+c|}{\sqrt{a^2+b^2}}
        ';
        return $formula;
    }

    public function unit203_f08(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20308;
        $formula['name'] = '円の方程式';
        $formula['content'] = '
            点(a,b)を中心とし,半径がrの円の方程式は\\\\
            (x-a)^2+(y-b)^2=r^2\\\\
            特に,原点Oを中心とし,半径がrの円の方程式は\\\\
            x^2+y^2=r^2
        ';
        return $formula;
    }

    public function unit203_f09(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20309;
        $formula['name'] = '円と直線の位置関係(1)';
        $formula['content'] = '
            円の方程式と直線の方程式からyを消去してxの2次方程式が得られるとき,その判別式をDとすると\\\\
            \begin{array}{ccc}
                D \gt 0 & \iff & 異なる2点で交わる\\\\
                D = 0 & \iff & 接する\\\\
                D \lt 0 & \iff & 共有点を持たない
            \end{array}
        ';
        return $formula;
    }

    public function unit203_f10(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20310;
        $formula['name'] = '円と直線の位置関係(2)';
        $formula['content'] = '
            半径rの円の中心と直線lの距離をdとする\\\\
            \begin{array}{ccc}
                d \lt r & \iff & 異なる2点で交わる\\\\
                d = r & \iff & 接する\\\\
                d \gt r & \iff & 共有点を持たない
            \end{array}
        ';
        return $formula;
    }

    public function unit203_f11(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20311;
        $formula['name'] = '軌跡を求める手順';
        $formula['content'] = '
            \begin{array}{ll}
                1 & 求める軌跡の任意の点の座標を(x,y)で表し,与えられた条件を座標の間の関係式で表す\\\\
                2 & 軌跡の方程式を導き,その方程式の表す図形を求める\\\\
                3 & その図形上の任意の点が条件を満たしていることを確かめる
            \end{array}
        ';
        return $formula;
    }

    public function unit203_f12(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20312;
        $formula['name'] = '直線と領域';
        $formula['content'] = '
            直線\\ y=mx+n\\ をlとする\\\\
            \begin{array}{ll}
                1 & 不等式\\ y \gt mx+n\\ の表す領域は,直線lの上側の部分\\\\
                2 & 不等式\\ y \lt mx+n\\ の表す領域は,直線lの下側の部分\\\\
            \end{array}
        ';
        $formula['canvas'] = '
            <script type="text/javascript">
                    var canvas = document.getElementById(\'canvas20312\');
                    if (canvas.getContext) {
                        var y_axis = canvas.getContext(\'2d\');
                        y_axis.beginPath();
                        y_axis.moveTo(100,190);
                        y_axis.lineTo(100,10);
                        y_axis.lineTo(105,15);
                        y_axis.moveTo(100,10);
                        y_axis.lineTo(95,15);
                        y_axis.stroke();

                        var x_axis = canvas.getContext(\'2d\');
                        x_axis.beginPath();
                        x_axis.moveTo(10,100);
                        x_axis.lineTo(340,100);
                        x_axis.lineTo(335,95);
                        x_axis.moveTo(340,100);
                        x_axis.lineTo(335,105);
                        x_axis.stroke();

                        var line = canvas.getContext(\'2d\');
                        line.beginPath();
                        line.moveTo(10,170);
                        line.lineTo(340,20);
                        line.stroke();

                        var text = canvas.getContext(\'2d\');
                        text.font = \'15pt Arial\';
                        text.fillText(\'x\', 330, 120);
                        text.fillText(\'y\', 85, 20);
                        text.fillText(\'l\', 320, 20);
                        text.fillText(\'O\', 80, 120);
                        text.fillStyle = \'rgba(255,0,0)\';
                        text.fillText(\'y>mx+n\', 120, 50);
                        text.fillStyle = \'rgba(0,0,255)\';
                        text.fillText(\'y<mx+n\', 180, 150);

                        var back = canvas.getContext(\'2d\');
                        back.beginPath();
                        back.moveTo(10,10);
                        back.lineTo(10,170);
                        back.lineTo(340,20);
                        back.lineTo(340,10);
                        back.lineTo(10,10);
                        back.fillStyle = \'rgba(255,0,0,0.3)\';
                        back.fill();
                        back.beginPath();
                        back.moveTo(10,190);
                        back.lineTo(10,170);
                        back.lineTo(340,20);
                        back.lineTo(340,190);
                        back.lineTo(10,190);
                        back.fillStyle = \'rgba(0,0,255,0.3)\';
                        back.fill();
                    }
            </script>';
        return $formula;
    }

    public function unit203_f13(){
        $formula['unit_id'] = 203;
        $formula['id'] = 20313;
        $formula['name'] = '円と領域';
        $formula['content'] = '
            円\\ (x-a)^2+(y-b)^2=r^2\\ をCとする\\\\
            \begin{array}{ll}
                1 & 不等式\\ (x-a)^2+(y-b)^2 \lt r^2\\ の表す領域は,円Cの内部\\\\
                2 & 不等式\\ (x-a)^2+(y-b)^2 \gt r^2\\ の表す領域は,円Cの外部\\\\
            \end{array}
        ';
        $formula['canvas'] = '
            <script type="text/javascript">
                    var canvas = document.getElementById(\'canvas20313\');
                    if (canvas.getContext) {
                        var y_axis = canvas.getContext(\'2d\');
                        y_axis.beginPath();
                        y_axis.moveTo(60,190);
                        y_axis.lineTo(60,10);
                        y_axis.lineTo(65,15);
                        y_axis.moveTo(60,10);
                        y_axis.lineTo(55,15);
                        y_axis.stroke();

                        var x_axis = canvas.getContext(\'2d\');
                        x_axis.beginPath();
                        x_axis.moveTo(10,130);
                        x_axis.lineTo(340,130);
                        x_axis.lineTo(335,125);
                        x_axis.moveTo(340,130);
                        x_axis.lineTo(335,135);
                        x_axis.stroke();

                        var circle = canvas.getContext(\'2d\');
                        circle.beginPath();
                        circle.arc( 175, 100, 50, 0 * Math.PI / 180, 360 * Math.PI / 180, false ) ;
                        circle.stroke();
                        var line = canvas.getContext(\'2d\');
                        line.beginPath();
                        line.moveTo(220,150);
                        line.lineTo(175,100);
                        line.stroke();

                        var text = canvas.getContext(\'2d\');
                        text.font = \'15pt Arial\';
                        text.fillText(\'x\', 330, 150);
                        text.fillText(\'y\', 45, 20);
                        text.fillText(\'O\', 40, 150);
                        text.fillStyle = \'rgba(255,0,0)\';
                        text.fillText(\'(x-a) +(y-b)  > r \', 120, 40);
                        text.fillStyle = \'rgba(0,0,255)\';
                        text.fillText(\'(x-a) +(y-b)  < r \', 150, 170);
                        text.font = \'10pt Arial\';
                        text.fillStyle = \'rgba(255,0,0)\';
                        text.fillText(\'2\', 160, 30);
                        text.fillText(\'2\', 220, 30);
                        text.fillText(\'2\', 255, 30);
                        text.fillStyle = \'rgba(0,0,255)\';
                        text.fillText(\'2\', 190, 160);
                        text.fillText(\'2\', 250, 160);
                        text.fillText(\'2\', 285, 160);

                        var back = canvas.getContext(\'2d\');
                        back.beginPath();
                        back.rect(10,10,330,180);
                        back.fillStyle = \'rgba(255,0,0,0.3)\';
                        back.fill();
                        back.beginPath();
                        back.fillStyle = \'rgba(0,0,255,0.3)\';
                        back.arc( 175, 100, 50, 0 * Math.PI / 180, 360 * Math.PI / 180, false ) ;
                        back.fill();
                    }
            </script>';
        return $formula;
    }

    public function unit204_f01(){
        $formula['unit_id'] = 204;
        $formula['id'] = 20401;
        $formula['name'] = '扇形の弧の長さと面積';
        $formula['content'] = '
            半径r, 中心角\thetaの扇形の弧の長さをl, 面積をSとすると\\\\
            l=r\theta, \quad S=\frac{1}{2}r^2\theta = \frac{1}{2}rl
        ';
        return $formula;
    }

    public function unit204_f02(){
        $formula['unit_id'] = 204;
        $formula['id'] = 20402;
        $formula['name'] = '三角関数の値の範囲';
        $formula['content'] = '
            -1 \leqq \sin{\theta} \leqq 1\\\\
            -1 \leqq \cos{\theta} \leqq 1\\\\
            \tan{\theta}は実数全体
        ';
        return $formula;
    }

    public function unit204_f03(){
        $formula['unit_id'] = 204;
        $formula['id'] = 20403;
        $formula['name'] = '様々な角度の三角比';
        $formula['content'] = '
            \begin{array}{ll}
                & \sin{(\theta+2n\pi)} = \sin{\theta}\\\\
                1 & \cos{(\theta+2n\pi)} = \cos{\theta}\\\\
                & \tan{(\theta+2n\pi)} = \tan{\theta}\\\\
                \hline\\\\
                & \sin{(-\theta)} = -\sin{\theta}\\\\
                2 & \cos{(-\theta)} = \cos{\theta}\\\\
                & \tan{(-\theta)} = -\tan{\theta}\\\\
                \hline\\\\
                & \sin{(\theta+\pi)} = -\sin{\theta}\\\\
                3 & \cos{(\theta+\pi)} = -\cos{\theta}\\\\
                & \tan{(\theta+\pi)} = \tan{\theta}\\\\
                \hline\\\\
                & \displaystyle \sin{(\theta+\frac{\pi}{2})} = \cos{\theta}\\\\
                4 & \displaystyle \cos{(\theta+\frac{\pi}{2})} = -\sin{\theta}\\\\
                & \displaystyle \tan{(\theta+\frac{\pi}{2})} = -\frac{1}{\tan{\theta}}\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit204_f04(){
        $formula['unit_id'] = 204;
        $formula['id'] = 20404;
        $formula['name'] = '加法定理';
        $formula['content'] = '
            \begin{array}{l}
                \sin{(\alpha+\beta)} = \sin{\alpha}\cos{\beta} + \cos{\alpha}\sin{\beta}\\\\
                \sin{(\alpha-\beta)} = \sin{\alpha}\cos{\beta} - \cos{\alpha}\sin{\beta}\\\\
                \cos{(\alpha+\beta)} = \cos{\alpha}\cos{\beta} - \sin{\alpha}\sin{\beta}\\\\
                \cos{(\alpha-\beta)} = \cos{\alpha}\cos{\beta} + \sin{\alpha}\sin{\beta}\\\\
                \displaystyle \tan{(\alpha+\beta)} = \frac{\tan{\alpha}+\tan{\beta}}{1-\tan{\alpha}\tan{\beta}}\\\\
                \displaystyle \tan{(\alpha-\beta)} = \frac{\tan{\alpha}-\tan{\beta}}{1+\tan{\alpha}\tan{\beta}}\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit204_f05(){
        $formula['unit_id'] = 204;
        $formula['id'] = 20405;
        $formula['name'] = '2倍角の公式';
        $formula['content'] = '
            \begin{array}{l}
                \sin{2\alpha} = 2\sin{\alpha}\cos{\alpha}\\\\
                \cos{2\alpha} = \cos^2{\alpha} - \sin^2{\alpha} = 1-2\sin^2{\alpha} = 2\cos^2{\alpha}-1\\\\
                \displaystyle \tan{2\alpha} = \frac{2\tan{\alpha}}{1-\tan^2{\alpha}}
            \end{array}
        ';
        return $formula;
    }

    public function unit204_f06(){
        $formula['unit_id'] = 204;
        $formula['id'] = 20406;
        $formula['name'] = '半角の公式';
        $formula['content'] = '
            \begin{array}{l}
                \displaystyle \sin^2{\frac{\alpha}{2}} = \frac{1-\cos{\alpha}}{2}\\\\
                \displaystyle \cos^2{\frac{\alpha}{2}} = \frac{1+\cos{\alpha}}{2}\\\\
                \displaystyle \tan^2{\frac{\alpha}{2}} = \frac{1-\cos{\alpha}}{1+\cos{\alpha}}
            \end{array}
        ';
        return $formula;
    }

    public function unit204_f07(){
        $formula['unit_id'] = 204;
        $formula['id'] = 20407;
        $formula['name'] = '三角関数の合成';
        $formula['content'] = '
            a\sin{\theta}+b\cos{\theta} = \sqrt{a^2+b^2}\sin{(\theta+\alpha)}\\\\
            ただし,\\  \displaystyle \sin{\alpha} = \frac{b}{\sqrt{a^2+b^2}},\\  \cos{\alpha} = \frac{a}{\sqrt{a^2+b^2}}
        ';
        return $formula;
    }

    public function unit205_f01(){
        $formula['unit_id'] = 205;
        $formula['id'] = 20501;
        $formula['name'] = '累乗根の性質';
        $formula['content'] = '
            \begin{array}{ll}
                1 & \sqrt[n]{a} \sqrt[n]{b} = \sqrt[n]{ab}\\\\
                2 & \displaystyle \frac{\sqrt[n]{a}}{\sqrt[n]{b}} = \sqrt[n]{\frac{a}{b}}\\\\
                3 & (\sqrt[n]{a})^m = \sqrt[n]{a^m}\\\\
                4 & \sqrt[m]{\sqrt[n]{a}} = \sqrt[mn]{a}\\\\
                5 & \sqrt[n]{a^m} = \sqrt[np]{a^{mp}}
            \end{array}
        ';
        return $formula;
    }

    public function unit205_f02(){
        $formula['unit_id'] = 205;
        $formula['id'] = 20502;
        $formula['name'] = '指数関数のグラフ';
        $formula['content'] = '
            y=a^x\\ のグラフについて\\\\
            \begin{array}{ll}
                1 & 点(0,1),(1,a)を通り,x軸を漸近線として持つ曲線である\\\\
                2 & a \gt 1 のとき右上がりの曲線,\\ 0 \lt a \lt 1 のとき右下がりの曲線
            \end{array}
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot20502\', {
                boundingbox:[-5,5,5,-1],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            function bezier(t) {
                return Math.pow(2,t);
            }
            function bezier2(t) {
                return Math.pow(0.5,t);
            }
            board.create(\'functiongraph\', [bezier, -10, 10],{strokeColor:\'red\'});
            board.create(\'functiongraph\', [bezier2, -10, 10],{strokeColor:\'blue\'});
            p1 = board.create(\'point\',[0,1] , {name:\' \', face:\'o\', size:1, fixed:true});
            board.create(\'text\',[2,2, \'y=a^x(a > 1)\'], {fontSize:15,color:\'red\'});
            board.create(\'text\',[-4.5,2, \'y=a^x(0 < a < 1)\'], {fontSize:15,color:\'blue\'});
        </script>
        ';
        return $formula;
    }

    public function unit205_f03(){
        $formula['unit_id'] = 205;
        $formula['id'] = 20503;
        $formula['name'] = '指数関数の性質';
        $formula['content'] = '
            \begin{array}{ll}
                1 & 定義域は実数全体,値域は正の数全体である\\\\
                2 & a \gt 1のとき \quad xの値が増加するとyの値も増加する\\\\
                  & \quad \quad p \lt q \iff a^p \lt a^q\\\\
                  & 0 \lt a \lt 1のとき \quad xの値が増加するとyの値は減少する\\\\
                  & \quad \quad p \lt q \iff a^p \gt a^q\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit205_f04(){
        $formula['unit_id'] = 205;
        $formula['id'] = 20504;
        $formula['name'] = '対数';
        $formula['content'] = '
            a^p=M \iff p=\log_a{M}\\\\
            ただし\\ a \gt 0,\\ a \neq 1,\\ M \gt 0
        ';
        return $formula;
    }

    public function unit205_f05(){
        $formula['unit_id'] = 205;
        $formula['id'] = 20505;
        $formula['name'] = '対数の性質';
        $formula['content'] = '
            a \gt 0,\\ a \neq 1,\\ M \gt 0,\\ N \gt 0でkが定数のとき\\\\
            \begin{array}{ll}
                1 & \log_a{MN} = \log_a{M} + \log_a{N}\\\\
                2 & \log_a{\frac{M}{N}} = \log_a{M} - \log_a{N}\\\\
                3 & \log_a{M^k} = k\log_a{M}
            \end{array}
        ';
        return $formula;
    }

    public function unit205_f06(){
        $formula['unit_id'] = 205;
        $formula['id'] = 20506;
        $formula['name'] = '底の変換公式';
        $formula['content'] = '
            \log_a{b} = \frac{\log_c{b}}{\log_c{a}} \quad 特に,\\ \log_a{b} = \frac{1}{\log_b{a}}\\\\
            ただしa,b,cは正の数で,a \neq 1,\\ b \neq 1,\\ c \neq 1
        ';
        return $formula;
    }

    public function unit205_f07(){
        $formula['unit_id'] = 205;
        $formula['id'] = 20507;
        $formula['name'] = '対数関数のグラフ';
        $formula['content'] = '
            y=\log_a{x}\\ のグラフについて\\\\
            \begin{array}{ll}
                1 & 点(1,0),(a,1)を通り,y軸を漸近線として持つ曲線である\\\\
                2 & a \gt 1 のとき右上がりの曲線,\\ 0 \lt a \lt 1 のとき右下がりの曲線
            \end{array}
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot20507\', {
                boundingbox:[-1,5,3,-5],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            function bezier(t) {
                return Math.log2(t);
            }
            function bezier2(t) {
                return Math.log(t)/Math.log(0.5);
            }
            board.create(\'functiongraph\', [bezier, 0, 10],{strokeColor:\'red\'});
            board.create(\'functiongraph\', [bezier2, 0, 10],{strokeColor:\'blue\'});
            p1 = board.create(\'point\',[1,0] , {name:\' \', face:\'o\', size:1, fixed:true});
            board.create(\'text\',[1,2, \'y=\log_ax(a > 1)\'], {fontSize:15,color:\'red\'});
            board.create(\'text\',[1,-2, \'y=\log_ax(0 < a < 1)\'], {fontSize:15,color:\'blue\'});
        </script>
        ';
        return $formula;
    }

    public function unit205_f08(){
        $formula['unit_id'] = 205;
        $formula['id'] = 20508;
        $formula['name'] = '対数関数の性質';
        $formula['content'] = '
            \begin{array}{ll}
                1 & 定義域は正の数全体,値域は実数全体である\\\\
                2 & a \gt 1のとき \quad xの値が増加するとyの値も増加する\\\\
                  & \quad \quad 0 \lt p \lt q \iff \log_a{p} \lt \log_a{q}\\\\
                  & 0 \lt a \lt 1のとき \quad xの値が増加するとyの値は減少する\\\\
                  & \quad \quad 0 \lt p \lt q \iff \log_a{p} \gt \log_a{q}\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit206_f01(){
        $formula['unit_id'] = 206;
        $formula['id'] = 20601;
        $formula['name'] = '微分係数';
        $formula['content'] = '
            f\'(a) = \lim_{h \rightarrow 0}{\frac{f(a+h)-f(a)}{h}}
        ';
        return $formula;
    }

    public function unit206_f02(){
        $formula['unit_id'] = 206;
        $formula['id'] = 20602;
        $formula['name'] = '接線の傾きと微分係数';
        $formula['content'] = '
            曲線\\ y=f(x)\\ 上の点A(a,f(a))における曲線の傾きは,\\\\
            関数f(x)のx=aにおける微分係数f\'(a)で表される
        ';
        return $formula;
    }

    public function unit206_f03(){
        $formula['unit_id'] = 206;
        $formula['id'] = 20603;
        $formula['name'] = '導関数';
        $formula['content'] = '
            f\'(x) = \lim_{h \rightarrow 0}{\frac{f(x+h)-f(x)}{h}}
        ';
        return $formula;
    }

    public function unit206_f04(){
        $formula['unit_id'] = 206;
        $formula['id'] = 20604;
        $formula['name'] = '累乗と定数関数の導関数';
        $formula['content'] = '
            \begin{array}{lll}
                1 & 関数x^nの導関数は & (x^n)\' = nx^{n-1}\\\\
                2 & 定数関数cの導関数は & (x)\' = 0
            \end{array}
        ';
        return $formula;
    }

    public function unit206_f05(){
        $formula['unit_id'] = 206;
        $formula['id'] = 20605;
        $formula['name'] = '導関数の性質';
        $formula['content'] = '
            k,lは定数とする\\\\
            \begin{array}{llcl}
                1 & y=kf(x) & ならば & y\' = kf\'(x)\\\\
                2 & y=f(x)+g(x) & ならば & y\' = f\'(x)+g\'(x)\\\\
                3 & y=kf(x)+lg(x) & ならば & y\' = kf\'(x)+lg\'(x)\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit206_f06(){
        $formula['unit_id'] = 206;
        $formula['id'] = 20606;
        $formula['name'] = '接線の方程式';
        $formula['content'] = '
            曲線\\ y=f(x)\\ 上の点A(a,f(a))における曲線の接線の方程式は\\\\
            y-f(a) = f\'(a)(x-a)
        ';
        return $formula;
    }

    public function unit206_f07(){
        $formula['unit_id'] = 206;
        $formula['id'] = 20607;
        $formula['name'] = '関数の増減';
        $formula['content'] = '
            ある区間で\\\\
            \begin{array}{llll}
                常に & f\'(x) \gt 0 & ならば & f(x)はその区間で単調に増加する\\\\
                常に & f\'(x) \lt 0 & ならば & f(x)はその区間で単調に減少する\\\\
                常に & f\'(x) = 0 & ならば & f(x)はその区間で定数である\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit206_f08(){
        $formula['unit_id'] = 206;
        $formula['id'] = 20608;
        $formula['name'] = '関数の極大,極小';
        $formula['content'] = '
            \begin{array}{ll}
                1 & 関数f(x)がx=aで極値をとるならば \quad f\'(a)=0\\\\
                2 & 関数f(x)の極値を求めるには,f\'(x)=0となるxの値を求め,その前後におけるf\'(x)の符号を調べる\\\\
                3 & f\'(x)の符号がx=aの前後で正から負に変わるときf(a)は極大値\\\\
                  & f\'(x)の符号がx=aの前後で負から正に変わるときf(a)は極小値\\\\
            \end{array}\\\\

            \begin{array}{c|ccc}
                x & \cdots & a &\cdots\\\\
                \hline
                f\'(x) & + & 0 & -\\\\
                \hline
                f(x) & \nearrow & 極大 & \searrow\\\\
            \end{array}

            \begin{array}{c|ccc}
                x & \cdots & a & \cdots\\\\
                \hline
                f\'(x) & - & 0 & +\\\\
                \hline
                f(x) & \searrow & 極小 & \nearrow\\\\
            \end{array}
            
        ';
        return $formula;
    }

    public function unit207_f01(){
        $formula['unit_id'] = 207;
        $formula['id'] = 20701;
        $formula['name'] = '不定積分';
        $formula['content'] = '
            F\'(x)=f(x)のとき\\\\
            \int f(x)dx = F(x)+C \quad Cは定数
        ';
        return $formula;
    }

    public function unit207_f02(){
        $formula['unit_id'] = 207;
        $formula['id'] = 20702;
        $formula['name'] = '累乗の関数の不定積分';
        $formula['content'] = '
            \int x^ndx = \frac{1}{n+1}x^{n+1}+C
        ';
        return $formula;
    }

    public function unit207_f03(){
        $formula['unit_id'] = 207;
        $formula['id'] = 20703;
        $formula['name'] = '不定積分の性質';
        $formula['content'] = '
            k,lは定数とする\\\\
            \begin{array}{ll}
                1 & \int kf(x)dx = k\int f(x)dx\\\\
                2 & \int \left\{ f(x)+g(x) \right\}dx = \int f(x)dx + \int g(x)dx\\\\
                3 & \int \left\{ kf(x)+lg(x) \right\}dx = k\int f(x)dx + l\int g(x)dx\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit207_f04(){
        $formula['unit_id'] = 207;
        $formula['id'] = 20704;
        $formula['name'] = '定積分';
        $formula['content'] = '
            関数f(x)の不定積分の1つをF(x)とするとき\\\\
            \int_a^b f(x)dx = \left[ F(x) \right]_a^b = F(b)-F(a)
        ';
        return $formula;
    }

    public function unit207_f05(){
        $formula['unit_id'] = 207;
        $formula['id'] = 20705;
        $formula['name'] = '定積分の性質';
        $formula['content'] = '
            k,lは定数とする\\\\
            \begin{array}{ll}
                1 & \int_a^b kf(x)dx = k\int_a^b f(x)dx\\\\
                2 & \int_a^b \left\{f(x)+g(x)\right\}dx = \int_a^b f(x)dx + \int_a^b g(x)dx\\\\
                3 & \int_a^b \left\{kf(x)+lg(x)\right\}dx = k\int_a^b f(x)dx + l\int_a^b g(x)dx\\\\
                4 & \int_a^a f(x)dx = 0\\\\
                5 & \int_a^b f(x)dx = -\int_b^a f(x)dx\\\\
                6 & \int_a^b f(x)dx = \int_a^c f(x)dx + \int_c^b f(x)dx
            \end{array}
        ';
        return $formula;
    }

    public function unit207_f06(){
        $formula['unit_id'] = 207;
        $formula['id'] = 20706;
        $formula['name'] = '面積(1)';
        $formula['content'] = '
            区間\\ a \leqq x \leqq b\\ で常にf(x) \geqq 0とする\\\\
            曲線y=f(x)とx軸,および2直線x=a,\\ x=bで囲まれた図形の面積Sは\\\\
            S = \int_a^b f(x)dx
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot20706\', {
                boundingbox:[-2,6,2,-1],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            function bezier(t) {
                return 0.5*t*t*t+2*t*t+1.5*t+1;
            }

            var c1 = board.create(\'functiongraph\', [bezier, -10, 10]);
            var l1 = board.create(\'integral\',[[-1,1], c1],{withLabel:false});
        </script>
        ';
        return $formula;
    }

    public function unit207_f07(){
        $formula['unit_id'] = 207;
        $formula['id'] = 20707;
        $formula['name'] = '面積(2)';
        $formula['content'] = '
            区間\\ a \leqq x \leqq b\\ で常にf(x) \geqq g(x)とする\\\\
            曲線y=f(x)とy=g(x),および2直線x=a,\\ x=bで囲まれた図形の面積Sは\\\\
            S = \int_a^b \left\{f(x)-g(x)\right\}dx
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot20707\', {
                boundingbox:[-2,6,2,-5],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            function bezier(t) {
                return t*t+1.5*t-4;
            }

            function bezier2(t) {
                return -1*t*t-1.5*t+5;
            }

            var c1 = board.create(\'functiongraph\', [bezier, -10, 10]);
            var c2 = board.create(\'functiongraph\', [bezier2, -10, 10]);
            var l1 = board.create(\'integral\',[[-1,1], c1],{withLabel:false});
            var l2 = board.create(\'integral\',[[-1,1], c2],{withLabel:false});
            board.create(\'text\',[1,4, \'y=f(x)\'], {fontSize:15,color:\'blue\'});
            board.create(\'text\',[-1.5,-3, \'y=g(x)\'], {fontSize:15,color:\'blue\'});
        </script>
        ';
        return $formula;
    }

    public function unit301_f01(){
        $formula['unit_id'] = 301;
        $formula['id'] = 30101;
        $formula['name'] = '極形式';
        $formula['content'] = '
            複素数平面上で,z=a+biを表す点をPとする\\\\
            OPの長さをr,実軸の正の部分からOPまでの回転角を\thetaとすると\\\\
            z = r(\cos{\theta}+i\sin{\theta})\\\\
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot30101\', {
                boundingbox:[-1,5,5,-1],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            o = board.create(\'point\',[0,0] , {name:\' \', face:\'o\', size:1, fixed:true});
            p = board.create(\'point\',[4,3] , {name:\'P(z)\', face:\'o\', size:1, fixed:true});
            px = board.create(\'point\',[4,0] , {name:\' \', face:\'o\', size:0, fixed:true});
            py = board.create(\'point\',[0,3] , {name:\' \', face:\'o\', size:0, fixed:true});
            board.create(\'line\',[o,p],{straightFirst:false, straightLast:false, strokeWidth:2});
            board.create(\'line\',[p,px],{straightFirst:false, straightLast:false, strokeWidth:2, dash:2});
            board.create(\'line\',[p,py],{straightFirst:false, straightLast:false, strokeWidth:2, dash:2});
            board.create(\'angle\',[px,o,p],{name:\'θ\'});
            board.create(\'text\',[2,2, \'r\'], {fontSize:20});
        </script>
        ';
        return $formula;
    }

    public function unit301_f02(){
        $formula['unit_id'] = 301;
        $formula['id'] = 30102;
        $formula['name'] = '複素数の積と絶対値,偏角';
        $formula['content'] = '
            z_1=r_1(\cos{\theta_1}+i\sin{\theta_1}),\\ z_2=r_2(\cos{\theta_2}+i\sin{\theta_2})とする\\\\
            \begin{array}{ll}
                1 & z_1z_2 = r_1r_2 \left\{ \cos{(\theta_1+\theta_2)}+i\sin{(\theta_1+\theta_2)} \right\} \\\\
                2 & |z_1 z_2| = |z_1||z_2| = r_1 r_2\\\\
                3 & \arg{z_1 z_2} = \arg{z_1}+\arg{z_2} = \theta_1+\theta_2
            \end{array}
        ';
        return $formula;
    }

    public function unit301_f03(){
        $formula['unit_id'] = 301;
        $formula['id'] = 30103;
        $formula['name'] = '複素数の商と絶対値,偏角';
        $formula['content'] = '
            z_1=r_1(\cos{\theta_1}+i\sin{\theta_1}),\\ z_2=r_2(\cos{\theta_2}+i\sin{\theta_2})とする\\\\
            \begin{array}{ll}
                1 & \displaystyle \frac{z_1}{z_2} = \frac{r_1}{r_2} \left\{ \cos{(\theta_1-\theta_2)}+i\sin{(\theta_1-\theta_2)} \right\} \\\\
                2 & \displaystyle \left|\frac{z_1}{z_2}\right| = \frac{|z_1|}{|z_2|} = \frac{r_1}{r_2}\\\\
                3 & \displaystyle \arg{\frac{z_1}{z_2}} = \arg{z_1}-\arg{z_2} = \theta_1-\theta_2
            \end{array}
        ';
        return $formula;
    }

    public function unit301_f04(){
        $formula['unit_id'] = 301;
        $formula['id'] = 30104;
        $formula['name'] = 'ド・モアブルの定理';
        $formula['content'] = '
            nが整数のとき\\\\
            (\cos{\theta}+i\sin{\theta})^n = \cos{n\theta}+i\sin{n\theta}
        ';
        return $formula;
    }

    public function unit301_f05(){
        $formula['unit_id'] = 301;
        $formula['id'] = 30105;
        $formula['name'] = '1のn乗根';
        $formula['content'] = '
            自然数nに対して,1のn乗根は次のn個の複素数で表される\\\\
            z_k = \cos{\frac{2k\pi}{n}} + i\sin{\frac{2k\pi}{n}}\\\\
            (k=0,1,2,\cdots,n-1)
        ';
        return $formula;
    }

    public function unit301_f06(){
        $formula['unit_id'] = 301;
        $formula['id'] = 30106;
        $formula['name'] = '内分点,外分点';
        $formula['content'] = '
            2点A(\alpha),B(\beta)に対して,次のことが成り立つ\\\\
            線分ABをm:nに内分する点を表す複素数は \quad \displaystyle \frac{n\alpha+m\beta}{m+n}\\\\
            特に,線分ABの中点を表す複素数は \quad \displaystyle \frac{\alpha+\beta}{2}\\\\
            線分ABをm:nに外分する点を表す複素数は \quad \displaystyle \frac{-n\alpha+m\beta}{m-n}\\\\
        ';
        return $formula;
    }

    public function unit301_f07(){
        $formula['unit_id'] = 301;
        $formula['id'] = 30107;
        $formula['name'] = '方程式の表す図形';
        $formula['content'] = '
            点\alphaを中心とする半径rの円は,次の方程式を満たす点z全体である\\\\
            |z-\alpha| = r
        ';
        return $formula;
    }

    public function unit301_f08(){
        $formula['unit_id'] = 301;
        $formula['id'] = 30108;
        $formula['name'] = '3点の位置関係と複素数';
        $formula['content'] = '
            異なる3点A(\alpha),B(\beta),C(\gamma)に対して\\\\
            \angle{\beta\alpha\gamma} = \arg{\frac{\gamma-\alpha}{\beta-\alpha}}\\\\
            \begin{array}{ccc}
                3点A,B,Cが一直線上にある & \iff & \displaystyle \frac{\gamma-\alpha}{\beta-\alpha}が実数\\\\
                2直線AB,ACが垂直に交わる & \iff & \displaystyle \frac{\gamma-\alpha}{\beta-\alpha}が純虚数\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit302_f01(){
        $formula['unit_id'] = 302;
        $formula['id'] = 30201;
        $formula['name'] = '放物線';
        $formula['content'] = '
            放物線\\ y^2=4px\\ の性質 \quad ただしp\neq0\\\\
            \begin{array}{ll}
                1 & 頂点は原点, 焦点は点(p,0),準線は直線x=-p\\\\
                2 & 軸はx軸で,放物線は軸に関して対象である
            \end{array}
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot30201\', {
                boundingbox:[-2,5,5,-5],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            function bezier(t) {
                return 2*Math.sqrt(t);
            }
            function bezier2(t) {
                return -2*Math.sqrt(t);
            }

            board.create(\'functiongraph\', [bezier, 0, 10]);
            board.create(\'functiongraph\', [bezier2, 0, 10]);

            f = board.create(\'point\',[1,0] , {name:\' \', face:\'o\', size:1, fixed:true});
            board.create(\'line\',[[-1,1],[-1,-1]],{strokeWidth:2,fixed:true});

        </script>
        ';
        return $formula;
    }

    public function unit302_f02(){
        $formula['unit_id'] = 302;
        $formula['id'] = 30202;
        $formula['name'] = '楕円';
        $formula['content'] = '
            楕円\\ \displaystyle \frac{x^2}{a^2}+\frac{y^2}{b^2}=1\\ の性質 \quad ただしa \gt b \gt 0\\\\
            \begin{array}{ll}
                1 & 中心は原点, 長軸の長さは2a, 短軸の長さは2b\\\\
                2 & 焦点は2点(\sqrt{a^2-b^2},0),(-\sqrt{a^2-b^2},0)\\\\
                3 & 楕円はx軸,y軸,原点に関して対象である\\\\
                4 & 楕円上の点から2つの焦点までの距離の和は2a
            \end{array}
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot30202\', {
                boundingbox:[-4,4,4,-4],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            function bezier(t) {
                return 2*Math.sqrt(1-Math.pow(t,2)/9);
            }
            function bezier2(t) {
                return -2*Math.sqrt(1-Math.pow(t,2)/9);
            }
            board.create(\'functiongraph\', [bezier, -3, 3]);
            board.create(\'functiongraph\', [bezier2, -3, 3]);

            f1 = board.create(\'point\',[Math.sqrt(5),0] , {name:\' \', face:\'o\', size:1, fixed:true});
            f2 = board.create(\'point\',[-Math.sqrt(5),0] , {name:\' \', face:\'o\', size:1, fixed:true});
        </script>
        ';
        return $formula;
    }

    public function unit302_f03(){
        $formula['unit_id'] = 302;
        $formula['id'] = 30203;
        $formula['name'] = '双曲線';
        $formula['content'] = '
            楕円\\ \displaystyle \frac{x^2}{a^2}-\frac{y^2}{b^2}=1\\ の性質 \quad ただしa \gt 0, b \gt 0\\\\
            \begin{array}{ll}
                1 & 中心は原点, 頂点は(a,0),(-a,0)\\\\
                2 & 焦点は2点(\sqrt{a^2+b^2},0),(-\sqrt{a^2+b^2},0)\\\\
                3 & 双曲線はx軸,y軸,原点に関して対象である\\\\
                4 & 漸近線は2直線 \displaystyle \frac{x}{a}-\frac{y}{b}=0,\\ \frac{x}{a}+\frac{y}{b}=0\\\\
                5 & 双曲線上の点から2つの焦点までの距離の差は2a
            \end{array}
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot30203\', {
                boundingbox:[-5,4,5,-4],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            function bezier(t) {
                return 2*Math.sqrt(Math.pow(t,2)-1);
            }
            function bezier2(t) {
                return -2*Math.sqrt(Math.pow(t,2)-1);
            }
            board.create(\'functiongraph\', [bezier, -10, 10]);
            board.create(\'functiongraph\', [bezier2, -10, 10]);

            f1 = board.create(\'point\',[Math.sqrt(5),0] , {name:\' \', face:\'o\', size:1, fixed:true});
            f2 = board.create(\'point\',[-Math.sqrt(5),0] , {name:\' \', face:\'o\', size:1, fixed:true});
            d1 = board.create(\'point\',[1,0] , {name:\' \', face:\'o\', size:1, fixed:true});
            d2 = board.create(\'point\',[-1,0] , {name:\' \', face:\'o\', size:1, fixed:true});
            board.create(\'line\',[[0,0],[1,2]],{fixed:true,dash:true});
            board.create(\'line\',[[0,0],[1,-2]],{fixed:true,dash:true});
        </script>
        ';
        return $formula;
    }

    public function unit302_f04(){
        $formula['unit_id'] = 302;
        $formula['id'] = 30204;
        $formula['name'] = '曲線の平行移動(1)';
        $formula['content'] = '
            曲線F(x,y)=0をx軸方向にp,y軸方向にqだけ平行移動した曲線の方程式は,\\\\
            F(x-p,y-q)=0
        ';
        return $formula;
    }

    public function unit302_f05(){
        $formula['unit_id'] = 302;
        $formula['id'] = 30205;
        $formula['name'] = '曲線の平行移動(2)';
        $formula['content'] = '
            曲線x=f(t),y=g(t)をx軸方向にp,y軸方向にqだけ平行移動した曲線の媒介変数表示は,\\\\
            x=f(t)+p,\quad y=g(t)+q
        ';
        return $formula;
    }

    public function unit302_f06(){
        $formula['unit_id'] = 302;
        $formula['id'] = 30206;
        $formula['name'] = '極座標と直交座標';
        $formula['content'] = '
            極座標(r,\theta)と直交座標(x,y)には次の関係がある\\\\
            \begin{array}{ll}
                1 & x=r\cos{\theta}, \quad y=r\sin{\theta}\\\\
                2 & r=\sqrt{x^2+y^2}\\\\
                3 & r \neq 0のとき, \\ \displaystyle \cos{\theta}=\frac{x}{r}, \quad \sin{\theta}=\frac{y}{r}
            \end{array}
        ';
        return $formula;
    }

    public function unit303_f01(){
        $formula['unit_id'] = 303;
        $formula['id'] = 30301;
        $formula['name'] = '分数関数のグラフと性質';
        $formula['content'] = '
            y=\frac{k}{x-p}+q\\ のグラフは,\\ y=\frac{k}{x}\\ のグラフを\\\\
            x軸方向にp, y軸方向にqだけ平行移動した直角双曲線で\\\\
            漸近線は2直線\\ x=p,\\ y=q\\\\
            定義域はx \neq p, \\ 値域はy \neq q
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot30301\', {
                boundingbox:[-4,5,6,-3],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            function bezier(t) {
                return 2/(t-1)+1;
            }
            function bezier2(t) {
                return 2/t;
            }
            board.create(\'functiongraph\', [bezier, -10, 10]);
            board.create(\'functiongraph\', [bezier2, -10, 10],{dash:true});
            board.create(\'line\',[[1,0],[1,1]],{fixed:true,dash:true});
            board.create(\'line\',[[0,1],[1,1]],{fixed:true,dash:true});
        </script>
        ';
        return $formula;
    }

    public function unit303_f02(){
        $formula['unit_id'] = 303;
        $formula['id'] = 30302;
        $formula['name'] = '無理関数のグラフと性質';
        $formula['content'] = '
            y=\sqrt{a(x-p)}\\ のグラフは,\\ y=\sqrt{ax}\\ のグラフを\\\\
            x軸方向にpだけ平行移動した曲線で,\\\\
            a \gt 0のとき \quad 定義域はx \geqq p,\\ 値域はy \geqq 0\\\\
            a \lt 0のとき \quad 定義域はx \leqq p,\\ 値域はy \geqq 0\\\\
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot30302\', {
                boundingbox:[-1,3,5,-1],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            function bezier(t) {
                return Math.sqrt(t-1);
            }
            function bezier2(t) {
                return Math.sqrt(t);
            }
            board.create(\'functiongraph\', [bezier, 1, 10]);
            board.create(\'functiongraph\', [bezier2, 0, 10],{dash:true});
        </script>
        ';
        return $formula;
    }

    public function unit303_f03(){
        $formula['unit_id'] = 303;
        $formula['id'] = 30303;
        $formula['name'] = '逆関数の求め方';
        $formula['content'] = '
            \begin{array}{ll}
                1 & 関係式y=f(x)を変形して,x=g(y)の形にする\\\\
                2 & xとyを入れ替えて, y=g(x)とする\\\\
                3 & g(x)の定義域は,f(x)の値域と同じにとる
            \end{array}
        ';
        return $formula;
    }

    public function unit304_f01(){
        $formula['unit_id'] = 304;
        $formula['id'] = 30401;
        $formula['name'] = '数列の極限';
        $formula['content'] = '
            数列の極限 \quad
            \begin{array}{c|l}
                収束 & \displaystyle \lim_{n \rightarrow \infty}a_n = \alpha\\\\
                \hline
                     & \displaystyle \lim_{n \rightarrow \infty}a_n = \infty\\\\
                発散 & \displaystyle \lim_{n \rightarrow \infty}a_n = -\infty\\\\
                     & 振動
            \end{array}
        ';
        return $formula;
    }

    public function unit304_f02(){
        $formula['unit_id'] = 304;
        $formula['id'] = 30402;
        $formula['name'] = '数列の極限の性質';
        $formula['content'] = '
            数列\{a_n\},\{b_n\}が収束して, \displaystyle \lim_{n \rightarrow \infty}a_n=\alpha, \lim_{n \rightarrow \infty}b_n = \betaとする\\\\
            \begin{array}{lll}
                1 & \displaystyle \lim_{n \rightarrow \infty}ka_n = k\alpha & ただしkは定数\\\\
                2 & \displaystyle \lim_{n \rightarrow \infty}(a_n+b_n) = \alpha+\beta & \lim_{n \rightarrow \infty}(a_n-b_n) = \alpha-\beta\\\\
                3 & \displaystyle \lim_{n \rightarrow \infty}(ka_n+lb_n) = k\alpha+l\beta & ただしk,lは定数\\\\
                4 & \displaystyle \lim_{n \rightarrow \infty}a_nb_n = \alpha\beta & \\\\
                5 & \displaystyle \lim_{n \rightarrow \infty}\frac{a_n}{b_n} = \frac{\alpha}{\beta} & ただし\beta \neq 0 
            \end{array}
        ';
        return $formula;
    }

    public function unit304_f03(){
        $formula['unit_id'] = 304;
        $formula['id'] = 30403;
        $formula['name'] = '数列の極限と大小関係';
        $formula['content'] = '
            \displaystyle \lim_{n \rightarrow \infty}a_n=\alpha, \lim_{n \rightarrow \infty}b_n = \betaとする\\\\
            \begin{array}{ll}
                1 & すべてのnについて\\ a_n \leqq b_n\\ ならば \quad \alpha \leqq \beta\\\\
                2 & すべてのnについて\\ a_n \leqq c_n \leqq b_n\\ かつ \\ \alpha = \beta\\ ならば\\\\
                  & 数列{c_n}は収束し, \displaystyle \lim_{n \rightarrow \infty}c_n=\alpha
            \end{array}
        ';
        return $formula;
    }

    public function unit304_f04(){
        $formula['unit_id'] = 304;
        $formula['id'] = 30404;
        $formula['name'] = '無限等比数列の極限';
        $formula['content'] = '
            無限等比数列{r^n}の極限は\\\\
            \begin{array}{cll}
                r \gt 1 & のとき & \displaystyle \lim_{n \rightarrow \infty}r^n = \infty\\\\
                r = 1 & のとき & \displaystyle \lim_{n \rightarrow \infty}r^n = 1\\\\
                |r| \lt 1 & のとき & \displaystyle \lim_{n \rightarrow \infty}r^n = 0\\\\
                r \leqq -1 & のとき & 振動
            \end{array}
        ';
        return $formula;
    }

    public function unit304_f05(){
        $formula['unit_id'] = 304;
        $formula['id'] = 30405;
        $formula['name'] = '無限等比級数の収束,発散';
        $formula['content'] = '
            無限等比級数 a+ar+ \cdots +ar^{n-1}+ \cdots \quad の収束,発散は\\\\
            \begin{array}{l}
                a \neq 0\\ のとき\\\\
                \quad |r| \lt 1\\ ならば収束し,その和は\displaystyle \frac{a}{1-r}\\\\
                \quad |r| \geqq 1\\ ならば発散する\\\\
                a = 0\\ のとき \quad 収束し,その和は0である
            \end{array}
        ';
        return $formula;
    }

    public function unit304_f06(){
        $formula['unit_id'] = 304;
        $formula['id'] = 30406;
        $formula['name'] = '無限級数の収束,発散';
        $formula['content'] = '
            \begin{array}{llcl}
                1 & 無限級数 \displaystyle \sum_{n=1}^{\infty} a_n\\ が収束する & \Rightarrow & \displaystyle \lim_{n \rightarrow \infty}a_n = 0\\\\
                2 & 数列{a_n}が0に収束しない & \Rightarrow & 無限級数 \displaystyle \sum_{n=1}^{\infty} a_n \\ は発散する
            \end{array}
        ';
        return $formula;
    }

    public function unit304_f07(){
        $formula['unit_id'] = 304;
        $formula['id'] = 30407;
        $formula['name'] = '関数の極限の性質';
        $formula['content'] = '
            \displaystyle \lim_{n \rightarrow \infty}f(x)=\alpha, \lim_{n \rightarrow \infty}g(x) = \betaとする\\\\
            \begin{array}{lll}
                1 & \displaystyle \lim_{n \rightarrow \infty}\left\{kf(x)+lg(x)\right\} = k\alpha+l\beta & ただしk,lは定数\\\\
                2 & \displaystyle \lim_{n \rightarrow \infty}f(x)g(x) = \alpha\beta & \\\\
                3 & \displaystyle \lim_{n \rightarrow \infty}\frac{f(x)}{g(x)} = \frac{\alpha}{\beta} & ただし\beta \neq 0 
            \end{array}
        ';
        return $formula;
    }

    public function unit304_f08(){
        $formula['unit_id'] = 304;
        $formula['id'] = 30408;
        $formula['name'] = '関数の極限と大小関係';
        $formula['content'] = '
            \displaystyle \lim_{n \rightarrow a}f(x)=\alpha, \lim_{n \rightarrow a}g(x) = \betaとする\\\\
            \begin{array}{ll}
                1 & xがaに近いとき,常に\\ f(x) \leqq g(x)\\ ならば \quad \alpha \leqq \beta\\\\
                2 & xがaに近いとき,常に\\ f(x) \leqq h(x) \leqq g(x)\\ かつ \\ \alpha = \beta\\ ならば\\\\
                  & \displaystyle \lim_{n \rightarrow a}h(x)=\alpha
            \end{array}
        ';
        return $formula;
    }

    public function unit304_f09(){
        $formula['unit_id'] = 304;
        $formula['id'] = 30409;
        $formula['name'] = '三角関数の極限';
        $formula['content'] = '
            \displaystyle \lim_{x \rightarrow 0}\frac{\sin{x}}{x}=1
        ';
        return $formula;
    }

    public function unit304_f10(){
        $formula['unit_id'] = 304;
        $formula['id'] = 30410;
        $formula['name'] = '関数の連続性';
        $formula['content'] = '
            aを関数f(x)の定義域に属する値とするとき,\\\\
            関数f(x)がx=aで連続であるとは,次のことが満たされていることである\\\\
            \begin{array}{ll}
                1 & 極限値 \displaystyle \lim_{x \rightarrow a}f(x)\\ が存在する\\\\
                2 & \displaystyle \lim_{x \rightarrow a}f(x) = f(a)\\ が成り立つ
            \end{array}
        ';
        return $formula;
    }

    public function unit304_f11(){
        $formula['unit_id'] = 304;
        $formula['id'] = 30411;
        $formula['name'] = '中間値の定理';
        $formula['content'] = '
            関数f(x)が閉区間[a,b]で連続で,f(a) \neq f(b)ならば,\\\\
            f(a)とf(b)の間の任意の値kに対して\\\\
            f(c)=k\\\\
            を満たす実数cが,aとbの間に少なくとも1つある
        ';
        return $formula;
    }

    public function unit305_f01(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30501;
        $formula['name'] = '微分可能と連続';
        $formula['content'] = '
            関数f(x)がx=aで微分可能ならば,x=aで連続である
        ';
        return $formula;
    }

    public function unit305_f02(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30502;
        $formula['name'] = '積の導関数';
        $formula['content'] = '
            \{f(x)g(x)\}\' = f\'(x)g(x) + f(x)g\'(x)
        ';
        return $formula;
    }

    public function unit305_f03(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30503;
        $formula['name'] = '商の導関数';
        $formula['content'] = '
            \left\{\frac{f(x)}{g(x)}\right\}\' = \frac{f\'(x)g(x) - f(x)g\'(x)}{\{g(x)\}^2}
        ';
        return $formula;
    }

    public function unit305_f04(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30504;
        $formula['name'] = '合成関数の微分法';
        $formula['content'] = '
            \frac{dy}{dx} = \frac{dy}{du} \cdot \frac{du}{dx}
        ';
        return $formula;
    }

    public function unit305_f05(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30505;
        $formula['name'] = '逆関数の微分法';
        $formula['content'] = '
            \frac{dy}{dx} = \frac{1}{\frac{dx}{dy}}
        ';
        return $formula;
    }

    public function unit305_f06(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30506;
        $formula['name'] = '三角関数の導関数';
        $formula['content'] = '
            (\sin{x})\' = \cos{x}\\\\
            (\cos{x})\' = -\sin{x}\\\\
            (\tan{x})\' = \frac{1}{\cos^2{x}}\\\\
        ';
        return $formula;
    }

    public function unit305_f07(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30507;
        $formula['name'] = '対数関数の導関数';
        $formula['content'] = '
            (\log{x})\' = \frac{1}{x}\\\\
            (\log_a{x})\' = \frac{1}{x\log{a}}\\\\
        ';
        return $formula;
    }

    public function unit305_f08(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30508;
        $formula['name'] = '指数関数の導関数';
        $formula['content'] = '
            (e^x)\' = e^x\\\\
            (a^x)\' = a^x\log{a}\\\\
        ';
        return $formula;
    }

    public function unit305_f09(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30509;
        $formula['name'] = '媒介変数で表された関数の導関数';
        $formula['content'] = '
            x=f(t),\\ y=g(t)のとき\\\\
            \frac{dy}{dx} = \frac{\frac{dy}{dt}}{\frac{dx}{dt}} = \frac{g\'(t)}{f\'(t)}
        ';
        return $formula;
    }

    public function unit305_f10(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30510;
        $formula['name'] = '法線の方程式';
        $formula['content'] = '
            曲線\\ y=f(x)上の点A(a,f(a))における法線の方程式は\\\\
            \begin{array}{cl}
                f\'(a) \neq 0のとき & \displaystyle y-f(a) = -\frac{1}{f\'(a)}(x-a)\\\\
                f\'(a) = 0 のとき & x=a
            \end{array}
        ';
        return $formula;
    }

    public function unit305_f11(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30511;
        $formula['name'] = '平均値の定理';
        $formula['content'] = '
            関数f(x)が閉区間[a,b]で連続で,開区間(a,b)で微分可能ならば,\\\\
            \frac{f(b)-f(a)}{b-a} = f\'(c), \quad a \lt c \lt b\\\\
            を満たす実数cが存在する
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot30511\', {
                boundingbox:[-1,20,15,-2],
                axis: true,
                showNavigation: true,
                showCopyright: false,
            });

            function bezier(t) {
                return 0.1*(t-10)*(t-10)*(t-10)+1*(t-10)*(t-10)+1*(t-10)+5;
            }
            f1 = board.create(\'functiongraph\', [bezier, -1, 15]);
            p1 = board.create(\'point\',[1,bezier(1)] , {name:\' \', face:\'o\', size:1, fixed:true});
            p2 = board.create(\'point\',[12,bezier(12)] , {name:\' \', face:\'o\', size:1, fixed:true});
            g1 = board.create(\'glider\', [3.48,bezier(3.48),f1]);
            t1 = board.create(\'tangent\', [g1]);
            g2 = board.create(\'glider\', [9.86,bezier(9.86),f1]);
            t2 = board.create(\'tangent\', [g2]);
            board.create(\'line\',[p1,p2],{straightFirst:false,straightLast:false});
        </script>
        ';
        return $formula;
    }

    public function unit305_f12(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30512;
        $formula['name'] = '導関数の符号と関数の増減';
        $formula['content'] = '
            \begin{array}{cl}
                1 & 開区間(a,b)で常にf\'(x) \gt 0ならば,f(x)は閉区間[a,b]で単調に増加する\\\\
                2 & 開区間(a,b)で常にf\'(x) \lt 0ならば,f(x)は閉区間[a,b]で単調に減少する\\\\
                3 & 開区間(a,b)で常にf\'(x) = 0ならば,f(x)は閉区間[a,b]で定数である\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit305_f13(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30513;
        $formula['name'] = '曲線の凹凸';
        $formula['content'] = '
            \begin{array}{l}
                関数f(x)は第2次導関数f\'\'(x)を持つとする\\\\
                \quad f\'\'(x) \gt 0である区間では,曲線y=f(x)は下に凸であり,\\\\
                \quad f\'\'(x) \lt 0である区間では,曲線y=f(x)は上に凸である\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit305_f14(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30514;
        $formula['name'] = '変曲点';
        $formula['content'] = '
            関数f(x)は第2次導関数を持つとする\\\\
            \begin{array}{ll}
                1 & f\'\'(a)=0のとき,x=aの前後でf\'\'(x)の符号が変わるならば,\\\\
                  & 点(a,f(a))は曲線y=f(x)の変曲点である\\\\
                2 & 点(a,f(a))が曲線y=f(x)の変曲点ならば, \quad f\'\'(a)=0\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit305_f15(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30515;
        $formula['name'] = '第2次導関数と極値';
        $formula['content'] = '
            x=aを含むある区間でf\'\'(x)は連続であるとする\\\\
            \begin{array}{ll}
                1 & f\'(a)=0\\ かつ\\ f\'\'(a) \lt 0\\  ならば,f(a)は極大値\\\\ 
                2 & f\'(a)=0\\ かつ\\ f\'\'(a) \gt 0\\  ならば,f(a)は極小値
            \end{array}
        ';
        return $formula;
    }

    public function unit305_f16(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30516;
        $formula['name'] = '速度,加速度';
        $formula['content'] = '
            座標平面上を運動する点Pの時刻tにおける座標(x,y)がtの関数であるとき,\\\\
            点Pの時刻tにおける速度\vec{v},速さ|\vec{v}|,加速度\vec{\alpha},加速度の大きさ|\vec{\alpha}|は,\\\\
            \begin{array}{cc}
                \displaystyle \vec{v} = (\frac{dx}{dt},\frac{dy}{dt}), & \displaystyle \vec{\alpha} = (\frac{d^2x}{dt^2},\frac{d^2y}{dt^2})\\\\
                \displaystyle |\vec{v}| = \sqrt{(\frac{dx}{dt})^2+(\frac{dy}{dt})^2}, & \displaystyle |\vec{\alpha}| = \sqrt{(\frac{d^2x}{dt^2})^2+(\frac{d^2y}{dt^2})^2}
            \end{array}
        ';
        return $formula;
    }

    public function unit305_f17(){
        $formula['unit_id'] = 305;
        $formula['id'] = 30517;
        $formula['name'] = '1次の近似式';
        $formula['content'] = '
            \begin{array}{lll}
                1 & |h|が十分小さいとき & f(a+h) \fallingdotseq f(a)+f\'(a)h\\\\
                2 & |x|が十分小さいとき & f(x) \fallingdotseq f(0)+f\'(0)x
            \end{array}
        ';
        return $formula;
    }

    public function unit306_f01(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30601;
        $formula['name'] = '累乗の不定積分';
        $formula['content'] = '
            \begin{array}{ll}
                \alpha \neq 1のとき & \displaystyle \int{x^\alpha}dx = \frac{1}{\alpha+1}x^{\alpha+1}+C\\\\
                & \displaystyle \int{\frac{1}{x}}dx = \log|x|+C\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit306_f02(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30602;
        $formula['name'] = '三角関数の不定積分';
        $formula['content'] = '
            \begin{array}{l}
                \int{\sin{x}}dx = -\cos{x}+C\\\\
                \int{\cos{x}}dx = \sin{x}+C\\\\
                \displaystyle \int{\frac{dx}{\cos^2{x}}} = \tan{x}+C\\\\
                \displaystyle \int{\frac{dx}{\sin^2{x}}} = -\frac{1}{\tan{x}}+C\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit306_f03(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30603;
        $formula['name'] = '指数関数の不定積分';
        $formula['content'] = '
            \begin{array}{l}
                \int{e^x}dx = e^x+C\\\\
                \displaystyle \int{a^x}dx = \frac{a^x}{\log{a}}+C\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit306_f04(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30604;
        $formula['name'] = '置換積分法';
        $formula['content'] = '
            \begin{array}{lll}
                1 & \int{f(x)}dx = \int{f(g(t))g\'(t)}dt & ただしx=g(t)\\\\
                2 & \int{g(x)g\'(x)}dx = \int{f(u)}du & ただしg(x)=u\\\\
                3 & \displaystyle \int{\frac{g\'(x)}{g(x)}}dx = \log|g(x)|+C
            \end{array}
        ';
        return $formula;
    }

    public function unit306_f05(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30605;
        $formula['name'] = '部分積分法';
        $formula['content'] = '
            \int{f(x)g\'(x)}dx = f(x)g(x) - \int{f\'(x)g(x)}dx
        ';
        return $formula;
    }

    public function unit306_f06(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30606;
        $formula['name'] = '定積分の置換積分法';
        $formula['content'] = '
            \alpha \lt \betaのとき,区間[a,b]で微分可能な関数x=g(t)に対し,\\\\
            a=g(\alpha),\\ b=g(\beta)ならば,\\\\
            \int_a^b{f(x)}dx = \int_\alpha^\beta{f(g(t))g\'(t)}dt
        ';
        return $formula;
    }

    public function unit306_f07(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30607;
        $formula['name'] = '偶関数,奇関数の定積分';
        $formula['content'] = '
            \begin{array}{lll}
                1 & f(x)が偶関数のとき & \displaystyle \int_{-a}^a{f(x)}dx = 2\int_0^a{f(x)}dx\\\\
                2 & f(x)が奇関数のとき & \displaystyle \int_{-a}^a{f(x)}dx = 0
            \end{array}
        ';
        return $formula;
    }

    public function unit306_f08(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30608;
        $formula['name'] = '定積分の部分積分法';
        $formula['content'] = '
            \int_a^b{f(x)g\'(x)}dx = \left[f(x)g(x)\right]_a^b - \int_a^b{f\'(x)g(x)}dx
        ';
        return $formula;
    }

    public function unit306_f09(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30609;
        $formula['name'] = '定積分で表された関数';
        $formula['content'] = '
            aが定数のとき, \quad \displaystyle \frac{d}{dx}\int_a^x{f(t)}dt = f(x)
        ';
        return $formula;
    }

    public function unit306_f10(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30610;
        $formula['name'] = '定積分と和の極限';
        $formula['content'] = '
            \begin{array}{ll}
                1 & \displaystyle \int_a^b{f(x)}dx = \lim_{n \rightarrow \infty} \sum_{k=0}^{n-1}f(x_k)\Delta{x} = \lim_{n \rightarrow \infty} \sum_{k=1}^{n}f(x_k)\Delta{x}\\\\
                  & \quad ここで, \displaystyle  \Delta{x} = \frac{b-a}{n}, \\ x_k = a+k\Delta{x}\\\\
                2 & \displaystyle  \lim_{n \rightarrow \infty} \frac{1}{n} \sum_{k=0}^{n-1}f(\frac{k}{n}) = \lim_{n \rightarrow \infty} \frac{1}{n} \sum_{k=1}^{n}f(\frac{k}{n}) = \int_0^1{f(x)}dx
            \end{array}
        ';
        return $formula;
    }

    public function unit306_f11(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30611;
        $formula['name'] = '定積分と不等式';
        $formula['content'] = '
            区間[a,b]でf(x) \geqq g(x)ならば \quad \displaystyle \int_a^b{f(x)}dx \geqq \int_a^b{g(x)}dx\\\\
            等号は,常にf(x)=g(x)であるときにのみ成り立つ
        ';
        return $formula;
    }

    public function unit306_f12(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30612;
        $formula['name'] = '立体の断面積と体積';
        $formula['content'] = '
            a \leqq x \leqq bとして,x軸に垂直でx軸との交点の座標がxである平面で\\\\
            ある立体を切ったときの断面積をS(x)とすると\\\\
            V = \int_a^b{S(x)}dx
        ';
        return $formula;
    }

    public function unit306_f13(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30613;
        $formula['name'] = '回転体の体積';
        $formula['content'] = '
            V = \pi\int_a^b{\left\{f(x)\right\}^2}dx
        ';
        return $formula;
    }

    public function unit306_f14(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30614;
        $formula['name'] = '曲線の長さ';
        $formula['content'] = '
            曲線x=f(t),\\ y=g(t)\\ (\alpha \leqq t \leqq \beta)の長さLは\\\\
            L=\int_\alpha^\beta\sqrt{(\frac{dx}{dt})^2+(\frac{dy}{dt})^2}dt = \int_\alpha^\beta\sqrt{\{f\'(t)\}^2+\{g\'(t)\}^2}dt\\\\
            曲線y=f(x)\\ (a \leqq t \leqq b)の長さLは\\\\
            L=\int_a^b\sqrt{1+(\frac{dy}{dx})^2}dx = \int_a^b\sqrt{1+\{f\'(x)\}^2}dx
        ';
        return $formula;
    }

    public function unit306_f15(){
        $formula['unit_id'] = 306;
        $formula['id'] = 30615;
        $formula['name'] = '速度と道のり';
        $formula['content'] = '
            数直線上を運動する点Pの速度をv=f(t)とし,t=aのときのPの座標をkとする\\\\
            \begin{array}{ll}
                t=bにおけるPの座標xは & x=k+\int_a^b{f(t)}dt\\\\
                t=aからt=bまでのPの位置の変化量sは & s=\int_a^b{f(t)}dt\\\\
                t=aからt=bまでのPの道のりlは & l=\int_a^b|f(t)|dt\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit401_f01(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40101;
        $formula['name'] = '要素の個数';
        $formula['content'] = '
            全体集合Uの2つの部分集合A,Bについて,\\\\
            \begin{array}{ll}
                1 & n(A \cup B)=n(A)+n(B)-n(A \cap B)\\\\
                2 & A \cap B = \varnothingのとき, \quad n(A \cup B)=n(A)+n(B)\\\\
                3 & n(\bar{A})= n(U)-n(A)
            \end{array}
        ';
        return $formula;
    }

    public function unit401_f02(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40102;
        $formula['name'] = '和の法則';
        $formula['content'] = '
            2つの事柄A,Bは同時に起こらないとする\\\\
            Aの起こり方がa通り,Bの起こり方がb通りあるとすると,\\\\
            AまたはBが起こる場合はa+b通りある
        ';
        return $formula;
    }

    public function unit401_f03(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40103;
        $formula['name'] = '積の法則';
        $formula['content'] = '
            事柄Aの起こり方がa通りあり,そのおのおのの場合について,\\\\
            事柄Bの起こり方がb通りあるとすると,AとBがともに起こる場合はab通りある
        ';
        return $formula;
    }

    public function unit401_f04(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40104;
        $formula['name'] = '順列の総数';
        $formula['content'] = '
            {}_n \mathrm{ P }_r = \underbrace{n(n-1)(n-2) \cdots (n-r+1)}_{r個の数の積}\\\\
            特に,{}_n \mathrm{ P }_n=n!=n(n-1)(n-2) \cdots 3 \cdot 2 \cdot 1
        ';
        return $formula;
    }

    public function unit401_f05(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40105;
        $formula['name'] = '種々の順列';
        $formula['content'] = '
            \begin{array}{ll}
                円順列\\\\
                \quad 異なるn個のものの円順列の総数は & \displaystyle \frac{{}_n \mathrm{ P }_n}{n} = (n-1)!\\\\
                重複順列\\\\
                \quad n個からr個とる重複順列の総数は & n^r
            \end{array}
        ';
        return $formula;
    }

    public function unit401_f06(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40106;
        $formula['name'] = '組み合わせの総数';
        $formula['content'] = '
            \begin{array}{ll}
                1 & \displaystyle {}_n \mathrm{C}_r = \frac{{}_n \mathrm{P}_r}{r!} = \frac{n(n-1)(n-2) \cdots (n-r+1)}{r(r-1)(r-2) \cdots 3 \cdot 2 \cdot 1}\\\\
                  & \quad 特に,\\ {}_n \mathrm{C}_n = 1\\\\
                2 & \displaystyle {}_n \mathrm{C}_r = \frac{n!}{r!(n-r)!}\\\\
                3 & {}_n \mathrm{C}_r = {}_n \mathrm{C}_{n-r} \quad ただし\\ 0 \leqq r \leqq n\\\\
                4 & {}_n \mathrm{C}_r = {}_{n-1} \mathrm{C}_{r-1} + {}_{n-1} \mathrm{C}_r \quad ただし\\ 1 \leqq r \leqq n-1, \\ n \geqq 2
            \end{array}
        ';
        return $formula;
    }

    public function unit401_f07(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40107;
        $formula['name'] = '確率の定義';
        $formula['content'] = '
            P(A) = \frac{n(A)}{n(U)} = \frac{事象Aの起こる場合の数}{起こりうるすべての場合の数}
        ';
        return $formula;
    }

    public function unit401_f08(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40108;
        $formula['name'] = '確率の基本性質';
        $formula['content'] = '
            \begin{array}{ll}
                1 & 任意の事象Aに対して \quad 0 \leqq P(A) \leqq 1\\\\
                  & 特に,空事象\varnothingの確率は \quad P(\varnothing)=0\\\\
                  & 全事象Uの確率は \quad P(U)=1\\\\
                2 & 2つの事象A,Bが互いに排反であるとき \quad P(A \cup B) = P(A)+P(B)
            \end{array}
        ';
        return $formula;
    }

    public function unit401_f09(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40109;
        $formula['name'] = '種々の確率';
        $formula['content'] = '
            \begin{array}{l}
                和事象の確率\\\\
                \quad P(A \cup B)=P(A)+P(B)-P(A \cap B)\\\\
                余事象の確率\\\\
                \quad P(\bar{A}) = 1-P(A)
            \end{array}
        ';
        return $formula;
    }

    public function unit401_f10(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40110;
        $formula['name'] = '独立な試行の確率';
        $formula['content'] = '
            2つの独立な試行S,Tを行うとき,Sでは事象Aが起こり,\\\\
            Tでは事象Bが起こるという事象をCとすると,事象Cの確率は\\\\
            P(C) = P(A)P(B)
        ';
        return $formula;
    }

    public function unit401_f11(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40111;
        $formula['name'] = '反復試行の確率';
        $formula['content'] = '
            1回の試行で事象Aが起こる確率をpとする\\\\
            この試行をn回繰り返し行うとき,事象Aが丁度r回起こる確率は\\\\
            {}_n \mathrm{C}_r p^r(1-p)^{n-r}
        ';
        return $formula;
    }

    public function unit401_f12(){
        $formula['unit_id'] = 401;
        $formula['id'] = 40112;
        $formula['name'] = '条件付き確率';
        $formula['content'] = '
            事象Aが起こったときに事象Bも起こる確率を条件付き確率P_A(B)といい,\\\\
            P_A(B) = \frac{P(A \cap B)}{P(A)}
        ';
        return $formula;
    }

    public function unit402_f01(){
        $formula['unit_id'] = 402;
        $formula['id'] = 40201;
        $formula['name'] = '角の二等分線と比';
        $formula['content'] = '
            \begin{array}{ll}
                1 & \triangle{ABC}の\angle{A}の二等分線と辺BCとの交点Pは,辺BCをAB:BCに内分する\\\\
                2 & AB \neq ACである\triangle{ABC}の頂点Aにおける外角の二等分線と辺BCの延長との\\\\
                  & 交点Qは,辺BCをAB:BCに外分する
            \end{array}
        ';
        return $formula;
    }

    public function unit402_f02(){
        $formula['unit_id'] = 402;
        $formula['id'] = 40202;
        $formula['name'] = '三角形の外心,内心,重心';
        $formula['content'] = '
            \begin{array}{ll}
                1 & 三角形の3辺の垂直二等分線は1点で交わる\\\\
                  & この点を三角形の外心という\\\\
                2 & 三角形の3つの内角の二等分線は1点で交わる\\\\
                  & この点を三角形の内心という\\\\
                3 & 三角形の3つの中線は1点で交わり,その点は各中線を2:1に内分する\\\\
                  & この点を三角形の重心という\\\\ 
            \end{array}
        ';
        return $formula;
    }

    public function unit402_f03(){
        $formula['unit_id'] = 402;
        $formula['id'] = 40203;
        $formula['name'] = 'チェバの定理';
        $formula['content'] = '
            \triangle{ABC}の頂点A,B,Cと,三角形の内部の点Oを結ぶ直線AO,BO,COが\\\\
            辺BC,CA,ABとそれぞれ点P,Q,Rで交わるとき\\\\
            \frac{BP}{PC} \cdot \frac{CQ}{QA} \cdot \frac{AR}{RB} = 1
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot40203\', {
                boundingbox:[-1,5,5,-1],
                axis: false,
                showNavigation: false,
                showCopyright: false,
            });

            function d_line(a,b,c,d) {
                m = (d-b)/(c-a);
                n = b -1*m*a;
                return [m,n];
            }

            function d_common(A,B){
                x = (B[1]-A[1])/(A[0]-B[0]);
                y = A[0]*x+A[1];
                return [x,y];
            }

            A = board.create(\'point\',[1,4] , {name:\'A\', face:\'o\', size:1, fixed:true});
            B = board.create(\'point\',[0,0] , {name:\'B\', face:\'o\', size:1, fixed:true});
            C = board.create(\'point\',[4,0] , {name:\'C\', face:\'o\', size:1, fixed:true});

            P = board.create(\'point\',d_common(d_line(1,4,2,1),[0,0]) , {name:\'P\', face:\'o\', size:1, fixed:true});
            Q = board.create(\'point\',d_common(d_line(0,0,2,1),d_line(1,4,4,0)) , {name:\'Q\', face:\'o\', size:1, fixed:true});
            R = board.create(\'point\',d_common(d_line(4,0,2,1),d_line(0,0,1,4)) , {name:\'R\', face:\'o\', size:1, fixed:true});

            board.create(\'line\',[A,P], {straightFirst:false,straightLast:false});
            board.create(\'line\',[B,Q], {straightFirst:false,straightLast:false});
            board.create(\'line\',[C,R], {straightFirst:false,straightLast:false});

            T1 = board.create(\'polygon\',[A,B,C]);
            O = board.create(\'point\',[2,1] , {name:\'O\', face:\'o\', size:1, fixed:true});
        </script>
        ';
        return $formula;
    }

    public function unit402_f04(){
        $formula['unit_id'] = 402;
        $formula['id'] = 40204;
        $formula['name'] = 'メネラウスの定理';
        $formula['content'] = '
            \triangle{ABC}の辺BC,CA,ABまたはその延長が\\\\
            三角形の頂点を通らない1つの直線lとそれぞれ点P,Q,Rで交わるとき\\\\
            \frac{BP}{PC} \cdot \frac{CQ}{QA} \cdot \frac{AR}{RB} = 1
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot40204\', {
                boundingbox:[-1,5,5,-1],
                axis: false,
                showNavigation: false,
                showCopyright: false,
            });

            function d_line(a,b,c,d) {
                m = (d-b)/(c-a);
                n = b -1*m*a;
                return [m,n];
            }

            function d_common(A,B){
                x = (B[1]-A[1])/(A[0]-B[0]);
                y = A[0]*x+A[1];
                return [x,y];
            }

            A = board.create(\'point\',[1,4] , {name:\'A\', face:\'o\', size:1, fixed:true});
            B = board.create(\'point\',[0,0] , {name:\'B\', face:\'o\', size:1, fixed:true});
            C = board.create(\'point\',[3,0] , {name:\'C\', face:\'o\', size:1, fixed:true});

            P = board.create(\'point\', [4,0] , {name:\'P\', face:\'o\', size:1, fixed:true});
            Q = board.create(\'point\',d_common(d_line(4,0,0.5,2),d_line(1,4,3,0)) , {name:\'Q\', face:\'o\', size:1, fixed:true});
            R = board.create(\'point\',d_common(d_line(4,0,0.5,2),d_line(1,4,0,0)) , {name:\'R\', face:\'o\', size:1, fixed:true});

            board.create(\'line\',[P,R], {name:\'l\',withLabel:true});
            board.create(\'line\',[B,P], {straightFirst:false});

            T1 = board.create(\'polygon\',[A,B,C]);
        </script>
        ';
        return $formula;
    }

    public function unit402_f05(){
        $formula['unit_id'] = 402;
        $formula['id'] = 40205;
        $formula['name'] = '円に内接する四角形';
        $formula['content'] = '
            四角形が円に内接するとき,次のことが成り立つ\\\\
            \begin{array}{ll}
                1 & 四角形の対角の和は180^\circである\\\\
                2 & 四角形の内角は,その対角の外角に等しい
            \end{array}
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot40205\', {
                boundingbox:[-1,5,5,-1],
                axis: false,
                showNavigation: false,
                showCopyright: false,
            });

            O = board.create(\'point\',[2,2] , {name:\'\', face:\'o\', size:0, fixed:true});
            C = board.create(\'circle\',[O,2])
            A = board.create(\'point\',[1,2+Math.sqrt(3)] , {name:\'\', face:\'o\', size:1, fixed:true});
            B = board.create(\'point\',[2-Math.sqrt(3),1] , {name:\'\', face:\'o\', size:1, fixed:true});
            C = board.create(\'point\',[4,2] , {name:\'\', face:\'o\', size:1, fixed:true});
            D = board.create(\'point\',[2+Math.sqrt(3),1] , {name:\'\', face:\'o\', size:1, fixed:true});
            P = board.create(\'point\',[5,1] , {name:\'\', face:\'o\', size:0, fixed:true});

            board.create(\'angle\',[B,A,C] , {name:\'α\'});
            board.create(\'angle\',[C,D,B] , {name:\'180°-α\'});
            board.create(\'angle\',[P,D,C] , {name:\'α\'});

            board.create(\'line\',[B,D]);

            T1 = board.create(\'polygon\',[A,B,D,C]);
        </script>
        ';
        return $formula;
    }

    public function unit402_f06(){
        $formula['unit_id'] = 402;
        $formula['id'] = 40206;
        $formula['name'] = '接線の長さ';
        $formula['content'] = '
            円の外部の1点からその円に引いた2本の接線について,\\\\
            2つの接線の長さは等しい\\\\
            下図でPA=PB
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot40206\', {
                boundingbox:[-1,5,5,-1],
                axis: false,
                showNavigation: false,
                showCopyright: false,
            });

            O = board.create(\'point\',[3,2] , {name:\'O\', face:\'o\', size:1, fixed:true});
            C = board.create(\'circle\',[O,1])
            A = board.create(\'point\',[5/2,2+Math.sqrt(3)/2] , {name:\'A\', face:\'o\', size:1, fixed:true});
            B = board.create(\'point\',[5/2,2-Math.sqrt(3)/2] , {name:\'B\', face:\'o\', size:1, fixed:true});
            P = board.create(\'point\',[0,2] , {name:\'P\', face:\'o\', size:1, fixed:true});

            board.create(\'line\',[P,A],{straightFirst:false});
            board.create(\'line\',[P,B],{straightFirst:false});
            board.create(\'line\',[O,A],{straightFirst:false,straightLast:false,dash:true});
            board.create(\'line\',[O,B],{straightFirst:false,straightLast:false,dash:true});
        </script>
        ';
        return $formula;
    }

    public function unit402_f07(){
        $formula['unit_id'] = 402;
        $formula['id'] = 40207;
        $formula['name'] = '接線と弦の作る角';
        $formula['content'] = '
            円Oの弦ABと,その端点Aにおける接線ATが作る角\angle{BAT}は,\\\\
            その角の内部に含まれる弧ABに対する円周角\angle{ACB}に等しい
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot40207\', {
                boundingbox:[-1,5,5,-1],
                axis: false,
                showNavigation: false,
                showCopyright: false,
            });

            O = board.create(\'point\',[2,2] , {name:\'O\', face:\'o\', size:1, fixed:true});
            C = board.create(\'circle\',[O,2])
            A = board.create(\'point\',[2,0] , {name:\'A\', face:\'o\', size:1, fixed:true});
            B = board.create(\'point\',[4,2] , {name:\'B\', face:\'o\', size:1, fixed:true});
            C = board.create(\'point\',[1,2+Math.sqrt(3)] , {name:\'C\', face:\'o\', size:1, fixed:true});
            T = board.create(\'point\',[4,0] , {name:\'T\', face:\'o\', size:0, fixed:true});

            board.create(\'line\',[A,T]);
            T1 = board.create(\'polygon\',[A,B,C]);

            board.create(\'angle\',[A,C,B] , {name:\'α\'});
            board.create(\'angle\',[T,A,B] , {name:\'α\'});
        </script>
        ';
        return $formula;
    }

    public function unit402_f08(){
        $formula['unit_id'] = 402;
        $formula['id'] = 40208;
        $formula['name'] = '方べきの定理';
        $formula['content'] = '
            \begin{array}{ll}
                1 & 円の2つの弦AB,CDの交点またはそれらの延長の交点をPとすると\\\\
                  & \quad PA \cdot PB = PC \cdot PD\\\\
                2 & 円の外部の点Pから円に引いた接線の接点をTとする\\\\
                  & Pを通る直線がこの円と2点A,Bで交わるとき\\\\
                  & \quad PA \cdot PB = PT^2
            \end{array}
        ';
        $formula['plot'] = '
        <script>
            var board = JXG.JSXGraph.initBoard(\'plot40208\', {
                boundingbox:[0,6,6,0],
                axis: false,
                showNavigation: false,
                showCopyright: false,
            });

            function d_line(a,b,c,d) {
                m = (d-b)/(c-a);
                n = b -1*m*a;
                return [m,n];
            }

            function d_common(A,B){
                x = (B[1]-A[1])/(A[0]-B[0]);
                y = A[0]*x+A[1];
                return [x,y];
            }

            O1 = board.create(\'point\',[3/2,4] , {name:\'\', face:\'o\', size:0, fixed:true});
            C1 = board.create(\'circle\',[O1,1]);
            O2 = board.create(\'point\',[9/2,4] , {name:\'\', face:\'o\', size:0, fixed:true});
            C2 = board.create(\'circle\',[O2,1]);
            A1 = board.create(\'point\',[3/2-Math.sqrt(3)/2,9/2] , {name:\'A\', face:\'o\', size:1, fixed:true});
            B1 = board.create(\'point\',[3/2+Math.sqrt(3)/2,9/2] , {name:\'B\', face:\'o\', size:1, fixed:true});
            C1 = board.create(\'point\',[3/2,5] , {name:\'C\', face:\'o\', size:1, fixed:true});
            D1 = board.create(\'point\',[2,4-Math.sqrt(3)/2] , {name:\'D\', face:\'o\', size:1, fixed:true});
            A2 = board.create(\'point\',[9/2-Math.sqrt(3)/2,7/2] , {name:\'A\', face:\'o\', size:1, fixed:true});
            B2 = board.create(\'point\',[9/2+Math.sqrt(3)/2,7/2] , {name:\'B\', face:\'o\', size:1, fixed:true});
            T = board.create(\'point\',[4,4+Math.sqrt(3)/2] , {name:\'T\', face:\'o\', size:1, fixed:true});
            P1 = board.create(\'point\',d_common(d_line(3/2-Math.sqrt(3)/2,9/2,3/2+Math.sqrt(3)/2,9/2),d_line(3/2,5,2,4-Math.sqrt(3)/2)) , {name:\'P\', face:\'o\', size:1, fixed:true});
            P2 = board.create(\'point\',[3,7/2] , {name:\'P\', face:\'o\', size:1, fixed:true});

            board.create(\'line\',[A1,B1],{straightFirst:false,straightLast:false});
            board.create(\'line\',[C1,D1],{straightFirst:false,straightLast:false});
            board.create(\'line\',[P2,B2],{straightFirst:false,straightLast:true});
            board.create(\'line\',[P2,T],{straightFirst:false,straightLast:true});
        </script>
        ';
        return $formula;
    }

    public function unit402_f09(){
        $formula['unit_id'] = 402;
        $formula['id'] = 40209;
        $formula['name'] = 'オイラーの多面体定理';
        $formula['content'] = '
            凸多面体の頂点,辺,面の数をそれぞれv,e,fとすると\\\\
            v-e+f=2
        ';
        return $formula;
    }

    public function unit403_f01(){
        $formula['unit_id'] = 403;
        $formula['id'] = 40301;
        $formula['name'] = '倍数の判定法';
        $formula['content'] = '
            \begin{array}{ll}
                2の倍数 & 一の位が0,2,4,6,8のいずれかである\\\\
                5の倍数 & 一の位が0,5のいずれかである\\\\
                4の倍数 & 下2桁が4の倍数である\\\\
                3の倍数 & 各位の数の和が3の倍数である\\\\
                9の倍数 & 各位の数の和が9の倍数である
            \end{array}
        ';
        return $formula;
    }

    public function unit403_f02(){
        $formula['unit_id'] = 403;
        $formula['id'] = 40302;
        $formula['name'] = '約数の個数';
        $formula['content'] = '
            自然数Nを素因数分解した結果がN=p^aq^br^c \cdots であるとき,\\\\
            Nの正の約数の個数は,次の式で表される\\\\
            (a+1)(b+1)(c+1) \cdots
        ';
        return $formula;
    }

    public function unit403_f03(){
        $formula['unit_id'] = 403;
        $formula['id'] = 40303;
        $formula['name'] = '最大公約数,最小公倍数の性質';
        $formula['content'] = '
            2つの自然数a,bの最大公約数をg,最小公倍数をlとする\\\\
            a=ga\',\\ b=gb\'\\ であるとすると,次のことが成り立つ\\\\
            \begin{array}{ll}
                1 & a\',b\'は互いに素である\\\\
                2 & l=ga\'b\'\\\\
                3 & ab=gl \quad 特にg=1のとき,\\ ab=l
            \end{array}
        ';
        return $formula;
    }

    public function unit403_f04(){
        $formula['unit_id'] = 403;
        $formula['id'] = 40304;
        $formula['name'] = '整数の割り算';
        $formula['content'] = '
            整数aと正の整数bに対して\\\\
            a=bq+r \quad 0 \leqq r \lt b\\\\
            を満たす整数qとrがただ1通りに定まる
        ';
        return $formula;
    }

    public function unit403_f05(){
        $formula['unit_id'] = 403;
        $formula['id'] = 40305;
        $formula['name'] = '割り算の余りの性質';
        $formula['content'] = '
            mを正の整数とし,2つの整数a,bをmで割ったときの余りをそれぞれr,r\'とする\\\\
            \begin{array}{ll}
                1 & a+bをmで割った余りは,r+r\'をmで割った余りと等しい\\\\
                2 & a-bをmで割った余りは,r-r\'をmで割った余りと等しい\\\\
                3 & abをmで割った余りは,rr\'をmで割った余りと等しい\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit403_f06(){
        $formula['unit_id'] = 403;
        $formula['id'] = 40306;
        $formula['name'] = '合同式とその性質';
        $formula['content'] = '
            mを正の整数とする。2つの整数a,bについてa-bがmの倍数であるとき,\\\\
            aとbはmを法として合同であるといい,\\\\
            a \equiv b \pmod m \quad とかく\\\\
            a \equiv c \pmod m, \quad b \equiv d \pmod m\\ のとき\\\\
            \begin{array}{ll}
                1 & a+b \equiv c+d \pmod m\\\\
                2 & a-b \equiv c-d \pmod m\\\\
                3 & ab \equiv cd \pmod m\\\\
                4 & a^k \equiv c^k \pmod m
            \end{array}
        ';
        return $formula;
    }

    public function unit403_f07(){
        $formula['unit_id'] = 403;
        $formula['id'] = 40307;
        $formula['name'] = '割り算と最大公約数';
        $formula['content'] = '
            2つの自然数a,bについて,aをbで割ったときの商をq,余りをrとすると\\\\
            aとbの最大公約数は,bとrの最大公約数に等しい
        ';
        return $formula;
    }

    public function unit501_f01(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50101;
        $formula['name'] = 'ベクトルの加法';
        $formula['content'] = '
            \begin{array}{lcl}
                1 & 交換法則 & \vec{a}+\vec{b} = \vec{b}+\vec{a}\\\\
                2 & 結合法則 & (\vec{a}+\vec{b})+\vec{c} = \vec{a}+(\vec{b}+\vec{c})
            \end{array}
        ';
        return $formula;
    }

    public function unit501_f02(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50102;
        $formula['name'] = '逆ベクトルと零ベクトル';
        $formula['content'] = '
            \begin{array}{ll}
                1 & \vec{a}+(-\vec{a}) = \vec{0}\\\\
                2 & \vec{a} + \vec{0} = \vec{a}
            \end{array}
        ';
        return $formula;
    }

    public function unit501_f03(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50103;
        $formula['name'] = 'ベクトルの実数倍';
        $formula['content'] = '
            k,lを実数とするとき\\\\
            \begin{array}{ll}
                1 & k(l\vec{a}) = (kl)\vec{a}\\\\
                2 & (k+l)\vec{a} = k\vec{a} + l\vec{a}\\\\
                3 & k(\vec{a}+\vec{b}) = k\vec{a} + k\vec{b}
            \end{array}
        ';
        return $formula;
    }

    public function unit501_f04(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50104;
        $formula['name'] = 'ベクトルの平行条件';
        $formula['content'] = '
            \vec{a} \neq \vec{0},\\ \vec{b} \neq \vec{0}のとき\\\\
            \vec{a} /\!/ \vec{b} \iff \vec{b} = k\vec{a}となる実数kがある
        ';
        return $formula;
    }

    public function unit501_f05(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50105;
        $formula['name'] = 'ベクトルの分解';
        $formula['content'] = '
            2つのベクトル\vec{a},\vec{b}は\vec{0}でなく,また平行でないとする\\\\
            このとき,任意のベクトル\vec{p}は,次の形にただ1通りに表すことができる\\\\
            \vec{p} = s\vec{a}+t\vec{b} \quad ただしs,tは実数
        ';
        return $formula;
    }

    public function unit501_f06(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50106;
        $formula['name'] = 'ベクトルの成分と大きさ';
        $formula['content'] = '
            \vec{a}=(a_1,a_2)のとき \quad |\vec{a}|=\sqrt{a_1^2+a_2^2}
        ';
        return $formula;
    }

    public function unit501_f07(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50107;
        $formula['name'] = '成分によるベクトルの演算';
        $formula['content'] = '
            \begin{array}{ll}
                1 & (a_1,a_2)+(b_1,b_2) = (a_1+b_1,a_2+b_2)\\\\
                2 & k(a_1,a_2) = (ka_1,ka_2)
            \end{array}
        ';
        return $formula;
    }

    public function unit501_f08(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50108;
        $formula['name'] = 'ベクトルの内積';
        $formula['content'] = '
            \vec{a}=(a_1,a_2),\\ \vec{b}=(b_1,b_2)とすると,\\\\
            \vec{a} \cdot \vec{b} = |\vec{a}||\vec{b}|\cos{\theta} = a_1b_1+a_2b_2\\\\
            ただし,\thetaは\vec{a}と\vec{b}のなす角\\\\
            特に\theta=90^\circのとき, \quad \vec{a} \cdot \vec{b}=0
        ';
        return $formula;
    }

    public function unit501_f09(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50109;
        $formula['name'] = 'ベクトルのなす角';
        $formula['content'] = '
            \vec{a}=(a_1,a_2),\\ \vec{b}=(b_1,b_2)のなす角を\thetaとすると,\\\\
            \cos{\theta} = \frac{\vec{a} \cdot \vec{b}}{|\vec{a}||\vec{b}|} = \frac{a_1b_1+a_2b_2}{\sqrt{a_1^2+a_2^2}\sqrt{b_1^2+b_2^2}}\\\\
            ただし,\\ 0^\circ \leqq \theta \leqq 180^\circ
        ';
        return $formula;
    }

    public function unit501_f10(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50110;
        $formula['name'] = '内積の性質';
        $formula['content'] = '
            \begin{array}{ll}
                1 & \vec{a} \cdot \vec{b} = \vec{b} \cdot \vec{a}\\\\
                2 & (\vec{a}+\vec{b}) \cdot \vec{c} = \vec{a} \cdot \vec{c} + \vec{b} \cdot \vec{c}\\\\
                3 & (k\vec{a}) \cdot \vec{b} = \vec{a} \cdot (k\vec{b}) = k(\vec{a} \cdot \vec{b}) \quad ただしkは実数\\\\
                4 & \vec{a} \cdot \vec{a} = |\vec{a}|^2\\\\
                5 & |\vec{a}| = \sqrt{\vec{a} \cdot \vec{a}}
            \end{array}
        ';
        return $formula;
    }

    public function unit501_f11(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50111;
        $formula['name'] = '線分の内分点,外分点の位置ベクトル';
        $formula['content'] = '
            2点A(\vec{a}),B(\vec{b})を結ぶ線分ABを\\\\
            m;nに内分する点P,外分する点Qの位置ベクトルを,それぞれ\vec{p},\vec{q}とすると\\\\
            \vec{p} = \frac{n\vec{a}+m\vec{b}}{m+n}, \quad \vec{q} = \frac{-n\vec{a}+m\vec{b}}{m-n}\\\\
            特に,線分AMの中点Mの位置ベクトル\vec{m}は\\\\
            \vec{m} = \frac{\vec{a}+\vec{b}}{2}
        ';
        return $formula;
    }

    public function unit501_f12(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50112;
        $formula['name'] = '三角形の重心の位置ベクトル';
        $formula['content'] = '
            3点A(\vec{a}),B(\vec{b}),C(\vec{c})を頂点とする\triangle{ABC}の重心Gの位置ベクトル\vec{g}は,\\\\
            \vec{g} = \frac{\vec{a}+\vec{b}+\vec{c}}{3}
        ';
        return $formula;
    }

    public function unit501_f13(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50113;
        $formula['name'] = '一直線上の点';
        $formula['content'] = '
            2点A,Bが異なるとき,\\\\
            点Pが直線AB上にある \iff \overrightarrow{AP} = k\overrightarrow{AB}となる実数kがある
        ';
        return $formula;
    }

    public function unit501_f14(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50114;
        $formula['name'] = '直線のベクトル方程式';
        $formula['content'] = '
            点A(\vec{a})を通り,\vec{0}でないベクトル\vec{d}に平行な直線のベクトル方程式は\\\\
            \vec{p}=\vec{a}+t\vec{d}\\\\
            異なる2点A(\vec{a}),B(\vec{b})を通る直線のベクトル方程式は\\\\
            \vec{p}=(1-t)\vec{a}+t\vec{b}\\\\
        ';
        return $formula;
    }

    public function unit501_f15(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50115;
        $formula['name'] = '同じ平面上にある点';
        $formula['content'] = '
            点Pが平面ABC上にある\\\\
            \iff \overrightarrow{CP}=s\overrightarrow{CA}+t\overrightarrow{CB}となる実数s,tがある
        ';
        return $formula;
    }

    public function unit501_f16(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50116;
        $formula['name'] = '座標軸に垂直な平面の方程式';
        $formula['content'] = '
            点P(a,b,c)を通り,x軸に垂直な平面の方程式は \quad x=a\\\\
            点P(a,b,c)を通り,y軸に垂直な平面の方程式は \quad y=b\\\\
            点P(a,b,c)を通り,z軸に垂直な平面の方程式は \quad z=c
        ';
        return $formula;
    }

    public function unit501_f17(){
        $formula['unit_id'] = 501;
        $formula['id'] = 50117;
        $formula['name'] = '球面の方程式';
        $formula['content'] = '
            中心が点(a,b,c),半径がrの球面の方程式は\\\\
            (x-a)^2+(y-b)^2+(z-c)^2=r^2
        ';
        return $formula;
    }

    public function unit502_f01(){
        $formula['unit_id'] = 502;
        $formula['id'] = 50201;
        $formula['name'] = '等差数列の一般項';
        $formula['content'] = '
            初項a,公差dの等差数列{a_n}の一般項は\\\\
            a_n=a+(n-1)d
        ';
        return $formula;
    }

    public function unit502_f02(){
        $formula['unit_id'] = 502;
        $formula['id'] = 50202;
        $formula['name'] = '等差数列の和';
        $formula['content'] = '
            初項a,公差d,末項l,項数nの等差数列の和をS_nとすると\\\\
            S_n=\frac{1}{2}n(a+l) = \frac{1}{2}n\left\{2a+(n-1)d\right\}
        ';
        return $formula;
    }

    public function unit502_f03(){
        $formula['unit_id'] = 502;
        $formula['id'] = 50203;
        $formula['name'] = '等比数列の一般項';
        $formula['content'] = '
            初項a,公比rの等差数列{a_n}の一般項は\\\\
            a_n=ar^{n-1}
        ';
        return $formula;
    }

    public function unit502_f04(){
        $formula['unit_id'] = 502;
        $formula['id'] = 50204;
        $formula['name'] = '等比数列の和';
        $formula['content'] = '
            初項a,公比r,項数nの等比数列の和をS_nとする\\\\
            \begin{array}{lll}
                1 & r \neq 1のとき & \displaystyle S_n=\frac{a(1-r^n)}{1-r}=\frac{a(r^n-1)}{r-1}\\\\
                2 & r=1のとき & S_n=na
            \end{array}
        ';
        return $formula;
    }

    public function unit502_f05(){
        $formula['unit_id'] = 502;
        $formula['id'] = 50205;
        $formula['name'] = '数列の和の公式';
        $formula['content'] = '
            \begin{array}{ll}
                1 & \displaystyle \sum_{k=1}^{n}c = nc\\\\
                2 & \displaystyle \sum_{k=1}^{n}k = \frac{1}{2}n(n+1)\\\\
                3 & \displaystyle \sum_{k=1}^{n}k^2 = \frac{1}{6}n(2n+1)(n+1)\\\\
                4 & \displaystyle \sum_{k=1}^{n}k^3 = \left\{\frac{1}{2}n(n+1)\right\}^2\\\\
                5 & \displaystyle \sum_{k=1}^{n}r^{k-1} = \frac{1-r^n}{1-r} = \frac{r^n-1}{r-1}
            \end{array}
        ';
        return $formula;
    }

    public function unit502_f06(){
        $formula['unit_id'] = 502;
        $formula['id'] = 50206;
        $formula['name'] = 'Σの性質';
        $formula['content'] = '
            \begin{array}{ll}
                1 & \displaystyle \sum_{k=1}^{n}(a_k+b_k) = \sum_{k=1}^{n}a_k+\sum_{k=1}^{n}b_k\\\\
                2 & \displaystyle \sum_{k=1}^{n}pa_k = p\sum_{k=1}^{n}a_k\\\\
            \end{array}
        ';
        return $formula;
    }

    public function unit502_f07(){
        $formula['unit_id'] = 502;
        $formula['id'] = 50207;
        $formula['name'] = '階差数列と一般項';
        $formula['content'] = '
            数列{a_n}の階差数列を{b_n}とすると,\\\\
            n \leqq 2とすると, \quad \displaystyle a_n=a_1+\sum_{k=1}^{n-1}b_k
        ';
        return $formula;
    }

    public function unit502_f08(){
        $formula['unit_id'] = 502;
        $formula['id'] = 50208;
        $formula['name'] = '数列の和と一般項';
        $formula['content'] = '
            数列{a_n}の初項から第n項までの和をS_nとすると\\\\
            \begin{array}{ll}
                初項a_1は & a_1=S_1\\\\
                n \geqq 2のとき & a_n=S_n-S_{n-1}
            \end{array}
        ';
        return $formula;
    }

    public function unit502_f09(){
        $formula['unit_id'] = 502;
        $formula['id'] = 50209;
        $formula['name'] = '数学的帰納法';
        $formula['content'] = '
            自然数nに関する事柄Pがすべての自然数nについて成り立つことを\\\\
            数学的帰納法で証明するには,次の2つのことを示す\\\\
            \begin{array}{ll}
                [1] & n=1のときPが成り立つ\\\\
                [2] & n=kのときPが成り立つと仮定すると\\\\
                    & n=k+1のときにもPが成り立つ
            \end{array}
        ';
        return $formula;
    }
}
