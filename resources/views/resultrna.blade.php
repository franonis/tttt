@extends('layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/layui/dist/css/layui.css') }}"  media="all">

@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container content">
    <div class="row">
        @include('partials.errors')
        <p>Upload your data / Set Parameters / <a style="font-size: 200%;">Show the statistical results</a></p><a style="font-size: 180%;display: block;text-align:right;" >Transcriptomics</a>
        <hr>
            <div class="col-md-2">
                <input name="downloadpath" value="{{ $downloadpath }}" style="display: none;">
            </div>
            <div class="col-md-10">
                <div class="layui-tab">
                  <ul class="layui-tab-title">
                    <li>Differential Expression</li>
                    <li  class="layui-this">Data Variability</li>
                    <li>Volcano Plot</li>
                    <li>Heatmap</li>
                    <li>GO enrichment</li>
                  </ul>
                  <div class="layui-tab-content">
                    <div class="layui-tab-item">
                        <div class="col-md-12">
                            <div class="col-md-2">
                                <h4>Download</h4>
                            </div>
                            <div class="col-md-10" style="border:1px dashed #000;">
                                <a href="{{ url('download/file/')}}/{{ $downloadpath }}..++DEgeneStatistics_{{$DEname}}.csv">DEgeneStatistics_{{$DEname}}.csv<i class="layui-icon layui-icon-download-circle"></i></a>
                            </div>
                    <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                            <div class="col-md-2">
                                <h4>Gene differential expression result: </h4>
                            </div>
                            <a style="display: none;" name="tax" id="name" value="{{ $downloadpath }}..++DEgeneStatistics_{{$DEname}}.csv">{{ $downloadpath }}..++DEgeneStatistics_{{$DEname}}.csv</a>
                            <a style="display: none;" name="tx" id="data_type" value="{{ $data_type }}">{{ $data_type }}</a>
                            <div class="col-md-10" id="DERNA" style="display:none;">
                                <table id="showde1" lay-filter="test"></table>
                            </div>
                            <div class="col-md-10" id="DEMiAr" style="display:none;">
                                <table id="showde2" lay-filter="test"></table>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item layui-show">
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <h4>Download</h4>
                                </div>
                                <div class="col-md-10" style="border:1px dashed #000;">
                                    <a href="{{ url('download/rna/')}}/{{ $downloadpath }}----DV.zip">DV.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                </div>
                    <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                                <div class="col-md-2">
                                    <h4>PCA score plot:</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/PCA_show.png" style="height:50%;width: 60%;">
                                </div>
                                <div class="col-md-2">
                                    <h4>Heatmap result:</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/heatmap_allgroups.png" style="height:50%;width: 60%;">
                                </div>
                            </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 3 Volcano-->
                        <div class="col-md-12">
                            <form  id="Volcano" class="layui-form" action="/update/updaternaVolcano">
                                <div class="col-md-2">
                                    <h4>Update with new parameters</h4>
                                </div>
                                <div class="col-md-10">
                                    <div class="col-md-4">
                                        <h4>Fold Change threshold:</h4>
                                    </div>
                                    <div class="col-md-8">
                                        <small>
                                        <input id="f_volcano" type="text" name="f_volcano" value="{{$f}}" style="width:50px; display:inline;" class="form-control" >
                                        </small>
                                    </div>
                                    <div class="col-md-4">
                                        <h4>P-Value threshold:</h4>
                                    </div>
                                    <div class="col-md-8">
                                        <small>
                                        <input id="p_volcano" type="text" name="p_volcano" value="{{$p}}" style="width:50px; display:inline;" class="form-control" >
                                        </small>
                                    </div>
                                    <div class="col-md-4">
                                        <h4>Show TOP hits names:</h4>
                                    </div>
                                    <div class="col-md-8">
                                        <small>
                                        <input id="u" type="text" name="u" value="{{$u}}" style="width:50px; display:inline;" class="form-control" >
                                        </small>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="volcanoupdateri" name="volcanoupdateri" class="btn btn-success form-control" onclick="volcanoupdate()">Update</button>
                                    </div>
                                    <div class="col-md-3">
                                        <p id="volcanoupdatebutton" style="display: none; margin-top: 4%; ">updating<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
                                    </div>
                                </div>
                            </form>
                                <div class="col-md-2">
                                    <h4>Download</h4>
                                </div>
                                <div class="col-md-10" style="border:1px dashed #000;">
                                    <a href="{{ url('download/rna/')}}/{{ $downloadpath }}----Volcano.zip">Volcano.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                </div>
                                <div class="col-md-2">
                                    <h4>Volcano result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img id="volcanopng" src="http://www.lintwebomics.info/{{ $path }}results/volcano_show.png" style="height:80%;width: 80%;">
                                </div>
                        </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 4 Heatmap-->
                        <div class="col-md-12">
                            <form  id="Heatmap" class="layui-form" action="/update/updaternaHeatmap">
                                <div class="col-md-2">
                                    <h4>Update with new parameters</h4>
                                </div>
                                <div class="col-md-10">
                                    <div class="col-md-4" title="Set the number of top significant changed lipids to display on the heatmap">
                                            <h4>Show TOP hits <i class="layui-icon layui-icon-about"></i> :</h4>
                                        </div>
                                    <div class="col-md-8">
                                        <small>
                                        <input id="v" type="text" name="v" value="{{ $v }}" style="width:50px; display:inline;" class="form-control" >
                                        </small>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="button" id="heatmapupdateri" name="heatmapupdateri" class="btn btn-success form-control" onclick="heatmapupdate()">Update</button>
                                    </div>
                                    <div class="col-md-3">
                                        <p id="heatmapupdatebutton" style="display: none; margin-top: 4%; ">updating<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
                                    </div>
                                </div>
                            </form>
                                <div class="col-md-2">
                                    <h4>Download</h4>
                                </div>
                                <div class="col-md-10" style="border:1px dashed #000;">
                                    <a href="{{ url('download/rna/')}}/{{ $downloadpath }}----Heatmap.zip">Heatmap.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                </div>
                                <div class="col-md-2">
                                    <h4>Heatmap result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img id="heatmappng" src="http://www.lintwebomics.info/{{ $path }}results/heatmap_show.png" style="height:50%;width: 60%;">
                                </div>
                        </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 5 GO enrichment-->
                            <div class="col-md-12">
                                <form  id="enrich" class="layui-form">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-12">
                                            <div class="layui-form-item">
                                                <label class="layui-form-label">Choose species：</label>
                                                <div class="layui-input-block" id="t">
                                                  <input type="radio" name="t" value="mmu" title="Mus musculus" checked="">
                                                  <input type="radio" name="t" value="hsa" title="Homo sapiens">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
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
                                        <div class="col-md-4">
                                            <h4>Fold Change threshold:</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <input id="f_enrich" type="text" name="f_enrich" value="{{$f}}" style="width:50px; display:inline;" class="form-control" >
                                            </small>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>P-Value threshold:</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <input id="p_enrich" type="text" name="p_enrich" value="{{$p}}" style="width:50px; display:inline;" class="form-control" >
                                            </small>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>Show TOP hits names:</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <input id="s" type="text" name="s" value="{{$s}}" style="width:50px; display:inline;" class="form-control" >
                                            </small>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" id="enrichupdateri" name="enrichupdateri" class="btn btn-success form-control" onclick="enrichupdate()">Update</button>
                                        </div>
                                        <div class="col-md-3">
                                            <p id="enrichupdatebutton" style="display: none; margin-top: 4%; ">updating<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
                                        </div>
                                    </div>
                                </form>
                                <div class="col-md-2">
                                    <h4>Download</h4>
                                </div>
                                <div class="col-md-10" style="border:1px dashed #000;">
                                    <a href="{{ url('download/rna/')}}/{{ $downloadpath }}----GOenrichment.zip">GOenrichment.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                </div><br>
                    <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <h4>Up-regulated genes:</h4>
                                    </div>
                                    <div class="col-md-10">
                                        {!! $up !!}
                                        <p></p>
                                    </div><br>
                                </div>
                                <div class="col-md-2">
                                    <h4>Down-regulated genes:</h4>
                                </div>
                                <div class="col-md-10">
                                    {!! $down !!}
                                </div>
                            </div>
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
        var type = document.getElementById("data_type").innerHTML;
        if (type == "RNAseq") {
            document.getElementById("DERNA").style.display="block";
        }
        if (type == "MiAr") {
            document.getElementById("DEMiAr").style.display="block";
        }
          
          
    });
