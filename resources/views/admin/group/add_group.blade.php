@extends('layouts.app', ['authgroup'=>'admin'])

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('flashmessage'))
            <div class="alert alert-danger text-center">
                {{ session('flashmessage') }}
            </div> 
            @endif
            
            <div class="card">
                <div class="card-header">
                    クラスの追加　生徒もcsvファイルで同時に追加できます
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('add_class')}}" enctype="multipart/form-data">
                        @csrf
                        <input type="text" class="form-control" name="name" placeholder="クラス名" required><br>
                        生徒の追加：
                        <input type="file" class="form-control-lg" name="member"><br>
                        <input type="checkbox" class="toggle"> 
                            生徒IDから自動でメールアドレスを生成する場合は、チェックしてください
                            <div class="address">
                                <input type="text" class="form-control" name="email" placeholder="ここにアドレスの@以下を入力してください　例：@gmail.com">
                            </div>
                        <br><br>
                        <button type="submit" class="btn btn-primary">クラスを追加</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection