<?php
namespace App\Library;

use App\Models\AlignProteinSequence;
use App\Models\Cugenedb;
use App\Models\ExpressionValue;
use App\Models\FeatureDefinition;
use App\Models\GeneDescription;
use App\Models\GeneFamily;
use App\Models\GeneInfo;
use App\Models\GeneName;
use App\Models\GeneToProtein;
use App\Models\NewAltProteinFeature;
use App\Models\NewAsEvent;
use App\Models\Orth;
use App\Models\ProteinFeature;
use App\Models\ProteinSequence;
use App\Models\PSIvalue;
use App\Models\ShowCdsSequence;
use App\Models\ShowGeneSequence;
use App\Models\ShowProteinSequence;
use App\Models\ShowTranscriptSequence;
use App\Models\TfProtein;
use App\Models\TranscriptInfo;
use App\Models\Uniprot;
use App\Models\WildExpressValue;
use App\Models\WildPsiValue;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;

class Search
{
    private $fd; // feature definitions
    private $apf; // alternative protein features
    private $aps; // protein sequence for alignment
    private $pf; // protein features
    private $as; // gene AS event
    private $up; // uniprot
    private $gn; //gene name
    private $gd; //gene description
    private $gp; //gene to protein
    private $gi; //gene info
    private $ex; //expression
    private $psi; //PSI
    private $ti; //transcript info
    private $tf; //tf to protein
    private $wex; //wild expression
    private $wpsi; //wild psi value
    private $gf; //gene family
    private $orth; //orth
    private $sgs; // gene sequence for show
    private $sts; // transcript sequence for show
    private $sps; // protein sequence for show
    private $scs; // protein sequence for show
    private $cgd; // protein sequence for show

    public function __construct()
    {
        $this->fd = $this->getFeatureDefinition();
        $this->aps = new AlignProteinSequence();
        $this->apf = new NewAltProteinFeature();
        $this->pf = new ProteinFeature();
        $this->as = new NewAsEvent();
        $this->up = new Uniprot();
        $this->gn = new GeneName();
        $this->gp = new GeneToProtein();
        $this->gi = new GeneInfo();
        $this->gd = new GeneDescription();
        $this->ex = new ExpressionValue();
        $this->psi = new PSIvalue();
        $this->ti = new TranscriptInfo();
        $this->tf = new TfProtein();
        $this->wex = new WildExpressValue();
        $this->wpsi = new WildPsiValue();
        $this->gf = new GeneFamily();
        $this->orth = new Orth();
        $this->sgs = new ShowGeneSequence();
        $this->sts = new ShowTranscriptSequence();
        $this->sps = new ShowProteinSequence();
        $this->scs = new ShowCdsSequence();
        $this->cgd = new Cugenedb();
    }

    public function cugrGeneInfo($gene_id)
    {

        $http = new Client();
        $url = 'http://cmb.bnu.edu.cn/cugr/api/cucumber/feature/name/' . $gene_id;
        try {
            $response = $http->get($url);
        } catch (ClientException $e) {
            abort(500, 'Can not connect to CuGR, please try later..');
        }

        $cugr_gene_data = json_decode((string) $response->getBody(), true);

        return $cugr_gene_data;
    }

    public function location($species, $location)
    {
        //$http = new Client();
        ////dd($http);
        //$url = 'http://cmb.bnu.edu.cn/cugr/index.php/api/' . $species . '/features?location=' . $location;  //
        //try {
        //    $response = $http->get($url);
        //} catch (ClientException $e) {
        //    abort(500, 'Can not connect to CuGR, please try later..');
        //}
        ////dd($http);
        //$cugr_gene_data = json_decode((string) $response->getBody(), true);
        ////dd($url);
        //$data = $cugr_gene_data['data'];
        //$genes = [];    //
        //foreach ($data as $d) {
        //    if ($d['type'] == 'gene') {
        //        $genes[] = $d['feature'];
        //    }
        //}
        $genes = [];

        $loc = preg_split('/[:\..]/', $location);

        $gene = $this->gi->where('chr', $loc[0])->where('start', '>=', $loc[1])->where('end', '<=', $loc[3])->pluck('gene');
        foreach ($gene as $g) {
            if ($species == 'wild_cucumber' and preg_match("/Csa/", $g)) {
                continue;
            } elseif ($species == 'dom_cucumber' and preg_match("/evm/", $g)) {
                continue;
            } else {
                array_push($genes, $g);
            }
        }
        //dd($genes);
        return $genes;
    }

