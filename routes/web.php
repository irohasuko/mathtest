<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//ユニットの選択ページ
Route::get('/unit_select', [App\Http\Controllers\SortController::class, 'unit_select'])->name('unit_select');

//問題の選択ページ
Route::get('/q_select/{id}', [App\Http\Controllers\SortController::class, 'q_select'])->name('question_select');

//問題画面
//数学Ⅰ
Route::get('/q_select/{unit_id}/10101',[App\Http\Controllers\QuestionController::class, 'unit101_q01'])->name('Q10101');
Route::get('/q_select/{unit_id}/10102',[App\Http\Controllers\QuestionController::class, 'unit101_q02'])->name('Q10102');
Route::get('/q_select/{unit_id}/10103',[App\Http\Controllers\QuestionController::class, 'unit101_q03'])->name('Q10103');
Route::get('/q_select/{unit_id}/10104',[App\Http\Controllers\QuestionController::class, 'unit101_q04'])->name('Q10104');
Route::get('/q_select/{unit_id}/10105',[App\Http\Controllers\QuestionController::class, 'unit101_q05'])->name('Q10105');
Route::get('/q_select/{unit_id}/10106',[App\Http\Controllers\QuestionController::class, 'unit101_q06'])->name('Q10106');
Route::get('/q_select/{unit_id}/10107',[App\Http\Controllers\QuestionController::class, 'unit101_q07'])->name('Q10107');
Route::get('/q_select/{unit_id}/10108',[App\Http\Controllers\QuestionController::class, 'unit101_q08'])->name('Q10108');
Route::get('/q_select/{unit_id}/10109',[App\Http\Controllers\QuestionController::class, 'unit101_q09'])->name('Q10109');
Route::get('/q_select/{unit_id}/10110',[App\Http\Controllers\QuestionController::class, 'unit101_q10'])->name('Q10110');
Route::get('/q_select/{unit_id}/10111',[App\Http\Controllers\QuestionController::class, 'unit101_q11'])->name('Q10111');
Route::get('/q_select/{unit_id}/10112',[App\Http\Controllers\QuestionController::class, 'unit101_q12'])->name('Q10112');

Route::get('/q_select/{unit_id}/10201',[App\Http\Controllers\QuestionController::class, 'unit102_q01'])->name('Q10201');
Route::get('/q_select/{unit_id}/10202',[App\Http\Controllers\QuestionController::class, 'unit102_q02'])->name('Q10202');
Route::get('/q_select/{unit_id}/10203',[App\Http\Controllers\QuestionController::class, 'unit102_q03'])->name('Q10203');
Route::get('/q_select/{unit_id}/10204',[App\Http\Controllers\QuestionController::class, 'unit102_q04'])->name('Q10204');
Route::get('/q_select/{unit_id}/10205',[App\Http\Controllers\QuestionController::class, 'unit102_q05'])->name('Q10205');
Route::get('/q_select/{unit_id}/10206',[App\Http\Controllers\QuestionController::class, 'unit102_q06'])->name('Q10206');
Route::get('/q_select/{unit_id}/10207',[App\Http\Controllers\QuestionController::class, 'unit102_q07'])->name('Q10207');
Route::get('/q_select/{unit_id}/10208',[App\Http\Controllers\QuestionController::class, 'unit102_q08'])->name('Q10208');
Route::get('/q_select/{unit_id}/10209',[App\Http\Controllers\QuestionController::class, 'unit102_q09'])->name('Q10209');
Route::get('/q_select/{unit_id}/10210',[App\Http\Controllers\QuestionController::class, 'unit102_q10'])->name('Q10210');
Route::get('/q_select/{unit_id}/10211',[App\Http\Controllers\QuestionController::class, 'unit102_q11'])->name('Q10211');

Route::get('/q_select/{unit_id}/10301',[App\Http\Controllers\QuestionController::class, 'unit103_q01'])->name('Q10301');
Route::get('/q_select/{unit_id}/10302',[App\Http\Controllers\QuestionController::class, 'unit103_q02'])->name('Q10302');
Route::get('/q_select/{unit_id}/10303',[App\Http\Controllers\QuestionController::class, 'unit103_q03'])->name('Q10303');
Route::get('/q_select/{unit_id}/10304',[App\Http\Controllers\QuestionController::class, 'unit103_q04'])->name('Q10304');
Route::get('/q_select/{unit_id}/10305',[App\Http\Controllers\QuestionController::class, 'unit103_q05'])->name('Q10305');
Route::get('/q_select/{unit_id}/10306',[App\Http\Controllers\QuestionController::class, 'unit103_q06'])->name('Q10306');
Route::get('/q_select/{unit_id}/10307',[App\Http\Controllers\QuestionController::class, 'unit103_q07'])->name('Q10307');
Route::get('/q_select/{unit_id}/10308',[App\Http\Controllers\QuestionController::class, 'unit103_q08'])->name('Q10308');
Route::get('/q_select/{unit_id}/10309',[App\Http\Controllers\QuestionController::class, 'unit103_q09'])->name('Q10309');

Route::get('/q_select/{unit_id}/10401',[App\Http\Controllers\QuestionController::class, 'unit104_q01'])->name('Q10401');
Route::get('/q_select/{unit_id}/10402',[App\Http\Controllers\QuestionController::class, 'unit104_q02'])->name('Q10402');
Route::get('/q_select/{unit_id}/10403',[App\Http\Controllers\QuestionController::class, 'unit104_q03'])->name('Q10403');
Route::get('/q_select/{unit_id}/10404',[App\Http\Controllers\QuestionController::class, 'unit104_q04'])->name('Q10404');

//数学Ⅱ
Route::get('/q_select/{unit_id}/20101',[App\Http\Controllers\QuestionController::class, 'unit201_q01'])->name('Q20101');
Route::get('/q_select/{unit_id}/20102',[App\Http\Controllers\QuestionController::class, 'unit201_q02'])->name('Q20102');
Route::get('/q_select/{unit_id}/20103',[App\Http\Controllers\QuestionController::class, 'unit201_q03'])->name('Q20103');
Route::get('/q_select/{unit_id}/20104',[App\Http\Controllers\QuestionController::class, 'unit201_q04'])->name('Q20104');
Route::get('/q_select/{unit_id}/20105',[App\Http\Controllers\QuestionController::class, 'unit201_q05'])->name('Q20105');

