@extends('layouts.question')

@section('question')
<p>{{$text}}{{$blank_text}}</p>
@endsection

@section('submit')
@for($i=0 ; $i<$blanks ; $i++)
    <div class="form-group">
        <input type="number" required name="answers[]" class="form-control" placeholder="{{$option[$i]}}" step="0.1">
    </div>
@endfor
@endsection