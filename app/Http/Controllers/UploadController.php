<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UploadController;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    private $home;
    public function getUploadPage()
    {
        return view('upload', ['title' => 'upload']);
    }

    public function upload(Request $request)
    {
        #dd("vv");
        $file = $request->file('file');
        #dd($file);
        $allowed_extensions = ["csv", "txt", "CSV"]; //多类型
        //判断文件是否是允许上传的文件类型
        if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            $data = [
                'status' => 0, //返回状态码，在js中用改状态判断是否上传成功。
                'msg' => '不支持此格式',
            ];
            return json_encode($data);
        }

        //保存文件，新建路径，拷贝文件
        //路径都是public--uploads下的文件名的md5值
        $path = md5($file->getClientOriginalName());
        $destinationPath = 'uploads/' . $path . '/';
        is_dir($destinationPath) or mkdir($destinationPath, 0777, true);
        $extension = $file->getClientOriginalExtension();
        $fileName = $extension;
        $file->move($destinationPath, $file->getClientOriginalName());
        $data = [
            'status' => 1, //返回状态码，在js中用改状态判断是否上传成功。
            'msg' => $destinationPath . $fileName, //上传成功，返回服务器上文件名字
            'originalname' => $file->getClientOriginalName(), //上传成功，返回上传原文件名字
            'file' => $file, //上传成功，返回上传原文件名字
        ];
        return json_encode($data);

    }
    #设置参数
    public function canshu(Request $request)
    {
        $omics = $request->omics;
        if ($request->file_datafile == "no data" || $request->file_descfile == "no data") {
            return view('errors.200', ['title' => 'No Data', 'msg' => 'Please upload your file!', 'back' => 'Go back upload Page']);
        }
        $file_data = $request->file_datafile;
        $file_desc = $request->file_descfile;
        $path_datafile = 'uploads/' . md5($file_data) . '/' . $file_data;
        $path_descfile = 'uploads/' . md5($file_desc) . '/' . $file_desc;

        #输出文件位置
        $outpath = 'uploads/' . md5($file_data . $file_desc) . '/';
        is_dir($outpath) or mkdir($outpath, 0777, true);

        if ($omics != "rna") {

            #设置t值
            $t = ['lipidomics' => 'LipidSearch', 'metabonomics' => 'Metabolites', 'proteinomics' => 'Proteins'];

            $command = 'Rscript /home/zhangqb/program/dev/options/inputFileOpts.R -i "' . $path_datafile . '" -d "' . $path_datafile . '" -t "' . $t[$omics] . '" -l F -n "" -p "' . $outpath . '" ';
            #dd($command);

            try {
                exec($command);
            } catch (\Exception $e) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR']);
            }
            if ($this->isRunOver($outpath . 'groupsLevel.csv')) {
                #读取参数
                $groupsLevel = file_get_contents($outpath . '/groupsLevel.csv');
                $groupsLevels = explode("\n", $groupsLevel);
                array_shift($groupsLevels); #去掉第一行和最后一行
                array_pop($groupsLevels);
                $firstline = file_get_contents($outpath . '/firstline.csv');
                $firstlines = explode("\n", $firstline);
                array_shift($firstlines);
                array_pop($firstlines);
                return view('canshu', ['title' => '设置参数', 'groupsLevels' => $groupsLevels, 'omics' => $omics, 'file_data' => $file_data, 'file_desc' => $file_desc, 'firstlines' => $firstlines]);
            }
        } else {
            $command = 'Rscript /home/zhangqb/program/dev/options/inputFileOpts_RNA.R -d "' . $path_descfile . '" -p "' . $outpath . '" ';
            #dd($command);

            try {
                exec($command);
            } catch (\Exception $e) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR']);
            }
            if ($this->isRunOver($outpath . 'groupsLevel_RNA.csv')) {
                $groupsLevel = file_get_contents($outpath . '/groupsLevel_RNA.csv');
                $groupsLevels = explode("\n", $groupsLevel);
                array_shift($groupsLevels); #去掉第一行和最后一行
                array_pop($groupsLevels);
                return view('canshurna', ['title' => '设置参数', 'groupsLevels' => $groupsLevels, 'omics' => $omics, 'file_data' => $file_data, 'file_desc' => $file_desc]);
            }
        }

    }
    private function isRunOver($file)
    {
        return file_exists($file) ? true : false;
    }
#设置例子的参数
    public function examplecanshu(Request $request)
    {
        $file_data = ['lipidomics' => 'Cos7_integ_2.csv', 'metabonomics' => 'HANgene_tidy.CSV', 'rna' => 'gene_tidy.CSV', 'proteinomics' => 'lipid_tidy2.CSV'];
        $file_desc = ['lipidomics' => 'Cos7_integ_sampleList.csv', 'metabonomics' => 'HANsampleList.CSV', 'rna' => 'sampleList.CSV', 'proteinomics' => 'sampleList_lip.csv'];
        $omics = $request->exampleomics;
        if ($omics != "rna") {
            $groupsLevel = file_get_contents(storage_path('example/') . $omics . '/groupsLevel.csv');
            $groupsLevels = explode("\n", $groupsLevel);
            array_shift($groupsLevels); #去掉第一行和最后一行
            array_pop($groupsLevels);
            $firstline = file_get_contents(storage_path('example/') . $omics . '/firstline.csv');
            $firstlines = explode("\n", $firstline);
            array_shift($firstlines);
            array_pop($firstlines);
            return view('canshu', ['title' => '设置参数', 'groupsLevels' => $groupsLevels, 'omics' => $omics, 'file_data' => $file_data[$omics], 'file_desc' => $file_desc[$omics], 'firstlines' => $firstlines]);
        } else {
            $groupsLevel = file_get_contents(storage_path('example/') . $omics . '/groupsLevel_RNA.csv');
            $groupsLevels = explode("\n", $groupsLevel);
            array_shift($groupsLevels); #去掉第一行和最后一行
            array_pop($groupsLevels);
            return view('canshurna', ['title' => '设置参数', 'groupsLevels' => $groupsLevels, 'omics' => $omics, 'file_data' => $file_data[$omics], 'file_desc' => $file_desc[$omics]]);
        }

    }

    public function crosscanshu(Request $request)
    {
        $omics = $request->omics;
        $omics = $request->omics;
        $omics = $request->omics;
        return view('crosscanshu', ['title' => '设置参数']);
    }
}