Route::get('/q_select/{unit_id}/20201',[App\Http\Controllers\QuestionController::class, 'unit202_q01'])->name('Q20201');
Route::get('/q_select/{unit_id}/20202',[App\Http\Controllers\QuestionController::class, 'unit202_q02'])->name('Q20202');
Route::get('/q_select/{unit_id}/20203',[App\Http\Controllers\QuestionController::class, 'unit202_q03'])->name('Q20203');
Route::get('/q_select/{unit_id}/20204',[App\Http\Controllers\QuestionController::class, 'unit202_q04'])->name('Q20204');
Route::get('/q_select/{unit_id}/20205',[App\Http\Controllers\QuestionController::class, 'unit202_q05'])->name('Q20205');
Route::get('/q_select/{unit_id}/20206',[App\Http\Controllers\QuestionController::class, 'unit202_q06'])->name('Q20206');
Route::get('/q_select/{unit_id}/20207',[App\Http\Controllers\QuestionController::class, 'unit202_q07'])->name('Q20207');

Route::get('/q_select/{unit_id}/20301',[App\Http\Controllers\QuestionController::class, 'unit203_q01'])->name('Q20301');
Route::get('/q_select/{unit_id}/20302',[App\Http\Controllers\QuestionController::class, 'unit203_q02'])->name('Q20302');
Route::get('/q_select/{unit_id}/20303',[App\Http\Controllers\QuestionController::class, 'unit203_q03'])->name('Q20303');
Route::get('/q_select/{unit_id}/20304',[App\Http\Controllers\QuestionController::class, 'unit203_q04'])->name('Q20304');
Route::get('/q_select/{unit_id}/20305',[App\Http\Controllers\QuestionController::class, 'unit203_q05'])->name('Q20305');
Route::get('/q_select/{unit_id}/20306',[App\Http\Controllers\QuestionController::class, 'unit203_q06'])->name('Q20306');
Route::get('/q_select/{unit_id}/20307',[App\Http\Controllers\QuestionController::class, 'unit203_q07'])->name('Q20307');
Route::get('/q_select/{unit_id}/20308',[App\Http\Controllers\QuestionController::class, 'unit203_q08'])->name('Q20308');

Route::get('/q_select/{unit_id}/20401',[App\Http\Controllers\QuestionController::class, 'unit204_q01'])->name('Q20401');
Route::get('/q_select/{unit_id}/20402',[App\Http\Controllers\QuestionController::class, 'unit204_q02'])->name('Q20402');
Route::get('/q_select/{unit_id}/20403',[App\Http\Controllers\QuestionController::class, 'unit204_q03'])->name('Q20403');
Route::get('/q_select/{unit_id}/20404',[App\Http\Controllers\QuestionController::class, 'unit204_q04'])->name('Q20404');
Route::get('/q_select/{unit_id}/20405',[App\Http\Controllers\QuestionController::class, 'unit204_q05'])->name('Q20405');
Route::get('/q_select/{unit_id}/20406',[App\Http\Controllers\QuestionController::class, 'unit204_q06'])->name('Q20406');
Route::get('/q_select/{unit_id}/20407',[App\Http\Controllers\QuestionController::class, 'unit204_q07'])->name('Q20407');
Route::get('/q_select/{unit_id}/20408',[App\Http\Controllers\QuestionController::class, 'unit204_q08'])->name('Q20408');

Route::get('/q_select/{unit_id}/20501',[App\Http\Controllers\QuestionController::class, 'unit205_q01'])->name('Q20501');
Route::get('/q_select/{unit_id}/20502',[App\Http\Controllers\QuestionController::class, 'unit205_q02'])->name('Q20502');
Route::get('/q_select/{unit_id}/20503',[App\Http\Controllers\QuestionController::class, 'unit205_q03'])->name('Q20503');
Route::get('/q_select/{unit_id}/20504',[App\Http\Controllers\QuestionController::class, 'unit205_q04'])->name('Q20504');
Route::get('/q_select/{unit_id}/20505',[App\Http\Controllers\QuestionController::class, 'unit205_q05'])->name('Q20505');
Route::get('/q_select/{unit_id}/20506',[App\Http\Controllers\QuestionController::class, 'unit205_q06'])->name('Q20506');
Route::get('/q_select/{unit_id}/20507',[App\Http\Controllers\QuestionController::class, 'unit205_q07'])->name('Q20507');
Route::get('/q_select/{unit_id}/20508',[App\Http\Controllers\QuestionController::class, 'unit205_q08'])->name('Q20508');
Route::get('/q_select/{unit_id}/20509',[App\Http\Controllers\QuestionController::class, 'unit205_q09'])->name('Q20509');
Route::get('/q_select/{unit_id}/20510',[App\Http\Controllers\QuestionController::class, 'unit205_q10'])->name('Q20510');

Route::get('/q_select/{unit_id}/20601',[App\Http\Controllers\QuestionController::class, 'unit206_q01'])->name('Q20601');
Route::get('/q_select/{unit_id}/20602',[App\Http\Controllers\QuestionController::class, 'unit206_q02'])->name('Q20602');
Route::get('/q_select/{unit_id}/20603',[App\Http\Controllers\QuestionController::class, 'unit206_q03'])->name('Q20603');
Route::get('/q_select/{unit_id}/20604',[App\Http\Controllers\QuestionController::class, 'unit206_q04'])->name('Q20604');
Route::get('/q_select/{unit_id}/20605',[App\Http\Controllers\QuestionController::class, 'unit206_q05'])->name('Q20605');
Route::get('/q_select/{unit_id}/20606',[App\Http\Controllers\QuestionController::class, 'unit206_q06'])->name('Q20606');
Route::get('/q_select/{unit_id}/20607',[App\Http\Controllers\QuestionController::class, 'unit206_q07'])->name('Q20607');

Route::get('/q_select/{unit_id}/20701',[App\Http\Controllers\QuestionController::class, 'unit207_q01'])->name('Q20701');
Route::get('/q_select/{unit_id}/20702',[App\Http\Controllers\QuestionController::class, 'unit207_q02'])->name('Q20702');
Route::get('/q_select/{unit_id}/20703',[App\Http\Controllers\QuestionController::class, 'unit207_q03'])->name('Q20703');
Route::get('/q_select/{unit_id}/20704',[App\Http\Controllers\QuestionController::class, 'unit207_q04'])->name('Q20704');
Route::get('/q_select/{unit_id}/20705',[App\Http\Controllers\QuestionController::class, 'unit207_q05'])->name('Q20705');
Route::get('/q_select/{unit_id}/20706',[App\Http\Controllers\QuestionController::class, 'unit207_q06'])->name('Q20706');
Route::get('/q_select/{unit_id}/20707',[App\Http\Controllers\QuestionController::class, 'unit207_q07'])->name('Q20707');

