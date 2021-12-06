@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('question',$unit,$question))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9">
            <div class="card">
                <div class="card-body">
                    <div id="question">
                        @yield('question')
                    </div>
                </div>
            </div>
            <br>
        </div>
        <div class="col-md-10 col-lg-3">
            <form method="post" action="{{route('answer',[$unit->id, $question->q_id])}}">
                @csrf
                @yield('submit')
                @foreach($right_answers as $right_answer)
                    <input type="hidden" name="right_answers[]" value="{{$right_answer}}">
                @endforeach
                <input type="hidden" name="text" value="{{$text}}">
                <input type="hidden" name="blank_text" value="{{$blank_text}}">
                <input type="hidden" name="start" value="{{$start}}">
                @if(isset($sample_text))
                    <input type="hidden" name="sample_text" value="{{$sample_text}}">
                @endif
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">解答</button>
                </div>
            </form>        
        </div>
    </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
    window.addEventListener('load',function(){
        setTimeout('display()',300);
    });
    function display(){
        document.getElementById('question').style.display = 'block';
    }
</script>
@endsection
