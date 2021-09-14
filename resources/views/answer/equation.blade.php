@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p>正解は...</p>
                    <div>{{$text}}</div>
                    <p>あなたの解答は...</p>
                    <div>{{$answer_text}}</div>
                </div>
            </div>
            <br>
        </div>

        <div class="col-md-8">
            @if($result == 1)
            <div class="alert alert-success">正解！</div>
            @elseif($result == 0)
            <div class="alert alert-danger">不正解...</div>
            @endif
            
        </div>

        <div class="col-md-8">
            <a class="btn btn-primary btn-block" href="{{route('Q'.$question_id, $unit_id)}}" role="button">もう一度同じ問題を解く</a>
            <a class="btn btn-primary btn-block" href="{{route('Q'.$next_id, $unit_id)}}" role="button">次のパターンの問題を解く</a>
            <a class="btn btn-primary btn-block" href="{{route('question_select', $unit_id)}}" role="button">問題選択画面に戻る</a>
        </div>
    </div>
</div>
@endsection