//数学Ⅲ
Route::get('/q_select/{unit_id}/30101',[App\Http\Controllers\QuestionController::class, 'unit301_q01'])->name('Q30101');
Route::get('/q_select/{unit_id}/30102',[App\Http\Controllers\QuestionController::class, 'unit301_q02'])->name('Q30102');
Route::get('/q_select/{unit_id}/30103',[App\Http\Controllers\QuestionController::class, 'unit301_q03'])->name('Q30103');
Route::get('/q_select/{unit_id}/30104',[App\Http\Controllers\QuestionController::class, 'unit301_q04'])->name('Q30104');
Route::get('/q_select/{unit_id}/30105',[App\Http\Controllers\QuestionController::class, 'unit301_q05'])->name('Q30105');
Route::get('/q_select/{unit_id}/30106',[App\Http\Controllers\QuestionController::class, 'unit301_q06'])->name('Q30106');
Route::get('/q_select/{unit_id}/30107',[App\Http\Controllers\QuestionController::class, 'unit301_q07'])->name('Q30107');

Route::get('/q_select/{unit_id}/30201',[App\Http\Controllers\QuestionController::class, 'unit302_q01'])->name('Q30201');
Route::get('/q_select/{unit_id}/30202',[App\Http\Controllers\QuestionController::class, 'unit302_q02'])->name('Q30202');
Route::get('/q_select/{unit_id}/30203',[App\Http\Controllers\QuestionController::class, 'unit302_q03'])->name('Q30203');
Route::get('/q_select/{unit_id}/30204',[App\Http\Controllers\QuestionController::class, 'unit302_q04'])->name('Q30204');
Route::get('/q_select/{unit_id}/30205',[App\Http\Controllers\QuestionController::class, 'unit302_q05'])->name('Q30205');
Route::get('/q_select/{unit_id}/30206',[App\Http\Controllers\QuestionController::class, 'unit302_q06'])->name('Q30206');
Route::get('/q_select/{unit_id}/30207',[App\Http\Controllers\QuestionController::class, 'unit302_q07'])->name('Q30207');
Route::get('/q_select/{unit_id}/30208',[App\Http\Controllers\QuestionController::class, 'unit302_q08'])->name('Q30208');
Route::get('/q_select/{unit_id}/30209',[App\Http\Controllers\QuestionController::class, 'unit302_q09'])->name('Q30209');

Route::get('/q_select/{unit_id}/30301',[App\Http\Controllers\QuestionController::class, 'unit303_q01'])->name('Q30301');
Route::get('/q_select/{unit_id}/30302',[App\Http\Controllers\QuestionController::class, 'unit303_q02'])->name('Q30302');
Route::get('/q_select/{unit_id}/30303',[App\Http\Controllers\QuestionController::class, 'unit303_q03'])->name('Q30303');
Route::get('/q_select/{unit_id}/30304',[App\Http\Controllers\QuestionController::class, 'unit303_q04'])->name('Q30304');
Route::get('/q_select/{unit_id}/30305',[App\Http\Controllers\QuestionController::class, 'unit303_q05'])->name('Q30305');

Route::get('/q_select/{unit_id}/30401',[App\Http\Controllers\QuestionController::class, 'unit304_q01'])->name('Q30401');
Route::get('/q_select/{unit_id}/30402',[App\Http\Controllers\QuestionController::class, 'unit304_q02'])->name('Q30402');
Route::get('/q_select/{unit_id}/30403',[App\Http\Controllers\QuestionController::class, 'unit304_q03'])->name('Q30403');
Route::get('/q_select/{unit_id}/30404',[App\Http\Controllers\QuestionController::class, 'unit304_q04'])->name('Q30404');
Route::get('/q_select/{unit_id}/30405',[App\Http\Controllers\QuestionController::class, 'unit304_q05'])->name('Q30405');
Route::get('/q_select/{unit_id}/30406',[App\Http\Controllers\QuestionController::class, 'unit304_q06'])->name('Q30406');
Route::get('/q_select/{unit_id}/30407',[App\Http\Controllers\QuestionController::class, 'unit304_q07'])->name('Q30407');

Route::get('/q_select/{unit_id}/30501',[App\Http\Controllers\QuestionController::class, 'unit305_q01'])->name('Q30501');
Route::get('/q_select/{unit_id}/30502',[App\Http\Controllers\QuestionController::class, 'unit305_q02'])->name('Q30502');
Route::get('/q_select/{unit_id}/30503',[App\Http\Controllers\QuestionController::class, 'unit305_q03'])->name('Q30503');
Route::get('/q_select/{unit_id}/30504',[App\Http\Controllers\QuestionController::class, 'unit305_q04'])->name('Q30504');
Route::get('/q_select/{unit_id}/30505',[App\Http\Controllers\QuestionController::class, 'unit305_q05'])->name('Q30505');
Route::get('/q_select/{unit_id}/30506',[App\Http\Controllers\QuestionController::class, 'unit305_q06'])->name('Q30506');
Route::get('/q_select/{unit_id}/30507',[App\Http\Controllers\QuestionController::class, 'unit305_q07'])->name('Q30507');
Route::get('/q_select/{unit_id}/30508',[App\Http\Controllers\QuestionController::class, 'unit305_q08'])->name('Q30508');
Route::get('/q_select/{unit_id}/30509',[App\Http\Controllers\QuestionController::class, 'unit305_q09'])->name('Q30509');
Route::get('/q_select/{unit_id}/30510',[App\Http\Controllers\QuestionController::class, 'unit305_q10'])->name('Q30510');
Route::get('/q_select/{unit_id}/30511',[App\Http\Controllers\QuestionController::class, 'unit305_q11'])->name('Q30511');
Route::get('/q_select/{unit_id}/30512',[App\Http\Controllers\QuestionController::class, 'unit305_q12'])->name('Q30512');

Route::get('/q_select/{unit_id}/30601',[App\Http\Controllers\QuestionController::class, 'unit306_q01'])->name('Q30601');
Route::get('/q_select/{unit_id}/30602',[App\Http\Controllers\QuestionController::class, 'unit306_q02'])->name('Q30602');
Route::get('/q_select/{unit_id}/30603',[App\Http\Controllers\QuestionController::class, 'unit306_q03'])->name('Q30603');
Route::get('/q_select/{unit_id}/30604',[App\Http\Controllers\QuestionController::class, 'unit306_q04'])->name('Q30604');
Route::get('/q_select/{unit_id}/30605',[App\Http\Controllers\QuestionController::class, 'unit306_q05'])->name('Q30605');
Route::get('/q_select/{unit_id}/30606',[App\Http\Controllers\QuestionController::class, 'unit306_q06'])->name('Q30606');
Route::get('/q_select/{unit_id}/30607',[App\Http\Controllers\QuestionController::class, 'unit306_q07'])->name('Q30607');
Route::get('/q_select/{unit_id}/30608',[App\Http\Controllers\QuestionController::class, 'unit306_q08'])->name('Q30608');
Route::get('/q_select/{unit_id}/30609',[App\Http\Controllers\QuestionController::class, 'unit306_q09'])->name('Q30609');
Route::get('/q_select/{unit_id}/30610',[App\Http\Controllers\QuestionController::class, 'unit306_q10'])->name('Q30610');
Route::get('/q_select/{unit_id}/30611',[App\Http\Controllers\QuestionController::class, 'unit306_q11'])->name('Q30611');
Route::get('/q_select/{unit_id}/30612',[App\Http\Controllers\QuestionController::class, 'unit306_q12'])->name('Q30612');

