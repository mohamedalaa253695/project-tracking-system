<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTasksController;
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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/projects', [ProjectController::class, 'index']) ;
    Route::get('/project/create', [ProjectController::class, 'create']);
    Route::post('/project/store', [ProjectController::class, 'store']);
    Route::get('/project/{project}', [ProjectController::class, 'show']) ;
    Route::get('/project/{project}/edit', [ProjectController::class, 'edit']) ;

    Route::post('/project/{project}/tasks', [ProjectTasksController::class, 'store']) ;
    Route::patch('/project/{project}', [ProjectController::class, 'update']);

    Route::delete('/project/{project}', [ProjectController::class, 'destroy']);

    Route::patch('/project/{project}/tasks/{task}', [ProjectTasksController::class, 'update']);
    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();
