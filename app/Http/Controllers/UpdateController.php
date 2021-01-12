<?php

namespace App\Http\Controllers;

use App\Http\Controllers\UpdateController;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function updatePCA(Request $request)
    {
        $path = $request->path;
        $f = $request->f;
        $p = $request->p;
        $u = $request->u;

        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/rnaVolcanoPlot.R -r "' . $path . '" -s "' . $pic_path . '" -f 2.0 -p 0.1 -u 20';
        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }

        return view('resultrna', ['title' => '上传数据', 'path' => $path]);
    }

    public function updateVolcano(Request $request)
    {
        $path = $request->path;
        $f = $request->f;
        $p = $request->p;
        $u = $request->u;
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';

        #火山图Rscript rnaVolcanoPlot.R -r "~/temp/" -s "~/temp/results2/" -f 2.0 -p 0.1 -u 20
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/rnaVolcanoPlot.R -r "' . $r_path . '" -s "' . $pic_path . '" -f ' . $f . ' -p ' . $p . ' -u ' . $u . '';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'volcano_*.pdf ' . $pic_path . 'volcano_show.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        return view('resultrna', ['title' => '上传数据', 'path' => $path, 'f' => $f, 'p' => $p, 'u' => $u]);
    }
    public function updateHeatmap(Request $request)
    {
        #dd($request);
        $path = $request->path;
        $v = $request->v;
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/';
        #热图Rscript rnaHeatmapPlot.R -r "~/temp/" -w "~/temp/results2/" -v 75
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/main_split/rnaHeatmapPlot.R -r "' . $r_path . '" -w "' . $pic_path . '" -v ' . $v;
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'heatmap_top*.pdf ' . $pic_path . 'heatmap_top.png';
        exec($command, $ooout, $flag);
        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }
        return view('resultrna', ['title' => '上传数据', 'path' => $path, 'v' => $v]);
    }

}