//数学A
Route::get('/q_select/{unit_id}/40101',[App\Http\Controllers\QuestionController::class, 'unit401_q01'])->name('Q40101');
Route::get('/q_select/{unit_id}/40102',[App\Http\Controllers\QuestionController::class, 'unit401_q02'])->name('Q40102');
Route::get('/q_select/{unit_id}/40103',[App\Http\Controllers\QuestionController::class, 'unit401_q03'])->name('Q40103');
Route::get('/q_select/{unit_id}/40104',[App\Http\Controllers\QuestionController::class, 'unit401_q04'])->name('Q40104');
Route::get('/q_select/{unit_id}/40105',[App\Http\Controllers\QuestionController::class, 'unit401_q05'])->name('Q40105');
Route::get('/q_select/{unit_id}/40106',[App\Http\Controllers\QuestionController::class, 'unit401_q06'])->name('Q40106');
Route::get('/q_select/{unit_id}/40107',[App\Http\Controllers\QuestionController::class, 'unit401_q07'])->name('Q40107');
Route::get('/q_select/{unit_id}/40108',[App\Http\Controllers\QuestionController::class, 'unit401_q08'])->name('Q40108');
Route::get('/q_select/{unit_id}/40109',[App\Http\Controllers\QuestionController::class, 'unit401_q09'])->name('Q40109');
Route::get('/q_select/{unit_id}/40110',[App\Http\Controllers\QuestionController::class, 'unit401_q10'])->name('Q40110');
Route::get('/q_select/{unit_id}/40111',[App\Http\Controllers\QuestionController::class, 'unit401_q11'])->name('Q40111');

Route::get('/q_select/{unit_id}/40201',[App\Http\Controllers\QuestionController::class, 'unit402_q01'])->name('Q40201');
Route::get('/q_select/{unit_id}/40202',[App\Http\Controllers\QuestionController::class, 'unit402_q02'])->name('Q40202');
Route::get('/q_select/{unit_id}/40203',[App\Http\Controllers\QuestionController::class, 'unit402_q03'])->name('Q40203');
Route::get('/q_select/{unit_id}/40204',[App\Http\Controllers\QuestionController::class, 'unit402_q04'])->name('Q40204');
Route::get('/q_select/{unit_id}/40205',[App\Http\Controllers\QuestionController::class, 'unit402_q05'])->name('Q40205');
Route::get('/q_select/{unit_id}/40206',[App\Http\Controllers\QuestionController::class, 'unit402_q06'])->name('Q40206');
Route::get('/q_select/{unit_id}/40207',[App\Http\Controllers\QuestionController::class, 'unit402_q07'])->name('Q40207');
Route::get('/q_select/{unit_id}/40208',[App\Http\Controllers\QuestionController::class, 'unit402_q08'])->name('Q40208');
Route::get('/q_select/{unit_id}/40209',[App\Http\Controllers\QuestionController::class, 'unit402_q09'])->name('Q40209');
Route::get('/q_select/{unit_id}/40210',[App\Http\Controllers\QuestionController::class, 'unit402_q10'])->name('Q40210');

Route::get('/q_select/{unit_id}/40301',[App\Http\Controllers\QuestionController::class, 'unit403_q01'])->name('Q40301');
Route::get('/q_select/{unit_id}/40302',[App\Http\Controllers\QuestionController::class, 'unit403_q02'])->name('Q40302');
Route::get('/q_select/{unit_id}/40303',[App\Http\Controllers\QuestionController::class, 'unit403_q03'])->name('Q40303');
Route::get('/q_select/{unit_id}/40304',[App\Http\Controllers\QuestionController::class, 'unit403_q04'])->name('Q40304');
Route::get('/q_select/{unit_id}/40305',[App\Http\Controllers\QuestionController::class, 'unit403_q05'])->name('Q40305');
Route::get('/q_select/{unit_id}/40306',[App\Http\Controllers\QuestionController::class, 'unit403_q06'])->name('Q40306');

//数学B
Route::get('/q_select/{unit_id}/50101',[App\Http\Controllers\QuestionController::class, 'unit501_q01'])->name('Q50101');
Route::get('/q_select/{unit_id}/50102',[App\Http\Controllers\QuestionController::class, 'unit501_q02'])->name('Q50102');
Route::get('/q_select/{unit_id}/50103',[App\Http\Controllers\QuestionController::class, 'unit501_q03'])->name('Q50103');
Route::get('/q_select/{unit_id}/50104',[App\Http\Controllers\QuestionController::class, 'unit501_q04'])->name('Q50104');
Route::get('/q_select/{unit_id}/50105',[App\Http\Controllers\QuestionController::class, 'unit501_q05'])->name('Q50105');
Route::get('/q_select/{unit_id}/50106',[App\Http\Controllers\QuestionController::class, 'unit501_q06'])->name('Q50106');
Route::get('/q_select/{unit_id}/50107',[App\Http\Controllers\QuestionController::class, 'unit501_q07'])->name('Q50107');
Route::get('/q_select/{unit_id}/50108',[App\Http\Controllers\QuestionController::class, 'unit501_q08'])->name('Q50108');

Route::get('/q_select/{unit_id}/50201',[App\Http\Controllers\QuestionController::class, 'unit502_q01'])->name('Q50201');
Route::get('/q_select/{unit_id}/50202',[App\Http\Controllers\QuestionController::class, 'unit502_q02'])->name('Q50202');
Route::get('/q_select/{unit_id}/50203',[App\Http\Controllers\QuestionController::class, 'unit502_q03'])->name('Q50203');
Route::get('/q_select/{unit_id}/50204',[App\Http\Controllers\QuestionController::class, 'unit502_q04'])->name('Q50204');
Route::get('/q_select/{unit_id}/50205',[App\Http\Controllers\QuestionController::class, 'unit502_q05'])->name('Q50205');
Route::get('/q_select/{unit_id}/50206',[App\Http\Controllers\QuestionController::class, 'unit502_q06'])->name('Q50206');
Route::get('/q_select/{unit_id}/50207',[App\Http\Controllers\QuestionController::class, 'unit502_q07'])->name('Q50207');
Route::get('/q_select/{unit_id}/50208',[App\Http\Controllers\QuestionController::class, 'unit502_q08'])->name('Q50208');
Route::get('/q_select/{unit_id}/50209',[App\Http\Controllers\QuestionController::class, 'unit502_q09'])->name('Q50209');







