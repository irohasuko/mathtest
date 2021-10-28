@extends('layouts.question')

@section('question')
<div class="text-center">
    {!!$canvas!!}
</div>
<p>{{$text}}{{$blank_text}}</p>
@endsection

@section('submit')
@for($i=0 ; $i<$blanks ; $i++)
    <div class="form-group ml-5">
        <input class="form-check-input" type="radio" name="answers[]" id="{{$i}}" value="{{$i+1}}" required>
        <label class="form-check-label" for="{{$i}}">
            {{$options[$i]}}
        </label>
        <input type="hidden" name="options[]" value="{{$options[$i]}}">
    </div>
@endfor
@endsection

@section('script')
{!!$script!!}
@endsection