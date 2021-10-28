@extends('layouts.question')

@section('question')
<div class="text-center">
    {!!$canvas!!}
</div>
<p>{{$text}}{{$blank_text}}</p>
@endsection

@section('submit')
@for($i=0 ; $i<$blanks ; $i++)
    <div class="form-group">
        <input type="number" required name="answers[]" class="form-control" placeholder="{{$option[$i]}}">
    </div>
@endfor
@endsection

@section('script')
{!!$script!!}
@endsection

