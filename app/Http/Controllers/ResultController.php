<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ResultController;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function getSetPage(Request $request)
    {
        $omics = $request->omics;
        #dd($omics);
        if ($omics == "rna") {

            return view('resultrna', ['title' => '上传数据']);
        } elseif ($omics == "lipidomics") {
            return view('resultlip', ['title' => '上传数据']);
        } else {
            return view('resultmet', ['title' => '上传数据']);
        }

    }
    public function getcrossPage(Request $request)
    {

        $image = 'images/cross.png';
        $size = getimagesize($image);
        $bgwidth = $size[0] * 1.02;
        $bgheigh = $size[1] * 1.02;
        $k1 = 3;
        $k2 = 4;
        $fgwidth = floor($size[0] / $k1);
        $fgheigh = floor($size[1] / $k2);

        #dd($fgwidth);
        return view('crossresult', ['image' => $image, 'bgwidth' => $bgwidth, 'bgheigh' => $bgheigh, 'fgwidth' => $fgwidth, 'fgheigh' => $fgheigh, 'k1' => $k1, 'k2' => $k2]);
    }
}
