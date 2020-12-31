<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BabaController;
use App\Models\GeneDisease;
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
        $disease = GeneDisease::all()->where('gene', $name)->toArray();
        #dd($disease);
        $count = 0;
        $tableJson = [];
        $loctmp = [];
        foreach ($disease as $t) {
            $tableJson['data'][] = [
                'no' => $count + 1,
                'gene' => $t['gene'],
                'disease' => $t['disease'],
            ];
            $count++;
        }
        $tableJson['code'] = 0;
        $tableJson['msg'] = '';
        $tableJson['count'] = $count;
        return $tableJson;
    }
}
