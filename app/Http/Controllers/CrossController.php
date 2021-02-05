<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\CrossController;

class CrossController extends Controller
{
    
#设置例子的参数
    public function crosscanshu(Request $request)
    {
        $example = $request->exampleomics;
        if ($example == "Example1") {
            $command = "Lipidomics";
        }
        if ($example == "Example2") {
            $command = "Transcriptomics";
        }
        if ($example == "Example3") {
            $command = "Lipidomics";
        }
        if ($example == "Example4") {
            $command = "Transcriptomics";
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

    private function isRunOver($file)
    {
        return file_exists($file) ? true : false;
    }

    public function crosscanshu1(Request $request)
    {
        $omics = $request->omics;
        $omics = $request->omics;
        $omics = $request->omics;
        return view('crosscanshu', ['title' => '设置参数']);
    }
}
