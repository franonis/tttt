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
        $path_datafile = 'uploads/' . $omics . $file_data . md5($file_data) . '/' . $file_data;
        $path_descfile = 'uploads/' . $omics . $file_desc . md5($file_desc) . '/' . $file_desc;

        #输出文件位置
        $outpath = 'uploads/' . $omics . $file_data . $file_desc . md5($file_data . $file_desc) . '/';
        is_dir($outpath) or mkdir($outpath, 0777, true);

        if ($omics != "rna") {

            #设置t值
            $t = ['lipidomics' => 'LipidSearch', 'metabonomics' => 'Metabolites', 'proteinomics' => 'Proteins'];

            $command = 'Rscript /home/zhangqb/program/dev/options/inputFileOpts.R -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -t "' . $t[$omics] . '" -l F -n "" -p "/home/zhangqb/tttt/public/' . $outpath . '" ';
            if (!$this->isRunOver($outpath . 'groupsLevel.csv')) {
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR']);
                }
            }

            if ($this->isRunOver($outpath . 'groupsLevel.csv')) {
                #读取参数
                $groupsLevel = file_get_contents($outpath . '/groupsLevel.csv');
                preg_match_all("/\"(.*?)\"/U", $groupsLevel, $groupsLevels);
                array_shift($groupsLevels[1]); #去掉第一行
                $groupsLevels = $groupsLevels[1];
                $firstlines = file_get_contents($outpath . '/firstline.csv');
                preg_match_all("/\"(.*?)\"/U", $firstline, $firstlines);
                array_shift($firstlines[1]); #去掉第一行
                $firstline = $firstlines[1];
                return view('canshu', ['title' => '设置参数', 'groupsLevels' => $groupsLevels, 'omics' => $omics, 'file_data' => $file_data, 'file_desc' => $file_desc, 'firstlines' => $firstlines]);
            }
        } else {
            $command = 'Rscript /home/zhangqb/program/dev/options/inputFileOpts_RNA.R -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -p "/home/zhangqb/tttt/public/' . $outpath . '" ';
            #dd($command);
            if (!$this->isRunOver($outpath . 'groupsLevel.csv')) {
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR']);
                }
            }

            if (!$this->isRunOver($outpath . 'groupsLevel.csv')) {
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR']);
                }
            }
            if ($this->isRunOver($outpath . 'groupsLevel_RNA.csv')) {
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
        $file_data = ['lipidomics' => 'HANlipid_tidy.csv', 'lipidomicscos' => 'Cos7_integ_2.csv', 'metabonomics' => 'HANgene_tidy.CSV', 'rnahan' => 'HANgene_tidy_geneid_allgroups.CSV', 'rna' => 'gene_tidy.CSV', 'proteinomics' => 'lipid_tidy2.CSV'];
        $file_desc = ['lipidomics' => 'HANsampleList_lipid.CSV', 'lipidomicscos' => 'Cos7_integ_sampleList.csv', 'metabonomics' => 'HANsampleList.CSV', 'rnahan' => 'HANsampleList_allgroups.CSV', 'rna' => 'sampleList.CSV', 'proteinomics' => 'sampleList_lip.csv'];
        #foreach ($file_data as $omics => $file) {
        #    $path_datafile = 'uploads/' . $omics . $file_data[$exam_omics] . md5($file_data[$exam_omics]);
        #    $path_descfile = 'uploads/' . $omics . $file_desc[$exam_omics] . md5($file_desc[$exam_omics]);
        #    $outpath = 'uploads/' . $omics . $file_data[$exam_omics] . $file_desc[$exam_omics] . md5($file_data[$exam_omics] . $file_desc[$exam_omics]) . '/';
        #    is_dir($outpath) or mkdir($outpath, 0777, true);
        #    is_dir($path_datafile) or mkdir($path_datafile, 0777, true);
        #    is_dir($path_descfile) or mkdir($path_descfile, 0777, true);
        #move($path_datafile,$file_data[$exam_omics]);
        #move($path_descfile,$file_desc[$exam_omics]);
        #}
        $omics = $request->exampleomics;
        $exam_omics = $omics;
        if ($exam_omics == "lipidomics" || $exam_omics == "lipidomicscos") {
            $omics = "lipidomics";
        }
        if ($exam_omics == "rna" || $exam_omics == "rnahan") {
            $omics = "rna";
        }
        $path_datafile = 'uploads/' . $omics . $file_data["rnahan"] . md5($file_data["rnahan"]);
        $path_descfile = 'uploads/' . $omics . $file_desc["rnahan"] . md5($file_desc["rnahan"]);
        is_dir($path_datafile) or mkdir($path_datafile, 0777, true);
        is_dir($path_descfile) or mkdir($path_descfile, 0777, true);

        $outpath = 'uploads/' . $omics . $file_data[$exam_omics] . $file_desc[$exam_omics] . md5($file_data[$exam_omics] . $file_desc[$exam_omics]) . '/';
        is_dir($outpath) or mkdir($outpath, 0777, true);
        $path_datafile = 'uploads/' . $omics . $file_data[$exam_omics] . md5($file_data[$exam_omics]) . '/' . $file_data[$exam_omics];
        $path_descfile = 'uploads/' . $omics . $file_desc[$exam_omics] . md5($file_desc[$exam_omics]) . '/' . $file_desc[$exam_omics];

        if ($omics != "rna") {
            $t = ['lipidomics' => 'LipidSearch', 'metabonomics' => 'Metabolites', 'proteinomics' => 'Proteins'];

            $command = 'Rscript /home/zhangqb/program/dev/options/inputFileOpts.R -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -t "' . $t[$exam_omics] . '" -l F -n "" -p "/home/zhangqb/tttt/public/' . $outpath . '" ';

            if (!$this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'groupsLevel.csv')) {
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR']);
                }
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
                return view('canshu', ['title' => '设置参数', 'groupsLevels' => $groupsLevels, 'omics' => $omics, 'file_data' => $file_data[$exam_omics], 'file_desc' => $file_desc[$exam_omics], 'firstlines' => $firstlines]);
            }
        } else {
            $command = 'Rscript /home/zhangqb/program/dev/options/inputFileOpts_RNA.R -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -p "/home/zhangqb/tttt/public/' . $outpath . '" ';
            #dd($command);
            if (!$this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'groupsLevel_RNA.csv')) {
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR']);
                }
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'groupsLevel_RNA.csv')) {
                $groupsLevel = file_get_contents($outpath . '/groupsLevel_RNA.csv');
                preg_match_all("/\"(.*?)\"/U", $groupsLevel, $groupsLevels);
                array_shift($groupsLevels[1]); #去掉第一行
                $groupsLevels = $groupsLevels[1];
                return view('canshurna', ['title' => '设置参数', 'groupsLevels' => $groupsLevels, 'omics' => $omics, 'file_data' => $file_data[$exam_omics], 'file_desc' => $file_desc[$exam_omics]]);
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
