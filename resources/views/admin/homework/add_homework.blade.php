@extends('layouts.app', ['authgroup'=>'admin'])

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('content')

<div class="container">
    <div class="row justify-content-center" style="height:800px;">
        <div class="col-md-6 h-100">
            <div class="card h-100">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="active"><a class="nav-link" data-toggle="tab" href="#math1">数学Ⅰ</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#math2">数学Ⅱ</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#math3">数学Ⅲ</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#mathA">数学A</a></li>
                        <li><a class="nav-link" data-toggle="tab" href="#mathB">数学B</a></li>
                    </ul>
                </div>
                <div class="card body h-100">
                    <div class="tab-content">
                        <div id="math1" class="tab-pane">
                            <div class="accordion1" id="accordion1" role="tablist" aria-multiselectable="true">
                                <div class="card">
                                    @foreach($math1s as $unit)
                                        <div class="card-header" role="tab" id="heading{{$unit->id}}">
                                            <h5 class="mb-0">
                                                <a class="collapsed text-body d-block p-3 m-n3" data-toggle="collapse" href="#collapse{{$unit->id}}" role="button" aria-expanded="false" aria-controls="collapse{{$unit->id}}">
                                                    {{$unit->name}}
                                                </a>
                                            </h5>
                                        </div><!-- /.card-header -->
                                        <div id="collapse{{$unit->id}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$unit->id}}" data-parent="#accordion1">
                                            <div class="card-body">
                                                @foreach($unit->questions as $question)
                                                    <ul class="list-group list-group-horizontal">
                                                        <a class="list-group-item list-group-item-action col-md-9" href="javascript:AddworkClick({{$question->q_id}});">{{$question->caption}}</a>
                                                        <a class="list-group-item list-group-item-action col-md-3" href="javascript:OnLinkClick({{$question->q_id}});">プレビュー</a>
                                                    </ul>
                                                @endforeach
                                            </div><!-- /.card-body -->
                                        </div><!-- /.collapse -->
                                    @endforeach
                                </div><!-- /.card -->
                            </div><!-- /#accordion -->
                        </div>
                        <div id="math2" class="tab-pane">
                            <div class="accordion2" id="accordion2" role="tablist" aria-multiselectable="true">
                                <div class="card">
                                    @foreach($math2s as $unit)
                                        <div class="card-header" role="tab" id="heading{{$unit->id}}">
                                            <h5 class="mb-0">
                                                <a class="collapsed text-body d-block p-3 m-n3" data-toggle="collapse" href="#collapse{{$unit->id}}" role="button" aria-expanded="false" aria-controls="collapse{{$unit->id}}">
                                                    {{$unit->name}}
                                                </a>
                                            </h5>
                                        </div><!-- /.card-header -->
                                        <div id="collapse{{$unit->id}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$unit->id}}" data-parent="#accordion2">
                                            <div class="card-body">
                                                <div class="list-group">
                                                    @foreach($unit->questions as $question)
                                                    <ul class="list-group list-group-horizontal">
                                                        <a class="list-group-item list-group-item-action col-md-9" href="javascript:AddworkClick({{$question->q_id}});">{{$question->caption}}</a>
                                                        <a class="list-group-item list-group-item-action col-md-3" href="javascript:OnLinkClick({{$question->q_id}});">プレビュー</a>
                                                    </ul>
                                                    @endforeach
                                                </div>
                                            </div><!-- /.card-body -->
                                        </div><!-- /.collapse -->
                                    @endforeach
                                </div><!-- /.card -->
                            </div><!-- /#accordion -->
                        </div>
                        <div id="math3" class="tab-pane">
                            <div class="accordion3" id="accordion3" role="tablist" aria-multiselectable="true">
                                <div class="card">
                                    @foreach($math3s as $unit)
                                        <div class="card-header" role="tab" id="heading{{$unit->id}}">
                                            <h5 class="mb-0">
                                                <a class="collapsed text-body d-block p-3 m-n3" data-toggle="collapse" href="#collapse{{$unit->id}}" role="button" aria-expanded="false" aria-controls="collapse{{$unit->id}}">
                                                    {{$unit->name}}
                                                </a>
                                            </h5>
                                        </div><!-- /.card-header -->
                                        <div id="collapse{{$unit->id}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$unit->id}}" data-parent="#accordion3">
                                            <div class="card-body">
                                                <div class="list-group">
                                                    @foreach($unit->questions as $question)
                                                    <ul class="list-group list-group-horizontal">
                                                        <a class="list-group-item list-group-item-action col-md-9" href="javascript:AddworkClick({{$question->q_id}});">{{$question->caption}}</a>
                                                        <a class="list-group-item list-group-item-action col-md-3" href="javascript:OnLinkClick({{$question->q_id}});">プレビュー</a>
                                                    </ul>
                                                    @endforeach
                                                </div>
                                            </div><!-- /.card-body -->
                                        </div><!-- /.collapse -->
                                    @endforeach
                                </div><!-- /.card -->
                            </div><!-- /#accordion -->
                        </div>
                        <div id="mathA" class="tab-pane">
                            <div class="accordionA" id="accordionA" role="tablist" aria-multiselectable="true">
                                <div class="card">
                                    @foreach($mathAs as $unit)
                                        <div class="card-header" role="tab" id="heading{{$unit->id}}">
                                            <h5 class="mb-0">
                                                <a class="collapsed text-body d-block p-3 m-n3" data-toggle="collapse" href="#collapse{{$unit->id}}" role="button" aria-expanded="false" aria-controls="collapse{{$unit->id}}">
                                                    {{$unit->name}}
                                                </a>
                                            </h5>
                                        </div><!-- /.card-header -->
                                        <div id="collapse{{$unit->id}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$unit->id}}" data-parent="#accordionA">
                                            <div class="card-body">
                                                <div class="list-group">
                                                    @foreach($unit->questions as $question)
                                                    <ul class="list-group list-group-horizontal">
                                                        <a class="list-group-item list-group-item-action col-md-9" href="javascript:AddworkClick({{$question->q_id}});">{{$question->caption}}</a>
                                                        <a class="list-group-item list-group-item-action col-md-3" href="javascript:OnLinkClick({{$question->q_id}});">プレビュー</a>
                                                    </ul>
                                                    @endforeach
                                                </div>
                                            </div><!-- /.card-body -->
                                        </div><!-- /.collapse -->
                                    @endforeach
                                </div><!-- /.card -->
                            </div><!-- /#accordion -->
                        </div>
                        <div id="mathB" class="tab-pane">
                            <div class="accordionB" id="accordionB" role="tablist" aria-multiselectable="true">
                                <div class="card">
                                    @foreach($mathBs as $unit)
                                        <div class="card-header" role="tab" id="heading{{$unit->id}}">
                                            <h5 class="mb-0">
                                                <a class="collapsed text-body d-block p-3 m-n3" data-toggle="collapse" href="#collapse{{$unit->id}}" role="button" aria-expanded="false" aria-controls="collapse{{$unit->id}}">
                                                    {{$unit->name}}
                                                </a>
                                            </h5>
                                        </div><!-- /.card-header -->
                                        <div id="collapse{{$unit->id}}" class="collapse" role="tabpanel" aria-labelledby="heading{{$unit->id}}" data-parent="#accordionB">
                                            <div class="card-body">
                                                <div class="list-group">
                                                    @foreach($unit->questions as $question)
                                                    <ul class="list-group list-group-horizontal">
                                                        <a class="list-group-item list-group-item-action col-md-9" href="javascript:AddworkClick({{$question->q_id}});">{{$question->caption}}</a>
                                                        <a class="list-group-item list-group-item-action col-md-3" href="javascript:OnLinkClick({{$question->q_id}});">プレビュー</a>
                                                    </ul>
                                                    @endforeach
                                                </div>
                                            </div><!-- /.card-body -->
                                        </div><!-- /.collapse -->
                                    @endforeach
                                </div><!-- /.card -->
                            </div><!-- /#accordion -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 h-100">
            <div class="card h-50">
                <div id="preview" class="card-body">
                    @foreach($math1s as $unit)
                        @foreach($unit->questions as $question)
                            <div class="collapse" id="pre{{$question->q_id}}">
                                {{$question->caption}}
                            </div>
                        @endforeach
                    @endforeach
                    @foreach($math2s as $unit)
                        @foreach($unit->questions as $question)
                            <div class="collapse" id="pre{{$question->q_id}}">
                                {{$question->caption}}
                            </div>
                        @endforeach
                    @endforeach
                    @foreach($math3s as $unit)
                        @foreach($unit->questions as $question)
                            <div class="collapse" id="pre{{$question->q_id}}">
                                {{$question->caption}}
                            </div>
                        @endforeach
                    @endforeach
                    @foreach($mathAs as $unit)
                        @foreach($unit->questions as $question)
                            <div class="collapse" id="pre{{$question->q_id}}">
                                {{$question->caption}}
                            </div>
                        @endforeach
                    @endforeach
                    @foreach($mathBs as $unit)
                        @foreach($unit->questions as $question)
                            <div class="collapse" id="pre{{$question->q_id}}">
                                {{$question->caption}}
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
            <div class="card h-50">
                <div class="card-body">
                    <div style="overflow-y: auto; height:250px">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">単元名</th>
                                    <th scope="col">問題名</th>
                                    <th scope="col">回数</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody style="overflow-y:auto; width:100%;">
                                @foreach($math1s as $unit)
                                    @foreach($unit->questions as $question)
                                    <div>
                                        <tr id="t{{$question->q_id}}" class="rowlink collapse">
                                            <div>
                                                <td>{{$question->unit->name}}</td>
                                                <td>{{$question->caption}}</td>
                                                <td><div id="count{{$question->q_id}}" data-value=0>0</div></td>
                                                <td><a href="javascript:Deletework({{$question->q_id}});">×</a></td>
                                            </div>
                                        </tr>
                                    </div>
                                    @endforeach
                                @endforeach
                                @foreach($math2s as $unit)
                                    @foreach($unit->questions as $question)
                                    <div>
                                        <tr id="t{{$question->q_id}}" class="rowlink collapse">
                                            <div>
                                                <td>{{$question->unit->name}}</td>
                                                <td>{{$question->caption}}</td>
                                                <td><div id="count{{$question->q_id}}" data-value=0>0</div></td>
                                                <td><a href="javascript:Deletework({{$question->q_id}});">×</a></td>
                                            </div>
                                        </tr>
                                    </div>
                                    @endforeach
                                @endforeach
                                @foreach($math3s as $unit)
                                    @foreach($unit->questions as $question)
                                    <div>
                                        <tr id="t{{$question->q_id}}" class="rowlink collapse">
                                            <div>
                                                <td>{{$question->unit->name}}</td>
                                                <td>{{$question->caption}}</td>
                                                <td><div id="count{{$question->q_id}}" data-value=0>0</div></td>
                                                <td><a href="javascript:Deletework({{$question->q_id}});">×</a></td>
                                            </div>
                                        </tr>
                                    </div>
                                    @endforeach
                                @endforeach
                                @foreach($mathAs as $unit)
                                    @foreach($unit->questions as $question)
                                    <div>
                                        <tr id="t{{$question->q_id}}" class="rowlink collapse">
                                            <div>
                                                <td>{{$question->unit->name}}</td>
                                                <td>{{$question->caption}}</td>
                                                <td><div id="count{{$question->q_id}}" data-value=0>0</div></td>
                                                <td><a href="javascript:Deletework({{$question->q_id}});">×</a></td>
                                            </div>
                                        </tr>
                                    </div>
                                    @endforeach
                                @endforeach
                                @foreach($mathBs as $unit)
                                    @foreach($unit->questions as $question)
                                    <div>
                                        <tr id="t{{$question->q_id}}" class="rowlink collapse">
                                            <div>
                                                <td>{{$question->unit->name}}</td>
                                                <td>{{$question->caption}}</td>
                                                <td><div id="count{{$question->q_id}}" data-value=0>0</div></td>
                                                <td><a href="javascript:Deletework({{$question->q_id}});">×</a></td>
                                            </div>
                                        </tr>
                                    </div>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <form id="submit_form" method="post" action="{{route('add_work',$group_id)}}" class="row">
                            @csrf
                            <div class="col-md-6">
                                開始日
                                <input type="date" class="form-control" name="start" placeholder="開始日" required>
                            </div>
                            <div class="col-md-6">
                                終了日
                                <input type="date" class="form-control" name="end" placeholder="終了日" required>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="text" class="form-control" name="caption" placeholder="宿題名" required>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">宿題を出題</button>
                            </div>
                            <input type="hidden" name="group_id" value="{{$group_id}}">
                        </form>
                    <div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>
    function OnLinkClick(id) {
        const p1 = document.getElementById("pre"+id);
        const pre = document.getElementById("preview");

        if(p1.style.display=="block"){
            // noneで非表示
            pre.style.display = "none"
            p1.style.display ="none";
        }else{
            // blockで表示
            pre.style.display = "block"
            p1.style.display ="block";
        }
    }

    

    function AddworkClick(id) {
        const q = document.getElementById('t'+id);
        const count = document.getElementById('count'+id);

        if(q.style.display=="table-row"){   //表示されていた場合の処理
            //q.style.display ="none";
            count.dataset.value = Number(count.dataset.value) + 1;
            count.innerHTML = count.dataset.value;

            var input = document.getElementById('times'+id);
            input.value = Number(count.dataset.value);

        }else{  //表示されていなかった場合の処理
            q.style.display ="table-row";
            count.dataset.value = Number(count.dataset.value) + 1;
            count.innerHTML = count.dataset.value;

            const form = document.getElementById('submit_form');

            var q_id = document.createElement('input');
            q_id.id = 'q' + id;
            q_id.name = 'question_id[]';
            q_id.type = 'hidden';
            q_id.value = id;
            form.appendChild(q_id);

            var t = document.createElement('input');
            t.id = 'times' + id;
            t.name = 'times[]';
            t.type = 'hidden';
            t.value = 1;
            form.appendChild(t);
            
        }
    }

    function Deletework(id) {
        const p1 = document.getElementById("t"+id);
        const count = document.getElementById('count'+id);
        count.dataset.value = 0;
        p1.style.display ="none";

        const q_id = document.getElementById("q"+id);
        q_id.remove();
        const times = document.getElementById("times"+id);
        times.remove();
    }

</script>

@endsection