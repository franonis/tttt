<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BabaController;
use Illuminate\Http\Request;

class BabaController extends Controller
{
    public function searchdisease(Request $request)
    {
        #dd($request->gene);
        $genename = $request->gene;

        return view('diseaseresult', ['genename' => $genename]);
    }

    public function diseasetable($name)
    {
        #$disease = GeneDisease::all()->where('gene', $name)->toArray();
        $gene_disease = file_get_contents('gene_disease.txt');
        preg_match_all("/\t.*?$name.*?\t.*\n/U", $gene_disease, $diseases);
        #preg_match_all
        #dd($diseases);
        $count = 0;
        $tableJson = [];
        $loctmp = [];
        foreach ($diseases[0] as $disease) {
            #dd($diseases);
            $t = explode("\t", $disease);
            $tableJson['data'][] = [
                'no' => $count + 1,
                'gene' => $t[1],
                'disease' => $t[2],
            ];
            $count++;
        }
        $tableJson['code'] = 0;
        $tableJson['msg'] = '';
        $tableJson['count'] = $count;
        return $tableJson;
    }

    public function detable($both)
    {   
        $boths = explode(",", $both);
        $name = $boths[0];
        $type = $boths[1];
        $name=preg_replace('/\+\+/', "/", $name);
        $gene_de = file_get_contents($name,0,null,0,3000);
        $hangs = explode("\n", $gene_de);
        
        $count = 0;
        $tableJson = [];
        $loctmp = [];
        for ($h=1; $h < 20; $h++) {
            $t=[];
            $lie=explode(",", $hangs[$h]);
            if ($type == "MiAr") {
                
                for ($i=1; $i < 7; $i++) { 
                    if ($lie[$i] == "NA") {
                        $t[$i]="NA";
                    }elseif (strstr($lie[$i],'e')) {
                        $temp = explode("e", $lie[$i]);
                        $tmp = explode('.', $temp[0]);
                        $t[$i] = $tmp[0] . '.' . substr($tmp[1],0,2) . 'e' . $temp[1];
                    }else{
                        $tmp = explode('.', $lie[$i]);
                        $t[$i] = $tmp[0] . '.' . substr($tmp[1],0,2);
                    }
                }
                $tableJson['data'][] = [
                    'gene' => $lie[0],
                    'logFC' => $t[1],
                    'AveExpr' => $t[2],
                    't' => $t[3], 
                    'PValue' => $t[4],
                    'adjPVal'=> $t[5],
                    'B' => $t[6],
                ];
                // code...
            }
            if ($type == "RNAseq") {
                for ($i=1; $i < 6; $i++) { 
                    if ($lie[$i] == "NA") {
                        $t[$i]="NA";
                    }elseif (strstr($lie[$i],'e')) {
                        $temp = explode("e", $lie[$i]);
                        $tmp = explode('.', $temp[0]);
                        $t[$i] = $tmp[0] . '.' . substr($tmp[1],0,2) . 'e' . $temp[1];
                    }else{
                        $tmp = explode('.', $lie[$i]);
                        $t[$i] = $tmp[0] . '.' . substr($tmp[1],0,2);
                    }
                }
                $tableJson['data'][] = [
                    'gene' => $lie[0],
                    'baseMean' => $t[1],
                    'logFC' => $t[2],
                    'lfcSE' => $t[3], 
                    'PValue' => $t[4],
                    'adjPVal'=> $t[5],
                ];
                // code...
            }

            $count++;
        }
        $tableJson['code'] = 0;
        $tableJson['msg'] = '';
        $tableJson['count'] = $count;
        return $tableJson;
    }

    public function nametable($name)
    {   
        $name=preg_replace('/\+\+/', "/", $name);
        $gene_de = file_get_contents($name,0,null,0,1000);
        $hangs = explode("\n", $gene_de);
        
        $count = 0;
        $tableJson = [];
        $loctmp = [];
        $max = 10;
        if (count($hangs) < 10) {
            $max = count($hangs);
        }
        for ($h=1; $h < $max; $h++) {
            $tableJson['data'][] = [
                'no' => $h,
                'name' => $hangs[$h],
            ];
            $count++;
        }
        $tableJson['code'] = 0;
        $tableJson['msg'] = '';
        $tableJson['count'] = $count;
        return $tableJson;
    }
}