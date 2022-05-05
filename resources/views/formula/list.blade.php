@extends('layouts.app')

@section('breadcrumbs', Breadcrumbs::render('formula_list'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="card">
                  <div class="card-header" role="tab" id="headingOne">
                    <h5 class="mb-0">
                      <a class="collapsed text-body d-block p-3 m-n3" data-toggle="collapse" href="#collapseOne" role="button" aria-expanded="false" aria-controls="collapseOne">
                        数学Ⅰ
                      </a>
                    </h5>
                  </div><!-- /.card-header -->
                  <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($math1s as $math1)
                                <a href="{{route('formula_select', $math1->id)}}" class="list-group-item list-group-item-action">{{$math1->name}}</a>
                            @endforeach
                        </div>
                    </div><!-- /.card-body -->
                  </div><!-- /.collapse -->
                </div><!-- /.card -->
                <div class="card">
                  <div class="card-header" role="tab" id="headingTwo">
                    <h5 class="mb-0">
                      <a class="collapsed text-body d-block p-3 m-n3" data-toggle="collapse" href="#collapseTwo" role="button" aria-expanded="false" aria-controls="collapseTwo">
                        数学Ⅱ
                      </a>
                    </h5>
                  </div><!-- /.card-header -->
                  <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                      <div class="list-group">
                        @foreach($math2s as $math2)
                            <a href="{{route('formula_select', $math2->id)}}" class="list-group-item list-group-item-action">{{$math2->name}}</a>
                        @endforeach
                    </div>
                    </div><!-- /.card-body -->
                  </div><!-- /.collapse -->
                </div><!-- /.card -->
                <div class="card">
                  <div class="card-header" role="tab" id="headingThree">
                    <h5 class="mb-0">
                      <a class="collapsed text-body d-block p-3 m-n3" data-toggle="collapse" href="#collapseThree" role="button" aria-expanded="false" aria-controls="collapseThree">
                        数学Ⅲ
                      </a>
                    </h5>
                  </div><!-- /.card-header -->
                  <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                      <div class="list-group">
                        @foreach($math3s as $math3)
                            <a href="{{route('formula_select', $math3->id)}}" class="list-group-item list-group-item-action">{{$math3->name}}</a>
                        @endforeach
                    </div>
                    </div><!-- /.card-body -->
                  </div><!-- /.collapse -->
                </div><!-- /.card -->
                <div class="card">
                    <div class="card-header" role="tab" id="headingFour">
                      <h5 class="mb-0">
                        <a class="collapsed text-body d-block p-3 m-n3" data-toggle="collapse" href="#collapseFour" role="button" aria-expanded="false" aria-controls="collapseThree">
                          数学A
                        </a>
                      </h5>
                    </div><!-- /.card-header -->
                    <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                      <div class="card-body">
                        <div class="list-group">
                          @foreach($mathAs as $mathA)
                              <a href="{{route('formula_select', $mathA->id)}}" class="list-group-item list-group-item-action">{{$mathA->name}}</a>
                          @endforeach
                      </div>
                      </div><!-- /.card-body -->
                    </div><!-- /.collapse -->
                  </div><!-- /.card -->
                  <div class="card">
                    <div class="card-header" role="tab" id="headingFive">
                      <h5 class="mb-0">
                        <a class="collapsed text-body d-block p-3 m-n3" data-toggle="collapse" href="#collapseFive" role="button" aria-expanded="false" aria-controls="collapseThree">
                          数学B
                        </a>
                      </h5>
                    </div><!-- /.card-header -->
                    <div id="collapseFive" class="collapse" role="tabpanel" aria-labelledby="headingFive" data-parent="#accordion">
                      <div class="card-body">
                        <div class="list-group">
                          @foreach($mathBs as $mathB)
                              <a href="{{route('formula_select', $mathB->id)}}" class="list-group-item list-group-item-action">{{$mathB->name}}</a>
                          @endforeach
                      </div>
                      </div><!-- /.card-body -->
                    </div><!-- /.collapse -->
                  </div><!-- /.card -->
              </div><!-- /#accordion -->
        </div>
    </div>
</div>
@endsection
