<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrossController extends Controller
{
    
#设置例子的参数
    public function crosscanshu(Request $request)
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
