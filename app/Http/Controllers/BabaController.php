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

    public function detable($name)
    {
        
        $name=preg_replace('/\+\+/', "/", $name);
        $gene_de = file_get_contents($name,0,null,0,1000);
        dd($gene_de);
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
}
