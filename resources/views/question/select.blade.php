@extends('layouts.question')

@section('question')
<p>{{$text}}
    @for($i=0 ; $i<$blanks ; $i++)
    {{$options[$i]}}
    {{'\\\\'}}
    @endfor
{{'$$'}}</p>
@endsection

@section('submit')
@for($i=0 ; $i<$blanks ; $i++)
    <div class="form-group ml-5">
        <input class="form-check-input" type="radio" name="answer" id="{{$i}}" value="{{$i+1}}" required>
        <label class="form-check-label" for="{{$i}}">
            {{$options[$i]}}
        </label>
    </div>
@endfor
@endsection