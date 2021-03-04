<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TwoController;
use Illuminate\Http\Request;

class TwoController extends Controller
{
    private $home;
    public function getTwoPage()
    {
        return view('uploadtwo', ['title' => 'upload']);
    }

    public function getreaultPage(Request $request)
    {
        $command = $request->command;
        $outpath = $request->outpath;
        $m = $request->m;#missing
        $n = $request->n;#是否70%gk
        $s = $request->s;#自己设的值
        $g = $request->g;#列
        $k = $request->k;#行
        $omics1=$request->omics1;#
        $omics2=$request->omics2;#$outpath = 'mutil/example1'.md5("filename").'/';
        if (!$this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'correlationPlot.png')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        }

        $pic_path =  '/home/zhangqb/tttt/public/'.$outpath;

        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'correlationPlot.pdf ' . $pic_path . 'correlationPlot.png';
        if (!$this->isRunOver($pic_path.'correlationPlot.png')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        }
        
        #图片切割
        $command = 'python3 /home/zhangqb/program/dev/correlation/getSplitWindowArgs.py -p "' . $pic_path . '" -k ' . $k . ' -g ' . $g . ' -o "' . $pic_path . '"';
        if (!$this->isRunOver($pic_path.'splitWinArgs.csv')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        }
        $split = file_get_contents($pic_path . 'splitWinArgs.csv');
        #dd($split);
        preg_match_all("/^(.*?)\r\n(.*?)\r\n(.*?)\r\n/U", $split, $splits);
        $kongbai=explode(",", $splits[1][0]);
        $hang=explode(",", $splits[2][0]);#宽
        $lie=explode(",", $splits[3][0]);#高
        #dd($hang);



        $image = $pic_path.'correlationPlot.png';
        $size = getimagesize($image);
        $kongbai2[0]=$size[0] - array_sum($hang) - $kongbai[0]-count($hang)*2;
        $bgwidth = $size[0];
        $bgheigh = $size[1];
        $k1 = $g;#列
        $k2 = $k;
        $fgwidth = floor($size[0] / $k1);
        $fgheigh = floor($size[1] / $k2);

