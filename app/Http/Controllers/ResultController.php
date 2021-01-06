<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ResultController;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function getSetPage(Request $request)
    {
        $omics = $request->omics;
        #设置参数
        $file_data= $request->file_data;
        $file_desc= $request->file_desc;
        $groupsLevel= $request->groupsLevel;
        $data_type= $request->data_type;
        #输出文件路径
        $outpath = 'uploads/' . md5($file_data . $file_desc) . '/';
        $ouput=$outpat.'/results2/';
        #输入文件路径
        $path_datafile = 'uploads/' . md5($file_data) . '/' . $file_data;
        $path_descfile = 'uploads/' . md5($file_desc) . '/' . $file_desc;
        #dd($omics);
        if ($omics == "rna") {

            $control= $request->control;
            $normalization= $request->normalization;
            #processing_RNA
            Rscript processing_RNA.R -a "Ly6ChighD4" -i "./branch/benchmark/input/HANgene_tidy_geneid_allgroups.CSV" -d "./branch/benchmark/input/HANsampleList_allgroups.CSV" -c "PMND1" -o "~/temp/results2/" -n T -t "RNAseq" -p "~/temp/"
            $command = 'Rscript /home/zhangqb/program/dev/options/inputFileOpts_RNA.R -d "' . $path_descfile . '" -p "' . $outpath . '" ';
            #dd($command);

            try {
                exec($command);
            } catch (\Exception $e) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR'.$command]);
            }

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
    private function isRunOver($file)
    {
        return file_exists($file) ? true : false;
    }
}
