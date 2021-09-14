@extends('layouts.question')
@section('question')
<p>{{$text}} = \frac{\fboxア}{\fboxイ}x^{2} + \frac{\fboxウ}{\fboxエ}xy + \frac{\fboxオ}{\fboxカ}y^2 $$

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
    <div class="form-group">
        <input type="number" required name="answers[]" class="form-control" placeholder="オ">
    </div>
    <div class="form-group">
        <input type="number" required name="answers[]" class="form-control" placeholder="カ">
    </div>
@endsection