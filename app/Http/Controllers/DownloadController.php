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
}
