@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <p>{{$text}} = {{$blank_text}}</p>
                </div>
            </div>
            <br>

            <form method="post" action="{{route('answer',[$unit_id, $question_id])}}">
                @csrf
                @for($i=0 ; $i<$blanks ; $i++)
                    <div class="form-group">
                        <input type="number" required name="answers[]" class="form-control" placeholder="{{$option[$i]}}">
                    </div>
                @endfor

                @foreach($right_answers as $right_answer)
                    <input type="hidden" name="right_answers[]" value="{{$right_answer}}">
                @endforeach
                <input type="hidden" name="text" value="{{$text}}">
                <input type="hidden" name="blank_text" value="{{$blank_text}}">
                <button type="submit" class="btn btn-primary">解答</button>
            </form>        
        </div>
    </div>
</div>
@endsection
