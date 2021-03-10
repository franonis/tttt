@extends('layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/layui/dist/css/layui.css') }}"  media="all">

@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container content">
    <div class="row">
        @include('partials.errors')
        <p>Upload your data / Set Parameters / <a style="font-size: 200%;">Show the statistical results</a></p><a style="font-size: 180%;display: block;text-align:right;" >Enrichment</a>
        <hr>
            <div class="col-md-2">
            </div>
            <div class="col-md-10">
                <div class="col-md-12">
                    <div class="col-md-2">
                        <h4>{{$omics1}}</h4>
                    </div>
                    <div class="col-md-4" style="border:1px dashed #000; overflow-y:auto; width:200px; height:300px;">
                        <p>list of lipid</p><br>
                        <pre>{{ $lipid }}</pre>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10" style="border:1px dashed #000;">
                            <a href="{{ url('download/file/')}}/{{ $downloadpath }}lipids_{{$k2}}.csv">Download the lipid list file</a>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10" style="border:1px dashed #000;">
                            <a href="{{ url('result/enrichresult/')}}/{{$k2}}--{{$downloadpath}}--{{$omics1}}" target="_blank">Enrich</a>
                        </div><br>
                    </div>
                </div><br>
            <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR><br>
                
                <div class="col-md-12">
                    <div class="col-md-2">
                        <h4>{{$omics2}}</h4>
                    </div>
                    <div class="col-md-4" style="border:1px dashed #000; overflow-y:auto; width:200px; height:300px;">
                        <p>list of genes</p><br>
                        <pre>{{ $gene }}</pre>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10" style="border:1px dashed #000;">
                            <a href="{{ url('download/file/')}}/{{ $downloadpath }}genes_{{$g}}.csv">Download the gene list file</a>
                        </div>
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10" style="border:1px dashed #000;">
                        <form id="regionform" class="layui-form" action="/result/enrichresultgene">
                            <input name="downloadpath" value="{{ $downloadpath }}" style="display: none;">
                            <input name="omics" value="{{ $omics2 }}" style="display: none;">
                            <input name="k" value="{{ $g }}" style="display: none;">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">Choose species：</label>
                                        <div class="layui-input-block" id="t">
                                          <input type="radio" name="t" value="mmu" title="mmu" checked="">
                                          <input type="radio" name="t" value="has" title="has">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="genetype" style="display: none;">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">Gene Type：</label>
                                        <div class="layui-input-block" id="t">
                                          <input type="radio" name="g" value="ENSEMBL" title="ENSEMBL">
                                          <input type="radio" name="g" value="SYMBOL" title="SYMBOL" checked="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">GO term：</label>
                                        <div class="layui-input-block" id="c">
                                          <input type="radio" name="c" value="Biological_Process" title="Biological Process" checked="">
                                          <input type="radio" name="c" value="Cellular_Component" title="Cellular Component">
                                          <input type="radio" name="c" value="Molecular_Function" title="Molecular Function">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">Set top number：</label>
                                        <div class="layui-input-block" id="s">
                                          <input id="s" type="text" name="s" value="s" style="width:50px; display:inline;" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button id="submitEnrich" class="layui-btn" type="submit" >Enrich</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            <hr>
        </div>
    </div>
</div>
@endsection
@section('footer')
  @include('partials.footer')
@endsection
@section('js')
<script src="{{ asset('/layui/dist/layui.js') }}" charset="utf-8"></script>

<script>
    $(document).ready(function(){
        layui.use('form', function(){
          var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
        });

        layui.use('table', function(){
          var table = layui.table; //只有执行了这一步，部分表单元素才会自动修饰成功
        });
        omics=$("input[name='omics']").val();
        if (omics == "Proteomics") {
          document.getElementById("genetype").style.display="none";
        }
        if (omics == "Transcriptomics") {
          document.getElementById("genetype").style.display="block";
        }
        console.log(omics);

    });
</script>
@endsection
