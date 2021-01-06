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
        preg_match_all("/$name.*\n/U", $gene_disease, $diseases);
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
                'gene' => $t[0],
                'disease' => $t[1],
            ];
            $count++;
        }
        $tableJson['code'] = 0;
        $tableJson['msg'] = '';
        $tableJson['count'] = $count;
        return $tableJson;
    }
}
