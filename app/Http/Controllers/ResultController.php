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
        $file_data = $request->file_data;
        $file_desc = $request->file_desc;
        $groupsLevel = $request->groupsLevel;
        $data_type = $request->data_type;
        #输出文件路径
        $outpath = 'uploads/' . $omics . $file_data . $file_desc . md5($file_data . $file_desc) . '/';
        is_dir($outpath . 'results2') or mkdir($outpath . 'results2', 0777, true);
        #输入文件路径
        $path_datafile = 'uploads/' . $omics . $file_data . md5($file_data) . '/' . $file_data;
        $path_descfile = 'uploads/' . $omics . $file_desc . md5($file_desc) . '/' . $file_desc;
        #dd($omics);
        if ($omics == "rna") {

            $control = $request->control;
            $normalization = $request->normalization;
            #processing_RNA

            if ($data_type == "rna") {
                $command = 'Rscript /home/zhangqb/program/dev/main_split/processing_RNA.R -a "' . $groupsLevel . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -c "' . $control . '" -o "/home/zhangqb/tttt/public/' . $outpath . 'results2/"  -t RNAseq -p "/home/zhangqb/tttt/public/' . $outpath . '"';
            } else {
                $command = 'Rscript /home/zhangqb/program/dev/main_split/processing_RNA.R -a "' . $groupsLevel . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -c "' . $control . '" -o "/home/zhangqb/tttt/public/' . $outpath . 'results2/" -n ' . $normalization . ' -t MiAr -p "/home/zhangqb/tttt/public/' . $outpath . '"';
            }
            #Rscript  -a "Ly6ChighD4" -i "./branch/benchmark/input/HANgene_tidy_geneid_allgroups.CSV" -d "./branch/benchmark/input/HANsampleList_allgroups.CSV" -c "PMND1" -o "~/temp/results2/"  -t "RNAseq" -p "~/temp/"

            #dd($command);
            try {
                exec($command);
            } catch (\Exception $e) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
                $path = '/home/zhangqb/tttt/public/' . $outpath;
                $pic_path = $path . 'results/';
                is_dir($pic_path) or mkdir($pic_path, 0777, true);

                $command = 'Rscript /home/zhangqb/program/dev/main_split/show_variability.R -r "' . $path . '" -o "' . $pic_path . '"';
                #dd($command);
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                }
                #火山图Rscript rnaVolcanoPlot.R -r "~/temp/" -s "~/temp/results2/" -f 2.0 -p 0.1 -u 20
                $command = 'Rscript /home/zhangqb/program/dev/main_split/rnaVolcanoPlot.R -r "' . $path . '" -s "' . $pic_path . '" -f 2.0 -p 0.1 -u 20';
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                }
                #热图Rscript rnaHeatmapPlot.R -r "~/temp/" -w "~/temp/results2/" -v 75
                $command = 'Rscript /home/zhangqb/program/dev/main_split/show_variability.R -r "' . $path . '" -w "' . $pic_path . '" -v 75';
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                }

                return view('resultrna', ['title' => '上传数据']);
            }else {
                return view('resultrna', ['title' => '上传数据']);
            }

        } else {
            #参数
            $firstline = $request->firstline;
            $delodd = $request->delodd;
            if ($omics == "lipidomics") {
                #Rscript processing.R -a "all_together" -i "./branch/benchmark/input/HANlipid_tidy.csv" -d "./branch/benchmark/input/HANsampleList_lipid.CSV" -c "" -t "LipidSearch" -f "LipidIon" -l F -o "~/temp/" -n "" -p "~/temp/"
                $command = 'Rscript /home/zhangqb/program/dev/main_split/processing.R -a "' . $groupsLevel . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -t "' . $data_type . '" -c "' . $groupsLevel . '" -f "' . $firstline . '" -l "' . $delodd . '" -o "/home/zhangqb/tttt/public/' . $outpath . 'results2/"  -n "" -p "/home/zhangqb/tttt/public/' . $outpath . '"';
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                }

                if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data_tidy.csv')) {
                    #dd("nidaye");
                    $path = '/home/zhangqb/tttt/public/' . $outpath;
                    #"MARresults","headgroup","FAchainVisual"
                    $pic_path = $path . 'results/';
                    is_dir($pic_path) or mkdir($pic_path, 0777, true);
                    #MAR
                    $mar_path = $path . 'results/MARresults';
                    is_dir($mar_path) or mkdir($mar_path, 0777, true);
                    #head
                    $headgroup_path = $path . 'results/headgroup';
                    is_dir($headgroup_path) or mkdir($headgroup_path, 0777, true);
                    #FA
                    $fa_path = $path . 'results/FAchainVisual';
                    is_dir($fa_path) or mkdir($fa_path, 0777, true);

                    $command = 'Rscript /home/zhangqb/program/dev/main_split/lipPCAPlot.R -r "' . $path . '" -q "' . $mar_path . '"';
                    #dd($command);

                    try {
                        exec($command);
                    } catch (\Exception $e) {
                        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                    }

                    $command = 'Rscript /home/zhangqb/program/dev/main_split/lipVolcanoPlot.R -r "' . $path . '" -s F -p "' . $mar_path . '" -b F -x "raw" -j 2 -k 0.1 -m 10 -w T ';
                    try {
                        exec($command);
                    } catch (\Exception $e) {
                        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                    }

                    $command = 'Rscript /home/zhangqb/program/dev/main_split/lipHeatmapPlot.R -r "' . $path . '" -y "' . $mar_path . '" -e 75';

                    try {
                        exec($command);
                    } catch (\Exception $e) {
                        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                    }

                    $command = 'Rscript /home/zhangqb/program/dev/main_split/headgroupStat.R -r "' . $path . '" -u "' . $headgroup_path . '" -w T';

                    try {
                        exec($command);
                    } catch (\Exception $e) {
                        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                    }

                    $command = 'Rscript /home/zhangqb/program/dev/main_split/FAchainStat.R -r "' . $path . '" -v "' . $fa_path . '" -g "FA_info" -w T';

                    try {
                        exec($command);
                    } catch (\Exception $e) {
                        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                    }
                    return view('resultlip', ['title' => '上传数据']);

                }

                #dd($command);
            } else {
                $command = 'Rscript /home/zhangqb/program/dev/main_split/processing.R -a "' . $groupsLevel . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -t "' . $data_type . '" -c "' . $groupsLevel . '" -f "' . $firstline . '" -l "' . $delodd . '" -o "/home/zhangqb/tttt/public/' . $outpath . 'results2/"  -n "" -p "/home/zhangqb/tttt/public/' . $outpath . '"';
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                }

                if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data_tidy.csv')) {
                    #dd("nidaye");
                    $path = '/home/zhangqb/tttt/public/' . $outpath;
                    #"MARresults","headgroup","FAchainVisual"
                    $pic_path = $path . 'results/';
                    is_dir($pic_path) or mkdir($pic_path, 0777, true);
                    #MAR
                    $mar_path = $path . 'results/MARresults';
                    is_dir($mar_path) or mkdir($mar_path, 0777, true);
                    #head
                    $headgroup_path = $path . 'results/headgroup';
                    is_dir($headgroup_path) or mkdir($headgroup_path, 0777, true);
                    #FA
                    $fa_path = $path . 'results/FAchainVisual';
                    is_dir($fa_path) or mkdir($fa_path, 0777, true);

                    $command = 'Rscript /home/zhangqb/program/dev/main_split/lipPCAPlot.R -r "' . $path . '" -q "' . $mar_path . '"';
                    #dd($command);

                    try {
                        exec($command);
                    } catch (\Exception $e) {
                        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                    }

                    $command = 'Rscript /home/zhangqb/program/dev/main_split/lipVolcanoPlot.R -r "' . $path . '" -s F -p "' . $mar_path . '" -b F -x "raw" -j 2 -k 0.1 -m 10 -w T ';
                    try {
                        exec($command);
                    } catch (\Exception $e) {
                        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                    }

                    $command = 'Rscript /home/zhangqb/program/dev/main_split/lipHeatmapPlot.R -r "' . $path . '" -y "' . $mar_path . '" -e 75';

                    try {
                        exec($command);
                    } catch (\Exception $e) {
                        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                    }

                    $command = 'Rscript /home/zhangqb/program/dev/main_split/headgroupStat.R -r "' . $path . '" -u "' . $headgroup_path . '" -w T';

                    try {
                        exec($command);
                    } catch (\Exception $e) {
                        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                    }

                    $command = 'Rscript /home/zhangqb/program/dev/main_split/FAchainStat.R -r "' . $path . '" -v "' . $fa_path . '" -g "FA_info" -w T';

                    try {
                        exec($command);
                    } catch (\Exception $e) {
                        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                    }

                #dd($command);
                return view('resultmet', ['title' => '上传数据']);
            }

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
