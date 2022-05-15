@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('flashmessage'))
            <div class="alert alert-danger text-center">
                {{ session('flashmessage') }}
            </div> 
            @endif
            <div class="card">
                <div class="card-header">
                    パスワードの更新
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('password_update_post')}}">
                        @csrf
                        <input type="password" class="form-control" name="current_password" placeholder="現在のパスワード" required>
                        <input type="password" class="form-control" name="new_password" placeholder="新しいパスワード" required>
                        <input type="password" class="form-control" name="check_password" placeholder="確認のためもう一度入力してください" required><br>
                        <button type="submit" class="btn btn-primary">更新</button>
                    </form>                   
                </div>
            </div>
        </div>
    </div>
</div>

@endsection