@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('question',$unit,$question))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9 mb-5">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#tabanswer" role="tab">
                        答え
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tabsample" role="tab">
                        解説
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#tabformula" role="tab">
                        使用する公式
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tabanswer" role="tabpanel">
                    <div class="card card-body">
                        <div id="answer">
                            @yield('answer')
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="tabsample" role="tabpanel">
                    <div class="card card-body">
                        <div id="sample_card">
                            @if(isset($sample_text))
                                $${{$sample_text}}$$
                            @else
                                申し訳ございません。解説はまだ未実装です。今後の実装をお待ちください。
                            @endif
                            @if(isset($a_script))
                                <div class="text-center">
                                    <canvas id="canvas" width="350" height="200">
                                        canvas対応のブラウザでは、ここに図形が表示されます。
                                    </canvas>
                                </div>
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
                <div class="tab-pane" id="tabformula" role="tabpanel">
                    @if(isset($formulas))
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="card">
                            @foreach($formulas as $formula)
                                <div class="card-header" role="tab" id="heading{{$formula['id']}}">
                                    <h5 class="mb-0">
                                        <a class="collapsed text-body d-block p-3 m-n3" data-toggle="collapse" href="#collapse{{$formula['id']}}" role="button" aria-expanded="false" aria-controls="collapse{{$formula['id']}}">
                                            {{$formula['name']}}
                                        </a>
                                    </h5>
                                </div><!-- /.card-header -->
                                <div id="collapse{{$formula['id']}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$formula['id']}}" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="formula">
                                            $${{$formula['content']}}$$
                                        </div>
                                        @if(isset($formula['canvas']))
                                        <div class="text-center">
                                            <canvas id="canvas{{$formula['id']}}" width="350" height="200">
                                                canvas対応のブラウザでは、ここに図形が表示されます。
                                            </canvas>
                                        </div>
                                        @endif
                                        @if(isset($formula['plot']))
                                            <div class="graph-wrap" align="center">
                                            <!-- グラフの出力先(JSXGraph用) -->
                                                <div id="plot{{$formula['id']}}" class="graph" style="width:300px; height:300px;"></div>
                                            </div>
                                        @endif
                                    </div><!-- /.card-body -->
                                </div><!-- /.collapse -->
                            @endforeach
                        </div><!-- /.card -->
                    </div><!-- /#accordion -->
                    @else
                        <div class="card">
                            <div class="card-body text-center">
                                この問題で使用する公式は一覧にはありません
                            </div>
                        </div>
                    @endif
                </div>
            </div>
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

@section('canvas')
    @if(isset($formulas))   
        @foreach($formulas as $formula)
            @if(isset($formula->canvas))
                <script type="text/javascript">
                    window.addEventListener('load',function draw() {
                        var canvas = document.getElementById('canvas{{$formula->id}}');
                        if (canvas.getContext) {
                            {{$formula->canvas}}
                        }
                    });
                </script>
            @endif
        @endforeach
    @endif
    @if(isset($plot))
        {!!$plot!!}
    @endif
    @if(isset($a_script))
        {!!$a_script!!}
    @endif
    @if(isset($formulas))
        @foreach($formulas as $formula)
            @if(isset($formula['canvas']))
                {!!$formula['canvas']!!}
            @endif
            @if(isset($formula['plot']))
                {!!$formula['plot']!!}
            @endif
        @endforeach
    @endif
@endsection