</script>
<script>
    layui.use(['element', 'layer','form','table'], function(){
        var element = layui.element;
        var layer = layui.layer;
        var table = layui.table;
        var type = document.getElementById("data_type").innerHTML;
        var name = document.getElementById("name").innerHTML;
        table.render({
            elem: '#showde1'
            ,autoSort: true
            ,text: {
                none: 'no data avalible' //默认：无数据。
            }
            ,cellMinWidth: 90
            ,toolbar: '<div> just top 20 for show</div>'
            ,defaultToolbar: ['filter', 'print', 'exports']
            ,url: '{{url('/detable/f')}}'+ name+","+type//数据接口
            ,cols: [[ //表头
            {field: 'gene', title: 'gene', sort: true}
            ,{field: 'baseMean', title: 'baseMean', sort: true}
            ,{field: 'logFC', title: 'logFC', sort: true}
            ,{field: 'lfcSE', title: 'lfcSE', sort: true}
            ,{field: 'PValue', title: 'P_Value', sort: true}
            ,{field: 'adjPVal', title: 'adj_P_Val', sort: true}
            ]]
        });

        table.render({
            elem: '#showde2'
            ,autoSort: true
            ,text: {
                none: 'no data avalible' //默认：无数据。
            }
            ,cellMinWidth: 90
            ,toolbar: '<div> just top 20 for show</div>'
            ,defaultToolbar: ['filter', 'print', 'exports']
            ,url: '{{url('/detable/f')}}'+ name+","+type//数据接口
            ,cols: [[ //表头
            {field: 'gene', title: 'gene', sort: true}
            ,{field: 'logFC', title: 'logFC', sort: true}
            ,{field: 'AveExpr', title: 'AveExpr', sort: true}
            ,{field: 't', title: 't', sort: true}
            ,{field: 'PValue', title: 'P_Value', sort: true}
            ,{field: 'adjPVal', title: 'adj_P_Val', sort: true}
            ,{field: 'B', title: 'B', sort: true}
            ]]
        });
    });
