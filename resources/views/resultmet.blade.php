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
        <p>Upload your data / Set Parameters / <a style="font-size: 200%;">Show the statistical results</a></p><a style="font-size: 180%;display: block;text-align:right;" >Metabolomics</a>
        <hr>
            <div class="col-md-2">
                <input name="downloadpath" value="{{ $downloadpath }}" style="display: none;">
            </div>
            <div class="col-md-10">
                <div class="layui-tab">
                  <ul class="layui-tab-title">
                    <li class="layui-this">Dimensionality Reduction Analyses</li>
                    <li>Volcano</li>
                    <li>Heatmap</li>
                    <li>Enrichment</li>
                  </ul>
                  <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show"><!--第一部分 1 Dimensionality Reduction Analyses-->
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <h4>Download</h4>
                                </div>
                                <div class="col-md-10" style="border:1px dashed #000;">
                                    <a href="{{ url('download/mar/')}}/{{ $downloadpath }}MARresults++++DRA.zip">DRA.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                </div><br>
                    <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                                <div class="col-md-2">
                                    <h4>PCA score plot:</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/MARresults/PCA_show.png" style="height:50%;width: 60%;">
                                </div>
                                <div class="col-md-2">
                                    <h4>OPLS-DA score plot:</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/MARresults/OPLSDA_show.png" style="height:50%;width: 60%;">
                                </div>
                            </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 2 Volcano-->
                            <div class="col-md-12">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-4">
                                            <h4>Adjusted P-Value:</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <select id="x" name="x">
                                                <option value="raw">P-Value</option>
                                                <option value="fdr">Benjamini-Hochberg adjusted P-Value</option>
                                            </select>
                                            </small>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>Fold Change threshold:</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <input id="j_volcano" type="text" name="j_volcano" value="{{$j}}" style="width:50px; display:inline;" class="form-control" >
                                            </small>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>P-Value threshold:</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <input id="k_volcano" type="text" name="k_volcano" value="{{$k}}" style="width:50px; display:inline;" class="form-control" >
                                            </small>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>Show TOP hits names:</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <input id="m" type="text" name="m" value="{{$m}}" style="width:50px; display:inline;" class="form-control" >
                                            </small>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" id="volcanoupdateri" name="volcanoupdateri" class="btn btn-success form-control" onclick="volcanoupdate()">Update</button>
                                        </div>
                                        <div class="col-md-3">
                                            <p id="volcanoupdatebutton" style="display: none; margin-top: 4%; ">updating<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
                                        </div>
                                    </div>
                                <div class="col-md-2">
                                    <h4>Download</h4>
                                </div>
                                <div class="col-md-10" style="border:1px dashed #000;">
                                    <a href="{{ url('download/mar/')}}/{{ $downloadpath }}MARresults++++Volcano.zip">Volcano.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                </div>
                                <div class="col-md-2">
                                    <h4>Volcano result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img id="volcanopng" src="http://www.lintwebomics.info/{{ $path }}results/MARresults/volcano_show.png" style="height:50%;width: 60%;">
                                </div>
                            </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 3 Heatmap-->
                            <div class="col-md-12">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-4" title="Set the number of top significant changed metabolites to display on the heatmap">
                                            <h4>Show TOP hits <i class="layui-icon layui-icon-about"></i> :</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <input id="e" type="text" name="e" value="{{ $e }}" style="width:50px; display:inline;" class="form-control" >
                                            </small>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" id="heatmapupdateri" name="heatmapupdateri" class="btn btn-success form-control" onclick="heatmapupdate()">Update</button>
                                        </div>
                                        <div class="col-md-3">
                                            <p id="heatmapupdatebutton" style="display: none; margin-top: 4%; ">updating<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
                                        </div>

                                    </div>
                                <div class="col-md-2">
                                    <h4>Download</h4>
                                </div>
                                <div class="col-md-10" style="border:1px dashed #000;">
                                    <a href="{{ url('download/mar/')}}/{{ $downloadpath }}MARresults++++Heatmap.zip">Heatmap.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                </div>
                                <div class="col-md-2">
                                    <h4>Heatmap result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img id="heatmappng" src="http://www.lintwebomics.info/{{ $path }}results/MARresults/heatmap_show.png" style="height:50%;width: 60%;">
                                </div>
                            </div>
                    </div>
                        <div class="layui-tab-item"><!--第一部分 4 enrich-->
                            <div class="col-md-12">
                            <form  id="enrich" class="layui-form" action="/update/updaternaenrich">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-3">
                                                <h4>Fold Change threshold: </h4>
                                            </div>
                                            <div class="col-md-9">
                                                <small>
                                                <input id="j_enrich" type="text" name="j_enrich" value="{{$j}}" style="width:50px; display:inline;" class="form-control" >
                                                </small>
                                            </div><br>
                                            <div class="col-md-3">
                                                <h4>P-Value threshold: </h4>
                                            </div>
                                            <div class="col-md-9">
                                                <small>
                                                <input id="k_enrich" type="text" name="k_enrich" value="{{$k}}" style="width:50px; display:inline;" class="form-control" >
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
                    <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                                <div class="col-md-2">
                                    <h4>Download</h4>
                                </div>
                                <div class="col-md-10" style="border:1px dashed #000;">
                                    <a href="{{ url('download/zip/')}}/{{ $downloadpath }}enrich++++enrichment.zip">enrichment.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                </div>
                    <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                                <div class="col-md-2">
                                    <h4>Up-regulated metabolites: </h4>
                                </div>
                                <div class="col-md-10">
                                    {!! $up !!}
                                </div><br>
                                <div class="col-md-2">
                                    <h4>Down-regulated metabolites: </h4>
                                </div>
                                <div class="col-md-10">
                                    {!! $down !!}
                                </div>
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

