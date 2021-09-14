@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @yield('question')
            <form method="post" action="{{route('A'.$question_id,$unit_id)}}">
                @csrf
                @yield('submit')
                @foreach($right_answers as $right_answer)
                    <input type="hidden" name="right_answers[]" value="{{$right_answer}}">
                @endforeach
                <input type="hidden" name="text" value="{{$text}}">
                <button type="submit" class="btn btn-primary">解答</button>
            </form>        
        </div>
    </div>
</div>
@endsection
