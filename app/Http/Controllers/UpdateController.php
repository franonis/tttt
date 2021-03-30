<?php

namespace App\Http\Controllers;
set_time_limit(0);
use App\Http\Controllers\UpdateController;
use Illuminate\Http\Request;

class UpdateController extends Controller 
{
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
        
        return view('resultrna', ['title' => '上传数据', 'path' => $path, 'up' => $up, 'down' => $down, 'downloadpath' => $downloadpath, 'downloadfilename' => $downloadfilename, 'DEname' => 'DEgeneStatistics_'.$experiment .'_vs_'. $control .'.csv', 'DEgeneStatistics' => $DEgeneStatistics, 'f' => 2.0, 'p' => 0.1, 'u' => 20, 'v' => 75,'t' => "mmu",'g' => "SYMBOL",'s' => 50,'c' => "Biological_Process",]);
    }
    public function updaternaHeatmap(Request $request)
    {
        #dd($request);
        $path = $request->path;
        $downloadpath = $request->downloadpath;
        $f = $request->f;
        $p = $request->p;
        $u = $request->u;
        $v = $request->v;
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        #热图Rscript rnaHeatmapPlot.R -r "~/temp/" -w "~/temp/results2/" -v 75
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/rnaHeatmapPlot.R -r "' . $r_path . '" -w "' . $pic_path . '" -v ' . $v;
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'heatmap_top*.pdf ' . $pic_path . 'heatmap_top.png';
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
        
        return view('resultrna', ['title' => '上传数据', 'path' => $path, 'up' => $up, 'down' => $down, 'omics' => $omics, 'downloadpath' => $downloadpath, 'downloadfilename' => $downloadfilename, 'DEname' => 'DEgeneStatistics_'.$experiment .'_vs_'. $control .'.csv', 'DEgeneStatistics' => $DEgeneStatistics, 'f' => 2.0, 'p' => 0.1, 'u' => 20, 'v' => 75,'t' => "mmu",'g' => "SYMBOL",'s' => 50,'c' => "Biological_Process",]);
    }
#, '' => $, '' => $, '' => $, '' => $, '' => $, '' => $, '' => $, '' => $, '' => $
    public function updatelipVolcano(Request $request)
    {
        $path = $request->path;
        $downloadpath = $request->downloadpath;
        $s = $request->s;
        $b = $request->b;
        $x = $request->x;
        $j = $request->j;
        $k = $request->k;
        $m = $request->m;
        $w = $request->w;
        $e = $request->e;
        $g = $request->g;
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        $mar_path = $pic_path . 'MARresults/';

        #火山图Rscript lipVolcanoPlot.R -r "~/temp/" -s F -p "~/temp/results/" -b F -x "raw" -j 2 -k 0.1 -m 10 -w T
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipVolcanoPlot.R -r "' . $r_path . '" -s ' . $s . ' -p "' . $pic_path . '" -b ' . $b . ' -x "' . $x . '" -j ' . $j . ' -k ' . $k . ' -m ' . $m . ' -w ' . $w . ' ';
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
        return view('resultlip', ['title' => '上传数据', 'path' => $path, 'downloadpath' => $downloadpath, "s" => $s, "b" => $b, "x" => $x, "j" => $j, "k" => $k, "m" => $m, "w" => $w, "e" => $e, "g" => $g]);
    }
    public function updatelipHeatmap(Request $request)
    {
        #dd($request);
        $path = $request->path;
        $downloadpath = $request->downloadpath;
        $s = $request->s;
        $b = $request->b;
        $x = $request->x;
        $j = $request->j;
        $k = $request->k;
        $m = $request->m;
        $w = $request->w;
        $e = $request->e;
        $g = $request->g;
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        $mar_path = $pic_path . 'MARresults/';
        #热图Rscript rnaHeatmapPlot.R -r "~/temp/" -w "~/temp/results2/" -e 75
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e ' . $e;
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
        return view('resultlip', ['title' => '上传数据', 'path' => $path, 'downloadpath' => $downloadpath, "s" => $s, "b" => $b, "x" => $x, "j" => $j, "k" => $k, "m" => $m, "w" => $w, "e" => $e, "g" => $g]);
    }

    public function updatelipfa(Request $request)
    {
        $path = $request->path;
        $downloadpath = $request->downloadpath;
        $s = $request->s;
        $b = $request->b;
        $x = $request->x;
        $j = $request->j;
        $k = $request->k;
        $m = $request->m;
        $w = $request->w;
        $e = $request->e;
        $g = $request->g;
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        $mar_path = $pic_path . 'MARresults/';

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/FAchainStat.R -r "' . $r_path . '" -v "' . $pic_path . '" -g "FA_info" -w T';

        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'FAchainVisual/tilePlot_*.pdf ' . $pic_path . 'FAchainVisual/fa_show.png';
        $command = 'for file in ' . $pic_path . 'FAchainVisual/*.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.*}.png; done';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        return view('resultlip', ['title' => '上传数据', 'path' => $path, 'downloadpath' => $downloadpath, "s" => $s, "b" => $b, "x" => $x, "j" => $j, "k" => $k, "m" => $m, "w" => $w, "e" => $e, "g" => $g]);
    }

    public function updateliphead(Request $request)
    {
        $path = $request->path;
        $downloadpath = $request->downloadpath;
        $s = $request->s;
        $b = $request->b;
        $x = $request->x;
        $j = $request->j;
        $k = $request->k;
        $m = $request->m;
        $w = $request->w;
        $e = $request->e;
        $g = $request->g;
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        $mar_path = $pic_path . 'MARresults/';

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/headgroupStat.R -r "' . $r_path . '" -u "' . $pic_path . '" -w ' . $w;
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

        return view('resultlip', ['title' => '上传数据', 'path' => $path, 'downloadpath' => $downloadpath, "s" => $s, "b" => $b, "x" => $x, "j" => $j, "k" => $k, "m" => $m, "w" => $w, "e" => $e, "g" => $g]);
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