        #dd($omics1);
        $enrichpath = preg_replace('/\//', "++", $outpath);#下载的时候用
        return view('crossresult', ['image' => $image, 'enrichpath' => $enrichpath, 'bgwidth' => $bgwidth, 'bgheigh' => $bgheigh, 'fgwidth' => $fgwidth, 'fgheigh' => $fgheigh, 'k1' => $k1, 'k2' => $k2, 'kongbai' => $kongbai, 'kongbai2' => $kongbai2, 'hang' => $hang, 'lie' => $lie, 'omics1' => $omics1, 'omics2' => $omics2]);
    }

    public function gettwotwoPage(Request $request)
    {
        $file_datafile_left = $request->file_datafile_left;
        $file_descfile_left = $request->file_descfile_left;
        $file_datafile_right = $request->file_datafile_right;
        $file_descfile_right = $request->file_descfile_right;
        $omics1 = $request->omics_left;
        $omics2 = $request->omics_right;
        $delodd = $request->delodd;
        $data_type = $request->data_type;
        $m = $request->m;#missing
        $n = $request->n;#是否70%gk
        $s = $request->s;#自己设的值
        $g = $request->g;#列
        $k = $request->k;#行


        #t和u的设置
        $t = ['Lipidomics' => 'Lipids', 'Metabolomics' => 'Metabolites', 'Transcriptomics' => 'RNAseq', 'Proteomics' => 'Proteins'];
        if ($data_type == "microarray") {
            $t['Transcriptomics'] = 'MiAr';
        }
        #输出文件位置
        $outpath = 'mutil/' . $omics_left . $omics_right . $file_datafile_left . $file_datafile_right . md5($file_descfile_left . $file_descfile_right) . '/';
        is_dir($outpath) or mkdir($outpath, 0777, true);

        #执行程序
        #$command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/correlation/correlation_main.R -i "/home/zhangqb/program/branch/benchmark/input/HANLipidMediator_imm_forcor.CSV" -d "/home/zhangqb/program/branch/benchmark/input/HANsampleList_lipmid.csv" -t "Metabolites" -l F -m 0.67 -j "/home/zhangqb/program/branch/benchmark/input/HANgene_tidy.CSV" -e "/home/zhangqb/program/branch/benchmark/input/HANsampleList.CSV" -u "RNAseq" -g 6 -k 4 -n F -s 0.4 -o "' . $outpath . '"';
        if ($n) {
            $command='/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/correlation/correlation_main.R -i "/home/zhangqb/tttt/public/'.$file_datafile_left.'" -d "/home/zhangqb/tttt/public/'.$file_descfile_left.'" -t "'.$t[$omics1].'" -l '.$delodd.' -m '.$m.' -j "/home/zhangqb/tttt/public/'.$file_datafile_right.'" -e "/home/zhangqb/tttt/public/'.$file_descfile_right.'" -u "'.$t[$omics2].'" -g '.$g.' -k '.$k.' -n F -s '.$s.' -o "' . $outpath . '"';
            # code...
        }else{
            $command='/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/correlation/correlation_main.R -i "/home/zhangqb/tttt/public/'.$file_datafile_left.'" -d "/home/zhangqb/tttt/public/'.$file_descfile_left.'" -t "'.$t[$omics1].'" -l '.$delodd.' -m '.$m.' -j "/home/zhangqb/tttt/public/'.$file_datafile_right.'" -e "/home/zhangqb/tttt/public/'.$file_descfile_right.'" -u "'.$t[$omics2].'" -g '.$g.' -k '.$k.' -n T -o "' . $outpath . '"';
        }
        
        
        if (!$this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'correlationPlot.png')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        }

        $pic_path =  '/home/zhangqb/tttt/public/'.$outpath;

        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 -trim ' . $pic_path . 'correlationPlot.pdf ' . $pic_path . 'correlationPlot.png';
        if (!$this->isRunOver($pic_path.'correlationPlot.png')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        }
        
        #图片切割
        $command = 'python3 /home/zhangqb/program/dev/correlation/getSplitWindowArgs.py -p "' . $pic_path . '" -k ' . $k . ' -g ' . $g . ' -o "' . $pic_path . '"';
        if (!$this->isRunOver($pic_path.'splitWinArgs.csv')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        }
        $split = file_get_contents($pic_path . 'splitWinArgs.csv');
        #dd($split);
        preg_match_all("/^(.*?)\r\n(.*?)\r\n(.*?)\r\n/U", $split, $splits);
        $kongbai=explode(",", $splits[1][0]);
        $hang=explode(",", $splits[2][0]);#宽
        $lie=explode(",", $splits[3][0]);#高
        #dd($hang);



        $image = $pic_path.'correlationPlot.png';
        $size = getimagesize($image);
        $kongbai2[0]=$size[0] - array_sum($hang) - $kongbai[0]-count($hang)*2;
        $bgwidth = $size[0];
        $bgheigh = $size[1];
        $k1 = $g;#列
        $k2 = $k;
        $fgwidth = floor($size[0] / $k1);
        $fgheigh = floor($size[1] / $k2);

        #dd($omics1);
        $enrichpath = preg_replace('/\//', "++", $outpath);#下载的时候用
        return view('crossresult', ['image' => $image, 'enrichpath' => $enrichpath, 'bgwidth' => $bgwidth, 'bgheigh' => $bgheigh, 'fgwidth' => $fgwidth, 'fgheigh' => $fgheigh, 'k1' => $k1, 'k2' => $k2, 'kongbai' => $kongbai, 'kongbai2' => $kongbai2, 'hang' => $hang, 'lie' => $lie, 'omics1' => $omics1, 'omics2' => $omics2]);
    }

    public function getenrichPage($pos)
    {
        $poss=explode("--", $pos);
        $k1 = $poss[0]+1;#列gene
        $k2 = $poss[1]+1;
        $enrichpath=$poss[2];#$outpath
        $omics1=$poss[3];#$omics1
        $omics2=$poss[4];#$omics2
        $enrichpath = preg_replace('/\+\+/', "/", $enrichpath);#$enrichpath = preg_replace('/\//', "++", $outpath);
        $downloadpath = preg_replace('/\//', "++", $enrichpath);
        $gene = file_get_contents($enrichpath . 'genes_'.$k1.'.csv',0,null,0,1000);
        $lipid = file_get_contents($enrichpath . 'lipids_'.$k2.'.csv');

        return view('crossresultenrich', ['k1' => $k1,'k2' => $k2,'gene' => $gene,'lipid' => $lipid,'enrichpath' => $enrichpath,'downloadpath' => $downloadpath, 'omics1' => $omics1, 'omics2' => $omics2]);
    }

    public function getenenrichresultPage($pos)
    {
        $poss=explode("--", $pos);
        $k1 = $poss[0];#行列数gene
        $enrichpath=$poss[1];#$outpath
        $omics=$poss[2];#$omics
        $opath = preg_replace('/\+\+/', "/", $enrichpath);
        $command="";
        if ($omics == "Metabolomics") {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/enrich/metCorEnrich.R -i "/home/zhangqb/tttt/public/'.$opath.'" -j '.$k1.' -o "/home/zhangqb/tttt/public/'.$opath.'"';
            $resultfile="ora_dpi72.png";
        }
        if ($omics == "Lipidomics") {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/enrich/lipCorEnrich.R -i "/home/zhangqb/tttt/public/'.$opath.'" -j '.$k1.' -o "/home/zhangqb/tttt/public/'.$opath.'"';
            $resultfile="ora_dot_dpi72.png";
        }
        exec($command, $ooout, $flag);

        if ($flag == 1) {
            return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
        }
        return view('crossresultenrichresult', ['k1' => $k1,'opath' => $opath,'resultfile' => $resultfile,'downloadpath' => $downloadpath, 'omics' => $omics1]);

    }
    #设置参数
    public function canshu(Request $request)
    {
        dd($request);
        
        $file_datafile_left  = $request->file_datafile_left ;
        $file_descfile_left  = $request->file_descfile_left ;
        $file_datafile_right = $request->file_datafile_right;       
        $file_descfile_right = $request->file_descfile_right; 
        if ($file_datafile_left == "no data" || $file_descfile_left == "no data" || $file_datafile_right == "no data" || $file_descfile_left == "no data") {
            return view('errors.200', ['title' => 'No Data', 'msg' => 'Please upload your file!', 'back' => 'Go back upload Page']);
        }
        $omics_left  = $request->omics_left;
        $omics_right = $request->omics_right;
        
        if ($request->delodd) {
            $delodd = "T";
        }else{
            $delodd = "F";
        }
        $data_type = $request->data_type;

        #改成路径+文件名
        $file_datafile_left  = 'mutil/' . md($file_datafile_left) . '/' . $file_datafile_left ;
        $file_descfile_left  = 'mutil/' . md($file_descfile_left) . '/' . $file_descfile_left ;
        $file_datafile_right = 'mutil/' . md($file_datafile_right) . '/' . $file_datafile_right ;
        $file_descfile_right = 'mutil/' . md($file_descfile_right) . '/' . $file_descfile_right ;

        return view('canshutwotwo', ['file_datafile_left' => $file_datafile_left,'file_descfile_left' => $file_descfile_left,'file_datafile_right' => $file_datafile_right,'file_descfile_right' => $file_descfile_right,'omics_left' => $omics_left,'omics_right' => $omics_right,'delodd' => $delodd,'data_type' => $data_type,'m' => '0.67','g' => '4','k' => '4','s' => '0.8']);
    }
    private function isRunOver($file)
    {
        return file_exists($file) ? true : false;
    }
