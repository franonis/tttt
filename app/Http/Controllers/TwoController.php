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
        $example = $request->exampleomics;
        if ($example == "Example1") {
            $outpath = '/enrich/example1'.md5("HANLipidMediator_imm_forcor.CSVHANsampleList_lipmid.csvHANsampleList.CSV").'/';
            is_dir($outpath) or mkdir($outpath, 0777, true);
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/correlation/correlation_main.R -i "/home/zhangqb/program/branch/benchmark/input/HANLipidMediator_imm_forcor.CSV" -d "/home/zhangqb/program/branch/benchmark/input/HANsampleList_lipmid.csv" -t "Metabolites" -l F -m 0.67 -j "/home/zhangqb/program/branch/benchmark/input/HANgene_tidy.CSV" -e "/home/zhangqb/program/branch/benchmark/input/HANsampleList.CSV" -u "RNAseq" -g 6 -k 4 -n F -s 0.4 -o "' . $outpath . '"';
            return view('canshutwo', ['t' => '设置参数', 'l' => "F", 'm' => "0.67", 'u' => "RNAseq", 'g' => "6", 'k' => "4", 'n' => "F", 's' => "0.4", 'outpath' => $outpath]);
        }
        if ($example == "Example2") {
            $outpath = '/enrich/example2'.md5("lipids.csvRNAseq_genesymbol.csvsampleList.csv").'/';
            is_dir($outpath) or mkdir($outpath, 0777, true);
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/correlation/correlation_main.R -i "/home/zhangqb/program/testData/SVFmultiomics_210118/input/lipids.csv" -d "/home/zhangqb/program/testData/SVFmultiomics_210118/input/sampleList.csv" -t "Lipids" -l T -m 0.67 -j "/home/zhangqb/program/testData/SVFmultiomics_210118/input/RNAseq_genesymbol.csv" -e "/home/zhangqb/program/testData/SVFmultiomics_210118/input/sampleList.csv" -u "RNAseq" -g 7 -k 6 -n T -o "' . $outpath . '"';
            return view('canshutwo', ['t' => '设置参数', 'l' => "T", 'm' => "0.67", 'u' => "RNAseq", 'g' => "7", 'k' => "6", 'n' => "T", 'outpath' => $outpath]);
        }
        if ($example == "Example3") {
            $outpath = '/enrich/example3'.md5("metabolites.csvRNAseq_genesymbol.csvsampleList.csv").'/';
            is_dir($outpath) or mkdir($outpath, 0777, true);
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/correlation/correlation_main.R -i "/home/zhangqb/program/testData/SVFmultiomics_210118/input/metabolites.csv" -d "/home/zhangqb/program/testData/SVFmultiomics_210118/input/sampleList.csv" -t "Metabolites" -m 0.67 -j "/home/zhangqb/program/testData/SVFmultiomics_210118/input/RNAseq_genesymbol.csv" -e "/home/zhangqb/program/testData/SVFmultiomics_210118/input/sampleList.csv" -u "RNAseq" -g 7 -k 6 -n T -o "' . $outpath . '"';
            return view('canshutwo', ['t' => '设置参数', 'l' => "F", 'm' => "0.67", 'u' => "RNAseq", 'g' => "7", 'k' => "6", 'n' => "T", 'outpath' => $outpath]);
        }
        if ($example == "Example4") {
            $outpath = '/enrich/example4'.md5("metabolites_tidy2.csvproteins_Depletion_tidy.csvsampleList_lip.csv").'/';
            is_dir($outpath) or mkdir($outpath, 0777, true);
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/correlation/correlation_main.R -i "/home/zhangqb/program/testData/CerebrospinalFluid_multiomics/input/metabolites_tidy2.csv" -d "/home/zhangqb/program/testData/CerebrospinalFluid_multiomics/input/sampleList_lip.csv" -t "Metabolites" -m 0.67 -j "/home/zhangqb/program/testData/CerebrospinalFluid_multiomics/input/proteins_Depletion_tidy.csv" -e "/home/zhangqb/program/testData/CerebrospinalFluid_multiomics/input/sampleList_lip.csv" -u "Proteins" -g 7 -k 6 -n F -s 0.82 -o "' . $outpath . '"';
            return view('canshutwo', ['t' => '设置参数', 'l' => "F", 'm' => "0.67", 'u' => "Proteins", 'g' => "7", 'k' => "6", 'n' => "F", 's' => "0.82", 'outpath' => $outpath]);
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