    public function gene($gene)
    {
        // 获取基因的基本信息
        //$cugr_gene_data = $this->cugrGeneInfo($gene);

        $gene_data = $this->gi->where('gene', $gene)->get()->first();

        if (!$gene_data) {
            return null;
        }

        $chr = $gene_data['chr'];
        $gene_data['start'] = (int) $gene_data['start'];
        $gene_data['end'] = (int) $gene_data['end'];

        $start = min($gene_data['start'], $gene_data['end']);
        $end = max($gene_data['start'], $gene_data['end']);

        $_start = max(($start - 300), 0);
        $_end = $end + 200;

        $species = [];

        if (preg_match('/Csa/', $gene)) {
            $jbrowse = 'http://cmb.bnu.edu.cn/cugr/jbrowse/index.html?data=data%2Fjson%2Fcuas&loc=' . $chr . '%3A' . $_start . '..' . $_end . '&tracklist=0&nav=0&overview=0&tracks=DNA%2Cfeatures';
            $species = ["Cucumis sativus", "L. var.", "sativus", "cv. 9930"];
        } else {
            $jbrowse = 'http://cmb.bnu.edu.cn/cugr/jbrowse/index.html?data=data%2Fjson%2Fcuas_wild&loc=' . $chr . '%3A' . $_start . '..' . $_end . '&tracklist=0&nav=0&overview=0&tracks=DNA%2Cfeatures';
            $species = ["Cucumis sativus", "var.", "hardwickii ", "PI 183967"];
        }

        // 获取基因的蛋白
        $genename = $this->gp->where('gene', $gene)->get()->first();

        $genes = $this->pf->select('protein')->where('gene', $genename['protein'])->get();
        //dd($genes);
        if (!$genes) {
            return null;
        }
        $proteins = array_sort(array_unique(array_pluck($genes->toArray(), 'protein')), '');
        //dd($genename);
        // 获取基因的剪切事件
        $events = $this->as->where('gene', $gene)->get();
        $description = $this->gd->where('gene', $gene)->pluck('description')->first();
        $cugenedb = $this->cgd->where('gene', $gene)->pluck('cugenedb')->first();

        return [
            'chr' => $chr,
            'start' => $start,
            'end' => $end,
            'strand' => $gene_data['strand'],
            'name' => $gene_data['gene'],
            'genename' => $genename['protein'],
            'jbrowse' => $jbrowse,
            'proteins' => $proteins,
            'events' => $events,
            'species' => $species,
            'description' => $description,
            'cugenedb' => $cugenedb,
        ];
    }

    public function genedescri($gene)
    {
        return $this->gd->where('gene', $gene)->pluck('description')->first();
    }

    public function protein($protein)
    {
        $arr = [];
        if (preg_match('/Csa/', $protein)) {
            $proteins = explode('.', $protein);
            $gene = $proteins[0];
            $pro = (int) $proteins[1];
        } elseif (preg_match('/evm.TU/', $protein)) {
            $proteins = explode('S.', $protein);
            $gene = $proteins[0] . 'S';
            $pro = (int) $proteins[1];
        }
        $proteins = $this->pf->where('gene', $gene)->where('protein', $pro)->get();

        return $proteins ? $proteins : null;
    }

    public function proteinSequence($protein)
    {
        $pro_seq = new ProteinSequence();
        $seq = $pro_seq->select('sequence')->where('protein', $protein)->first();

        return $seq ? $seq->sequence : '';
    }

