@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('question',$unit,$question))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div id="answer">
                        @yield('answer')
                    </div>
                </div>
            </div>
            <br>
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
