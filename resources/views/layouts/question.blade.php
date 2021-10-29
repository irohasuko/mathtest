@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('question',$unit,$question))

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @yield('question')
                </div>
            </div>
            <br>

            <form method="post" action="{{route('answer',[$unit->id, $question->q_id])}}">
                @csrf
                @yield('submit')
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
