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
            <div class="card">
                <div class="card-header">
                    このクラスに出題した宿題
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">宿題名</th>
                                <th scope="col">開始日</th>
                                <th scope="col">期限</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($homeworks as $homework)
                            <tr class="rowlink position-relative">
                                <td><a class="stretched-link" href="{{route('homework_detail',$homework->id)}}"></a></td>
                                <td>{{$homework->name}}</td>
                                <td>{{$homework->start}}</td>
                                <td>{{$homework->end}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer position-relative bg-warning">
                    <a class="stretched-link" href="{{route('add_homework',$group->id)}}">宿題の追加</a>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">ユーザID</th>
                                <th scope="col">メールアドレス</th>
                                <th scope="col">名前</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="rowlink position-relative">
                                <td><a class="stretched-link" href="{{route('user_manage',$user->id)}}"></a></td>
                                <td>{{$user->id}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer position-relative bg-warning">
                    <a class="stretched-link" href="{{route('add_member',$group->id)}}">メンバーの追加</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection