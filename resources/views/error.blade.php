@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    エラー
                </div>
                <div class="card-body">
                    解答画面の再読み込み、問題ページの期限切れ、ボタンの二重送信などの原因により、エラーが発生しました。
                    再びホームに戻り、やり直してください。
                </div>
            </div>
        </div>
    </div>
</div>
@endsection