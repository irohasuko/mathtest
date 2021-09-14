@extends('layouts.question')
@section('question')
<p>{{$text}} = \fboxアx^{3} + \fboxイx^{2}y + \fboxウxy^{2} + \fboxエy^{3} $$
@endsection

@section('submit')
    <div class="form-group">
        <input type="number" required name="answers[]" class="form-control" placeholder="ア">
    </div>
    <div class="form-group">
        <input type="number" required name="answers[]" class="form-control" placeholder="イ">
    </div>
    <div class="form-group">
        <input type="number" required name="answers[]" class="form-control" placeholder="ウ">
    </div>
    <div class="form-group">
        <input type="number" required name="answers[]" class="form-control" placeholder="エ">
    </div>
@endsection