</script>
<script>
    $(document).ready(function(){
        layui.use('form', function(){
          var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
        });
        layui.use(['form', 'layedit', 'laydate'], function(){
          var form = layui.form
          ,layer = layui.layer
          ,layedit = layui.layedit
          ,laydate = layui.laydate;
        });
        layui.use('element', function(){
          var element = layui.element; //导航的hover效果、二级菜单等功能，需要依赖element模块

          //监听导航点击
          element.on('nav(demo)', function(elem){
            //console.log(elem)
            layer.msg(elem.text());
          });
        });
        layui.use('slider', function(){
          var $ = layui.$
          ,slider = layui.slider;
          //默认滑块
          slider.render({
            elem: '#slideTest1'
          });

          //定义初始值
          slider.render({
            elem: '#slideTest2'
            ,value: 20 //初始值
          });

          //设置最大最小值
          slider.render({
            elem: '#slideTest3'
            ,min: 1 //最小值
            ,max: 8 //最大值
          });
        });

    });

</script>
<script type="text/javascript">
    
    function volcanoupdate() {
        var det = "----";
        var path = $("input[name='downloadpath']").val();
        var f = $("input[name='f_volcano']").val();
        var p = $("input[name='p_volcano']").val();
        var u = $("input[name='u']").val();
        document.getElementById("volcanoupdatebutton").style.display="block";
        console.log('/update/updaternaVolcano/'+path+det+f+det+p+det+u);
        $.ajax({
            type: "get",
            url: '/update/updaternaVolcano/'+path+det+f+det+p+det+u,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
            },
            success: function (data) {
                if(data.code == 'success'){
                    console.log("keyi");
                    //location.reload()
                    console.log(data.png);
                    document.getElementById("volcanopng").src = data.png;
                    document.getElementById("volcanoupdatebutton").style.display="none";
                }else{
                    alert('register fail');
                }
            },
            error: function(request, status, error){
                alert(error);
            },
        });
    };


    function heatmapupdate() {
        var det = "----";
        var path = $("input[name='downloadpath']").val();
        var v = $("input[name='v']").val();
        document.getElementById("heatmapupdatebutton").style.display="block";
        console.log('/update/updaternaHeatmap/'+path+det+v);
        $.ajax({
            type: "get",
            url: '/update/updaternaHeatmap/'+path+det+v,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
            },
            success: function (data) {
                if(data.code == 'success'){
                    console.log("keyi");
                    //location.reload()
                    var sr = document.getElementById("heatmappng").src;
                    console.log(sr);
                    //console.log(data.png);
                    document.getElementById("heatmappng").src = sr+'?t='+'+Math.random()';
                    document.getElementById("heatmapupdatebutton").style.display="none";
                }else{
                    alert('register fail');
                }
            },
            error: function(request, status, error){
                alert(error);
            },
        });
    };

    function enrichupdate() {
        var det = "----";
        var path = $("input[name='downloadpath']").val();
        var t =$("input[name='t']:checked").val();
        var g =$("input[name='g']:checked").val();
        var c =$("input[name='c']:checked").val();
        var f = $("input[name='f_enrich']").val();
        var p = $("input[name='p_enrich']").val();
        var s = $("input[name='s']").val();
        document.getElementById("enrichupdatebutton").style.display="block";
        console.log('/update/updaternaenrich/'+path+det+t+det+g+det+c+det+f+det+p+det+s);
        $.ajax({
            type: "get",
            url: '/update/updaternaenrich/'+path+det+t+det+g+det+c+det+f+det+p+det+s,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
            },
            success: function (data) {
                if(data.code == 'success'){
                    console.log("keyi");
                    //location.reload()
                    var sr = document.getElementById("enrichuppng").src;
                    console.log(sr);
                    //console.log(data.png);
                    document.getElementById("enrichuppng").src = sr+'?t='+'+Math.random()';
                    var sr = document.getElementById("enrichdownpng").src;
                    console.log(sr);
                    //console.log(data.png);
                    document.getElementById("enrichdownpng").src = sr+'?t='+'+Math.random()';
                    document.getElementById("enrichupdatebutton").style.display="none";
                }else{
                    alert('register fail');
                }
            },
            error: function(request, status, error){
                alert(error);
            },
        });
    };
//————————————————
//版权声明：本文为CSDN博主「zlshmily」的原创文章，遵循CC 4.0 BY-SA版权协议，转载请附上原文出处链接及本声明。
//原文链接：https://blog.csdn.net/zlshmily/article/details/105513800
</script>

@endsection
