<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TwoController;
use Illuminate\Http\Request;

class TwoController extends Controller
{
    private $home;
    public function getTwoPage()
    {
        return view('uploadtwo', ['title' => 'upload']);
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
        if ($request->delodd) {
            $delodd = "T";
        }else{
            $delodd = "F";
        }
        $path_datafile = 'uploads/' . $omics . $file_data . md5($file_data) . '/' . $file_data;
        $path_descfile = 'uploads/' . $omics . $file_desc . md5($file_desc) . '/' . $file_desc;

        #输出文件位置
        $outpath = 'uploads/' . $omics . $file_data . $file_desc . md5($file_data . $file_desc) . '/';
        is_dir($outpath) or mkdir($outpath, 0777, true);

        if ($omics != "Transcriptomics") {
            $t = ['Lipidomics' => 'LipidSearch', 'Metabolomics' => 'Metabolites', 'Proteomics' => 'Proteins'];

            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/options/inputFileOpts.R -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -t "' . $t[$omics] . '" -l F -n "" -p "/home/zhangqb/tttt/public/' . $outpath . '" ';

            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'groupsLevel.csv')) {
                $groupsLevel = file_get_contents($outpath . '/groupsLevel.csv');
                preg_match_all("/\"(.*?)\"/U", $groupsLevel, $groupsLevels);
                array_shift($groupsLevels[1]); #去掉第一行
                $groupsLevels = $groupsLevels[1];
                #dd($groupsLevels[1]);
                $firstline = file_get_contents($outpath . '/firstline.csv');
                preg_match_all("/\"(.*?)\"/U", $firstline, $firstlines);
                array_shift($firstlines[1]); #去掉第一行
                $firstlines = $firstlines[1];
                return view('canshu', ['title' => '设置参数', 'groupsLevels' => $groupsLevels, 'omics' => $omics, 'file_data' => $file_data, 'file_desc' => $file_desc, 'firstlines' => $firstlines, 'delodd' => $delodd]);
            }
        } else {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/options/inputFileOpts_RNA.R -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -p "/home/zhangqb/tttt/public/' . $outpath . '" ';
            #dd($command);
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'groupsLevel_RNA.csv')) {
                $groupsLevel = file_get_contents($outpath . '/groupsLevel_RNA.csv');
                preg_match_all("/\"(.*?)\"/U", $groupsLevel, $groupsLevels);
                array_shift($groupsLevels[1]); #去掉第一行
                $groupsLevels = $groupsLevels[1];
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
        #$omicsss = ['a' => 'Lipidomics', 'b' => 'Lipidomicscos', 'c' => 'Metabolomics', 'd' => 'Transcriptomicshan', 'e' => 'Transcriptomics', 'f' => 'Proteomics'];
        $file_data = ['Lipidomics' => 'HANlipid_tidy.csv', 'Lipidomicscos' => 'Cos7_integ_2.csv', 'Metabolomics' => 'metabolites_tidy2.csv', 'Transcriptomicshan' => 'HANgene_tidy_geneid_allgroups.CSV', 'Transcriptomics' => 'gene_tidy.CSV', 'Proteomics' => 'proteins_Depletion_tidy.csv'];
        $file_desc = ['Lipidomics' => 'HANsampleList_lipid.CSV', 'Lipidomicscos' => 'Cos7_integ_sampleList.csv', 'Metabolomics' => 'sampleList_lip.csv', 'Transcriptomicshan' => 'HANsampleList_allgroups.CSV', 'Transcriptomics' => 'sampleList.CSV', 'Proteomics' => 'sampleList_lip.csv'];
        #foreach ($omicsss as $num => $omics) {
        #    $path_datafile = 'uploads/' . $omics . $file_data[$num] . md5($file_data[$num]);
        #    $path_descfile = 'uploads/' . $omics . $file_desc[$num] . md5($file_desc[$num]);
        #    $outpath = 'uploads/' . $omics . $file_data[$num] . $file_desc[$num] . md5($file_data[$num] . $file_desc[$num]) . '/';
        #    is_dir($outpath) or mkdir($outpath, 0777, true);
        #    is_dir($path_datafile) or mkdir($path_datafile, 0777, true);
        #    is_dir($path_descfile) or mkdir($path_descfile, 0777, true);
        #}
        $omics = $request->exampleomics;
        $exam_omics = $omics;
        if ($exam_omics == "Lipidomics" || $exam_omics == "Lipidomicscos") {
            $omics = "Lipidomics";
        }
        if ($exam_omics == "Transcriptomics" || $exam_omics == "Transcriptomicshan") {
            $omics = "Transcriptomics";
        }
        
        $outpath = 'uploads/' . $omics . $file_data[$exam_omics] . $file_desc[$exam_omics] . md5($file_data[$exam_omics] . $file_desc[$exam_omics]) . '/';
        is_dir($outpath) or mkdir($outpath, 0777, true);
        $path_datafile = 'uploads/' . $omics . $file_data[$exam_omics] . md5($file_data[$exam_omics]) . '/' . $file_data[$exam_omics];
        $path_descfile = 'uploads/' . $omics . $file_desc[$exam_omics] . md5($file_desc[$exam_omics]) . '/' . $file_desc[$exam_omics];
        $t = ['Lipidomics' => 'LipidSearch', 'Lipidomicscos' => 'LipidSearch', 'Metabolomics' => 'Metabolites', 'Transcriptomicshan' => 'rna', 'Transcriptomics' => 'microarray', 'Proteomics' => 'Proteins'];
        if ($omics != "Transcriptomics") {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/options/inputFileOpts.R -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -t "' . $t[$omics] . '" -l F -n "" -p "/home/zhangqb/tttt/public/' . $outpath . '" ';

            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'groupsLevel.csv')) {
                $groupsLevel = file_get_contents($outpath . '/groupsLevel.csv');
                preg_match_all("/\"(.*?)\"/U", $groupsLevel, $groupsLevels);
                array_shift($groupsLevels[1]); #去掉第一行
                $groupsLevels = $groupsLevels[1];
                #dd($groupsLevels[1]);
                return view('canshu', ['data_type' => $t[$omics], 'groupsLevels' => $groupsLevels, 'omics' => $omics, 'file_data' => $file_data[$exam_omics], 'file_desc' => $file_desc[$exam_omics], 'delodd' => "F"]);
            }
        } else {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/options/inputFileOpts_RNA.R -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -p "/home/zhangqb/tttt/public/' . $outpath . '" ';
            #dd($command);
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'groupsLevel_RNA.csv')) {
                $groupsLevel = file_get_contents($outpath . '/groupsLevel_RNA.csv');
                preg_match_all("/\"(.*?)\"/U", $groupsLevel, $groupsLevels);
                array_shift($groupsLevels[1]); #去掉第一行
                $groupsLevels = $groupsLevels[1];
                return view('canshurna', ['data_type' => $t[$omics], 'groupsLevels' => $groupsLevels, 'omics' => $omics, 'file_data' => $file_data[$exam_omics], 'file_desc' => $file_desc[$exam_omics]]);
            }
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
