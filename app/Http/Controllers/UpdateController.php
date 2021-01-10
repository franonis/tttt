<?php

use App\Http\Controllers\UpdateController;
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function updatePCA(Request $request)
    {
        $path = $request->path;
        $f = $request->f;
        $p = $request->p;
        $u = $request->u;

        $command = 'Rscript /home/zhangqb/program/dev/main_split/rnaVolcanoPlot.R -r "' . $path . '" -s "' . $pic_path . '" -f 2.0 -p 0.1 -u 20';
        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }

        return view('resultrna', ['title' => '上传数据', 'path' => $path . 'results/']);
    }
    public function updateHeatmap(Request $request)
    {
        dd($request);
        $path = $request->path;
        $f = $request->f;
        $p = $request->p;
        $u = $request->u;

        $command = 'Rscript /home/zhangqb/program/dev/main_split/rnaVolcanoPlot.R -r "' . $path . '" -s "' . $pic_path . '" -f 2.0 -p 0.1 -u 20';
        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }

        return view('resultrna', ['title' => '上传数据', 'path' => $path . 'results/']);
    }
    public function updateVolcano(Request $request)
    {
        $path = $request->path;
        $f = $request->f;
        $p = $request->p;
        $u = $request->u;

        $command = 'Rscript /home/zhangqb/program/dev/main_split/rnaVolcanoPlot.R -r "' . $path . '" -s "' . $pic_path . '" -f 2.0 -p 0.1 -u 20';
        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }

        return view('resultrna', ['title' => '上传数据', 'path' => $path . 'results/']);
    }

    public function huatu(Request $request)
    {
        $path = $request->path;
        $r_path = '/home/zhangqb/tttt/public/' . $path;
        $pic_path = '/home/zhangqb/tttt/public/' . $path . 'results/'; #$path是上一个处理数据程序的输出目录 $pic_path是本程序的输出目录
        is_dir($pic_path) or mkdir($pic_path, 0777, true);

        $command = 'Rscript /home/zhangqb/program/dev/main_split/show_variability.R -r "' . $r_path . '" -o "' . $pic_path . '"';
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
        $command = 'Rscript /home/zhangqb/program/dev/main_split/rnaVolcanoPlot.R -r "' . $r_path . '" -s "' . $pic_path . '" -f 2.0 -p 0.1 -u 20';
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
        $command = 'Rscript /home/zhangqb/program/dev/main_split/rnaHeatmapPlot.R -r "' . $r_path . '" -w "' . $pic_path . '" -v 75';
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
}
