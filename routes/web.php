<?php

use App\Http\Controllers\BabaController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\TwoController;
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
    return view('upload');
});
Route::get('/home', function () {
    return view('cross');
});
Route::get('/about', function () {
    return view('cross');
});
Route::get('/disease', function () {
    return view('disease');
});
Route::get('/searchdisease', [BabaController::class, 'searchdisease']);
Route::get('/diseasetable/f{name}', [BabaController::class, 'diseasetable']);

Route::get('/pdf/{name}', [PdfController::class, 'getpdf']);

Route::group(['prefix' => '/update'], function () {
    Route::get('/updatePCA', [UpdateController::class, 'updatePCA']);
    Route::get('/updaternaHeatmap', [UpdateController::class, 'updaternaHeatmap']);
    Route::get('/updaternaVolcano', [UpdateController::class, 'updaternaVolcano']);
    Route::get('/updatemetHeatmap', [UpdateController::class, 'updatemetHeatmap']);
    Route::get('/updatemetVolcano', [UpdateController::class, 'updatemetVolcano']);
    Route::get('/updatelipHeatmap', [UpdateController::class, 'updatelipHeatmap']);
    Route::get('/updatelipVolcano', [UpdateController::class, 'updatelipVolcano']);
    Route::get('/updatelipfa', [UpdateController::class, 'updatelipfa']);
    Route::get('/updateliphead', [UpdateController::class, 'updateliphead']);
});

Route::group(['prefix' => '/result'], function () {
    Route::get('/set', [ResultController::class, 'getsetPage']);
    Route::get('/two', [TwoController::class, 'getreaultPage']);
    Route::get('/enrich/{pos}', [TwoController::class, 'getenrichPage']);
    Route::get('/enrichresult/{pos}', [TwoController::class, 'getenenrichresultPage']);
});
#单组学
#Route::get('/upload', [UploadController::class, 'getUploadPage']);
Route::get('/upload', [TwoController::class, 'getTwoPage']);
Route::get('/canshu', [UploadController::class, 'canshu']);
Route::get('/examplecanshu', [UploadController::class, 'examplecanshu']);
#多组学
Route::get('/mutil', [TwoController::class, 'getTwoPage']);
Route::get('/mutilcanshu', [TwoController::class, 'canshu']);
Route::get('/mutilexamplecanshu', [TwoController::class, 'examplecanshu']);

Route::post('/uploadfile', [UploadController::class, 'upload']);

Route::group(['prefix' => '/download'], function () {
    Route::get('/example/{filename}', [DownloadController::class, 'exampleFile']);
    Route::get('/file/{filename}', [DownloadController::class, 'file']);
});
