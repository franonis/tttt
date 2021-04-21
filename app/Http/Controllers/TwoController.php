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
        #if (!$this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'correlationPlot.png')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        #}

        $pic_path =  '/home/zhangqb/tttt/public/'.$outpath;

        $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 ' . $pic_path . 'correlationPlot.pdf ' . $pic_path . 'correlationPlot.png';
        #if (!$this->isRunOver($pic_path.'correlationPlot.png')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        #}
        
        #图片切割
        $command = 'python3 /home/zhangqb/tttt/public/program/dev/correlation/getSplitWindowArgs.py -p "' . $pic_path . '" -o "' . $pic_path . '"';
        #if (!$this->isRunOver($pic_path.'splitWinArgs.csv')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        #}
        $split = file_get_contents($pic_path . 'splitWinArgs.csv');
        #dd($split);
        preg_match_all("/^(.*?)\r\n(.*?)\r\n(.*?)\r\n/U", $split, $splits);
        $kongbai=explode(",", $splits[1][0]);
        $hang=explode(",", $splits[2][0]);#宽
        $lie=explode(",", $splits[3][0]);#高
        #dd($hang);



        $image = $pic_path.'correlationPlot.png';
        $size = getimagesize($image);
        $kongbai2=$size[0] - array_sum($hang) - $kongbai[0]-count($hang)*2;
        $bgwidth = $size[0];
        $bgheigh = $size[1];
        $g = $g;#列
        $k2 = $k;
        $fgwidth = floor($size[0] / $g);
        $fgheigh = floor($size[1] / $k2);

        #dd($omics1);
        $enrichpath = preg_replace('/\//', "++", $outpath);#下载的时候用
        return view('crossresult', ['image' => $image, 'enrichpath' => $enrichpath, 'bgwidth' => $bgwidth, 'bgheigh' => $bgheigh, 'fgwidth' => $fgwidth, 'fgheigh' => $fgheigh, 'g' => $g, 'k2' => $k2, 'kongbai' => $kongbai, 'kongbai2' => $kongbai2, 'hang' => $hang, 'lie' => $lie, 'omics1' => $omics1, 'omics2' => $omics2]);
    }
    #非例子数据的多组学数据，得到切割图片页面
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
        $m = $m / 100;
        $n = $request->n;#是否70%gk
        $s = $request->s;#自己设的值
        $g = $request->g;#列col
        $k = $request->k;#行row
        $b = $request->b;
        $c = $request->c;
        $f = $request->f;
        $p = $request->p;

        #t和u的设置
        $t = ['Lipidomics' => 'Lipids', 'Metabolomics' => 'Metabolites', 'Transcriptomics' => 'RNAseq', 'Proteomics' => 'Proteins'];
        if ($data_type == "microarray") {
            $t['Transcriptomics'] = 'MiAr';
        }
        #ns的组合
        if ($n) {
            $ns=' -n F -s '.$s;
        }else{
            $ns=' -n T';
        }
        #不同聚类的命令，对应的参数，不同的输出路径
        if ($b == "hierarchical" || $b == "k_means") {
            $keycanshudir=$m . $n . $s . $g . $k . '/';
            $keycanshu= ' -m '. $m . $ns . ' -g ' . $g . ' -k ' . $k;
            $col = $g;
            $row = $k;
        }
        if ($b == "DBSCAN") {
            $keycanshudir=$m . $n . $s . $c . $f . '/';
            $keycanshu= ' -m '. $m . $ns . ' -c ' . $c . ' -f ' . $f;
            $col = $c;
            $row = $f;

        }
        if ($b == "MCL") {
            $keycanshudir=$m . $n . $s . $p . '/';
            $keycanshu= ' -m '. $m . $ns . ' -p ' . $p;
        }

        $outpath = 'mutil/'. $omics1 . $omics2 . md5($file_descfile_left . $file_descfile_right) . '/' . $b  . $keycanshudir;
        is_dir($outpath) or mkdir($outpath, 0777, true);

        $command='/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/correlation/correlation_main.R -i "/home/zhangqb/tttt/public/'.$file_datafile_left.'" -d "/home/zhangqb/tttt/public/'.$file_descfile_left.'" -t "'.$t[$omics1].'" -l '.$delodd.' -j "/home/zhangqb/tttt/public/'.$file_datafile_right.'" -e "/home/zhangqb/tttt/public/'.$file_descfile_right.'" -u "'.$t[$omics2].'" -o "' . $outpath . '" -b "'.$b.'"'. $keycanshu;

        
        
        #if (!$this->isRunOver('/home/zhangqb/tttt/public/' . $outpath . 'correlationPlot.png')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        #}

        $pic_path =  '/home/zhangqb/tttt/public/'.$outpath;

        $command = '/home/zhangqb/software/ImageMagick/bin/convert -background white -flatten -quality 100 ' . $pic_path . 'correlationPlot.pdf ' . $pic_path . 'correlationPlot.png';
        #if (!$this->isRunOver($pic_path.'correlationPlot.png')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        #}
        
        #图片切割
        
        $command = 'python3 /home/zhangqb/tttt/public/program/dev/correlation/getSplitWindowArgs.py -i "' . $pic_path . '" -o "' . $pic_path . '"';
        #if (!$this->isRunOver($pic_path.'splitWinArgs.csv')) {
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
        #}
        $split = file_get_contents($pic_path . 'splitWinArgs.csv');
        #dd($split);
        preg_match_all("/^(.*?)\r\n(.*?)\r\n(.*?)\r\n/U", $split, $splits);
        #dd($split);
        $kongbai=explode(",", $splits[1][0]);
        $hang=explode(",", $splits[2][0]);#宽
        $lie=explode(",", $splits[3][0]);#高
        #dd($hang);
        $shujiange = -2;
        $hengjiange = 3;

        if ($b == "MCL") {
            $col = count($hang);
            $row = count($lie);
        }
        
        $image = $pic_path.'correlationPlot.png';
        $size = getimagesize($image);
        $kongbai2=$size[0] - array_sum($hang) - $kongbai[0]-count($hang)*2;
        $bgwidth = $size[0];
        $bgheigh = $size[1];
        $g = $g;#列
        $k2 = $k;
        $fgwidth = floor($size[0] / $col);
        $fgheigh = floor($size[1] / $row);
        $diyihangkongbai = '<img style="width:'. $bgwidth.'px;height:'. $kongbai[1].'px;opacity: 0%;" src="http://www.lintwebomics.info/images/gg.png" />';
        if ($b == "k_means" or $b == "DBSCAN" or $b == "MCL") {
            $kongbai[0]=$kongbai[0]*0.95;
            $shujiange = 1;
            $kongbai2=$size[0] - array_sum($hang) - $kongbai[0]-count($hang)*5-1;
            $hengjiange = 4;
            $diyihangkongbai = '<div style="width:'. $bgwidth.'px;height:'. $kongbai[1].'px;opacity: 88%;" ><p>.</p></div>';
        }

        #dd($omics1); 
        $enrichpath = preg_replace('/\//', "++", $outpath);#下载的时候用
        return view('crossresult', ['image' => $image, 'enrichpath' => $enrichpath, 'bgwidth' => $bgwidth, 'bgheigh' => $bgheigh, 'fgwidth' => $fgwidth, 'fgheigh' => $fgheigh, 'col' => $col, 'row' => $row, 'kongbai' => $kongbai, 'kongbai2' => $kongbai2, 'shujiange' => $shujiange, 'hengjiange' => $hengjiange,'hang' => $hang, 'lie' => $lie, 'omics1' => $omics1, 'omics2' => $omics2, 'diyihangkongbai' => $diyihangkongbai]);
    }

    public function getenrichPage($pos)
    {
        #exec('rm ./*qs');
        $poss=explode("--", $pos);
        $g = $poss[0]+1;#列gene
        $j = $poss[1]+1;#行lipid
        $downloadpath=$poss[2];#$outpath
        $omics1=$poss[3];#$omics1lip
        $omics2=$poss[4];#$omics2tran
        $opath = preg_replace('/\+\+/', "/", $downloadpath);#$opath = preg_replace('/\//', "++", $outpath);#末尾有/
        $gene = 'genes_'.$g.'.csv';
        $lipid = 'lipids_'.$j.'.csv';
        $opath = $opath.$g.$j;
        is_dir($opath.'enrich/') or mkdir($opath.'enrich/', 0777, true);
        if ($omics1 == "Metabolomics") {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/metCorEnrich.R -i "/home/zhangqb/tttt/public/'.$opath.'enrich/../" -j '.$j.' -o "/home/zhangqb/tttt/public/'.$opath.'enrich/"';
            
            #if (!$this->isRunOver('/home/zhangqb/tttt/public/' .$opath.'enrich/ora_dpi72.png') ){
            exec($command, $ooout, $flag);
                if ($flag == 1) {
                #    dd($ooout);
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command.$flag]);
                }
            #}
            if ($this->isRunOver('/home/zhangqb/tttt/public/' .$opath.'enrich/ora_dpi72.png') ){
                $resultpng1 = '<img id="resultpng1" src="http://www.lintwebomics.info/' .$opath.'enrich/ora_dpi72.png" style="height:50%;width: 60%;">';
            }else{
                $resultpng1='<p>Can not do metabolite set enrichment! Try use <a href="http://www.metaboanalyst.ca/home.xhtml" style="color:deepskyblue;">MetaboAnalyst</a> website.</p>';
            }
        }
        if ($omics1 == "Lipidomics") {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/lipCorEnrich.R -i "/home/zhangqb/tttt/public/'.$opath.'enrich/../" -j '.$j.' -o "/home/zhangqb/tttt/public/'.$opath.'enrich/"';
            
            #if (!$this->isRunOver('/home/zhangqb/tttt/public/' .$opath.'enrich/LION-enrichment-plot.png') ){
                exec($command, $ooout, $flag);
                if ($flag == 1) {
                    return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
                }
            #}
            if ($this->isRunOver('/home/zhangqb/tttt/public/' .$opath.'enrich/LION-enrichment-plot.png') ){
                $resultpng1 = '<img id="resultpng1" src="http://www.lintwebomics.info/' .$opath.'enrich/LION-enrichment-plot.png" style="height:50%;width: 60%;">';
            }else{
                $resultpng1='<p>No genes enriched! Try check your data!</p>';
            }
        }

        if ($omics2 == "Transcriptomics") {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/geneCorEnrich.R -i "/home/zhangqb/tttt/public/'.$opath.'enrich/../" -k '.$g.' -t "mmu" -g "SYMBOL" -s 50 -c "Biological_Process" -o "/home/zhangqb/tttt/public/'.$opath.'enrich/"';
        }
        if ($omics2 == "Proteomics") {
            $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/enrich/geneCorEnrich.R -i "/home/zhangqb/tttt/public/'.$opath.'enrich/../" -k '.$g.' -t "hsa" -s 50 -c "Biological_Process" -o "/home/zhangqb/tttt/public/'.$opath.'enrich/"';
        }
        #dd($command);
        
        #if (!$this->isRunOver('/home/zhangqb/tttt/public/' .$opath.'enrich/GOenrich.png') ){
            exec($command, $ooout, $flag);
            #dd($command);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
            exec('cp data_circos.RData '.'/home/zhangqb/tttt/public/'.$opath.'enrich/');
            $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 /home/zhangqb/tttt/public/'.$opath.'enrich/GOenrich_Biological_Process.pdf /home/zhangqb/tttt/public/'.$opath.'enrich/GOenrich.png';
            exec($command, $ooout, $flag);

        #}
        if ($this->isRunOver('/home/zhangqb/tttt/public/' .$opath.'enrich/GOenrich.png') ){
            $resultpng2 = '<img id="resultpng2" src="http://www.lintwebomics.info/' .$opath.'enrich/GOenrich.png" style="height:50%;width: 60%;">';
        }else{
            $resultpng2='<p>No genes enriched! Try check your data!</p>';
        }

        #circos
        #is_dir($opath.'circos/') or mkdir($opath.'circos/', 0777, true);
        #输出文件也在enrich下
        $command = '/home/new/R-3.6.3/bin/Rscript /home/zhangqb/tttt/public/program/dev/correlation/circos_plot.R -r "/home/zhangqb/tttt/public/'.$opath.'enrich/" -i "/home/zhangqb/tttt/public/'.$opath.'enrich/../" -j '.$j.' -k '.$g.' -t 0.8 -n 25 -o "/home/zhangqb/tttt/public/'.$opath.'enrich/"';
        
        #if (!$this->isRunOver('/home/zhangqb/tttt/public/' .$opath.'enrich/circosPlot.png') ){
            exec($command, $ooout, $flag);
            if ($flag == 1) {
                return view('errors.200', ['title' => 'RUN ERROR', 'msg' => $command]);
            }
            $command = '/home/zhangqb/software/ImageMagick/bin/convert -quality 100 /home/zhangqb/tttt/public/'.$opath.'enrich/circosPlot.pdf /home/zhangqb/tttt/public/'.$opath.'enrich/circosPlot.png';
            exec($command, $ooout, $flag);
        #}
        if ($this->isRunOver('/home/zhangqb/tttt/public/' .$opath.'enrich/circosPlot.png') ){
            $circos = '<img id="circos" src="http://www.lintwebomics.info/' .$opath.'enrich/circosPlot.png" style="height:100%;width: 100%;">';
        }else{
            $circos='<p>Please check your correlation threshold. It may be too strict to filter.</p>';
        }

        return view('crossresultenrich', ['g' => $g,'t' => 0.6,'n' => 20,'j' => $j,'gene' => $gene,'lipid' => $lipid,'downloadpath' => $downloadpath, 'omics1' => $omics1, 'omics2' => $omics2, 's' => '50', 'resultpng1' => $resultpng1, 'resultpng2' => $resultpng2, 'circos' => $circos]);
    }


    
    #设置参数
    public function canshu(Request $request)
    {
        #dd($request);
        
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
        $file_datafile_left  = 'mutil/' . md5($file_datafile_left) . '/' . $file_datafile_left ;
        $file_descfile_left  = 'mutil/' . md5($file_descfile_left) . '/' . $file_descfile_left ;
        $file_datafile_right = 'mutil/' . md5($file_datafile_right) . '/' . $file_datafile_right ;
        $file_descfile_right = 'mutil/' . md5($file_descfile_right) . '/' . $file_descfile_right ;

        return view('canshutwotwo', ['file_datafile_left' => $file_datafile_left,'file_descfile_left' => $file_descfile_left,'file_datafile_right' => $file_datafile_right,'file_descfile_right' => $file_descfile_right,'omics_left' => $omics_left,'omics_right' => $omics_right,'delodd' => $delodd,'data_type' => $data_type,'m' => '67','g' => '4','k' => '4','s' => '0.8','c' => '4','f' => '3','p' => '0.55']);
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
            #命令
            #Rscript correlation_main.R -i "./branch/benchmark/input/HANLipidMediator_imm_forcor.CSV" -d "./branch/benchmark/input/HANsampleList_lipmid.csv" -t "Metabolites" -l F -m 0.67 -j "./branch/benchmark/input/HANgene_tidy.CSV" -e "./branch/benchmark/input/HANsampleList.CSV" -u "RNAseq" -g 6 -k 4 -n F -s 0.4 -o "~/temp/cor_hi/" -b "hierarchical" 
            #改成路径+文件名
            $file_datafile_left  = 'program/branch/benchmark/input/HANLipidMediator_imm_forcor.CSV' ; 
            $file_descfile_left  = 'program/branch/benchmark/input/HANsampleList_lipmid.csv' ; 
            $file_datafile_right = 'program/branch/benchmark/input/HANgene_tidy.CSV' ; 
            $file_descfile_right = 'program/branch/benchmark/input/HANsampleList.CSV' ;
            $delodd = 'F';
            $data_type = '';
            $n = 'F'; 
            $s = '0.4'; 
            $g = 6; 
            $k = 4; 
            $b = "hierarchical" ; 
            $c = 6; 
            $f = 4; 
            $p = 0.55; 
            $omics_left="Metabolomics";
            $omics_right="Transcriptomics";
        }
        if ($example == "Example2") {
            #命令
            #Rscript correlation_main.R -i "./testData/SVFmultiomics_210118/input/lipids.csv" -d "./testData/SVFmultiomics_210118/input/sampleList.csv" -t "Lipids" -l T -m 0.67 -j "./testData/SVFmultiomics_210118/input/RNAseq_genesymbol.csv" -e "./testData/SVFmultiomics_210118/input/sampleList.csv" -u "RNAseq" -g 7 -k 6 -n T -o "~/temp/cor_kmeans/" -b "k_means"
            #改成路径+文件名
            $file_datafile_left  = 'program/testData/SVFmultiomics_210118/input/lipids.csv'  ;
            $file_descfile_left  = 'program/testData/SVFmultiomics_210118/input/sampleList.csv'  ;
            $file_datafile_right = 'program/testData/SVFmultiomics_210118/input/RNAseq_genesymbol.csv'  ;
            $file_descfile_right = 'program/testData/SVFmultiomics_210118/input/sampleList.csv' ;
            $delodd = "T";
            $data_type = '';
            $n =  'T';
            $s =  '';
            $g =  7;
            $k =  6;
            $b =  "k_means";
            $c =  4;
            $f =  3;
            $p =  0.55;
            $omics_left="Lipidomics";
            $omics_right="Transcriptomics";
        }
        if ($example == "Example3") {
            #命令
            #Rscript correlation_main.R -i "./testData/SVFmultiomics_210118/input/metabolites.csv" -d "./testData/SVFmultiomics_210118/input/sampleList.csv" -t "Metabolites" -m 0.67 -j "./testData/SVFmultiomics_210118/input/RNAseq_genesymbol.csv" -e "./testData/SVFmultiomics_210118/input/sampleList.csv" -u "RNAseq" -c 4 -f 3 -n T -o "~/temp/cor_db/" -b "DBSCAN"
            #改成路径+文件名
            $file_datafile_left  = 'program/testData/SVFmultiomics_210118/input/metabolites.csv'  ;
            $file_descfile_left  = 'program/testData/SVFmultiomics_210118/input/sampleList.csv'  ;
            $file_datafile_right = 'program/testData/SVFmultiomics_210118/input/RNAseq_genesymbol.csv'  ;
            $file_descfile_right = 'program/testData/SVFmultiomics_210118/input/sampleList.csv' ;
            $delodd = 'F';
            $data_type = '';
            $n =  'T';
            $s =  '';
            $g =  4;
            $k =  3;
            $b =  "DBSCAN";
            $c =  4;
            $f =  3;
            $p =  0.55;
            $omics_left="Metabolomics";
            $omics_right="Transcriptomics";
        }
        if ($example == "Example4") {
            #命令
            #Rscript correlation_main.R -i "./testData/CerebrospinalFluid_multiomics/input/metabolites_tidy2.csv" -d "./testData/CerebrospinalFluid_multiomics/input/sampleList_lip.csv" -t "Metabolites" -m 0.67 -j "./testData/CerebrospinalFluid_multiomics/input/proteins_Depletion_tidy.csv" -e "./testData/CerebrospinalFluid_multiomics/input/sampleList_lip.csv" -u "Proteins" -p 0.55 -n F -s 0.82 -o "~/temp/cor_mcl/" -b "MCL" 
            #改成路径+文件名
            $file_datafile_left  = 'program/testData/CerebrospinalFluid_multiomics/input/metabolites_tidy2.csv'  ;
            $file_descfile_left  = 'program/testData/CerebrospinalFluid_multiomics/input/sampleList_lip.csv'  ;
            $file_datafile_right = 'program/testData/CerebrospinalFluid_multiomics/input/proteins_Depletion_tidy.csv'  ;
            $file_descfile_right = 'program/testData/CerebrospinalFluid_multiomics/input/sampleList_lip.csv' ;
            $delodd = 'F';
            $data_type = '';
            $n =  'F';
            $s =  0.82;
            $g =  4;
            $k =  3;
            $b =  "MCL";
            $c =  4;
            $f =  3;
            $p =  0.55;
            $omics_left="Metabolomics";
            $omics_right="Proteomics";
        }
        return view('canshutwotwo', ['file_datafile_left' => $file_datafile_left,'file_descfile_left' => $file_descfile_left,'file_datafile_right' => $file_datafile_right,'file_descfile_right' => $file_descfile_right,'omics_left' => $omics_left,'omics_right' => $omics_right,'delodd' => $delodd,'data_type' => $data_type,'m' => '67','g' => $g,'k' => $k,'s' => $s,'c' => $c,'f' => $f,'p' => $p]);

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

    public function getrnadownloadfilename($downloadpath)
    {
        #volcano
        $command='cd '.$downloadpath.' && ls ';
        exec($command,$download,$flag);
        return $download;
    }

    public function crosscanshu(Request $request)
    {
        $omics = $request->omics;
        $omics = $request->omics;
        $omics = $request->omics;
        return view('crosscanshu', ['title' => '设置参数']);
    }
}