layui.use('upload', function(){
  var upload = layui.upload;

  //执行实例

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
        var s = "F"
        var w = "F"

        var x = document.getElementById("x").value;
        var j = $("input[name='j_volcano']").val();
        var k = $("input[name='k_volcano']").val();
        var m = $("input[name='m']").val();

        document.getElementById("volcanoupdatebutton").style.display="block";
        $.ajax({
            type: "get",
            url: '/update/updatelipVolcano/'+path+det+s+det+x+det+j+det+k+det+m+det+w,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "path": path,
            },
            success: function (data) {
                if(data.code == 'success'){
                    document.getElementById("volcanopng").src = document.getElementById("volcanopng").src+'?t='+'+Math.random()';
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
        var e = $("input[name='e']").val();
        document.getElementById("heatmapupdatebutton").style.display="block";
        $.ajax({
            type: "get",
            url: '/update/updatelipHeatmap/'+path+det+e,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "path": path,
            },
            success: function (data) {
                if(data.code == 'success'){
                    document.getElementById("heatmappng").src = document.getElementById("heatmappng").src+'?t='+'+Math.random()';
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
        var j = $("input[name='j_enrich']").val();
        var k = $("input[name='k_enrich']").val();

        console.log('/update/updatemetenrich/'+path+det+j+det+k);

        document.getElementById("enrichupdatebutton").style.display="block";
        $.ajax({
            type: "get",
            url: '/update/updatemetenrich/'+path+det+j+det+k,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "path": path,
            },
            success: function (data) {
                if(data.code == 'success'){
                    console.log("keyi");
                    if (data.noup == "yes") {
                        document.getElementById("up").style.display="none";
                        document.getElementById("noup").style.display="block";
                    }else{
                        document.getElementById("up").src = document.getElementById("up").src+'?t='+'+Math.random()';
                        document.getElementById("up").style.display="block";
                        document.getElementById("noup").style.display="none";
                    }
                    if (data.nodown == "yes") {
                        document.getElementById("down").style.display="none";
                        document.getElementById("nodown").style.display="block";
                    }else{
                        document.getElementById("down").src = document.getElementById("down").src+'?t='+'+Math.random()';
                        document.getElementById("down").style.display="block";
                        document.getElementById("nodown").style.display="none";
                    }
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
