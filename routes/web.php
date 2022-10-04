<?php

use Illuminate\Support\Facades\Route;
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

//verified = メール認証済みかチェック
//auth.session = 別デバイス・ブラウザでログインしたらセッションを切断

Route::get('/', function () {
    return view('auth.login');
})->middleware(['verified', 'auth.session'])->name('dashboard');

Route::get('/dashboard', 'App\Http\Controllers\TaskController@index')
->middleware(['verified', 'auth.session'])->name('dashboard');

Route::post('/working/new', 'App\Http\Controllers\TaskController@create')
->middleware(['verified', 'auth.session'])->name('working_new');

Route::get('/working', 'App\Http\Controllers\TaskController@show')
->middleware(['verified', 'auth.session'])->name('working');

Route::post('/working/delete', 'App\Http\Controllers\TaskController@destroy')
->middleware(['verified', 'auth.session'])->name('working_delete');

Route::post('/working/finished', 'App\Http\Controllers\TaskController@edit')
->middleware(['verified', 'auth.session'])->name('working_finished');

Route::post('/working/reopen', 'App\Http\Controllers\TaskController@reopen')
->middleware(['verified', 'auth.session'])->name('working_reopen');

Route::get('/annotation', 'App\Http\Controllers\AnnotationController@index')
->middleware(['verified', 'auth.session'])->name('annotation');

Route::get('/annotation/{task_id}/{image_id}', 'App\Http\Controllers\AnnotationController@show')
->middleware(['verified', 'auth.session'])->name('annotation_task');

Route::get('/view/{task_id}', 'App\Http\Controllers\AnnotationController@view')
->middleware(['verified', 'auth.session'])->name('view');

Route::get('/help', function () {
    return view('help');
})->middleware(['verified', 'auth.session'])->name('help');

Route::get('/message', function () {
    return view('message');
})->middleware(['verified', 'auth.session'])->name('message');

Route::post('/contact', 'App\Http\Controllers\TaskController@sendMessage')
->middleware(['verified', 'auth.session'])->name('contact');

Route::get('/find', 'App\Http\Controllers\TaskController@find')->middleware(['verified', 'auth.session'])->name('find');

Route::post('/search', 'App\Http\Controllers\TaskController@search')
->middleware(['verified', 'auth.session'])->name('search');

require __DIR__.'/auth.php';
