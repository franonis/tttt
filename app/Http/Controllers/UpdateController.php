<?php

namespace App\Http\Controllers;
set_time_limit(0);
use App\Http\Controllers\UpdateController;
use Illuminate\Http\Request;

class UpdateController extends Controller 
{
    public function updatelipVolcano($data)
    {
        #dd($data);
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $s = $datas[1];
        $x = $datas[2];
        $j = $datas[3];
        $k = $datas[4];
        $m = $datas[5];
        $w = $datas[6];

        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipVolcanoPlot.R -r "' . $r_path . '" -s ' . $s . ' -p "' . $pic_path . '" -b F -x "' . $x . '" -j ' . $j . ' -k ' . $k . ' -m ' . $m . ' -w ' . $w . ' ';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/volcano_reg_*.pdf ' . $pic_path . 'MARresults/volcano_reg_'.$s.$x.$j.$k.$m.$w.'.png';
        exec($command, $ooout, $flag);
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/volcano_regClass_*.pdf ' . $pic_path . 'MARresults/volcano_regClass_'.$s.$x.$j.$k.$m.$w.'.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        return response()->json(['code'=> 'success','png1' => $pic_path.'MARresults/volcano_reg_'.$s.$x.$j.$k.$m.$w.'.png','png2' => $pic_path.'MARresults/volcano_regClass_'.$s.$x.$j.$k.$m.$w.'.png','sub' => $s]);
    }

    public function updatelipHeatmap($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $e = $datas[1];
        
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;


        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e ' . $e;
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/heatmap_top'.$e.'*.pdf ' . $pic_path . 'MARresults/heatmap_'.$e.'.png';
        exec($command, $ooout, $flag);
        #dd($ooout);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        return response()->json(['code'=> 'success','png' => $pic_path.'MARresults/heatmap_'.$e.'.png']);
    }

    public function updatelipheadheatmap($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $w = $datas[1];
        $z = $datas[2];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipSumClassHeatmapPlot.R -r "' . $r_path . '" -u "' . $pic_path . '" -w '.$w.' -z ' . $z;
        #dd($command);
        exec($command, $ooout, $flag);
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'headgroup/heatmap_lipClassSummary_*.pdf ' . $pic_path . 'headgroup/headgroupheatmap_'.$z.'.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #dd($ooout);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        return response()->json(['code'=> 'success','png' => $pic_path.'headgroupheatmap_'.$z.'.png']);
    }

    public function updateliphead($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $w = $datas[1];
        $z = $datas[2];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;

        exec('rm '.$pic_path.'headgroup/*');

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/headgroupStat.R -r "' . $r_path . '" -u "' . $pic_path . '" -w T';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'headgroup/headgroup_color_*.pdf ' . $pic_path . 'headgroup/headgroupcolor_new.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'headgroup/headgroup_cum_*.pdf ' . $pic_path . 'headgroup/headgroupcum_new.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #dd($ooout);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipSumClassHeatmapPlot.R -r "' . $r_path . '" -u "' . $pic_path . '" -w '.$w.' -z ' . $z;
        #dd($command);
        exec($command, $ooout, $flag);
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'headgroup/heatmap_lipClassSummary_*.pdf ' . $pic_path . 'headgroup/headgroupheatmap_'.$z.'.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #dd($ooout);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        $command = 'for file in ' . $pic_path . 'headgroup/*.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.pdf*}.png.png; done';
        exec($command, $ooout, $flag);

        exec('ls '.$pic_path.'/headgroup/others*pdf|wc -l', $pngnum, $flag);

        return response()->json(['code'=> 'success','pngnum'=> $pngnum,'color' => $pic_path.'headgroup/headgroupheatmap_'.$z.'.png','cum' => $pic_path.'headgroup/headgroupheatmap_'.$z.'.png','heatmap' => $pic_path.'headgroup/headgroupheatmap_'.$z.'.png']);
    }

    public function updatelipfa($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $g = $datas[1];
        $w = $datas[2];
        $e = $datas[3];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;

        exec('rm '.$pic_path.'FAchainVisual/*');

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/FAchainStat.R -r "' . $r_path . '" -v "' . $pic_path . '" -g "'.$g.'" -w '.$w.' -e '.$e;

        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #dd($ooout);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'FAchainVisual/tilePlot_*.pdf ' . $pic_path . 'FAchainVisual/fa_new.png';
        exec($command, $ooout, $flag);
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'FAchainVisual/heatmap_lipsubClass_*.pdf ' . $pic_path . 'FAchainVisual/faheatmap_new.png';
        exec($command, $ooout, $flag);

        $command = 'for file in ' . $pic_path . 'FAchainVisual/*.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.pdf*}.png.png; done';
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

        exec('ls '.$pic_path.'/headgroup/others*pdf|wc -l', $pngnum, $flag);

        return response()->json(['code'=> 'success','pngnum'=> $pngnum,'show' => $pic_path.'FAchainVisual/fa_new.png','heatmap' => $pic_path.'FAchainVisual/faheatmap_new.png']);
    }

    public function updatelipenrich($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $t = $datas[1];
        $g = $datas[2];
        $k = $datas[3];
        $l = $datas[4];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $enrich_path = '/home/zhangqb/tttt/public/' . $path.'enrich/';

        exec('rm '.$enrich_path.'*');

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

        return response()->json(['code'=> 'success','pngup' => $enrich_path.'up_LION-enrichment-plot.png','pngdown' => $enrich_path.'down_LION-enrichment-plot.png','png' => $enrich_path.'up_LION-enrichment-plot.png']);
    }

    public function updaternaVolcano($data)
    {
        #dd($data);
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $f = $datas[1];
        $p = $datas[2];
        $u = $datas[3];

        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;

        exec('rm '.$pic_path.'*');

        #火山图Rscript rnaVolcanoPlot.R -r "~/temp/" -s "~/temp/results2/" -f 2.0 -p 0.1 -u 20
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/rnaVolcanoPlot.R -r "' . $r_path . '" -s "' . $pic_path . '" -f ' . $f . ' -p ' . $p . ' -u ' . $u;
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'volcano_*.pdf ' . $pic_path . 'volcano_'.$f.$p.$u.'.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        return response()->json(['code'=> 'success','png' => $pic_path.'volcano_'.$f.$p.$u.'.png']);
    }
    public function updaternaHeatmap($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $v = $datas[1];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;
        exec('rm '.$pic_path.'*');
        #热图Rscript rnaHeatmapPlot.R -r "~/temp/" -w "~/temp/results2/" -v 75
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/rnaHeatmapPlot.R -r "' . $r_path . '" -w "' . $pic_path . '" -v ' . $v;
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'heatmap_top*.pdf ' . $pic_path . 'heatmap_show.png';
        #$command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'heatmap_top'.$v.'*.pdf ' . $pic_path . 'heatmap_'.$v.'.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        return response()->json(['code'=> 'success','png' => $pic_path.'heatmap_'.$v.'.png']);
    }

    public function showresultrna2($data)
    {
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;
 #$path是上一个处理数据程序的输出目录 $pic_path是本程序的输出目录
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
