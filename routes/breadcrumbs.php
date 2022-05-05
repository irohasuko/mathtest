<?php

use App\Models\Question;
use App\Models\Record;
use App\Models\Unit;

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('ホーム画面', route('home'));
});

//単元選択画面
Breadcrumbs::for('unit_select', function ($trail) {
    $trail->parent('home');
    $trail->push('単元選択', route('unit_select'));
});

//問題選択画面
Breadcrumbs::for('question_select', function ($trail,$unit) {
    $trail->parent('unit_select');
    $trail->push($unit->name, route('question_select',['id' => $unit->id]));
});

//問題画面
Breadcrumbs::for('question', function ($trail,$unit,$question) {
    $trail->parent('question_select',$unit);
    $trail->push($question->caption, route('question',['unit_id' => $question->unit_id, 'q_id' => $question->q_id,]));
});


//弱点演習画面
Breadcrumbs::for('random_list', function ($trail) {
    $trail->parent('home');
    $trail->push('弱点演習', route('random_list'));
});

//公式選択画面
Breadcrumbs::for('formula_list', function ($trail) {
    $trail->parent('home');
    $trail->push('公式一覧', route('formula_list'));
});

//問題画面
Breadcrumbs::for('formula_select', function ($trail,$unit_id) {
    $trail->parent('formula_list');
    $trail->push(Unit::find($unit_id)->name, route('formula_select',['unit_id' => $unit_id]));
});

