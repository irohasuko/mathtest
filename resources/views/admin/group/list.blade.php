@extends('layouts.app', ['authgroup'=>'admin'])

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('flashmessage'))
            <div class="alert alert-success text-center">
                {{ session('flashmessage') }}
            </div> 
            @endif
            <div class="list-group">
                @foreach($groups as $group)
                    <a href="{{route('user_list',$group->id)}}" class="list-group-item list-group-item-action">{{$group->name}}</a>
                @endforeach
            </div>
            <a href="{{route('add_group')}}" class="list-group-item list-group-item-action bg-warning">クラスの追加</a>
        </div>
    </div>
</div>

@endsection