//答え合わせ・記録
//Route::post('/q_select/{unit_id}/{question_id}',[App\Http\Controllers\QuestionController::class, 'check_answer'])->name('check_answer');
Route::post('/q_select/{unit_id}/10101',[App\Http\Controllers\AnswerController::class, 'unit101_a01'])->name('A10101');
Route::post('/q_select/{unit_id}/10102',[App\Http\Controllers\AnswerController::class, 'unit101_a02'])->name('A10102');
Route::post('/q_select/{unit_id}/10103',[App\Http\Controllers\AnswerController::class, 'unit101_a03'])->name('A10103');
Route::post('/q_select/{unit_id}/10104',[App\Http\Controllers\AnswerController::class, 'unit101_a04'])->name('A10104');
Route::post('/q_select/{unit_id}/10105',[App\Http\Controllers\AnswerController::class, 'unit101_a05'])->name('A10105');
Route::post('/q_select/{unit_id}/10106',[App\Http\Controllers\AnswerController::class, 'unit101_a06'])->name('A10106');
Route::post('/q_select/{unit_id}/10107',[App\Http\Controllers\AnswerController::class, 'unit101_a07'])->name('A10107');
Route::post('/q_select/{unit_id}/10108',[App\Http\Controllers\AnswerController::class, 'unit101_a08'])->name('A10108');
Route::post('/q_select/{unit_id}/10109',[App\Http\Controllers\AnswerController::class, 'unit101_a09'])->name('A10109');
Route::post('/q_select/{unit_id}/10110',[App\Http\Controllers\AnswerController::class, 'unit101_a10'])->name('A10110');
Route::post('/q_select/{unit_id}/10111',[App\Http\Controllers\AnswerController::class, 'unit101_a11'])->name('A10111');
Route::post('/q_select/{unit_id}/10112',[App\Http\Controllers\AnswerController::class, 'unit101_a12'])->name('A10112');

Route::post('/q_select/{unit_id}/10201',[App\Http\Controllers\AnswerController::class, 'unit102_a01'])->name('A10201');
Route::post('/q_select/{unit_id}/10202',[App\Http\Controllers\AnswerController::class, 'unit102_a02'])->name('A10202');
Route::post('/q_select/{unit_id}/10203',[App\Http\Controllers\AnswerController::class, 'unit102_a03'])->name('A10203');
Route::post('/q_select/{unit_id}/10204',[App\Http\Controllers\AnswerController::class, 'unit102_a04'])->name('A10204');
Route::post('/q_select/{unit_id}/10205',[App\Http\Controllers\AnswerController::class, 'unit102_a05'])->name('A10205');
Route::post('/q_select/{unit_id}/10206',[App\Http\Controllers\AnswerController::class, 'unit102_a06'])->name('A10206');
Route::post('/q_select/{unit_id}/10207',[App\Http\Controllers\AnswerController::class, 'unit102_a07'])->name('A10207');
Route::post('/q_select/{unit_id}/10208',[App\Http\Controllers\AnswerController::class, 'unit102_a08'])->name('A10208');
Route::post('/q_select/{unit_id}/10209',[App\Http\Controllers\AnswerController::class, 'unit102_a09'])->name('A10209');
Route::post('/q_select/{unit_id}/10210',[App\Http\Controllers\AnswerController::class, 'unit102_a10'])->name('A10210');
Route::post('/q_select/{unit_id}/10211',[App\Http\Controllers\AnswerController::class, 'unit102_a11'])->name('A10211');

Route::post('/q_select/{unit_id}/10301',[App\Http\Controllers\AnswerController::class, 'unit103_a01'])->name('A10301');
Route::post('/q_select/{unit_id}/10302',[App\Http\Controllers\AnswerController::class, 'unit103_a02'])->name('A10302');
Route::post('/q_select/{unit_id}/10303',[App\Http\Controllers\AnswerController::class, 'unit103_a03'])->name('A10303');
Route::post('/q_select/{unit_id}/10304',[App\Http\Controllers\AnswerController::class, 'unit103_a04'])->name('A10304');
Route::post('/q_select/{unit_id}/10305',[App\Http\Controllers\AnswerController::class, 'unit103_a05'])->name('A10305');
Route::post('/q_select/{unit_id}/10306',[App\Http\Controllers\AnswerController::class, 'unit103_a06'])->name('A10306');
Route::post('/q_select/{unit_id}/10307',[App\Http\Controllers\AnswerController::class, 'unit103_a07'])->name('A10307');
Route::post('/q_select/{unit_id}/10308',[App\Http\Controllers\AnswerController::class, 'unit103_a08'])->name('A10308');
Route::post('/q_select/{unit_id}/10309',[App\Http\Controllers\AnswerController::class, 'unit103_a09'])->name('A10309');

Route::post('/q_select/{unit_id}/10401',[App\Http\Controllers\AnswerController::class, 'unit104_a01'])->name('A10401');
Route::post('/q_select/{unit_id}/10402',[App\Http\Controllers\AnswerController::class, 'unit104_a02'])->name('A10402');
Route::post('/q_select/{unit_id}/10403',[App\Http\Controllers\AnswerController::class, 'unit104_a03'])->name('A10403');
Route::post('/q_select/{unit_id}/10404',[App\Http\Controllers\AnswerController::class, 'unit104_a04'])->name('A10404');

//数学Ⅱ
Route::post('/q_select/{unit_id}/20101',[App\Http\Controllers\AnswerController::class, 'unit201_a01'])->name('A20101');
Route::post('/q_select/{unit_id}/20102',[App\Http\Controllers\AnswerController::class, 'unit201_a02'])->name('A20102');
Route::post('/q_select/{unit_id}/20103',[App\Http\Controllers\AnswerController::class, 'unit201_a03'])->name('A20103');
Route::post('/q_select/{unit_id}/20104',[App\Http\Controllers\AnswerController::class, 'unit201_a04'])->name('A20104');
Route::post('/q_select/{unit_id}/20105',[App\Http\Controllers\AnswerController::class, 'unit201_a05'])->name('A20105');

