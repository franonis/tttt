<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DownloadController;

class DownloadController extends Controller
{
    public function exampleFile($file)
    {
        #Event::fire(new FileDownload($file));
        return response()->download(storage_path('example/sourcefile/' . $file));
    }

    public function png($file)
    {
        #Event::fire(new FileDownload($file));
        #dd($file);
        $file=preg_replace('/\+/', "/", $file);
        #return view('202');
        return response()->download(storage_path('public/' . $file));
    }
}
