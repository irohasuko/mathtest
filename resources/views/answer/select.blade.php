@extends('layouts.answer')

@section('answer')
<p>正解は...</p>
<div>{{$text}}</div>
<p>あなたの解答は...</p>
<div>{{$answer_text}}</div>
@endsection