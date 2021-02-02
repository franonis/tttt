<?php

namespace App\Http\Controllers;
set_time_limit(0);
use App\Http\Controllers\ResultController;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function getSetPage(Request $request)
    {
        #dd($request);
        $omics = $request->omics;
        $file_data = $request->file_data;
        $file_desc = $request->file_desc;
        $naperent = $request->naperent;
        $temp = 'uploads/' . $omics . $file_data . $file_desc . md5($file_data . $file_desc) . '/';
        is_dir($tmpout) or mkdir($tmpout, 0777, true);
        $subgroupfile = fopen("/home/zhangqb/tttt/public/$tmpout"."subgroup.txt", "w");

        if (!$request->subgroup) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => "You nend at least choose one group"]);
        }else{
            $subgroup = $request->subgroup;
            foreach ($subgroup as $key => $value) {
                fwrite($subgroupfile, $key . "\n");
                $lastgroup=$key;
            }
        }

        $control = $request->control;
        if (!array_key_exists($control, $subgroup) ) {
            fwrite($subgroupfile, $control . "\n");
        }
        fclose($subgroupfile);
        $data_type = $request->data_type;
        $path_datafile = 'uploads/' . $omics . $file_data . md5($file_data) . '/' . $file_data;
        $path_descfile = 'uploads/' . $omics . $file_desc . md5($file_desc) . '/' . $file_desc;
        if ($omics == "Transcriptomics") {
            
            $normalization = $request->normalization;
            $outpath = $outpath . $control .$lastgroup. '/'; #输出文件放一个对比组名命名的文件
            is_dir($outpath) or mkdir($outpath, 0777, true);
            $downloadpath = preg_replace('/\//', "+", $outpath);
            if ($data_type == "rna") {
                $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/processing_RNA.R -a "' . $experiment . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -c "' . $control . '" -o "/home/zhangqb/tttt/public/' . $outpath . '"  -t RNAseq -p "/home/zhangqb/tttt/public/' . $outpath . '"';
            } else {
                $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/processing_RNA.R -a "' . $experiment . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -c "' . $control . '" -o "/home/zhangqb/tttt/public/' . $outpath . '" -n ' . $normalization . ' -t MiAr -p "/home/zhangqb/tttt/public/' . $outpath . '"';
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
                if ($this->showresultrna($outpath)) {
                    if ($notshowvol) {
                        return view('resultrnanovolcano', ['title' => '上传数据', 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 'f' => 2.0, 'p' => 0.1, 'u' => 20, 'v' => 75]);                        
                    }else{
                        return view('resultrna', ['title' => '上传数据', 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 'f' => 2.0, 'p' => 0.1, 'u' => 20, 'v' => 75]);
                    }
                }
            } else {
                exec($command, $ooout, $flag);
                #dd($ooout);
                if ($flag == 1) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
                }
                if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
                    if ($this->showresultrna($outpath)) {
                        if ($notshowvol) {
                            return view('resultrnanovolcano', ['title' => '上传数据', 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 'f' => 2.0, 'p' => 0.1, 'u' => 20, 'v' => 75]);                            
                        }else{
                           return view('resultrna', ['title' => '上传数据', 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 'f' => 2.0, 'p' => 0.1, 'u' => 20, 'v' => 75]); 
                        }
                        
                    }
                }
            }
        } else {
            $delodd = $request->delodd;
            $outpath = $tmpout . $control .$lastgroup. '/'; #输出文件放一个对比组名命名的文件
            is_dir($outpath) or mkdir($outpath, 0777, true);
            $downloadpath = preg_replace('/\//', "+", $outpath);
            $command = '/home/new/R-3.6.3/bin/Rscript subgroupsSel.R -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -s "' . $tmpout . '" -p "' . $outpath . '"';
            exec($command, $ooout, $flag);
            #dd($ooout);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/processing.R  -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -t "' . $data_type . '" -c "' . $control . '" -e "' . $naperent . '" -l "' . $delodd . '" -o "/home/zhangqb/tttt/public/' . $outpath . '" -p "/home/zhangqb/tttt/public/' . $outpath . '"';
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
            } else {
                exec($command, $ooout, $flag);
                if ($flag == 1) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
                }
                if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {

                }
            if ($omics == "Lipidomics") {
                if ($this->showresultlip($outpath)) {
                    $command='ls /home/zhangqb/tttt/public'.$outpath.'result/FAchainVisual/*.png';
                    if ($notshowvol) {
                        return view('resultlipnovolcano', ['title' => '上传数据', 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 's' => "F", 'b' => "F", 'x' => "raw", 'j' => 2, 'k' => 0.1, 'm' => 10, 'w' => "T", 'e' => 75, 'g' => "FA_info", 'fapng' => $png]);
                    }else{
                        return view('resultlip', ['title' => '上传数据', 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 's' => "F", 'b' => "F", 'x' => "raw", 'j' => 2, 'k' => 0.1, 'm' => 10, 'w' => "T", 'e' => 75, 'g' => "FA_info", 'fapng' => $png]);
                    }
                            
                }
            } else {
                $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/processing.R -a "' . $experiment . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -t "' . $data_type . '" -c "' . $control . '" -f "' . $firstline . '" -l "' . $delodd . '" -o "/home/zhangqb/tttt/public/' . $outpath . '" -n "" -p "/home/zhangqb/tttt/public/' . $outpath . '"';
                if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
                    if ($this->showresultmet($outpath)) {
                        if ($notshowvol) {
                            return view('resultmetnovolcano', ['title' => '上传数据', 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 's' => "F", 'b' => "F", 'x' => "raw", 'j' => 2, 'k' => 0.1, 'm' => 10, 'w' => "T", 'e' => 75]);
                        }else{
                            return view('resultmet', ['title' => '上传数据', 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 's' => "F", 'b' => "F", 'x' => "raw", 'j' => 2, 'k' => 0.1, 'm' => 10, 'w' => "T", 'e' => 75]);
                        }
                        
                    }
                }
            }
        }
    }

    public function showresultrna($path)
    {
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/'; #$path是上一个处理数据程序的输出目录 $pic_path是本程序的输出目录
        is_dir($pic_path) or mkdir($pic_path, 0777, true);

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/show_variability.R -r "' . $r_path . '" -o "' . $pic_path . '"';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'PCA_score_plot_*.pdf ' . $pic_path . 'PCA_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        #火山图Rscript rnaVolcanoPlot.R -r "~/temp/" -s "~/temp/results2/" -f 2.0 -p 0.1 -u 20
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/rnaVolcanoPlot.R -r "' . $r_path . '" -s "' . $pic_path . '" -f 2.0 -p 0.1 -u 20';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'volcano*.pdf ' . $pic_path . 'volcano_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #热图Rscript rnaHeatmapPlot.R -r "~/temp/" -w "~/temp/results2/" -v 75
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/rnaHeatmapPlot.R -r "' . $r_path . '" -w "' . $pic_path . '" -v 75';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'heatmap_allgroups.pdf ' . $pic_path . 'heatmap_allgroups.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'heatmap_top*.pdf ' . $pic_path . 'heatmap_top.png';
        exec($command, $ooout, $flag);
        #dd($ooout);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #dd($path . 'results/');
        return 1;

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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/lipPCAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
        #dd($command);

        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/PCA_*.pdf ' . $pic_path . 'MARresults/PCA_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #OPLS-DA
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/lipOPLSDAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
        #dd($command);

        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/OPLSDA_*.pdf ' . $pic_path . 'MARresults/OPLSDA_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #火山图
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/lipVolcanoPlot.R -r "' . $r_path . '" -s F -p "' . $pic_path . '" -b F -x "raw" -j 2 -k 0.1 -m 10 -w T ';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/volcano_*.pdf ' . $pic_path . 'MARresults/volcano_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #热图
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e 75';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/heatmap_top*.pdf ' . $pic_path . 'MARresults/heatmap_show.png';
        exec($command, $ooout, $flag);
        #dd($ooout);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #head group
        #for file in *.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.*}.png; done
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/headgroupStat.R -r "' . $r_path . '" -u "' . $pic_path . '" -w T';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'headgroup/headgroup_color_*.pdf ' . $pic_path . 'headgroup/headgroupcolor_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'headgroup/headgroup_cum_*.pdf ' . $pic_path . 'headgroup/headgroupcum_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #dd($ooout);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #FAchain
        #for file in *.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.*}.png; done
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/FAchainStat.R -r "' . $r_path . '" -v "' . $pic_path . '" -g "FA_info" -w T';

        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #dd($ooout);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #$command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'FAchainVisual/tilePlot_*.pdf ' . $pic_path . 'FAchainVisual/fa_show.png';
        $command = 'for file in ' . $pic_path . 'FAchainVisual/*.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.pdf*}.png; done';
        exec($command, $ooout, $flag);
        #dd($command);
        if ($flag == 1) {
            #dd($command);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        #return 1;

    }

    public function showresultmet($path)
    {
        #"MARresults","headgroup","FAchainVisual"
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        is_dir($pic_path) or mkdir($pic_path, 0777, true);
        #MAR
        $mar_path = $pic_path . 'MARresults/';
        is_dir($mar_path) or mkdir($mar_path, 0777, true);
        #head
        $headgroup_path = $pic_path . 'headgroup';
        is_dir($headgroup_path) or mkdir($headgroup_path, 0777, true);
        #FA
        $fa_path = $pic_path . 'FAchainVisual';
        is_dir($fa_path) or mkdir($fa_path, 0777, true);
        #PCA
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/lipPCAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
        #dd($command);

        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $mar_path . 'PCA_score_plot_*.pdf ' . $mar_path . 'PCA_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #火山图
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/lipVolcanoPlot.R -r "' . $r_path . '" -s F -p "' . $pic_path . '" -b F -x "raw" -j 2 -k 0.1 -m 10 -w T ';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $mar_path . 'volcano_reg_*.pdf ' . $mar_path . 'volcano_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #热图
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e 75';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $mar_path . 'heatmap_top*.pdf ' . $mar_path . 'heatmap_top.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #return 1;
        return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
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
