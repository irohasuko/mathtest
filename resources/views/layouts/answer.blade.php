@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('question',$unit,$question))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9 mb-5">
            <div class="card">
                <div class="card-body">
                    <div id="answer">
                        @yield('answer')
                    </div>
                </div>
            </div>
            <!-- ボタン-->
            <div class="btn-toolbar">
                <div class="btn-group ml-auto">
                    <button class="btn btn-primary" data-toggle="collapse" data-target="#sample" aria-expand="false" aria-controls="sample">解説を表示</button>
                    <!--
                        <button class="btn btn-primary" data-toggle="collapse" data-target="#formula" aria-expand="false" aria-controls="formula">使用する公式</button>
                    -->
                </div>
            </div>
            <div class="collapse" id="sample">
                <div class="card card-body">
                    <div id="sample_card">
                        @if(isset($sample_text))
                        $${{$sample_text}}$$
                        @else
                        申し訳ございません。解説はまだ未実装です。今後の実装をお待ちください。
                        @endif
                        @if(isset($script))
                            <div class="text-center">
                                <canvas id="canvas" width="350" height="200">
                                    canvas対応のブラウザでは、ここに図形が表示されます。
                                </canvas>
                            </div>
                            @section('canvas')
                                {!!$script!!}
                            @endsection
                        @endif
                    </div>
                    @if(isset($plot))
                        <div class="graph-wrap" align="center">
                        <!-- グラフの出力先(JSXGraph用) -->
                            <div id="plot" class="graph" style="width:300px; height:200px;"></div>
                        </div>
                    @endif
                    
                </div>
            </div>
            <!--
            <div class="collapse" id="formula">
                <div class="card card-body">
                    $$分配法則$$
                </div>
            </div>
            -->
        </div>

        <div class="col-md-10 col-lg-3">
            @if($result == 1)
            <div class="alert alert-success">正解！</div>
            @elseif($result == 0)
            <div class="alert alert-danger">不正解...</div>
            @endif
            
            <a class="btn btn-primary btn-block" href="{{route('question',[$question->unit_id, $question->q_id])}}" role="button">もう一度同じ問題を解く</a>
            <a class="btn btn-primary btn-block" href="{{route('q_route',$next_id)}}" role="button">次のパターンの問題を解く</a>
            <a class="btn btn-primary btn-block" href="{{route('question_select', $unit->id)}}" role="button">問題選択画面に戻る</a>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    window.addEventListener('load',function(){
        setTimeout('display()',300);
    });
    function display(){
        document.getElementById('answer').style.display = 'block';
    }
</script>
@endsection

@if(isset($plot))
    @section('canvas')
        {!!$plot!!}
    @endsection
@endif
