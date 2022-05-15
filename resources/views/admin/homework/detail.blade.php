@extends('layouts.app', ['authgroup'=>'admin'])

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-group">
                <div class="card col-md-6">
                    <div class="card-header">
                        宿題の詳細
                    </div>
                    <div class="card-body">
                        <div style="overflow-y: auto; max-height:600px">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">単元名</th>
                                        <th scope="col">問題名</th>
                                        <th scope="col">回数</th>
                                    </tr>
                                </thead>
                                <tbody style="overflow-y:auto; width:100%;">
                                    @foreach($homework->homework_details as $detail)
                                        <tr class="rowlink">
                                            <td>{{$detail->question->unit->name}}</td>
                                            <td>{{$detail->question->caption}}</td>
                                            <td>{{$detail->times}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <ul class="list-group list-group-horizontal">
                            <div class="list-group-item col-md-3">開始日</div>
                            <div class="list-group-item col-md-9">{{$homework->start}}</div>
                        </ul>
                        <ul class="list-group list-group-horizontal">
                            <div class="list-group-item col-md-3">期限</div>
                            <div class="list-group-item col-md-9">{{$homework->end}}</div>
                        </ul>
                    </div>
                </div>
                <div class="card col-md-6">
                    <div class="card-header">
                        生徒の提出状況
                    </div>
                    <div class="card-body">
                        <div style="overflow-y: auto; max-height:600px">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">名前</th>
                                        <th scope="col">提出状況</th>
                                    </tr>
                                </thead>
                                <tbody style="overflow-y:auto;">
                                    @foreach($users as $user)
                                        <div>
                                            <tr class="rowlink">
                                                <td>{{$user->id}}</td>
                                                <td>{{$user->name}}</td>
                                                <td>{{$submit[$user->id]}}</td>
                                            </tr>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>                
        </div>
    </div>
</div>

@endsection