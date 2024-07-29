<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyUserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectUserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('/comment', CommentController::class);
    Route::resource('/company', CompanyController::class);
    Route::resource('/companyuser', CompanyUserController::class);
    Route::get('project/create/{company_id?}', [ProjectController::class, 'create']); // zelfde syntax als Route::get('/users', 'App\Http\Controllers\UserController@index');
    Route::resource('/project', ProjectController::class);
    Route::resource('/projectuser', ProjectUserController::class);
    Route::resource('/role', RoleController::class);
    Route::get('task/create/{project_id?}', [TaskController::class, 'create']); // zelfde syntax als Route::get('/users', 'App\Http\Controllers\UserController@index');
    Route::resource('/task', TaskController::class);
    Route::resource('/user', UserController::class);

    Route::post('/project/adduser', [ProjectController::class, 'adduser'])->name('project.adduser'); //name == naam vand e route
    Route::post('/company/adduser', [CompanyController::class, 'adduser'])->name('company.adduser'); //name == naam vand e route
    Route::post('/task/adduser', [TaskController::class, 'adduser'])->name('task.adduser'); //name == naam vand e route
    // Route::resource('/comments', 'CommentsController:class');

});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