#设置例子的参数
    public function examplecanshu(Request $request)
    {
        $example = $request->exampleomics;
        if ($example == "Example1") {
            $outpath = 'mutil/example1'.md5("HANLipidMediator_imm_forcor.CSVHANsampleList_lipmid.csvHANsampleList.CSV").'/';
            is_dir($outpath) or mkdir($outpath, 0777, true);
            $omics1="Metabolomics";
            $omics2="Transcriptomics";
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/correlation/correlation_main.R -i "/home/zhangqb/program/branch/benchmark/input/HANLipidMediator_imm_forcor.CSV" -d "/home/zhangqb/program/branch/benchmark/input/HANsampleList_lipmid.csv" -t "Metabolites" -l F -m 0.67 -j "/home/zhangqb/program/branch/benchmark/input/HANgene_tidy.CSV" -e "/home/zhangqb/program/branch/benchmark/input/HANsampleList.CSV" -u "RNAseq" -g 6 -k 4 -n F -s 0.4 -o "' . $outpath . '"';
            return view('canshutwo', ['t' => '设置参数', 'l' => "F", 'm' => "0.67", 'u' => "RNAseq", 'g' => "6", 'k' => "4", 'n' => "F", 's' => "0.4", 'outpath' => $outpath, 'command' => $command, 'omics1' => $omics1, 'omics2' => $omics2]);
        }
        if ($example == "Example2") {
            $outpath = 'mutil/example2'.md5("lipids.csvRNAseq_genesymbol.csvsampleList.csv").'/';
            is_dir($outpath) or mkdir($outpath, 0777, true);
            $omics1="Lipidomics";
            $omics2="Transcriptomics";
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/correlation/correlation_main.R -i "/home/zhangqb/program/testData/SVFmultiomics_210118/input/lipids.csv" -d "/home/zhangqb/program/testData/SVFmultiomics_210118/input/sampleList.csv" -t "Lipids" -l T -m 0.67 -j "/home/zhangqb/program/testData/SVFmultiomics_210118/input/RNAseq_genesymbol.csv" -e "/home/zhangqb/program/testData/SVFmultiomics_210118/input/sampleList.csv" -u "RNAseq" -g 7 -k 6 -n T -o "' . $outpath . '"';
            return view('canshutwo', ['t' => '设置参数', 'l' => "T", 'm' => "0.67", 'u' => "RNAseq", 'g' => "7", 'k' => "6", 'n' => "T", 'outpath' => $outpath, 'command' => $command, 'omics1' => $omics1, 'omics2' => $omics2]);
        }
        if ($example == "Example3") {
            $outpath = 'mutil/example3'.md5("metabolites.csvRNAseq_genesymbol.csvsampleList.csv").'/';
            is_dir($outpath) or mkdir($outpath, 0777, true);
            $omics1="Metabolomics";
            $omics2="Transcriptomics";
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/correlation/correlation_main.R -i "/home/zhangqb/program/testData/SVFmultiomics_210118/input/metabolites.csv" -d "/home/zhangqb/program/testData/SVFmultiomics_210118/input/sampleList.csv" -t "Metabolites" -m 0.67 -j "/home/zhangqb/program/testData/SVFmultiomics_210118/input/RNAseq_genesymbol.csv" -e "/home/zhangqb/program/testData/SVFmultiomics_210118/input/sampleList.csv" -u "RNAseq" -g 7 -k 6 -n T -o "' . $outpath . '"';
            return view('canshutwo', ['t' => '设置参数', 'l' => "F", 'm' => "0.67", 'u' => "RNAseq", 'g' => "7", 'k' => "6", 'n' => "T", 'outpath' => $outpath, 'command' => $command, 'omics1' => $omics1, 'omics2' => $omics2]);
        }
        if ($example == "Example4") {
            $outpath = 'mutil/example4'.md5("metabolites_tidy2.csvproteins_Depletion_tidy.csvsampleList_lip.csv").'/';
            is_dir($outpath) or mkdir($outpath, 0777, true);
            $omics1="Metabolomics";
            $omics2="Proteomics";
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/program/dev/correlation/correlation_main.R -i "/home/zhangqb/program/testData/CerebrospinalFluid_multiomics/input/metabolites_tidy2.csv" -d "/home/zhangqb/program/testData/CerebrospinalFluid_multiomics/input/sampleList_lip.csv" -t "Metabolites" -m 0.67 -j "/home/zhangqb/program/testData/CerebrospinalFluid_multiomics/input/proteins_Depletion_tidy.csv" -e "/home/zhangqb/program/testData/CerebrospinalFluid_multiomics/input/sampleList_lip.csv" -u "Proteins" -g 7 -k 6 -n F -s 0.82 -o "' . $outpath . '"';
            return view('canshutwo', ['t' => '设置参数', 'l' => "F", 'm' => "0.67", 'u' => "Proteins", 'g' => "7", 'k' => "6", 'n' => "F", 's' => "0.82", 'outpath' => $outpath, 'command' => $command, 'omics1' => $omics1, 'omics2' => $omics2]);
        }
    }

    public function upload(Request $request)
    {
        #dd("vv");
        $file = $request->file('file');
        #dd($file);
        $allowed_extensions = ["csv", "txt", "CSV"]; //多类型
        //判断文件是否是允许上传的文件类型
        if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            $data = [
                'status' => 0, //返回状态码，在js中用改状态判断是否上传成功。
                'msg' => '不支持此格式',
            ];
            return json_encode($data);
        }

        //保存文件，新建路径，拷贝文件
        //路径都是public--mutil下的文件名的md5值
        $path = md5($file->getClientOriginalName());
        $destinationPath = 'mutil/' . $path . '/';
        is_dir($destinationPath) or mkdir($destinationPath, 0777, true);
        $extension = $file->getClientOriginalExtension();
        $fileName = $extension;
        $file->move($destinationPath, $file->getClientOriginalName());
        $data = [
            'status' => 1, //返回状态码，在js中用改状态判断是否上传成功。
            'msg' => $destinationPath . $fileName, //上传成功，返回服务器上文件名字
            'originalname' => $file->getClientOriginalName(), //上传成功，返回上传原文件名字
            'file' => $file, //上传成功，返回上传原文件名字
        ];
        return json_encode($data);

    }

    public function crosscanshu(Request $request)
    {
        $omics = $request->omics;
        $omics = $request->omics;
        $omics = $request->omics;
        return view('crosscanshu', ['title' => '设置参数']);
    }
}
