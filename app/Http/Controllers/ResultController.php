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
        #exec('rm ./*qs');
        $omics = $request->omics;
        $file_data = $request->file_data;
        $file_desc = $request->file_desc;
        $naperent = $request->naperent;
        $tmpout = 'uploads/' . $omics . $file_data . $file_desc . md5($file_data . $file_desc) . '/';#该样本的主要输出路径
        is_dir($tmpout) or mkdir($tmpout, 0777, true);
        $subgroupfile = fopen("/home/zhangqb/tttt/public/$tmpout"."subgroup.txt", "w");

        $control = $request->control;
        $outpath = $tmpout . $control;

        if (!$request->subgroup) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => "You nend at least choose one group"]);
        }else{
            $subgroup = $request->subgroup;
            foreach ($subgroup as $key => $value) {
                fwrite($subgroupfile, $key . "\n");
                $outpath=$outpath.$key;
            }
        }
        $outpath =$outpath.$naperent."/";
        is_dir($outpath) or mkdir($outpath, 0777, true);#该样本底下各个小输出
        
        $downloadpath = preg_replace('/\//', "++", $outpath.'results/');
        if (!array_key_exists($control, $subgroup) ) {
            fwrite($subgroupfile, $control . "\n");
        }
        fclose($subgroupfile);
        $data_type = $request->data_type;
        $path_datafile = 'uploads/' . md5($file_data) . '/' . $file_data;
        $path_descfile = 'uploads/' . md5($file_desc) . '/' . $file_desc;
        if ($omics == "Transcriptomics") {
            $experiment = $request->experimental;
            $outpath = 'uploads/' . $omics . $file_data . $file_desc . md5($file_data . $file_desc) . '/' . $experiment . $control . '/';
            is_dir($outpath) or mkdir($outpath, 0777, true);
            $downloadpath = preg_replace('/\//', "++", $outpath.'results/');
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/processing_RNA.R -a "' . $experiment . '" -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -c "' . $control . '" -o "/home/zhangqb/tttt/public/' . $outpath . '" -t '.$data_type.' -p "/home/zhangqb/tttt/public/' . $outpath . '"';
            #if (!$this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
                exec($command, $ooout, $flag);
                #dd($ooout);
                if ($flag == 1) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
                }
            #}
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
                if ($this->showresultrna($outpath)) {
                    if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'results/up.png') ){
                        $up = '<img id="enrichuppng" src="http://www.lintwebomics.info/' . $outpath . 'results/up.png" style="height:50%;width: 60%;">';
                    }else{
                        $up='<p>No UP genes enriched! Please try again with other parameters or check your uploaded data.</p>';
                    }
                    if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'results/down.png') ){
                        $down='<img id="enrichdownpng" src="http://www.lintwebomics.info/' . $outpath . 'results/down.png" style="height:50%;width: 60%;">';
                    }else{
                        $down='<p>No DOWN genes enriched! Please try again with other parameters or check your uploaded data.</p>';
                    }
                    
                    return view('resultrna', ['title' => '上传数据', 'path' => $outpath, 'up' => $up, 'down' => $down, 'omics' => $omics, 'downloadpath' => $downloadpath, 'DEname' => $experiment .'_vs_'. $control, 'f' => 2.0, 'p' => 0.1, 'u' => 20, 'v' => 75,'t' => "mmu",'g' => "SYMBOL",'s' => 50,'c' => "Biological_Process",]); 
                }
            }
        } else {
            $delodd = $request->delodd;
            $n = $request->n;

            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/options/subgroupsSel.R -i "/home/zhangqb/tttt/public/' . $path_datafile . '" -d "/home/zhangqb/tttt/public/' . $path_descfile . '" -s "/home/zhangqb/tttt/public/' . $tmpout . '" -p "/home/zhangqb/tttt/public/' . $outpath . '"';
            exec($command, $ooout, $flag);
            #dd($ooout);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
            #if (!$this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
                $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/processing.R  -i "/home/zhangqb/tttt/public/' . $outpath . '" -t "' . $data_type . '" -c "' . $control . '" -e "' . $naperent . '" -l "' . $delodd . '" -n ' . $n . ' -o "/home/zhangqb/tttt/public/' . $outpath . '" -p "/home/zhangqb/tttt/public/' . $outpath . '"';
                exec($command, $ooout, $flag);
                if ($flag == 1) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
                }
            #}
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'data.RData')) {
                if ($omics == "Lipidomics") {
                    if (count($subgroup) == 1) {
                        #dd($downloadfilename);
                        if ($this->showresultlip($outpath)) {
                            $command='cd /home/zhangqb/tttt/public/'.$outpath.'results/FAchainVisual/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
                            exec($command,$fapng,$flag);
                            $command='cd /home/zhangqb/tttt/public/'.$outpath.'results/headgroup/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
                            exec($command,$headpng,$flag);
                            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'results/enrich/up_LION-enrichment-plot.png') ){
                                $up = '<img id="up" src="http://www.lintwebomics.info/' . $outpath . 'results/enrich/up_LION-enrichment-plot.png" style="height:90%;width: 90%;">';
                            }else{
                                $up='<p>No UP lipids enriched! Please try again with other parameters or check your uploaded data.</p>';
                            }
                            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'results/enrich/down_LION-enrichment-plot.png') ){
                                $down='<img id="down" src="http://www.lintwebomics.info/' . $outpath . 'results/enrich/down_LION-enrichment-plot.png" style="height:90%;width: 90%;">';
                            }else{
                                $down='<p>No DOWN lipids enriched! Please try again with other parameters or check your uploaded data.</p>';
                            }
                            return view('resultlip', ['title' => '上传数据', 'jb' => "yes", 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 's' => "F", 'x' => "raw", 'j' => 2, 'kk' => 0.1, 'm' => 10, 'w' => "T", 'e' => 75, 'g' => "all_info", 'fapng' => $fapng, 'headpng' => $headpng, 'up' => $up, 'down' => $down]);
                        }
                    }else{
                        if ($this->showresultlip2($outpath)) {
                            $command='cd /home/zhangqb/tttt/public/'.$outpath.'results/FAchainVisual/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
                            exec($command,$fapng,$flag); 
                            $command='cd /home/zhangqb/tttt/public/'.$outpath.'results/FAchainVisual/ && ls fa_show*.png | awk -F\'[_.]\' \'{print $2}\'';
                            exec($command,$fashowpng,$flag); 
                            $command='cd /home/zhangqb/tttt/public/'.$outpath.'results/headgroup/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
                            exec($command,$headpng,$flag);                                  
                            return view('resultlipnovolcano', ['title' => '上传数据', 'jb' => "no", 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 's' => "F", 'x' => "raw", 'j' => 2, 'kk' => 0.1, 'm' => 10, 'w' => "T", 'e' => 75, 'g' => "all_info", 'fapng' => $fapng, 'fashowpng' => $fashowpng, 'headpng' => $headpng]);
                        }
                    }
                }
                if ($omics == "Metabolomics") {
                    if (count($subgroup) == 1) {
                        #dd($downloadfilename);
                        if ($this->showresultmet($outpath)) {
                            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'results/enrich/up_ora_dpi72.png') ){
                                $up = '<img id="up" src="http://www.lintwebomics.info/' . $outpath . 'results/enrich/up_ora_dpi72.png" style="height:80%;width: 80%;display: block;"><br><p id="noup" style="display: none;" >No UP lipids enriched! Please try again with other parameters or check your uploaded data.</p>';
                            }else{
                                $up='<img id="up" src="http://www.lintwebomics.info/' . $outpath . 'results/enrich/up_ora_dpi72.png" style="height:80%;width: 80%;display: none;"><br><p id="noup" style="display: block;" >No UP lipids enriched! Please try again with other parameters or check your uploaded data.</p>';
                            }
                            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'results/enrich/down_ora_dpi72.png') ){
                                $down='<img id="down" src="http://www.lintwebomics.info/' . $outpath . 'results/enrich/down_ora_dpi72.png" style="height:80%;width: 80%;display: block;"><br><p id="nodown" style="display: none;" >No DOWN lipids enriched! Please try again with other parameters or check your uploaded data.</p>';
                            }else{
                                $down='<img id="down" src="http://www.lintwebomics.info/' . $outpath . 'results/enrich/down_ora_dpi72.png" style="height:80%;width: 80%;display: none;"><br><p id="nodown" style="display: block;" >No DOWN lipids enriched! Please try again with other parameters or check your uploaded data.</p>';
                            }
                            return view('resultmet', ['title' => '上传数据', 'jb' => "yes", 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 's' => "F", 'x' => "raw", 'j' => 2, 'k' => 0.1, 'm' => 10, 'w' => "T", 'e' => 75, 'up' => $up, 'down' => $down]);
                        }
                    }else{
                        if ($this->showresultmet2($outpath)) {
                            return view('resultmetnovolcano', ['title' => '上传数据', 'jb' => "no", 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 's' => "F", 'x' => "raw", 'j' => 2, 'k' => 0.1, 'm' => 10, 'w' => "T", 'e' => 75]);
                        }
                    }
                }
                if ($omics == "Proteomics") {
                    if (count($subgroup) == 1) {
                        #dd($downloadfilename);
                        if ($this->showresultpro($outpath)) {
                            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'results/enrich/up.png') ){
                                $up = '<img id="up" src="http://www.lintwebomics.info/' . $outpath . 'results/enrich/up.png" style="height:80%;width: 80%;display: block;"><br><p id="noup" style="display: none;" >No UP genes enriched! Please try again with other parameters or check your uploaded data.</p>';
                            }else{
                                $up='<img id="up" src="http://www.lintwebomics.info/' . $outpath . 'results/enrich/up.png" style="height:80%;width: 80%;display: none;"><br><p id="noup" style="display: block;" >No UP genes enriched! Please try again with other parameters or check your uploaded data.</p>';
                            }
                            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'results/enrich/down.png') ){
                                $down='<img id="down" src="http://www.lintwebomics.info/' . $outpath . 'results/enrich/down.png" style="height:80%;width: 80%;display: block;"><br><p  id="nodown" style="display: none;" >No DOWN genes enriched! Please try again with other parameters or check your uploaded data.</p>';
                            }else{
                                $down='<img id="down" src="http://www.lintwebomics.info/' . $outpath . 'results/enrich/down.png" style="height:80%;width: 80%;display: none;"><br><p id="nodown" style="display: block;" >No DOWN genes enriched! Please try again with other parameters or check your uploaded data.</p>';
                            }
                            return view('resultpro', ['title' => '上传数据', 'jb' => "yes", 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 's' => "20", 'x' => "raw", 'j' => 2, 'k' => 0.1, 'm' => 10, 'w' => "T", 'e' => 75, 'c' => "Biological_Process", 't' => "mmu", 'up' => $up, 'down' => $down]);
                        }
                    }else{
                        if ($this->showresultpro2($outpath)) {
                            return view('resultpronovolcano', ['title' => '上传数据', 'jb' => "no", 'path' => $outpath, 'omics' => $omics, 'downloadpath' => $downloadpath, 's' => "20", 'x' => "raw", 'j' => 2, 'k' => 0.1, 'm' => 10, 'w' => "T", 'e' => 75, 'c' => "Biological_Process", 't' => "mmu"]);
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
        #exec('rm '.$pic_path.'*');
        is_dir($pic_path) or mkdir($pic_path, 0777, true);

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/show_variability.R -r "' . $r_path . '" -o "' . $pic_path . '"';
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/rnaVolcanoPlot.R -r "' . $r_path . '" -s "' . $pic_path . '" -f 2.0 -p 0.1 -u 20';
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/rnaHeatmapPlot.R -r "' . $r_path . '" -w "' . $pic_path . '" -v 75';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'heatmap_allgroups.pdf ' . $pic_path . 'heatmap_allgroups.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'heatmap_top*.pdf ' . $pic_path . 'heatmap_show.png';
        exec($command, $ooout, $flag);
        #dd($ooout);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #
        #富集Rscript geneRegEnrich.R -r "~/temp/" -f 2.0 -p 0.05 -t "mmu" -g "SYMBOL" -s 50 -c "Biological_Process" -o "~/temp/results2/"
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/geneRegEnrich.R -r "' . $r_path . '" -o "' . $pic_path . '" -f 2.0 -p 0.05 -t "mmu" -g "SYMBOL" -s 50 -c "Biological_Process"';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'up*.pdf ' . $pic_path . 'up.png';
        exec($command, $ooout, $flag);

        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'down*.pdf ' . $pic_path . 'down.png';
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
        #exec('rm -rf '.$pic_path.'*');

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
        #enrich
        $enrich_path = $pic_path . 'enrich/';
        is_dir($enrich_path) or mkdir($enrich_path, 0777, true);
        #PCA
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipPCAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipOPLSDAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipVolcanoPlot.R -r "' . $r_path . '" -s T -p "' . $pic_path . '" -b F -x "raw" -j 2 -k 0.1 -m 10 -w T ';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/volcano_reg_*.pdf ' . $pic_path . 'MARresults/volcano_show.png';
        exec($command, $ooout, $flag);
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/volcano_regClass_*.pdf ' . $pic_path . 'MARresults/volcano_show2.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #热图
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e 75';
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/headgroupStat.R -r "' . $r_path . '" -u "' . $pic_path . '" -w T';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipSumClassHeatmapPlot.R -r "' . $r_path . '" -u "' . $pic_path . '" -w T -z F';
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
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'headgroup/heatmap_lipClassSummary_*.pdf ' . $pic_path . 'headgroup/headgroupheatmap_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #dd($ooout);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = 'for file in ' . $pic_path . 'headgroup/*.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.pdf*}.png; done';
        exec($command, $ooout, $flag);
        #dd($command);
        if ($flag == 1) {
            #dd($command);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #FAchain
        #for file in *.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.*}.png; done
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/FAchainStat.R -r "' . $r_path . '" -v "' . $pic_path . '" -g "all_info" -w T -e 75';

        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #dd($ooout);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'FAchainVisual/tilePlot_*.pdf ' . $pic_path . 'FAchainVisual/fa_show.png';
        exec($command, $ooout, $flag);
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'FAchainVisual/heatmap_lipsubClass_*.pdf ' . $pic_path . 'FAchainVisual/faheatmap_show.png';
        exec($command, $ooout, $flag);

        $command = 'for file in ' . $pic_path . 'FAchainVisual/*.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.pdf*}.png; done';
        exec($command, $ooout, $flag);
        #dd($command);
        if ($flag == 1) {
            #dd($command);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        #return 1;Rscript lipRegEnrich.R -r "~/temp/" -t "target_list" -j 2.0 -k 0.1 -p "~/temp/enrich/"
        #富集分析
        #/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/lipRegEnrich.R -r "/home/zhangqb/tttt/public/uploads/LipidomicsHANlipid_tidy.csvHANsampleList_lipid.CSV8d852c767707f00302f939401260cc64/Day1Day880/"  -t "target_list" -j 2.0 -k 0.1 -p "/home/zhangqb/tttt/public/uploads/LipidomicsHANlipid_tidy.csvHANsampleList_lipid.CSV8d852c767707f00302f939401260cc64/Day1Day880/results/enrich/"

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/lipRegEnrich.R -r "' . $r_path . '"  -t "target_list" -j 2.0 -k 0.1 -p "' . $enrich_path . '"';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        return 1;
        #return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
    }

    public function showresultmet($path)
    {
        #"MARresults","headgroup","FAchainVisual"
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        ##exec('rm -rf '.$pic_path.'*');
        is_dir($pic_path) or mkdir($pic_path, 0777, true);
        #MAR
        $mar_path = $pic_path . 'MARresults/';
        is_dir($mar_path) or mkdir($mar_path, 0777, true);
        #enrich
        $enrich_path = $pic_path . 'enrich/';
        is_dir($enrich_path) or mkdir($enrich_path, 0777, true);
        #PCA
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipPCAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        #OPLS-DA
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipOPLSDAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipVolcanoPlot.R -r "' . $r_path . '" -s F -p "' . $pic_path . '" -b F -x "raw" -j 2 -k 0.1 -m 10 -w T ';
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e 75';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $mar_path . 'heatmap_top*.pdf ' . $mar_path . 'heatmap_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #富集分析
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/met_preEnrich.R -r "' . $r_path . '"  -j 2.0 -k 0.1 -p "' . $enrich_path . '"';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/metRegEnrich.R -i "' . $enrich_path . '"  -o "' . $enrich_path . '"';
        #dd($command);
        exec($command, $ooout, $flag);
        return 1;
        #return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
    }

    public function showresultpro($path)
    {
        #"MARresults","headgroup","FAchainVisual"
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        #exec('rm -rf '.$pic_path.'*');
        is_dir($pic_path) or mkdir($pic_path, 0777, true);
        #MAR
        $mar_path = $pic_path . 'MARresults/';
        is_dir($mar_path) or mkdir($mar_path, 0777, true);
        #enrich
        $enrich_path = $pic_path . 'enrich/';
        is_dir($enrich_path) or mkdir($enrich_path, 0777, true);
        #PCA
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipPCAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        #OPLS-DA
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipOPLSDAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipVolcanoPlot.R -r "' . $r_path . '" -s F -p "' . $pic_path . '" -b F -x "raw" -j 2 -k 0.1 -m 10 -w T ';
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e 75';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $mar_path . 'heatmap_top*.pdf ' . $mar_path . 'heatmap_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #富集分析
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/met_preEnrich.R -r "' . $r_path . '"  -j 2.0 -k 0.1 -p "' . $enrich_path . '"';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/proteinRegEnrich.R -i "' . $enrich_path . '" -t "hsa" -s 20 -c "Biological_Process" -o "' . $enrich_path . '"';
        #dd($command);
        exec($command, $ooout, $flag);

        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $enrich_path . 'up*.pdf ' . $enrich_path . 'up.png';
        exec($command, $ooout, $flag);

        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $enrich_path . 'down*.pdf ' . $enrich_path . 'down.png';
        exec($command, $ooout, $flag);

        return 1;
        #return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
    }

    public function showresultlip2($path)
    {
        #"MARresults","headgroup","FAchainVisual"
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        #exec('rm -rf '.$pic_path.'*');
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipPCAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipOPLSDAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        #热图
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e 75';
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/headgroupStat.R -r "' . $r_path . '" -u "' . $pic_path . '" -w T';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipSumClassHeatmapPlot.R -r "' . $r_path . '" -u "' . $pic_path . '" -w T -z F';
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
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'headgroup/heatmap_lipClassSummary_*.pdf ' . $pic_path . 'headgroup/headgroupheatmap_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #dd($ooout);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = 'for file in ' . $pic_path . 'headgroup/*.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.pdf*}.png; done';
        exec($command, $ooout, $flag);
        #dd($command);
        if ($flag == 1) {
            #dd($command);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        #FAchain
        #for file in *.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.*}.png; done
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/FAchainStat.R -r "' . $r_path . '" -v "' . $pic_path . '" -g "all_info" -w T';

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
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'FAchainVisual/tilePlot_*.pdf ' . $pic_path . 'FAchainVisual/fa_show.png';
        exec($command, $ooout, $flag);
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'FAchainVisual/heatmap_lipsubClass_*.pdf ' . $pic_path . 'FAchainVisual/faheatmap_show.png';
        exec($command, $ooout, $flag);
        #return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        return 1;

    }

    public function showresultmet2($path)
    {
        #"MARresults","headgroup","FAchainVisual"
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        #exec('rm -rf '.$pic_path.'*');
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
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipPCAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        #OPLS-DA
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipOPLSDAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        #热图
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e 75';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $mar_path . 'heatmap_top*.pdf ' . $mar_path . 'heatmap_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        return 1;
        #return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
    }

    public function showresultpro2($path)
    {
        #"MARresults","headgroup","FAchainVisual"
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        #exec('rm -rf '.$pic_path.'*');
        is_dir($pic_path) or mkdir($pic_path, 0777, true);
        #MAR
        $mar_path = $pic_path . 'MARresults/';
        is_dir($mar_path) or mkdir($mar_path, 0777, true);
        #enrich
        $enrich_path = $pic_path . 'enrich/';
        is_dir($enrich_path) or mkdir($enrich_path, 0777, true);
        #PCA
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipPCAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        #OPLS-DA
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipOPLSDAPlot.R -r "' . $r_path . '" -q "' . $pic_path . '"';
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
        #热图
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e 75';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $mar_path . 'heatmap_top*.pdf ' . $mar_path . 'heatmap_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        return 1;
        #return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
    }

    public function getdownloadfilename($downloadpath)
    {
        #volcano
        $command='cd '.$downloadpath.'MARresults/ && ls volcano*';
        exec($command,$volcano,$flag);
        $download["volcano"]=$volcano;
        #heatmap
        $command='cd '.$downloadpath.'MARresults/ && ls heatmap*';
        exec($command,$heatmap,$flag);
        $download["heatmap"]=$heatmap;
        #headgroup
        $command='cd '.$downloadpath.'headgroup/ && ls';
        exec($command,$headgroup,$flag);
        $download["headgroup"]=$headgroup;
        #FAchainVisual
        $command='cd '.$downloadpath.'FAchainVisual/ && ls';
        exec($command,$FAchainVisual,$flag);
        $download["FAchainVisual"]=$FAchainVisual;
        #enrich
        $command='cd '.$downloadpath.'enrich/ && ls';
        exec($command,$enrich,$flag);
        $download["enrich"]=$enrich;
        return $download;
    }

    public function getrnadownloadfilename($downloadpath)
    {
        #volcano
        $command='cd '.$downloadpath.' && ls ';
        exec($command,$download,$flag);
        return $download;
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
