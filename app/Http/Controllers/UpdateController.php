<?php

use App\Http\Controllers\UpdateController;
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function updatePCA(Request $request)
    {
    	$path = = $request->path;
    	$f = = $request->f;
    	$p = = $request->p;
    	$u = = $request->u;

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
    	$path = = $request->path;
    	$f = = $request->f;
    	$p = = $request->p;
    	$u = = $request->u;

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
    	$path = = $request->path;
    	$f = = $request->f;
    	$p = = $request->p;
    	$u = = $request->u;

    	$command = 'Rscript /home/zhangqb/program/dev/main_split/rnaVolcanoPlot.R -r "' . $path . '" -s "' . $pic_path . '" -f 2.0 -p 0.1 -u 20';
        try {
            exec($command);
        } catch (\Exception $e) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => 'RUN ERROR' . $command]);
        }

        return view('resultrna', ['title' => '上传数据', 'path' => $path . 'results/']);
    }
}