    public function getproteinsequenceforalign($proteins)
    {
        $seq = [];
        $secstrutype = [[]];
        foreach ($proteins as $protein) {
            $data = $this->apf->where('protein', $protein)->first();
            $sequence = $this->aps->where('protein', $protein)->pluck('sequence')->first();
            $length = strlen($sequence) + 1;

            $seq[$protein]['value'] = [];
            $seq[$protein]['end'] = [];

            //把序列切割成100bp进行展示，长短可以调整
            $seq[$protein]['num'] = intval(strlen($sequence) / 60);
            $seq[$protein]['sequence'] = str_split($sequence, 60);
            $n = 0;
            $end = 0;
            foreach ($seq[$protein]['sequence'] as $shortseq) {
                $seq[$protein]['sequence'][$n] = str_split($shortseq);

                foreach ($seq[$protein]['sequence'][$n] as $aa) {
                    if ($aa != '-') {
                        $end++;
                    }
                }
                array_push($seq[$protein]['end'], $end);
                array_push($seq[$protein]['value'], strlen($shortseq));
                $n++;
            }
            $sequences = str_split($sequence);

            $seq[$protein]['position'] = array_fill(0, $length, 'gap');
            $i = 1;
            $j = 1;
            foreach ($sequences as $aa) {
                if ($aa != '-') {
                    $seq[$protein]['position'][$i] = $j;
                    $j++;
                }
                $i++;
            }
            $seq[$protein]['protein'] = $protein;
            $seq[$protein]['secondary_structure'] = $this->getsecondary_structure($data['secondary_structure'], $protein, $length);
            $seq[$protein]['coil'] = $this->getcoil($data['coil'], $protein, $length);
            $seq[$protein]['low_complexity'] = $this->getlow_complexity($data['low_complexity'], $protein, $length);
            $seq[$protein]['pest'] = $this->getdisorder($data['pest'], $protein, $length);
            $seq[$protein]['transmember'] = $this->gettransmember($data['transmember'], $protein, $length);
            $seq[$protein]['disorder'] = $this->getdisorder($data['disorder'], $protein, $length);
            //$seq[$protein]['prosite'] = $this->getprosite($data['prosite'],$protein,$length);
            //$seq[$protein]['pfam'] = $this->getpfam($data['pfam'],$protein,$length);
            //$seq[$protein]['sublocation'] = $this->getsublocation($data['sublocation'],$protein,$length);
            $seq[$protein]['signalp'] = $this->getsignalp($data['signalp'], $protein, $length);
            $seq[$protein]['netphos'] = $this->netphos($data['netphos'], $protein, $length);
            $seq[$protein]['oglycosylation'] = $this->glycosylation($data['oglycosylation'], $protein, $length);
            $seq[$protein]['nglycosylation'] = $this->glycosylation($data['nglycosylation'], $protein, $length);

        }
        //dd($seq[$protein]['nglycosylation']);
        return $seq;
    }

    public function glycosylation($value, $protein, $length)
    {
        $data[$protein] = [];
        $data[$protein] = array_fill(0, $length, '');
        $datas = explode('!', $value);
        foreach ($datas as $one) {
            if (!$one or $one == "bucunzai") {
                continue;
            }
            $loc = explode('~', $one);
            for ($i = $loc[0] - 1; $i < $loc[0]; $i++) {
                $data[$protein][$i] = 'label-danger';
            }
        }
        return $data[$protein];
    }

    public function getsignalp($value, $protein, $length)
    {
        $data[$protein] = [];
        $data[$protein] = array_fill(0, $length, '');
        $datas = explode('!', $value);
        foreach ($datas as $one) {
            if (!$one or $one == "bucunzai") {
                continue;
            }
            $loc = explode('~', $one);
            for ($i = 0; $i < $loc[0]; $i++) {
                $data[$protein][$i] = 'label-danger';
            }
        }
        return $data[$protein];
    }

    public function getproteinlength($protein)
    {
        $sequence = $this->aps->where('protein', $protein)->pluck('sequence')->first();
        $length = strlen($sequence) + 1;
        return $length;
    }

    public function netphos($value, $protein, $length)
    {
        //二级结构的每一个位置定义一个类型

        $data[$protein] = [];
        $data[$protein] = array_fill(0, $length, '');
        $datas = explode('!', $value);
        //dd($datas);
        foreach ($datas as $one) {
            if (!$one or $one == "bucunzai") {
                continue;
            }
            $loc = explode('~', $one);
            $data[$protein][$loc[1]] = 'label-danger';

        }
        return $data[$protein];

    }

