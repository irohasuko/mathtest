@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p>{{$text}}
                @for($i=0 ; $i<$blanks ; $i++)
                    {{$options[$i]}}
                    {{'\\\\'}}
                @endfor
                {{'$$'}}</p>
                </div>
            </div>
            <br>

            <form method="post" action="{{route('answer',[$unit_id, $question_id])}}">
                @csrf
                @for($i=0 ; $i<$blanks ; $i++)
                    <div class="form-group ml-5">
                        <input class="form-check-input" type="radio" name="answer" id="{{$i}}" value="{{$i+1}}" required>
                        <label class="form-check-label" for="{{$i}}">
                        {{$options[$i]}}
                        </label>
                    </div>
                @endfor

                @foreach($options as $option)
                    <input type="hidden" name="options[]" value="{{$option}}">
                @endforeach
                <input type="hidden" name="right_answer" value="{{$right_answer}}">
                <input type="hidden" name="text" value="{{$text}}">
                <button type="submit" class="btn btn-primary">解答</button>
            </form>        
        </div>
    </div>
</div>
@endsection