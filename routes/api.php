<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/researcher', 'App\Http\Controllers\ResearcherController@index');
Route::post('/researcher', 'App\Http\Controllers\ResearcherController@store');
Route::put('/researchers/{id}', [\App\Http\Controllers\ResearcherController::class, '__invoke']);
//Route::get('/researcher', 'App\Http\Controllers\ResearcherController@index');
Route::get('/orcid/list/', 'App\Http\Controllers\ResearchController@index');
Route::post('/orcid/create/{orcid}', 'App\Http\Controllers\ResearchController@store');
Route::put('/orcid/edit/{researcher}', 'App\Http\Controllers\ResearchController@update');
Route::get('/orcid/{id}', 'App\Http\Controllers\ResearchController@show');
Route::delete('/orcid/delete/{id}', 'App\Http\Controllers\ResearchController@destroy');
