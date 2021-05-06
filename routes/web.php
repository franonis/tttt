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
Route::get('/nametable/f{name}', [BabaController::class, 'nametable']);

Route::get('/pdf/{name}', [PdfController::class, 'getpdf']);

Route::group(['prefix' => '/update'], function () {
    Route::any('/updatePCA/{data}', [UpdateController::class, 'updatePCA']);
    Route::any('/updatelipVolcano/{data}', [UpdateController::class, 'updatelipVolcano']);#
    Route::any('/updatelipHeatmap/{data}', [UpdateController::class, 'updatelipHeatmap']);
    Route::any('/updateliphead/{data}', [UpdateController::class, 'updateliphead']);
    Route::any('/updatelipheadheatmap/{data}', [UpdateController::class, 'updatelipheadheatmap']);
    Route::any('/updatelipfa/{data}', [UpdateController::class, 'updatelipfa']);
    Route::any('/updatelipenrich/{data}', [UpdateController::class, 'updatelipenrich']);
    Route::any('/updaternaHeatmap/{data}', [UpdateController::class, 'updaternaHeatmap']);
    Route::any('/updaternaVolcano/{data}', [UpdateController::class, 'updaternaVolcano']);
    Route::any('/updaternaenrich/{data}', [UpdateController::class, 'updaternaenrich']);
    Route::any('/updatemetHeatmap/{data}', [UpdateController::class, 'updatemetHeatmap']);
    Route::any('/updatemetVolcano/{data}', [UpdateController::class, 'updatemetVolcano']);
    Route::any('/updatemetenrich/{data}', [UpdateController::class, 'updatemetenrich']);
    Route::any('/updateproHeatmap/{data}', [UpdateController::class, 'updateproHeatmap']);
    Route::any('/updateproVolcano/{data}', [UpdateController::class, 'updateproVolcano']);
    Route::any('/updateproenrich/{data}', [UpdateController::class, 'updateproenrich']);
    Route::any('/updatemutilenrich/{data}', [UpdateController::class, 'updatemutilenrich']);
    Route::any('/updatemutilcircos/{data}', [UpdateController::class, 'updatemutilcircos']);
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
Route::get('/upload', [UploadController::class, 'getUploadPage']);
#Route::post('/upload', [TwoController::class, 'getTwoPage']);
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
