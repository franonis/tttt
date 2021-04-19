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

        exec('rm '.$pic_path.'MARresults/volcano_reg_*.pdf');
        
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipVolcanoPlot.R -r "' . $r_path . '" -s ' . $s . ' -p "' . $pic_path . '" -b F -x "' . $x . '" -j ' . $j . ' -k ' . $k . ' -m ' . $m . ' -w ' . $w . ' ';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/volcano_reg_*.pdf ' . $pic_path . 'MARresults/volcano_show.png';
        exec($command, $ooout, $flag);
        if ($s == "T") {
            $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'MARresults/volcano_regClass_*.pdf ' . $pic_path . 'MARresults/volcano_show2.png';
            exec($command, $ooout, $flag);
        }
        
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        return response()->json(['code'=> 'success','png1' => $pic_path.'MARresults/volcano_show.png','png2' => $pic_path.'MARresults/volcano_show2.png','sub' => $s]);
    }

    public function updatelipHeatmap($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $e = $datas[1];
        
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;

        exec('rm '.$pic_path.'MARresults/heatmap_top*.pdf');


        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipHeatmapPlot.R -r "' . $r_path . '" -y "' . $pic_path . '" -e ' . $e;
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

        return response()->json(['code'=> 'success','png' => $pic_path.'MARresults/heatmap_show.png']);
    }

    public function updatelipheadheatmap($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $w = $datas[1];
        $z = $datas[2];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;

        exec('rm '.$pic_path.'headgroup/heatmap_lipClassSummary_*.pdf');

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipSumClassHeatmapPlot.R -r "' . $r_path . '" -u "' . $pic_path . '" -w '.$w.' -z ' . $z;
        #dd($command);
        exec($command, $ooout, $flag);
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'headgroup/heatmap_lipClassSummary_*.pdf ' . $pic_path . 'headgroup/headgroupheatmap_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #dd($ooout);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        return response()->json(['code'=> 'success','png' => $pic_path.'headgroup/headgroupheatmap_show.png']);
    }

    public function updateliphead($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $w = $datas[1];
        $z = $datas[2];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;

        exec('rm '.$pic_path.'headgroup/headgroup*pdf');

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/headgroupStat.R -r "' . $r_path . '" -u "' . $pic_path . '" -w T';
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

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/lipSumClassHeatmapPlot.R -r "' . $r_path . '" -u "' . $pic_path . '" -w '.$w.' -z ' . $z;
        #dd($command);
        exec($command, $ooout, $flag);
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'headgroup/heatmap_lipClassSummary_*.pdf ' . $pic_path . 'headgroup/headgroupheatmap_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #dd($ooout);
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }

        $command = 'for file in ' . $pic_path . 'headgroup/*.pdf; do /home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim $file ${file%%.pdf*}.png; done';
        exec($command, $ooout, $flag);

        exec('ls '.$pic_path.'/headgroup/others*pdf|wc -l', $pngnum, $flag);

        return response()->json(['code'=> 'success','pngnum'=> $pngnum,'color' => $pic_path.'headgroup/headgroupcolor_show.png','cum' => $pic_path.'headgroup/headgroupcum_show.png','heatmap' => $pic_path.'headgroup/headgroupheatmap_show.png']);
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

        exec('rm '.$pic_path.'FAchainVisual/*pdf');

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

        #$command='cd /home/zhangqb/tttt/public/'.$path.'results/FAchainVisual/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        #exec($command,$fapng,$flag);
        #$command='cd /home/zhangqb/tttt/public/'.$outpath.'results/FAchainVisual/ && ls fa_show*.png | awk -F\'[_.]\' \'{print $2}\'';
        #exec($command,$fashowpng,$flag); 
        #$command='cd /home/zhangqb/tttt/public/'.$path.'results/headgroup/ && ls other*.png | awk -F\'[_.]\' \'{print $2}\'';
        #exec($command,$headpng,$flag);

        exec('ls '.$pic_path.'/FAchainVisual/others*pdf|wc -l', $pngnum, $flag);
        exec('ls '.$pic_path.'/FAchainVisual/fa_show*.png|wc -l', $pngshownum, $flag);

        return response()->json(['code'=> 'success','pngnum'=> $pngnum,'pngshownum'=> $pngshownum,'show' => $pic_path.'FAchainVisual/fa_show.png','heatmap' => $pic_path.'FAchainVisual/faheatmap_show.png']);
    }

    public function updatelipenrich($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $t = $datas[1];
        $j = $datas[2];
        $k = $datas[3];
        $l = $datas[4];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        #dd($r_path);
        $enrich_path = '/home/zhangqb/tttt/public/' . $path.'enrich/';

        #exec('rm '.$enrich_path.'*');
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

        return response()->json(['code'=> 'success','pngup' => $enrich_path.'up_LION-enrichment-plot.png','pngdown' => $enrich_path.'down_LION-enrichment-plot.png','png' => $enrich_path.'LION-enrichment-plot.png']);
    }

    public function updatemetenrich($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $j = $datas[1];
        $k = $datas[2];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        #dd($r_path);
        $enrich_path = '/home/zhangqb/tttt/public/' . $path.'enrich/';

        #exec('rm '.$enrich_path.'*');
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/met_preEnrich.R -r "' . $r_path . '"  -j '.$j.' -k '.$k.' -p "' . $enrich_path . '"';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/metRegEnrich.R -i "' . $enrich_path . '"  -o "' . $enrich_path . '"';
        #dd($command);
        exec($command, $ooout, $flag);

        if ($this->isRunOver('/home/zhangqb/tttt/public/' . $enrich_path . 'up_ora_dpi72.png') ) {
            $noup = "no";
        }else{
            $noup = "yes";
        }
        if ($this->isRunOver('/home/zhangqb/tttt/public/' . $enrich_path . 'down_ora_dpi72.png') ) {
            $nodown = "no";
        }else{
            $nodown = "yes";
        }
        return response()->json(['code'=> 'success','noup' => $noup,'nodown' => $nodown]);
    }

    public function updateproenrich($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $j = $datas[1];
        $k = $datas[2];
        $t = $datas[3];
        $s = $datas[4];
        $c = $datas[5];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        #dd($r_path);
        $enrich_path = '/home/zhangqb/tttt/public/' . $path.'enrich/';

        exec('rm '.$enrich_path.'*pdf');
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/met_preEnrich.R -r "' . $r_path . '"  -j '.$j.' -k '.$k.' -p "' . $enrich_path . '"';
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/proteinRegEnrich.R -i "' . $enrich_path . '" -t "'.$t.'" -s '.$s.' -c "'.$c.'" -o "' . $enrich_path . '"';
        #dd($command);
        exec($command, $ooout, $flag);

        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $enrich_path . 'up*.pdf ' . $enrich_path . 'up.png';
        exec($command, $ooout, $flag);

        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $enrich_path . 'down*.pdf ' . $enrich_path . 'down.png';
        exec($command, $ooout, $flag);

        if ($this->isRunOver('/home/zhangqb/tttt/public/' . $enrich_path . 'up.png') ) {
            $noup = "no";
        }else{
            $noup = "yes";
        }
        if ($this->isRunOver('/home/zhangqb/tttt/public/' . $enrich_path . 'down.png') ) {
            $nodown = "no";
        }else{
            $nodown = "yes";
        }
        return response()->json(['code'=> 'success','noup' => $noup,'nodown' => $nodown]);
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

        exec('rm '.$pic_path.'volcano_*.pdf');

        #火山图Rscript rnaVolcanoPlot.R -r "~/temp/" -s "~/temp/results2/" -f 2.0 -p 0.1 -u 20
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/main_split/rnaVolcanoPlot.R -r "' . $r_path . '" -s "' . $pic_path . '" -f ' . $f . ' -p ' . $p . ' -u ' . $u;
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'volcano_*.pdf ' . $pic_path . 'volcano_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        return response()->json(['code'=> 'success','png' => $pic_path.'volcano_show.png']);
    }
    public function updaternaHeatmap($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $v = $datas[1];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;
        exec('rm '.$pic_path.'heatmap_top*.pdf');
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
        return response()->json(['code'=> 'success','png' => $pic_path.'heatmap_show.png']);
    }

    public function updaternaenrich($data)
    {
        $datas= explode("----", $data);
        $path = preg_replace('/\+\+/', "/", $datas[0]);
        $t = $datas[1];
        $g = $datas[2];
        $c = $datas[3];
        $f = $datas[4];
        $p = $datas[5];
        $s = $datas[6];
        $r_path = '/home/zhangqb/tttt/public/' . $path . '../';
        $pic_path = '/home/zhangqb/tttt/public/' . $path;
        exec('rm '.$pic_path.'*GOenrich*pdf');
        #热图Rscript rnaHeatmapPlot.R -r "~/temp/" -w "~/temp/results2/" -v 75
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/geneRegEnrich.R -r "' . $r_path . '" -o "' . $pic_path . '" -f '.$f.' -p '.$p.' -t "'.$t.'" -g "'.$g.'" -s '.$s.' -c "'.$c.'"';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'up*.pdf ' . $pic_path . 'up.png';
        exec($command, $ooout, $flag);

        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'down*.pdf ' . $pic_path . 'down.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        return response()->json(['code'=> 'success']);
    }



    public function updatemutilenrich($data)
    {
        $datas= explode("----", $data);
        $opath = preg_replace('/\+\+/', "/", $datas[0]);#末尾有gj
        $omics = $datas[1];
        $k = $datas[2];
        $t = $datas[3];
        $s = $datas[4];
        $c = $datas[5];
        if ($omics == "Transcriptomics") {
            $g = $datas[6];
        }
        
        #$opath = $path;#$opath = preg_replace('/\//', "++", $outpath);
        exec('rm '.$opath.'enrich/GOenrich*');
        if ($omics == "Transcriptomics") {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/geneCorEnrich.R -i "/home/zhangqb/tttt/public/'.$opath.'enrich/../" -k '.$k.' -t "'.$t.'" -g "'.$g.'" -s '.$s.' -c "'.$c.'" -o "/home/zhangqb/tttt/public/'.$opath.'enrich/"';
        }
        if ($omics == "Proteomics") {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/geneCorEnrich.R -i "/home/zhangqb/tttt/public/'.$opath.'enrich/../" -k '.$k.' -t "'.$t.'" -s '.$s.' -c "'.$c.'" -o "/home/zhangqb/tttt/public/'.$opath.'enrich/"';
        }
        #dd($command);
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        exec('cp data_circos.RData '.'/home/zhangqb/tttt/public/'.$opath.'enrich/');
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim /home/zhangqb/tttt/public/'.$opath.'enrich/GOenrich_'.$c.'.pdf /home/zhangqb/tttt/public/'.$opath.'enrich/GOenrich.png';
        exec($command, $ooout, $flag);
        return response()->json(['code'=> 'success']);
    }

    public function updatemutilcircos($data)
    {
        $datas= explode("----", $data);
        $opath = preg_replace('/\+\+/', "/", $datas[0]);#末尾有gj
        $k = $datas[1];
        $j = $datas[2];
        $t = $datas[3];
        $n = $datas[4];

        #$opath = $path;#$opath = preg_replace('/\//', "++", $outpath);#末尾有/

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/correlation/circos_plot.R -r "/home/zhangqb/tttt/public/'.$opath.'enrich/" -i "/home/zhangqb/tttt/public/'.$opath.'enrich/../" -j '.$j.' -k '.$k.' -t '.$t.' -n '.$n.' -o "/home/zhangqb/tttt/public/'.$opath.'enrich/"';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            #return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim /home/zhangqb/tttt/public/'.$opath.'enrich/circosPlot.pdf /home/zhangqb/tttt/public/'.$opath.'enrich/circosPlot.png';
        exec($command, $ooout, $flag);
        return response()->json(['code'=> 'success']);
    }

    private function isRunOver($file)
    {
        return file_exists($file) ? true : false;
    }

}
