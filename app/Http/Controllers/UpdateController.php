<?php

namespace App\Http\Controllers;
set_time_limit(0);
use App\Http\Controllers\UpdateController;
use Illuminate\Http\Request;

class UpdateController extends Controller 
{
    public function updatelipVolcano(Request $request)
    {
        $downloadpath = $request->downloadpath;
        $path = $request->path;
        $jb = $request->jb;
        $e = $request->e;
        $x = $request->x;
        $j = $request->j;
        $k = $request->k;
        $m = $request->m;
        if ($request->s) {
            $s = "T";
        }else{
            $s = "F";
        }
        if ($request->w) {
            $w = "T";
        }else{
            $w = "F";
        }
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipVolcanoPlot.R -r "' . $r_path . '" -s ' . $s . ' -p "' . $pic_path . '" -b F -x "' . $x . '" -j ' . $j . ' -k ' . $k . ' -m ' . $m . ' -w ' . $w . ' ';
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

        $command='cd /home/zhangqb/tttt/public/'.$path.'results/FAchainVisual/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        exec($command,$fapng,$flag);
        $command='cd /home/zhangqb/tttt/public/'.$path.'results/headgroup/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        exec($command,$headpng,$flag);

        if ($jb == "yes") {
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/enrich/up_LION-enrichment-plot.png') ){
                $up = '<img src="http://www.lintwebomics.info/' . $path . 'results/enrich/up_LION-enrichment-plot.png" style="height:50%;width: 60%;">';
            }else{
                $up='<p>No UP genes enriched! Please try again with other parameters or check your uploaded data.</p>';
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/enrich/down_LION-enrichment-plot.png') ){
                $down='<img src="http://www.lintwebomics.info/' . $path . 'results/enrich/down_LION-enrichment-plot.png" style="height:50%;width: 60%;">';
            }else{
                $down='<p>No DOWN genes enriched! Please try again with other parameters or check your uploaded data.</p>';
            }
            return view('resultlip', ['title' => 'result', 'jb' => "yes", 'path' => $path, 'downloadpath' => $downloadpath, 'x' => $x, 'j' => $j, 'k' => $k, 'm' => $m, 'e' => $e, 'fapng' => $fapng, 'headpng' => $headpng, 'up' => $up, 'down' => $down]);
        }elseif ($jb == "no") {
            return view('resultlipnovolcano', ['title' => 'result', 'jb' => "no", 'path' => $path, 'downloadpath' => $downloadpath, 'x' => $x, 'j' => $j, 'k' => $k, 'm' => $m, 'e' => $e, 'fapng' => $fapng, 'headpng' => $headpng]);
        }
    }

    public function updatelipHeatmap(Request $request)
    {
        $downloadpath = $request->downloadpath;
        $path = $request->path;
        $jb = $request->jb;
        $e = $request->e;
        $x = $request->x;
        $j = $request->j;
        $k = $request->k;
        $m = $request->m;
        
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e ' . $e;
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/heatmap_top'.$e.'*.pdf ' . $pic_path . 'MARresults/heatmap_show.png';
        exec($command, $ooout, $flag);
        #dd($ooout);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        $command='cd /home/zhangqb/tttt/public/'.$path.'results/FAchainVisual/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        exec($command,$fapng,$flag);
        $command='cd /home/zhangqb/tttt/public/'.$path.'results/headgroup/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        exec($command,$headpng,$flag);

        if ($jb == "yes") {
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/enrich/up_LION-enrichment-plot.png') ){
                $up = '<img src="http://www.lintwebomics.info/' . $path . 'results/enrich/up_LION-enrichment-plot.png" style="height:50%;width: 60%;">';
            }else{
                $up='<p>No UP genes enriched! Please try again with other parameters or check your uploaded data.</p>';
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/enrich/down_LION-enrichment-plot.png') ){
                $down='<img src="http://www.lintwebomics.info/' . $path . 'results/enrich/down_LION-enrichment-plot.png" style="height:50%;width: 60%;">';
            }else{
                $down='<p>No DOWN genes enriched! Please try again with other parameters or check your uploaded data.</p>';
            }
            return view('resultlip', ['title' => 'result', 'jb' => "yes", 'path' => $path, 'downloadpath' => $downloadpath, 'x' => $x, 'j' => $j, 'k' => $k, 'm' => $m, 'e' => $e, 'fapng' => $fapng, 'headpng' => $headpng, 'up' => $up, 'down' => $down]);
        }elseif ($jb == "no") {
            return view('resultlipnovolcano', ['title' => 'result', 'jb' => "no", 'path' => $path, 'downloadpath' => $downloadpath, 'x' => $x, 'j' => $j, 'k' => $k, 'm' => $m, 'e' => $e, 'fapng' => $fapng, 'headpng' => $headpng]);
        }
    }

    public function updateliphead(Request $request)
    {
        $downloadpath = $request->downloadpath;
        $path = $request->path;
        $jb = $request->jb;
        $e = $request->e;
        $x = $request->x;
        $j = $request->j;
        $k = $request->k;
        $m = $request->m;
        if ($request->w) {
            $w = "T";
        }else{
            $w = "F";
        }
        if ($request->z) {
            $z = "T";
        }else{
            $z = "F";
        }
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/headgroupStat.R -r "' . $r_path . '" -u "' . $pic_path . '" -w ' . $w;
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipSumClassHeatmapPlot.R -r "' . $r_path . '" -u "' . $pic_path . '" -w '.$w.' -z ' . $z;
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

        $command='cd /home/zhangqb/tttt/public/'.$path.'results/FAchainVisual/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        exec($command,$fapng,$flag);
        $command='cd /home/zhangqb/tttt/public/'.$path.'results/headgroup/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        exec($command,$headpng,$flag);

        if ($jb == "yes") {
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/enrich/up_LION-enrichment-plot.png') ){
                $up = '<img src="http://www.lintwebomics.info/' . $path . 'results/enrich/up_LION-enrichment-plot.png" style="height:50%;width: 60%;">';
            }else{
                $up='<p>No UP genes enriched! Please try again with other parameters or check your uploaded data.</p>';
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/enrich/down_LION-enrichment-plot.png') ){
                $down='<img src="http://www.lintwebomics.info/' . $path . 'results/enrich/down_LION-enrichment-plot.png" style="height:50%;width: 60%;">';
            }else{
                $down='<p>No DOWN genes enriched! Please try again with other parameters or check your uploaded data.</p>';
            }
            return view('resultlip', ['title' => 'result', 'jb' => "yes", 'path' => $path, 'downloadpath' => $downloadpath, 'x' => $x, 'j' => $j, 'k' => $k, 'm' => $m, 'e' => $e, 'fapng' => $fapng, 'headpng' => $headpng, 'up' => $up, 'down' => $down]);
        }elseif ($jb == "no") {
            return view('resultlipnovolcano', ['title' => 'result', 'jb' => "no", 'path' => $path, 'downloadpath' => $downloadpath, 'x' => $x, 'j' => $j, 'k' => $k, 'm' => $m, 'e' => $e, 'fapng' => $fapng, 'headpng' => $headpng]);
        }
    }

    public function updatelipfa(Request $request)
    {
        $downloadpath = $request->downloadpath;
        $path = $request->path;
        $jb = $request->jb;
        $e = $request->e;
        $x = $request->x;
        $j = $request->j;
        $k = $request->k;
        $m = $request->m;
        $g = $request->g;
        if ($request->s) {
            $s = "T";
        }else{
            $s = "F";
        }
        if ($request->w) {
            $w = "T";
        }else{
            $w = "F";
        }
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/FAchainStat.R -r "' . $r_path . '" -v "' . $pic_path . '" -g "'.$g.'" -w '.$w.' -e '.$e;

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

        $command='cd /home/zhangqb/tttt/public/'.$path.'results/FAchainVisual/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        exec($command,$fapng,$flag);
        $command='cd /home/zhangqb/tttt/public/'.$path.'results/headgroup/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        exec($command,$headpng,$flag);

        if ($jb == "yes") {
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/enrich/up_LION-enrichment-plot.png') ){
                $up = '<img src="http://www.lintwebomics.info/' . $path . 'results/enrich/up_LION-enrichment-plot.png" style="height:50%;width: 60%;">';
            }else{
                $up='<p>No UP genes enriched! Please try again with other parameters or check your uploaded data.</p>';
            }
            if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/enrich/down_LION-enrichment-plot.png') ){
                $down='<img src="http://www.lintwebomics.info/' . $path . 'results/enrich/down_LION-enrichment-plot.png" style="height:50%;width: 60%;">';
            }else{
                $down='<p>No DOWN genes enriched! Please try again with other parameters or check your uploaded data.</p>';
            }
            return view('resultlip', ['title' => 'result', 'jb' => "yes", 'path' => $path, 'downloadpath' => $downloadpath, 'x' => $x, 'j' => $j, 'k' => $k, 'm' => $m, 'e' => $e, 'fapng' => $fapng, 'headpng' => $headpng, 'up' => $up, 'down' => $down]);
        }elseif ($jb == "no") {
            return view('resultlipnovolcano', ['title' => 'result', 'jb' => "no", 'path' => $path, 'downloadpath' => $downloadpath, 'x' => $x, 'j' => $j, 'k' => $k, 'm' => $m, 'e' => $e, 'fapng' => $fapng, 'headpng' => $headpng]);
        }
    }

    public function updatelipenrich(Request $request)
    {
        $downloadpath = $request->downloadpath;
        $path = $request->path;
        $jb = $request->jb;
        $e = $request->e;
        $x = $request->x;
        $j = $request->j;
        $k = $request->k;
        $m = $request->m;
        $t = $request->t;
        $l = $request->l;
        if ($request->s) {
            $s = "T";
        }else{
            $s = "F";
        }
        if ($request->w) {
            $w = "T";
        }else{
            $w = "F";
        }
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $enrich_path = '/home/zhangqb/tttt/public/' . $path . 'results/enrich/';
        if ($t == "target_list") {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/lipRegEnrich.R -r "' . $r_path . '"  -t "' . $t . '" -j '.$j.' -k '.$k.' -p "' . $enrich_path . '"';
        }elseif ($t == "ranking") {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/lipRegEnrich.R -r "' . $r_path . '"  -t "' . $t . '" -l '.$l.' -p "' . $enrich_path . '"';
        }
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        $command='cd /home/zhangqb/tttt/public/'.$path.'results/FAchainVisual/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        exec($command,$fapng,$flag);
        $command='cd /home/zhangqb/tttt/public/'.$path.'results/headgroup/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        exec($command,$headpng,$flag);

        if ($jb == "yes") {
            if ($t == "target_list") {
                if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/enrich/up_LION-enrichment-plot.png') ){
                    $up = '<img src="http://www.lintwebomics.info/' . $path . 'results/enrich/up_LION-enrichment-plot.png" style="height:50%;width: 60%;">';
                }else{
                    $up='<p>No UP lipids enriched! Please try again with other parameters or check your uploaded data.</p>';
                }
                if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/enrich/down_LION-enrichment-plot.png') ){
                    $down='<img src="http://www.lintwebomics.info/' . $path . 'results/enrich/down_LION-enrichment-plot.png" style="height:50%;width: 60%;">';
                }else{
                    $down='<p>No DOWN lipids enriched! Please try again with other parameters or check your uploaded data.</p>';
                }
                return view('resultlip', ['title' => 'result', 'jb' => "yes", 'path' => $path, 'downloadpath' => $downloadpath, 'x' => $x, 'j' => $j, 'k' => $k, 'm' => $m, 'e' => $e, 'fapng' => $fapng, 'headpng' => $headpng, 'up' => $up, 'down' => $down]);
            }elseif ($t == "ranking") {
                if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/enrich/LION-enrichment-plot.png') ){
                    $ranking='<img src="http://www.lintwebomics.info/' . $path . 'results/enrich/LION-enrichment-plot.png" style="height:50%;width: 60%;">';
                }else{
                    $ranking='<p>No lipids enriched! Please try again with other parameters or check your uploaded data.</p>';
                }
                return view('resultlipranking', ['title' => 'result', 'jb' => "yes", 'path' => $path, 'downloadpath' => $downloadpath, 'x' => $x, 'j' => $j, 'k' => $k, 'm' => $m, 'e' => $e, 'fapng' => $fapng, 'headpng' => $headpng, 'ranking' => $ranking]);
            }
        }
    }

    public function updaternaVolcano(Request $request)
    {
        $DEname = $request->DEname;
        $downloadpath = $request->downloadpath;
        $path = $request->path;
        $f = $request->f;
        $p = $request->p;
        $u = $request->u;
        $v = $request->v;
        $g = $request->g;
        $c = $request->c;
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';

        #火山图Rscript rnaVolcanoPlot.R -r "~/temp/" -s "~/temp/results2/" -f 2.0 -p 0.1 -u 20
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/rnaVolcanoPlot.R -r "' . $r_path . '" -s "' . $pic_path . '" -f ' . $f . ' -p ' . $p . ' -u ' . $u . '';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'volcano_*.pdf ' . $pic_path . 'volcano_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        $downloadfilename = $this->getrnadownloadfilename('/home/zhangqb/tttt/public/' . $path.'results/');
        $DEgeneStatistics = file_get_contents($path . 'DEgeneStatistics_'.$experiment .'_vs_'. $control .'.csv');
        if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/up.png') ){
            $up = '<img src="http://www.lintwebomics.info/' . $path . 'results/up.png" style="height:50%;width: 60%;">';
        }else{
            $up='<p>No UP genes enriched! Try check your data!</p>';
        }
        if ($this->isRunOver('/home/zhangqb/tttt/public/' . $path . 'results/down.png') ){
            $down='<img src="http://www.lintwebomics.info/' . $path . 'results/down.png" style="height:50%;width: 60%;">';
        }else{
            $down='<p>No DOWN genes enriched! Try check your data!</p>';
        }
        
        return view('resultrna', ['title' => 'result', 'path' => $path, 'up' => $up, 'down' => $down, 'downloadpath' => $downloadpath, 'downloadfilename' => $downloadfilename, 'DEname' => 'DEgeneStatistics_'.$experiment .'_vs_'. $control .'.csv', 'DEgeneStatistics' => $DEgeneStatistics, 'f' => 2.0, 'p' => 0.1, 'u' => 20, 'v' => 75,'t' => "mmu",'g' => "SYMBOL",'s' => 50,'c' => "Biological_Process",]);
    }
    public function updaternaHeatmap($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $v = $datas[0];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;
        #热图Rscript rnaHeatmapPlot.R -r "~/temp/" -w "~/temp/results2/" -v 75
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/rnaHeatmapPlot.R -r "' . $r_path . '" -w "' . $pic_path . '" -v ' . $v;
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'heatmap_top'.$v.'*.pdf ' . $pic_path . 'heatmap_top.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        return response()->json([‘code’=> ‘success’]);
    }

    public function showresultrna2($data)
    {
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/'; #$path是上一个处理数据程序的输出目录 $pic_path是本程序的输出目录
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
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'volcano*.pdf ' . $pic_path . 'heatmap_show.png';
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
        #dd($path . 'results/');
        return 1;

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

    private function isRunOver($file)
    {
        return file_exists($file) ? true : false;
    }

}
