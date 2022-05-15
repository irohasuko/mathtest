@extends('layouts.app', ['authgroup'=>'admin'])

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{$user->name}}の成績
            <div class="card">
                <div class="card-header">
                    宿題の提出状況
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">宿題名</th>
                                <th scope="col">期限</th>
                                <th scope="col">提出状況</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($homeworks as $homework)
                            <tr>
                                <td>{{$homework->name}}</td>
                                <td>{{$homework->end}}</td>
                                <td>{{$submit[$homework->id]}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-group">
                <div class="card">
                    <div class="card-header">
                        演習の進捗状況
                    </div>
                    <div class="card-body">
                        <p>数学Ⅰ</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$progress[0]*100}}%;" aria-valuenow="{{$progress[0]*100}}" aria-valuemin="0" aria-valuemax="100">{{round($progress[0]*100)}}%</div>
                        </div><br>
                        <p>数学Ⅱ</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$progress[1]*100}}%;" aria-valuenow="{{$progress[1]*100}}" aria-valuemin="0" aria-valuemax="100">{{round($progress[1]*100)}}%</div>
                        </div><br>
                        <p>数学Ⅲ</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$progress[2]*100}}%;" aria-valuenow="{{$progress[2]*100}}" aria-valuemin="0" aria-valuemax="100">{{round($progress[2]*100)}}%</div>
                        </div><br>
                        <p>数学A</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$progress[3]*100}}%;" aria-valuenow="{{$progress[3]*100}}" aria-valuemin="0" aria-valuemax="100">{{round($progress[3]*100)}}%</div>
                        </div><br>
                        <p>数学B</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$progress[4]*100}}%;" aria-valuenow="{{$progress[4]*100}}" aria-valuemin="0" aria-valuemax="100">{{round($progress[4]*100)}}%</div>
                        </div><br>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        苦手な問題
                    </div>
                    <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">単元名</th>
                                <th scope="col">問題名</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($questions as $question)
                            <tr>
                                <td>{{$question[0]}}</td>
                                <td>{{$question[1]}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
