@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('formula_select',$unit_id))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
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
        </div>
    </div>
</div>
@endsection

@section('canvas')
    @foreach($formulas as $formula)
        @if(isset($formula['canvas']))
            {!!$formula['canvas']!!}
        @endif
        @if(isset($formula['plot']))
            {!!$formula['plot']!!}
        @endif
    @endforeach
@endsection
