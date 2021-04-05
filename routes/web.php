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
    return view('welcome');
});
Route::get('/home', function () {
    return view('cross');
});
Route::get('/single', function () {
    return view('upload');
});
Route::get('/intra', function () {
    return view('uploadtwo');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/disease', function () {
    return view('disease');
});
Route::get('/tmp', function () {
    return view('statistics');
});
Route::get('/searchdisease', [BabaController::class, 'searchdisease']);
Route::get('/diseasetable/f{name}', [BabaController::class, 'diseasetable']);
Route::get('/detable/f{name}', [BabaController::class, 'detable']);

Route::get('/pdf/{name}', [PdfController::class, 'getpdf']);

Route::group(['prefix' => '/update'], function () {
    Route::get('/updatePCA', [UpdateController::class, 'updatePCA']);
    Route::get('/updatelipVolcano', [UpdateController::class, 'updatelipVolcano']);#
    Route::get('/updatelipHeatmap', [UpdateController::class, 'updatelipHeatmap']);
    Route::get('/updateliphead', [UpdateController::class, 'updateliphead']);
    Route::get('/updatelipfa', [UpdateController::class, 'updatelipfa']);
    Route::get('/updatelipenrich', [UpdateController::class, 'updatelipenrich']);
    Route::get('/updaternaHeatmap', [UpdateController::class, 'updaternaHeatmap']);
    Route::post('/updaternaHeatmap', [UpdateController::class, 'updaternaHeatmap']);
    Route::get('/updaternaVolcano', [UpdateController::class, 'updaternaVolcano']);
    Route::get('/updaternaenrich', [UpdateController::class, 'updaternaenrich']);
    Route::get('/updatemetHeatmap', [UpdateController::class, 'updatemetHeatmap']);
    Route::get('/updatemetVolcano', [UpdateController::class, 'updatemetVolcano']);
    Route::get('/updatemetenrich', [UpdateController::class, 'updatemetenrich']);
    Route::get('/updateproHeatmap', [UpdateController::class, 'updateproHeatmap']);
    Route::get('/updateproVolcano', [UpdateController::class, 'updateproVolcano']);
    Route::get('/updateproenrich', [UpdateController::class, 'updateproenrich']);
});

Route::group(['prefix' => '/result'], function () {
    Route::get('/set', [ResultController::class, 'getsetPage']);
    Route::get('/two', [TwoController::class, 'getreaultPage']);
    Route::get('/twotwo', [TwoController::class, 'gettwotwoPage']);
    Route::get('/enrich/{pos}', [TwoController::class, 'getenrichPage']);
    Route::get('/enrichresult/{pos}', [TwoController::class, 'getenenrichresultPage']);
    Route::get('/enrichresultgene', [TwoController::class, 'getenenrichresultgenePage']);
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
Route::post('/uploadfilemutil', [TwoController::class, 'upload']);

Route::group(['prefix' => '/download'], function () {
    Route::get('/example/{filename}', [DownloadController::class, 'exampleFile']);
    Route::get('/file/{filename}', [DownloadController::class, 'file']);
    Route::get('/zip/{filename}', [DownloadController::class, 'zip']);
    Route::get('/mar/{filename}', [DownloadController::class, 'mar']);
    Route::get('/rna/{filename}', [DownloadController::class, 'rna']);
});