    public function getdisorder($value, $protein, $length)
    {
        //二级结构的每一个位置定义一个类型

        $data[$protein] = [];
        $data[$protein] = array_fill(0, $length, '');
        $datas = explode('!', $value);
        //dd($datas);
        foreach ($datas as $one) {
            if (!$one or $one == "bucunzai") {
                continue;
            }
            $loc = explode('~', $one);
            for ($i = $loc[0] - 1; $i < $loc[1]; $i++) {
                $data[$protein][$i] = 'label-danger';
            }
        }
        return $data[$protein];

    }

    public function gettransmember($value, $protein, $length)
    {
        //二级结构的每一个位置定义一个类型

        $data[$protein] = [];
        $data[$protein] = array_fill(0, $length, '');
        $datas = explode('!', $value);
        foreach ($datas as $one) {
            if (!$one or $one == "bucunzai") {
                continue;
            }
            $loc = explode('~', $one);
            for ($i = $loc[1] - 1; $i < $loc[2]; $i++) {
                if ($loc[0] == 'Extracellular_Region') {
                    $data[$protein][$i] = 'label-primary';
                } elseif ($loc[0] == 'Transmembrane_Helix') {
                    $data[$protein][$i] = 'label-warning';
                }
            }
        }
        return $data[$protein];

    }

    public function getlow_complexity($value, $protein, $length)
    {
        //二级结构的每一个位置定义一个类型

        $data[$protein] = [];
        $data[$protein] = array_fill(0, $length, '');
        $datas = explode('!', $value);
        foreach ($datas as $one) {
            if (!$one or $one == "bucunzai") {
                continue;
            }
            $loc = explode('~', $one);
            for ($i = $loc[0] - 1; $i < $loc[1]; $i++) {
                $data[$protein][$i] = 'label-primary';
            }
        }
        return $data[$protein];

    }

    public function getcoil($value, $protein, $length)
    {
        //二级结构的每一个位置定义一个类型

        $data[$protein] = [];
        $data[$protein] = array_fill(0, $length, '');
        $datas = explode('!', $value);
        foreach ($datas as $one) {
            if (!$one or $one == "bucunzai") {
                continue;
            }
            $loc = explode('~', $one);
            for ($i = $loc[0] - 1; $i < $loc[1]; $i++) {
                $data[$protein][$i] = 'label-info';
            }
        }
        return $data[$protein];

    }

    public function getsecondary_structure($value, $protein, $length)
    {
        //二级结构的每一个位置定义一个类型

        $data[$protein] = [];
        $data[$protein] = array_fill(0, $length, '');
        $datas = explode('!', $value);
        foreach ($datas as $one) {
            if (!$one or $one == "bucunzai") {
                continue;
            }
            $loc = explode('~', $one);
            for ($i = $loc[1] - 1; $i < $loc[2]; $i++) {
                if ($loc[0] == 'C') {
                    $data[$protein][$i] = 'label-primary';
                } elseif ($loc[0] == 'H') {
                    $data[$protein][$i] = 'label-warning';
                }
            }
        }
        return $data[$protein];

    }

    public function proteinWithFeatures($protein)
    {
        $protein_info = $this->protein($protein);
        $sequence = $this->proteinSequence($protein);

        if (empty($protein_info)) {
            return null;
        }

        $features_info = $this->getFeatureDefinition();
        $features = [];
        foreach ($features_info as $f => $fi) {
            $features[(int) $fi['id']] = [
                'name' => $f,
                'unit' => $fi['unit'],
                'comment' => $fi['comment'],
            ];
        }
        unset($features_info);

        $data = [
            'features' => $features,
            'proteins' => [$protein => ['sequence' => $sequence]],
        ];

        foreach ($protein_info as $pi) {
            $data['proteins'][$protein][$pi->feature_id] = trim($pi->value, '; ');
        }
        return $data;
    }

    public function proteinsWithFeatures($proteins)
    {
        $datum = [];
        foreach ($proteins as $protein) {
            $data = $this->proteinWithFeatures($protein);
            if (empty($datum)) {
                $datum = $data;
                continue;
            }
            $datum['proteins'][$protein] = $data['proteins'][$protein];
        }

        return $datum;
    }

