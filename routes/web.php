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

Route::get('/', function () {
    return view('auth.login');
})->middleware(['verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['verified'])->name('dashboard');

Route::get('/dashboard', 'App\Http\Controllers\TaskController@index')
->middleware(['verified'])->name('dashboard');

Route::post('/working/new', 'App\Http\Controllers\TaskController@create')
->middleware(['verified'])->name('working_new');

Route::get('/working', 'App\Http\Controllers\TaskController@show')
->middleware(['verified'])->name('working');

Route::post('/working/delete', 'App\Http\Controllers\TaskController@destroy')
->middleware(['verified'])->name('working_delete');

Route::get('/annotation', 'App\Http\Controllers\AnnotationController@index')
->middleware(['verified'])->name('annotation');

Route::get('/annotation/{task_id}/{image_id}', 'App\Http\Controllers\AnnotationController@show')
->middleware(['verified'])->name('annotation_task');

Route::get('/help', function () {
    return view('help');
})->middleware(['verified'])->name('help');

require __DIR__.'/auth.php';
