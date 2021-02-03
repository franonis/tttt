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
        return response()->download(storage_path($file));
    }


    public function dir($file)
    {
    
    //初始化zip 名字
        $zip_file = 'Example.zip';
        $zip = new \ZipArchive();
        $zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        //将被压缩文件夹
        $path = storage_path('/app/files/');
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $name => $file)
        {
            // 我们要跳过所有子目录
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();
                // 用 substr/strlen 获取文件扩展名
                $relativePath = 'invoices/' . substr($filePath, strlen($path) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return response()->download($zip_file);
    }
}
