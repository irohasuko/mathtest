@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('random_list'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    正答率の低い問題一覧
                </div>
                <div class="list-group">
                    @foreach($questions as $question)
                        <a href="{{route('question',[$question[0], $question[1]])}}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{$question[3]<10?'list-group-item-danger':'list-group-item-warning'}}">
                            {{$question[2]}}
                            <span class="badge badge-secondary rounded-pill">正答率：{{$question[3]}}%</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
