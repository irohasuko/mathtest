<?php

use App\Models\Question;
use App\Models\Record;
use App\Models\Unit;

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('ホーム画面', route('home'));
});

Breadcrumbs::for('unit_select', function ($trail) {
    $trail->parent('home');
    $trail->push('単元選択', route('unit_select'));
});

Breadcrumbs::for('question_select', function ($trail,$unit) {
    $trail->parent('unit_select');
    $trail->push($unit->name, route('question_select',['id' => $unit->id]));
});

Breadcrumbs::for('question', function ($trail,$unit,$question) {
    $trail->parent('question_select',$unit);
    $trail->push($question->caption, route('question',['unit_id' => $question->unit_id, 'q_id' => $question->q_id,]));
});