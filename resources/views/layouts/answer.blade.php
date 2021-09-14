@extends('layouts.question')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <p>正解は...</p>

            <div>
                @yield('right_answer')
            </div>

            <p>あなたの解答は...</p>

            <div>
                @yield('your_answer')
            </div>
        </div>

        <div class="col-md-8">
            <div class="alert alert-success">{{$message}}</div>
        </div>

        <div class="col-md-8">
            <a class="btn btn-primary btn-block" href="{{route('Q'.$question_id, $unit_id)}}" role="button">もう一度同じ問題を解く</a>
            <a class="btn btn-primary btn-block" href="{{route('Q'.$next_id, $unit_id)}}" role="button">次のパターンの問題を解く</a>
            <a class="btn btn-primary btn-block" href="{{route('question_select', $unit_id)}}" role="button">問題選択画面に戻る</a>
        </div>
    </div>
</div>
@endsection
