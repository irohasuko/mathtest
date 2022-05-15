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
                <h4 class="card-header"><a href="{{route('group_manage')}}">クラス管理</a></h4>
                <div class="card-body">
                    <p class="card-text">各クラスの進捗状況の確認、宿題の提供が行えます</p>
                </div>
            </div>
        </div>

        <div class="col-md-10 col-lg-12">
            <div class="card">
                <div class="card-header">{{'現在出題している宿題'}}</div>
                <div class="card-body">
                    @if(isset($homeworks))
                        <table class="table table-hover">
                            <tr>
                                <th scope="col">クラス</th>
                                <th scope="col">宿題名</th>
                                <th scope="col">期限</th>
                            </tr>
                            @foreach($homeworks as $homework)
                            <tr>
                                <td scope="col">{{$homework->group->name}}</td>
                                <td scope="col">{{$homework->name}}</td>
                                <td scope="col">{{$homework->end}}</td>
                            </tr>
                            @endforeach
                        </table>   
                    @else
                        現在出題中の宿題はありません
                    @endif
                </div> 
                
            </div>

        </div>
    </div>
</div>

@endsection