Route::post('/q_select/{unit_id}/20201',[App\Http\Controllers\AnswerController::class, 'unit202_a01'])->name('A20201');
Route::post('/q_select/{unit_id}/20202',[App\Http\Controllers\AnswerController::class, 'unit202_a02'])->name('A20202');
Route::post('/q_select/{unit_id}/20203',[App\Http\Controllers\AnswerController::class, 'unit202_a03'])->name('A20203');
Route::post('/q_select/{unit_id}/20204',[App\Http\Controllers\AnswerController::class, 'unit202_a04'])->name('A20204');
Route::post('/q_select/{unit_id}/20205',[App\Http\Controllers\AnswerController::class, 'unit202_a05'])->name('A20205');
Route::post('/q_select/{unit_id}/20206',[App\Http\Controllers\AnswerController::class, 'unit202_a06'])->name('A20206');
Route::post('/q_select/{unit_id}/20207',[App\Http\Controllers\AnswerController::class, 'unit202_a07'])->name('A20207');

Route::post('/q_select/{unit_id}/20301',[App\Http\Controllers\AnswerController::class, 'unit203_a01'])->name('A20301');
Route::post('/q_select/{unit_id}/20302',[App\Http\Controllers\AnswerController::class, 'unit203_a02'])->name('A20302');
Route::post('/q_select/{unit_id}/20303',[App\Http\Controllers\AnswerController::class, 'unit203_a03'])->name('A20303');
Route::post('/q_select/{unit_id}/20304',[App\Http\Controllers\AnswerController::class, 'unit203_a04'])->name('A20304');
Route::post('/q_select/{unit_id}/20305',[App\Http\Controllers\AnswerController::class, 'unit203_a05'])->name('A20305');
Route::post('/q_select/{unit_id}/20306',[App\Http\Controllers\AnswerController::class, 'unit203_a06'])->name('A20306');
Route::post('/q_select/{unit_id}/20307',[App\Http\Controllers\AnswerController::class, 'unit203_a07'])->name('A20307');
Route::post('/q_select/{unit_id}/20308',[App\Http\Controllers\AnswerController::class, 'unit203_a08'])->name('A20308');

Route::post('/q_select/{unit_id}/20401',[App\Http\Controllers\AnswerController::class, 'unit204_a01'])->name('A20401');
Route::post('/q_select/{unit_id}/20402',[App\Http\Controllers\AnswerController::class, 'unit204_a02'])->name('A20402');
Route::post('/q_select/{unit_id}/20403',[App\Http\Controllers\AnswerController::class, 'unit204_a03'])->name('A20403');
Route::post('/q_select/{unit_id}/20404',[App\Http\Controllers\AnswerController::class, 'unit204_a04'])->name('A20404');
Route::post('/q_select/{unit_id}/20405',[App\Http\Controllers\AnswerController::class, 'unit204_a05'])->name('A20405');
Route::post('/q_select/{unit_id}/20406',[App\Http\Controllers\AnswerController::class, 'unit204_a06'])->name('A20406');
Route::post('/q_select/{unit_id}/20407',[App\Http\Controllers\AnswerController::class, 'unit204_a07'])->name('A20407');
Route::post('/q_select/{unit_id}/20408',[App\Http\Controllers\AnswerController::class, 'unit204_a08'])->name('A20408');

Route::post('/q_select/{unit_id}/20501',[App\Http\Controllers\AnswerController::class, 'unit205_a01'])->name('A20501');
Route::post('/q_select/{unit_id}/20502',[App\Http\Controllers\AnswerController::class, 'unit205_a02'])->name('A20502');
Route::post('/q_select/{unit_id}/20503',[App\Http\Controllers\AnswerController::class, 'unit205_a03'])->name('A20503');
Route::post('/q_select/{unit_id}/20504',[App\Http\Controllers\AnswerController::class, 'unit205_a04'])->name('A20504');
Route::post('/q_select/{unit_id}/20505',[App\Http\Controllers\AnswerController::class, 'unit205_a05'])->name('A20505');
Route::post('/q_select/{unit_id}/20506',[App\Http\Controllers\AnswerController::class, 'unit205_a06'])->name('A20506');
Route::post('/q_select/{unit_id}/20507',[App\Http\Controllers\AnswerController::class, 'unit205_a07'])->name('A20507');
Route::post('/q_select/{unit_id}/20508',[App\Http\Controllers\AnswerController::class, 'unit205_a08'])->name('A20508');
Route::post('/q_select/{unit_id}/20509',[App\Http\Controllers\AnswerController::class, 'unit205_a09'])->name('A20509');
Route::post('/q_select/{unit_id}/20510',[App\Http\Controllers\AnswerController::class, 'unit205_a10'])->name('A20510');

Route::post('/q_select/{unit_id}/20601',[App\Http\Controllers\AnswerController::class, 'unit206_a01'])->name('A20601');
Route::post('/q_select/{unit_id}/20602',[App\Http\Controllers\AnswerController::class, 'unit206_a02'])->name('A20602');
Route::post('/q_select/{unit_id}/20603',[App\Http\Controllers\AnswerController::class, 'unit206_a03'])->name('A20603');
Route::post('/q_select/{unit_id}/20604',[App\Http\Controllers\AnswerController::class, 'unit206_a04'])->name('A20604');
Route::post('/q_select/{unit_id}/20605',[App\Http\Controllers\AnswerController::class, 'unit206_a05'])->name('A20605');
Route::post('/q_select/{unit_id}/20606',[App\Http\Controllers\AnswerController::class, 'unit206_a06'])->name('A20606');
Route::post('/q_select/{unit_id}/20607',[App\Http\Controllers\AnswerController::class, 'unit206_a07'])->name('A20607');

Route::post('/q_select/{unit_id}/20701',[App\Http\Controllers\AnswerController::class, 'unit207_a01'])->name('A20701');
Route::post('/q_select/{unit_id}/20702',[App\Http\Controllers\AnswerController::class, 'unit207_a02'])->name('A20702');
Route::post('/q_select/{unit_id}/20703',[App\Http\Controllers\AnswerController::class, 'unit207_a03'])->name('A20703');
Route::post('/q_select/{unit_id}/20704',[App\Http\Controllers\AnswerController::class, 'unit207_a04'])->name('A20704');
Route::post('/q_select/{unit_id}/20705',[App\Http\Controllers\AnswerController::class, 'unit207_a05'])->name('A20705');
Route::post('/q_select/{unit_id}/20706',[App\Http\Controllers\AnswerController::class, 'unit207_a06'])->name('A20706');
Route::post('/q_select/{unit_id}/20707',[App\Http\Controllers\AnswerController::class, 'unit207_a07'])->name('A20707');


