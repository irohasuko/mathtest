@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">演習選択</h4>
                    <p class="card-text">各単元の問題を自分で選択して演習できます</p>
                    <div class="text-right">
                        <a href="{{route('unit_select')}}" class="btn btn-primary">学習する</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-10 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">弱点演習</h4>
                    <p class="card-text">正答率の低い問題を抽出して演習できます</p>
                    <div class="text-right">
                        <a href="random_list" class="btn btn-primary">学習する</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-10 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">公式一覧</h4>
                    <p class="card-text">わからない問題は、公式を確認しましょう</p>
                    <div class="text-right">
                        <a href="#" class="btn btn-primary">学習する</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">{{'演習の進捗状況'}}</div>
                <div class="card-body">
                   {{-- <table class="table table-hover">
                        <tr>
                            <th scope="col">数学Ⅰ</th>
                            <th scope="col">数学Ⅱ</th>
                            <th scope="col">数学Ⅲ</th>
                            <th scope="col">数学A</th>
                            <th scope="col">数学B</th>
                        </tr>
                        <tr>
                            @for($i = 0; $i < 5; $i++)
                            <td>{{$record_count[$i]}}/{{$question_count[$i]}}</td>
                            @endfor
                        </tr>
                    </table>
                    --}}
                    <p>数学Ⅰ</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{($record_count[0]/$question_count[0])*100}}%;" aria-valuenow="{{$record_count[0]}}" aria-valuemin="0" aria-valuemax="{{$question_count[0]}}">{{round($record_count[0]/$question_count[0]*100)}}%</div>
                    </div><br>
                    <p>数学Ⅱ</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{($record_count[1]/$question_count[1])*100}}%;" aria-valuenow="{{$record_count[1]}}" aria-valuemin="0" aria-valuemax="{{$question_count[1]}}">{{round($record_count[1]/$question_count[1]*100)}}%</div>
                    </div><br>
                    <p>数学Ⅲ</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{($record_count[2]/$question_count[2])*100}}%;" aria-valuenow="{{$record_count[2]}}" aria-valuemin="0" aria-valuemax="{{$question_count[2]}}">{{round($record_count[2]/$question_count[2]*100)}}%</div>
                    </div><br>
                    <p>数学A</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{($record_count[3]/$question_count[3])*100}}%;" aria-valuenow="{{$record_count[3]}}" aria-valuemin="0" aria-valuemax="{{$question_count[3]}}">{{round($record_count[3]/$question_count[3]*100)}}%</div>
                    </div><br>
                    <p>数学B</p>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{($record_count[4]/$question_count[4])*100}}%;" aria-valuenow="{{$record_count[4]}}" aria-valuemin="0" aria-valuemax="{{$question_count[4]}}">{{round($record_count[4]/$question_count[4]*100)}}%</div>
                    </div><br>
                    

                </div> 
                
            </div>

        </div>
    </div>
</div>
@endsection
