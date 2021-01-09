<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ResultController;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function getSetPage(Request $request)
    {
        $omics = $request->omics;
        $file_data = $request->file_data;
        $file_desc = $request->file_desc;
        $groupsLevel = $request->groupsLevel;
        $data_type = $request->data_type;
        $outpath = 'uploads/' . $omics . $file_data . $file_desc . md5($file_data . $file_desc) . '/';
        is_dir($outpath . 'results2') or mkdir($outpath . 'results2', 0777, true);
        $path_datafile = 'uploads/' . $omics . $file_data . md5($file_data) . '/' . $file_data;
        $path_descfile = 'uploads/' . $omics . $file_desc . md5($file_desc) . '/' . $file_desc;
        if ($omics == "rna") {
            $control = $request->control;
            $normalization = $request->normalization;
            if ($data_type == "rna") {
                $command = 'Rscript /home/zhangqb/program/dev/main_split/processing_RNA.R -a "' . $groupsLevel . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -c "' . $control . '" -o "/home/zhangqb/tttt/public/' . $outpath . 'results2/"  -t RNAseq -p "/home/zhangqb/tttt/public/' . $outpath . '"';
            } else {
                $command = 'Rscript /home/zhangqb/program/dev/main_split/processing_RNA.R -a "' . $groupsLevel . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -c "' . $control . '" -o "/home/zhangqb/tttt/public/' . $outpath . 'results2/" -n ' . $normalization . ' -t MiAr -p "/home/zhangqb/tttt/public/' . $outpath . '"';
            }
            #dd($command);
            try {
                exec($command);
            } catch (\Exception $e) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
                $this->showresultrna($outpath);
                return view('resultrna', ['title' => '上传数据', 'path' => $outpath . 'results/']);
            }
        } else {
            $firstline = $request->firstline;
            $delodd = $request->delodd;
            if ($omics == "lipidomics") {
                $command = 'Rscript /home/zhangqb/program/dev/main_split/processing.R -a "' . $groupsLevel . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -t "' . $data_type . '" -c "' . $groupsLevel . '" -f "' . $firstline . '" -l "' . $delodd . '" -o "/home/zhangqb/tttt/public/' . $outpath . 'results2/"  -n "" -p "/home/zhangqb/tttt/public/' . $outpath . '"';
                #dd($command);
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                }
                if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
                    $this->showresultlip($outpath);
                    return view('resultlip', ['title' => '上传数据', 'path' => $outpath . 'results/']);
                }
            } else {
                $command = 'Rscript /home/zhangqb/program/dev/main_split/processing.R -a "' . $groupsLevel . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -t "' . $data_type . '" -c "' . $groupsLevel . '" -f "' . $firstline . '" -l "' . $delodd . '" -o "/home/zhangqb/tttt/public/' . $outpath . 'results2/"  -n "" -p "/home/zhangqb/tttt/public/' . $outpath . '"';
                #dd($command);
                try {
                    exec($command);
                } catch (\Exception $e) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
                }
                if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
                    $this->showresultmet($outpath);
                    return view('resultmet', ['title' => '上传数据', 'path' => $outpath . 'results/']);
                }
            }
        }
    }

    public function showresultrna($path)
    {
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        is_dir($pic_path) or mkdir($pic_path, 0777, true);

        $command = 'Rscript /home/zhangqb/program/dev/main_split/show_variability.R -r "' . $path . '" -o "' . $pic_path . '"';
        #dd($command);
        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'PCA_*.pdf ' . $pic_path . 'PCA_show.png';
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
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'volcano_*.pdf ' . $pic_path . 'volcano_show.png';
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
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'heatmap_allgroups.pdf ' . $pic_path . 'heatmap_allgroups.png';
        $command1 = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'heatmap_top*.pdf ' . $pic_path . 'heatmap_top.png';
        try {
            exec($command);
            exec($command1);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }

        return view('resultrna', ['title' => '上传数据', 'path' => $path . 'results/']);

    }

    public function showresultlip($path)
    {
        #"MARresults","headgroup","FAchainVisual"
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        is_dir($pic_path) or mkdir($pic_path, 0777, true);
        #MAR
        $mar_path = $pic_path . 'MARresults';
        is_dir($mar_path) or mkdir($mar_path, 0777, true);
        #head
        $headgroup_path = $pic_path . 'headgroup';
        is_dir($headgroup_path) or mkdir($headgroup_path, 0777, true);
        #FA
        $fa_path = $pic_path . 'FAchainVisual';
        is_dir($fa_path) or mkdir($fa_path, 0777, true);
        #PCA
        $command = 'Rscript /home/zhangqb/program/dev/main_split/lipPCAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
        #dd($command);

        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        #火山图
        $command = 'Rscript /home/zhangqb/program/dev/main_split/lipVolcanoPlot.R -r "' . $r_path . '" -s F -p "' . $pic_path . '" -b F -x "raw" -j 2 -k 0.1 -m 10 -w T ';
        #dd($command);
        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        #热图
        $command = 'Rscript /home/zhangqb/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e 75';
        #dd($command);
        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        #head group
        $command = 'Rscript /home/zhangqb/program/dev/main_split/headgroupStat.R -r "' . $r_path . '" -u "' . $pic_path . '" -w T';
        #dd($command);
        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        #FAchain
        $command = 'Rscript /home/zhangqb/program/dev/main_split/FAchainStat.R -r "' . $r_path . '" -v "' . $pic_path . '" -g "FA_info" -w T';

        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        return view('resultlip', ['title' => '上传数据', 'path' => $path]);

    }

    public function showresultmet($path)
    {
        #"MARresults","headgroup","FAchainVisual"
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        is_dir($pic_path) or mkdir($pic_path, 0777, true);
        #MAR
        $mar_path = $pic_path . 'MARresults';
        is_dir($mar_path) or mkdir($mar_path, 0777, true);
        #head
        $headgroup_path = $pic_path . 'headgroup';
        is_dir($headgroup_path) or mkdir($headgroup_path, 0777, true);
        #FA
        $fa_path = $pic_path . 'FAchainVisual';
        is_dir($fa_path) or mkdir($fa_path, 0777, true);
        #PCA
        $command = 'Rscript /home/zhangqb/program/dev/main_split/lipPCAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
        #dd($command);

        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        #火山图
        $command = 'Rscript /home/zhangqb/program/dev/main_split/lipVolcanoPlot.R -r "' . $r_path . '" -s F -p "' . $pic_path . '" -b F -x "raw" -j 2 -k 0.1 -m 10 -w T ';
        #dd($command);
        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        #热图
        $command = 'Rscript /home/zhangqb/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e 75';
        #dd($command);
        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        return view('resultmet', ['title' => '上传数据', 'path' => $path]);
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
