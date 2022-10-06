<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

//ロケール設定
Route::group(['middleware' => 'set.locale'], function () {
    Route::get('/setlocale/{locale}', function ($locale) {
        session()->put('locale', $locale);
        return redirect()->back();
    })->name('locale');
});

//verified = メール認証済みかチェック
//auth.session = 別デバイス・ブラウザでログインしたらセッションを切断

Route::group(['middleware' => ['verified', 'auth.session', 'set.locale']], function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('home');

    Route::get('/dashboard', 'App\Http\Controllers\TaskController@index')
    ->name('dashboard');

    Route::post('/working/new', 'App\Http\Controllers\TaskController@create')
    ->name('working_new');

    Route::get('/working', 'App\Http\Controllers\TaskController@show')
    ->name('working');

    Route::post('/working/delete', 'App\Http\Controllers\TaskController@destroy')
    ->name('working_delete');

    Route::post('/working/finished', 'App\Http\Controllers\TaskController@edit')
    ->name('working_finished');

    Route::post('/working/reopen', 'App\Http\Controllers\TaskController@reopen')
    ->name('working_reopen');

    Route::get('/annotation', 'App\Http\Controllers\AnnotationController@index')
    ->name('annotation');

    Route::get('/annotation/{task_id}/{image_id}', 'App\Http\Controllers\AnnotationController@show')
    ->name('annotation_task');

    Route::get('/view/{task_id}', 'App\Http\Controllers\AnnotationController@view')
    ->name('view');

    Route::get('/help', function () {
        return view('help');
    })->name('help');

    Route::get('/message', function () {
        return view('message');
    })->name('message');

    Route::post('/contact', 'App\Http\Controllers\TaskController@sendMessage')
    ->name('contact');

    Route::get('/find', 'App\Http\Controllers\TaskController@find')->name('find');

    Route::post('/search', 'App\Http\Controllers\TaskController@search')
    ->name('search');
});

require __DIR__.'/auth.php';