//数学Ⅲ
Route::post('/q_select/{unit_id}/30101',[App\Http\Controllers\AnswerController::class, 'unit301_a01'])->name('A30101');
Route::post('/q_select/{unit_id}/30102',[App\Http\Controllers\AnswerController::class, 'unit301_a02'])->name('A30102');
Route::post('/q_select/{unit_id}/30103',[App\Http\Controllers\AnswerController::class, 'unit301_a03'])->name('A30103');
Route::post('/q_select/{unit_id}/30104',[App\Http\Controllers\AnswerController::class, 'unit301_a04'])->name('A30104');
Route::post('/q_select/{unit_id}/30105',[App\Http\Controllers\AnswerController::class, 'unit301_a05'])->name('A30105');
Route::post('/q_select/{unit_id}/30106',[App\Http\Controllers\AnswerController::class, 'unit301_a06'])->name('A30106');
Route::post('/q_select/{unit_id}/30107',[App\Http\Controllers\AnswerController::class, 'unit301_a07'])->name('A30107');

Route::post('/q_select/{unit_id}/30201',[App\Http\Controllers\AnswerController::class, 'unit302_a01'])->name('A30201');
Route::post('/q_select/{unit_id}/30202',[App\Http\Controllers\AnswerController::class, 'unit302_a02'])->name('A30202');
Route::post('/q_select/{unit_id}/30203',[App\Http\Controllers\AnswerController::class, 'unit302_a03'])->name('A30203');
Route::post('/q_select/{unit_id}/30204',[App\Http\Controllers\AnswerController::class, 'unit302_a04'])->name('A30204');
Route::post('/q_select/{unit_id}/30205',[App\Http\Controllers\AnswerController::class, 'unit302_a05'])->name('A30205');
Route::post('/q_select/{unit_id}/30206',[App\Http\Controllers\AnswerController::class, 'unit302_a06'])->name('A30206');
Route::post('/q_select/{unit_id}/30207',[App\Http\Controllers\AnswerController::class, 'unit302_a07'])->name('A30207');
Route::post('/q_select/{unit_id}/30208',[App\Http\Controllers\AnswerController::class, 'unit302_a08'])->name('A30208');
Route::post('/q_select/{unit_id}/30209',[App\Http\Controllers\AnswerController::class, 'unit302_a09'])->name('A30209');

Route::post('/q_select/{unit_id}/30301',[App\Http\Controllers\AnswerController::class, 'unit303_a01'])->name('A30301');
Route::post('/q_select/{unit_id}/30302',[App\Http\Controllers\AnswerController::class, 'unit303_a02'])->name('A30302');
Route::post('/q_select/{unit_id}/30303',[App\Http\Controllers\AnswerController::class, 'unit303_a03'])->name('A30303');
Route::post('/q_select/{unit_id}/30304',[App\Http\Controllers\AnswerController::class, 'unit303_a04'])->name('A30304');
Route::post('/q_select/{unit_id}/30305',[App\Http\Controllers\AnswerController::class, 'unit303_a05'])->name('A30305');

Route::post('/q_select/{unit_id}/30401',[App\Http\Controllers\AnswerController::class, 'unit304_a01'])->name('A30401');
Route::post('/q_select/{unit_id}/30402',[App\Http\Controllers\AnswerController::class, 'unit304_a02'])->name('A30402');
Route::post('/q_select/{unit_id}/30403',[App\Http\Controllers\AnswerController::class, 'unit304_a03'])->name('A30403');
Route::post('/q_select/{unit_id}/30404',[App\Http\Controllers\AnswerController::class, 'unit304_a04'])->name('A30404');
Route::post('/q_select/{unit_id}/30405',[App\Http\Controllers\AnswerController::class, 'unit304_a05'])->name('A30405');
Route::post('/q_select/{unit_id}/30406',[App\Http\Controllers\AnswerController::class, 'unit304_a06'])->name('A30406');
Route::post('/q_select/{unit_id}/30407',[App\Http\Controllers\AnswerController::class, 'unit304_a07'])->name('A30407');

Route::post('/q_select/{unit_id}/30501',[App\Http\Controllers\AnswerController::class, 'unit305_a01'])->name('A30501');
Route::post('/q_select/{unit_id}/30502',[App\Http\Controllers\AnswerController::class, 'unit305_a02'])->name('A30502');
Route::post('/q_select/{unit_id}/30503',[App\Http\Controllers\AnswerController::class, 'unit305_a03'])->name('A30503');
Route::post('/q_select/{unit_id}/30504',[App\Http\Controllers\AnswerController::class, 'unit305_a04'])->name('A30504');
Route::post('/q_select/{unit_id}/30505',[App\Http\Controllers\AnswerController::class, 'unit305_a05'])->name('A30505');
Route::post('/q_select/{unit_id}/30506',[App\Http\Controllers\AnswerController::class, 'unit305_a06'])->name('A30506');
Route::post('/q_select/{unit_id}/30507',[App\Http\Controllers\AnswerController::class, 'unit305_a07'])->name('A30507');
Route::post('/q_select/{unit_id}/30508',[App\Http\Controllers\AnswerController::class, 'unit305_a08'])->name('A30508');
Route::post('/q_select/{unit_id}/30509',[App\Http\Controllers\AnswerController::class, 'unit305_a09'])->name('A30509');
Route::post('/q_select/{unit_id}/30510',[App\Http\Controllers\AnswerController::class, 'unit305_a10'])->name('A30510');
Route::post('/q_select/{unit_id}/30511',[App\Http\Controllers\AnswerController::class, 'unit305_a11'])->name('A30511');
Route::post('/q_select/{unit_id}/30512',[App\Http\Controllers\AnswerController::class, 'unit305_a12'])->name('A30512');

Route::post('/q_select/{unit_id}/30601',[App\Http\Controllers\AnswerController::class, 'unit306_a01'])->name('A30601');
Route::post('/q_select/{unit_id}/30602',[App\Http\Controllers\AnswerController::class, 'unit306_a02'])->name('A30602');
Route::post('/q_select/{unit_id}/30603',[App\Http\Controllers\AnswerController::class, 'unit306_a03'])->name('A30603');
Route::post('/q_select/{unit_id}/30604',[App\Http\Controllers\AnswerController::class, 'unit306_a04'])->name('A30604');
Route::post('/q_select/{unit_id}/30605',[App\Http\Controllers\AnswerController::class, 'unit306_a05'])->name('A30605');
Route::post('/q_select/{unit_id}/30606',[App\Http\Controllers\AnswerController::class, 'unit306_a06'])->name('A30606');
Route::post('/q_select/{unit_id}/30607',[App\Http\Controllers\AnswerController::class, 'unit306_a07'])->name('A30607');
Route::post('/q_select/{unit_id}/30608',[App\Http\Controllers\AnswerController::class, 'unit306_a08'])->name('A30608');
Route::post('/q_select/{unit_id}/30609',[App\Http\Controllers\AnswerController::class, 'unit306_a09'])->name('A30609');
Route::post('/q_select/{unit_id}/30610',[App\Http\Controllers\AnswerController::class, 'unit306_a10'])->name('A30610');
Route::post('/q_select/{unit_id}/30611',[App\Http\Controllers\AnswerController::class, 'unit306_a11'])->name('A30611');
Route::post('/q_select/{unit_id}/30612',[App\Http\Controllers\AnswerController::class, 'unit306_a12'])->name('A30612');

//数学A
Route::post('/q_select/{unit_id}/40101',[App\Http\Controllers\AnswerController::class, 'unit401_a01'])->name('A40101');
Route::post('/q_select/{unit_id}/40102',[App\Http\Controllers\AnswerController::class, 'unit401_a02'])->name('A40102');
Route::post('/q_select/{unit_id}/40103',[App\Http\Controllers\AnswerController::class, 'unit401_a03'])->name('A40103');
Route::post('/q_select/{unit_id}/40104',[App\Http\Controllers\AnswerController::class, 'unit401_a04'])->name('A40104');
Route::post('/q_select/{unit_id}/40105',[App\Http\Controllers\AnswerController::class, 'unit401_a05'])->name('A40105');
Route::post('/q_select/{unit_id}/40106',[App\Http\Controllers\AnswerController::class, 'unit401_a06'])->name('A40106');
Route::post('/q_select/{unit_id}/40107',[App\Http\Controllers\AnswerController::class, 'unit401_a07'])->name('A40107');
Route::post('/q_select/{unit_id}/40108',[App\Http\Controllers\AnswerController::class, 'unit401_a08'])->name('A40108');
Route::post('/q_select/{unit_id}/40109',[App\Http\Controllers\AnswerController::class, 'unit401_a09'])->name('A40109');
Route::post('/q_select/{unit_id}/40110',[App\Http\Controllers\AnswerController::class, 'unit401_a10'])->name('A40110');
Route::post('/q_select/{unit_id}/40111',[App\Http\Controllers\AnswerController::class, 'unit401_a11'])->name('A40111');

Route::post('/q_select/{unit_id}/40201',[App\Http\Controllers\AnswerController::class, 'unit402_a01'])->name('A40201');
Route::post('/q_select/{unit_id}/40202',[App\Http\Controllers\AnswerController::class, 'unit402_a02'])->name('A40202');
Route::post('/q_select/{unit_id}/40203',[App\Http\Controllers\AnswerController::class, 'unit402_a03'])->name('A40203');
Route::post('/q_select/{unit_id}/40204',[App\Http\Controllers\AnswerController::class, 'unit402_a04'])->name('A40204');
Route::post('/q_select/{unit_id}/40205',[App\Http\Controllers\AnswerController::class, 'unit402_a05'])->name('A40205');
Route::post('/q_select/{unit_id}/40206',[App\Http\Controllers\AnswerController::class, 'unit402_a06'])->name('A40206');
Route::post('/q_select/{unit_id}/40207',[App\Http\Controllers\AnswerController::class, 'unit402_a07'])->name('A40207');
Route::post('/q_select/{unit_id}/40208',[App\Http\Controllers\AnswerController::class, 'unit402_a08'])->name('A40208');
Route::post('/q_select/{unit_id}/40209',[App\Http\Controllers\AnswerController::class, 'unit402_a09'])->name('A40209');
Route::post('/q_select/{unit_id}/40210',[App\Http\Controllers\AnswerController::class, 'unit402_a10'])->name('A40210');

Route::post('/q_select/{unit_id}/40301',[App\Http\Controllers\AnswerController::class, 'unit403_a01'])->name('A40301');
Route::post('/q_select/{unit_id}/40302',[App\Http\Controllers\AnswerController::class, 'unit403_a02'])->name('A40302');
Route::post('/q_select/{unit_id}/40303',[App\Http\Controllers\AnswerController::class, 'unit403_a03'])->name('A40303');
Route::post('/q_select/{unit_id}/40304',[App\Http\Controllers\AnswerController::class, 'unit403_a04'])->name('A40304');
Route::post('/q_select/{unit_id}/40305',[App\Http\Controllers\AnswerController::class, 'unit403_a05'])->name('A40305');
Route::post('/q_select/{unit_id}/40306',[App\Http\Controllers\AnswerController::class, 'unit403_a06'])->name('A40306');

//数学B
Route::post('/q_select/{unit_id}/50101',[App\Http\Controllers\AnswerController::class, 'unit501_a01'])->name('A50101');
Route::post('/q_select/{unit_id}/50102',[App\Http\Controllers\AnswerController::class, 'unit501_a02'])->name('A50102');
Route::post('/q_select/{unit_id}/50103',[App\Http\Controllers\AnswerController::class, 'unit501_a03'])->name('A50103');
Route::post('/q_select/{unit_id}/50104',[App\Http\Controllers\AnswerController::class, 'unit501_a04'])->name('A50104');
Route::post('/q_select/{unit_id}/50105',[App\Http\Controllers\AnswerController::class, 'unit501_a05'])->name('A50105');
Route::post('/q_select/{unit_id}/50106',[App\Http\Controllers\AnswerController::class, 'unit501_a06'])->name('A50106');
Route::post('/q_select/{unit_id}/50107',[App\Http\Controllers\AnswerController::class, 'unit501_a07'])->name('A50107');
Route::post('/q_select/{unit_id}/50108',[App\Http\Controllers\AnswerController::class, 'unit501_a08'])->name('A50108');

Route::post('/q_select/{unit_id}/50201',[App\Http\Controllers\AnswerController::class, 'unit502_a01'])->name('A50201');
Route::post('/q_select/{unit_id}/50202',[App\Http\Controllers\AnswerController::class, 'unit502_a02'])->name('A50202');
Route::post('/q_select/{unit_id}/50203',[App\Http\Controllers\AnswerController::class, 'unit502_a03'])->name('A50203');
Route::post('/q_select/{unit_id}/50204',[App\Http\Controllers\AnswerController::class, 'unit502_a04'])->name('A50204');
Route::post('/q_select/{unit_id}/50205',[App\Http\Controllers\AnswerController::class, 'unit502_a05'])->name('A50205');
Route::post('/q_select/{unit_id}/50206',[App\Http\Controllers\AnswerController::class, 'unit502_a06'])->name('A50206');
Route::post('/q_select/{unit_id}/50207',[App\Http\Controllers\AnswerController::class, 'unit502_a07'])->name('A50207');
Route::post('/q_select/{unit_id}/50208',[App\Http\Controllers\AnswerController::class, 'unit502_a08'])->name('A50208');
Route::post('/q_select/{unit_id}/50209',[App\Http\Controllers\AnswerController::class, 'unit502_a09'])->name('A50209');