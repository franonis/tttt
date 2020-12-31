<?php

use App\Http\Controllers\BabaController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\UploadController;
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

#Route::get('/', [TestController]'TestController@showwelcome');

Route::get('/', function () {
    return view('welcome');
});
Route::get('/cross', function () {
    return view('cross');
});
Route::get('/help', function () {
    return view('about');
});
Route::get('/statistics', function () {
    return view('statistics');
});
Route::get('/faq', function () {
    return view('about');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/disease', function () {
    return view('disease');
});
Route::get('/searchdisease', [BabaController::class, 'searchdisease']);
Route::get('/diseasetable/f{name}', [BabaController::class, 'diseasetable']);

Route::get('/pdf/{name}', [PdfController::class, 'getpdf']);
#Route::post('/disease', function () {
#    return view('disease');
#});

Route::group(['prefix' => '/result'], function () {
    Route::post('/set', [ResultController::class, 'getsetPage']);
    Route::post('/cross', [ResultController::class, 'getcrossPage']);
    Route::get('/cross', [ResultController::class, 'getcrossPage']);
    Route::get('/set', [ResultController::class, 'getsetPage']);
});

Route::get('/upload', [UploadController::class, 'getUploadPage']);
Route::get('/canshu', [UploadController::class, 'canshu']);
Route::get('/crosscanshu', [UploadController::class, 'crosscanshu']);

Route::post('/uploadfile', [UploadController::class, 'newtask_att_up']);
