@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('question_select',$unit))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="list-group">
                @foreach($items as $item)
                    @if(Auth::check())
                        <a href="{{route('question',[$item->unit_id, $item->q_id])}}" class="list-group-item list-group-item-action {{$success[$item->q_id]==1?'list-group-item-success':''}}">{{$item->caption}}</a>
                    @else
                        <a href="{{route('question',[$item->unit_id, $item->q_id])}}" class="list-group-item list-group-item-action">{{$item->caption}}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection