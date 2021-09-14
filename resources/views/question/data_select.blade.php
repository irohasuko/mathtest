@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">x</th>
                                @foreach($x as $xs)
                                    <td>{{$xs}}</td>
                                @endforeach
                            </tr>
                            <tr>
                                <th scope="row">y</th>
                                @foreach($y as $ys)
                                    <td>{{$ys}}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                    <p>{{$text}}
                @for($i=0 ; $i<$blanks ; $i++)
                    {{$options[$i]}}
                    {{'\\\\'}}
                @endfor
                {{'$$'}}</p>
                </div>
            </div>
            <br>

            <form method="post" action="{{route('A'.$question_id,$unit_id)}}">
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