    public function getFeatureDefinition()
    {
        return Cache::rememberForever('feature_definition', function () {
            $defs = (new FeatureDefinition())->all();
            $definitions = [];
            foreach ($defs as $d) {
                $definitions[$d->name] = [
                    'id' => $d->id,
                    'unit' => isset($d->unit) ? $d->unit : '',
                    'comment' => isset($d->comment) ? $d->comment : '',
                ];
            }
            return $definitions;
        });
    }

    /*
    just try it
     */
    public function getfewfeature($protein)
    {
        $data = [];
        if (preg_match('/Csa/', $protein)) {
            $proteins = explode('.', $protein);
            $gene = $proteins[0];
            $pro = $proteins[1];
        } elseif (preg_match('/evm.TU/', $protein)) {
            $proteins = explode('S.', $protein);
            $gene = $proteins[0] . 'S';
            $pro = $proteins[1];
        }

        $length = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '15')->get()->first();
        $weight = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '16')->get()->first();
        $gravy = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '17')->get()->first();
        $charge = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '18')->get()->first();
        $weight = round(intval($weight['value']) / 1000, 2);
        $gravy = round($gravy['value'], 2);
        $data = [
            'length' => $length['value'],
            'weight' => $weight,
            'gravy' => $gravy,
            'charge' => $charge['value'],
        ];
        return $data;
    }

    public function getseqfeature($protein)
    {
        $data = [];
        if (preg_match('/Csa/', $protein)) {
            $proteins = explode('.', $protein);
            $gene = $proteins[0];
            $pro = $proteins[1];
        } elseif (preg_match('/evm.TU/', $protein)) {
            $proteins = explode('S.', $protein);
            $gene = $proteins[0] . 'S';
            $pro = $proteins[1];
        }
        $length = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '15')->get()->first();
        $weight = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '16')->get()->first();
        $gravy = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '17')->get()->first();
        $charge = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '18')->get()->first();
        $coefficient = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '19')->get()->first();
        $electric = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '20')->get()->first();
        $aliphatic = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '21')->get()->first();
        $weight = round(intval($weight['value']) / 1000, 2);
        $gravy = round($gravy['value'], 2);
        $data = [
            'length' => $length['value'],
            'weight' => $weight,
            'gravy' => $gravy,
            'charge' => $charge['value'],
            'coefficient' => $coefficient['value'],
            'electric' => $electric['value'],
            'aliphatic' => $aliphatic['value'],
        ];
        return $data;
    }

    public function getdomain($protein)
    {
        if (preg_match('/Csa/', $protein)) {
            $proteins = explode('.', $protein);
            $gene = $proteins[0];
            $pro = $proteins[1];
        } elseif (preg_match('/evm.TU/', $protein)) {
            $proteins = explode('S.', $protein);
            $gene = $proteins[0] . 'S';
            $pro = $proteins[1];
        }
        $domain = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '22')->get()->first();
        $value = $domain['value'];
        $values = explode('-', $value);
        return $values;
    }

    public function getkegg($protein)
    {
        $i = 0;
        $kong = "N/A";
        $data = [];
        $datum = [];
        if (preg_match('/Csa/', $protein)) {
            $proteins = explode('.', $protein);
            $gene = $proteins[0];
            $pro = $proteins[1];
        } elseif (preg_match('/evm.TU/', $protein)) {
            $proteins = explode('S.', $protein);
            $gene = $proteins[0] . 'S';
            $pro = $proteins[1];
        }
        $kegg = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '3')->get()->first();
        if ($kegg) {
            $kegg = $kegg['value'];
            $keggs = explode(';', $kegg);
            foreach ($keggs as $value) {
                if (!$value) {
                    continue;
                }
                $values = explode('~', $value);
                $id = array_shift($values);
                $pathway = implode('-', $values);
                $data = [
                    'id' => $id,
                    'pathway' => $pathway,
                ];
                array_push($datum, $data);
                $i++;
            }
        } else {
            $data = [
                'id' => $kong,
                'pathway' => $kong,
            ];
            array_push($datum, $data);
            $i++;
        }
        $datum['len'] = $i;
        #$deleted = array_pop($datum);
        return $datum;
    }
    public function getfunction($protein)
    {
        $i = 0;
        $kong = "N/A";
        $data = [];
        $datum = [];
        if (preg_match('/Csa/', $protein)) {
            $proteins = explode('.', $protein);
            $gene = $proteins[0];
            $pro = $proteins[1];
        } elseif (preg_match('/evm.TU/', $protein)) {
            $proteins = explode('S.', $protein);
            $gene = $proteins[0] . 'S';
            $pro = $proteins[1];
        }
        $go_function = $this->pf->where('gene', $gene)->where('protein', $pro)->where('feature_id', '10')->get()->first();
        //dd($go_function);
        if ($go_function) {
            $go_function = $go_function['value'];
            $go_functions = explode(';', $go_function);
            foreach ($go_functions as $value) {
                if (!$value) {
                    continue;
                }
                $values = explode('~', $value);
                $id = array_shift($values);
                $type = array_shift($values);
                $go_function = implode('-', $values);
                $data = [
                    'id' => $id,
                    'type' => $type,
                    'function' => $go_function,
                ];
                array_push($datum, $data);
                $i++;
            }
        } else {
            $data = [
                'id' => $kong,
                'type' => $kong,
                'function' => $kong,
            ];
            array_push($datum, $data);
            $i++;
        }
        #$deleted = array_pop($datum);
        $datum['len'] = $i;
        return $datum;
    }

    public function getFeatures($protein)
    {
        if (empty($protein)) {
            return view('errors.404', ['msg' => 'No protein provided!']);
        }

        $data = $this->proteinWithFeatures($protein);

        if (!$data || count($data) == 0) {
            return view('searchPage', ['errors' => ['Protein Not found!']]);
        }
        return $data;
    }

    public function genetoprotein($gene)
    {
        $allprotein = [];
        $gene = preg_replace("/G/", "P", $gene);
        $gene = $gene . "AS";
        $pro = $this->pf->where('gene', $gene)->pluck('protein');
        foreach ($pro as $p) {
            array_push($allprotein, $gene . "." . $p);
        }
        $allprotein = array_unique($allprotein);
        return $allprotein;
    }

    public function getsublocation($protein)
    {
        return explode('!', $this->apf->where('protein', $protein)->pluck('sublocation')->first());
    }

    public function getaltfeaturevalue($protein, $featurename)
    {
        return $this->apf->where('protein', $protein)->pluck($featurename)->first();
    }

    public function uniprot($uniprot)
    {
        return $this->up->where('uniprot', $uniprot)->get();
    }

    public function genename($genename)
    {
        return $this->gn->where('name', $genename)->get();
    }

    public function expressions($protein)
    {
        return $this->ex->where('protein', $protein)->get()->first();
    }
    public function wildexpressions($protein)
    {
        return $this->wex->where('protein', $protein)->get()->first();
    }
    public function psivalue($event, $chr, $loc)
    {
        //return $event;wild
        return $this->psi->where('event', $event)->where('loc', $loc)->where('chr', $chr)->get()->first();
    }
    public function wildpsivalue($event, $chr, $loc)
    {
        //return $event;wild
        return $this->wpsi->where('event', $event)->where('loc', $loc)->where('chr', $chr)->get()->first();
    }

    public function transcript($gene)
    {
        return $this->ti->where('gene', $gene)->get();
    }

    public function genefamily($tf)
    {
        return $this->gf->where('tf', $tf)->get();
    }

    public function description($gene)
    {
        return $this->gd->where('gene', $gene)->pluck('description')->first();
    }

    public function showgenesequence($gene)
    {
        return $this->sgs->where('gene', $gene)->pluck('sequence')->first();
    }

    public function showcdssequence($cds)
    {
        return $this->scs->where('cds', $cds)->pluck('sequence')->first();
    }

    public function showtranscriptsequence($transcript)
    {
        return $this->sts->where('transcript', $transcript)->pluck('sequence')->first();
    }

    public function showproteinsequence($protein)
    {
        return $this->sps->where('protein', $protein)->pluck('sequence')->first();
    }

    public function orth($gene)
    {
        return $this->orth->where('gene', $gene)->get()->first();
    }
}
