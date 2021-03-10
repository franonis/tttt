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
                        <br><p>list of lipid</p><br>
                        <pre>{{ $lipid }}</pre>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10" style="border:1px dashed #000;">
                            <a href="{{ url('download/file/')}}/{{ $downloadpath }}lipids_{{$k2}}.csv">Download the lipid list file</a>
                        </div><br><br>
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
                        <h4>Download</h4>
                    </div>
                    <div class="col-md-10" style="border:1px dashed #000;">
                        <div class="col-md-5">
                            <a href="{{ url('download/file/')}}/{{ $downloadpath }}enrich++msea_ora_result.csv">msea_ora_result.csv<i class="layui-icon layui-icon-download-circle"></i></a>
                        </div>
                        <div class="col-md-5">
                            <a href="{{ url('download/file/')}}/{{ $downloadpath }}enrich++ora_dpi72.png">ora_dpi72.png<i class="layui-icon layui-icon-download-circle"></i></a>
                        </div>
                        <div class="col-md-5">
                            <a href="{{ url('download/file/')}}/{{ $downloadpath }}enrich++ora_dot_dpi72.png">ora_dot_dpi72.png<i class="layui-icon layui-icon-download-circle"></i></a>
                        </div>
                    </div>
        <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                    <div class="col-md-2">
                        <h4>LION Enrichment result</h4>
                    </div>
                    <div class="col-md-10">
                        <img src="http://www.lintwebomics.info/{{ $opath }}enrich/PCA_show.png" style="height:50%;width: 60%;">
                    </div>
                </div>
            </div>
            <hr>
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
        console.log(omics);

    });
</script>
@endsection
