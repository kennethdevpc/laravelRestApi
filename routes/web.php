<?php

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
    return view('auth.login');
});

Auth::routes();
Route::resource('researchers',\App\Http\Controllers\ResearcherController::class)->middleware('auth');
Route::get('/home', [App\Http\Controllers\ResearcherController::class, 'index'])->name('home');
Route::get('/documents/{n}', [App\Http\Controllers\ResearcherController::class, 'indexPaginate'])->name('documents');

