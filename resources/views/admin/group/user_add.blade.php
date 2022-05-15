@extends('layouts.app', ['authgroup'=>'admin'])

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    生徒の追加
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('add_member_post',$group_id)}}" id="form">
                        @csrf
                        <div id="div1">1人目</div>
                        <input id="name1" type="text" class="form-control" name="name[]" placeholder="名前" required>
                        <input id="email1" type="email" class="form-control" name="email[]" placeholder="メールアドレス" required><br>
                    </form>
                    <input type="button" class="btn btn-danger" value="生徒をさらに追加" onclick="addForm()"><br>
                    <button type="submit" class="btn btn-primary" form="form">生徒の追加</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    var i = 2 ;
    function addForm() {
        var parent = document.getElementById('form');
        //div
        var newdiv = document.createElement('div');
        newdiv.id = 'div' + i;
        newdiv.innerHTML = i + '人目';
        parent.appendChild(newdiv);
        //name
        var input_name = document.createElement('input');
        input_name.type = 'text';
        input_name.classList.add('form-control');
        input_name.name = 'name[]';
        input_name.id = 'name' + i;
        input_name.placeholder = '名前';
        parent.appendChild(input_name);
        //email
        var input_mail = document.createElement('input');
        input_mail.type = 'email';
        input_mail.classList.add('form-control');
        input_mail.name = 'email[]';
        input_mail.id = 'mail' + i;
        input_mail.placeholder = 'メールアドレス';
        parent.appendChild(input_mail);
        var br = document.createElement('br');
        parent.appendChild(br);
        parent.appendChild(br);
        i++ ;
    }
</script>
@endsection