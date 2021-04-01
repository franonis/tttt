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
        <p>Upload your data / Set Parameters / <a style="font-size: 200%;">Show the statistical results</a></p><a style="font-size: 180%;display: block;text-align:right;" >Transcriptomics</a>
        <hr>
            <div class="col-md-2">
            </div>
            <div class="col-md-10">
                <div class="layui-tab">
                  <ul class="layui-tab-title">
                    <li>Different Expression</li>
                    <li  class="layui-this">Data Varability</li>
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
                                <a href="{{ url('download/file/')}}/{{ $downloadpath }}DEgeneStatistics_{{$DEname}}.csv">DEgeneStatistics_{{$DEname}}.csv<i class="layui-icon layui-icon-download-circle"></i></a>
                            </div>
                    <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                            <div class="col-md-2">
                                <h4>Gene differential expression result: </h4>
                            </div>
                            <div class="col-md-10" style="border:1px dashed #000; overflow-y:auto; width:700px; height:400px;">
                                <pre>{{ $DEgeneStatistics }}</pre>
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
                                <input name="downloadpath" value="{{ $downloadpath }}" style="display: none;">
                                <input name="DEname" value="{{ $DEname }}" style="display: none;">
                                <input name="path" value="{{ $path }}" style="display: none;">
                                <input name="v" value="{{ $v }}" style="display: none;">
                                <input name="s" value="{{ $s }}" style="display: none;">
                                <div class="col-md-2">
                                    <h4>Update with new parameters</h4>
                                </div>
                                <div class="col-md-10">
                                    <div class="col-md-4">
                                        <h4>Fold Change threshold:</h4>
                                    </div>
                                    <div class="col-md-8">
                                        <small>
                                        <input id="f" type="text" name="f" value="{{$f}}" style="width:50px; display:inline;" class="form-control" >
                                        </small>
                                    </div>
                                    <div class="col-md-4">
                                        <h4>P-Value threshold:</h4>
                                    </div>
                                    <div class="col-md-8">
                                        <small>
                                        <input id="p" type="text" name="p" value="{{$p}}" style="width:50px; display:inline;" class="form-control" >
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
                                        <button id="submitupdateVolcano"  class="layui-btn" type="submit" >Update</button>
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
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/volcano_show.png" style="height:50%;width: 60%;">
                                </div>
                        </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 4 Heatmap-->
                        <div class="col-md-12">
                            <form  id="Heatmap" class="layui-form" action="/update/updaternaHeatmap">
                                <input name="downloadpath" value="{{ $downloadpath }}" style="display: none;">
                                <input name="DEname" value="{{ $DEname }}" style="display: none;">
                                <input name="path" value="{{ $path }}" style="display: none;">
                                <input name="f" value="{{ $f }}" style="display: none;">
                                <input name="p" value="{{ $p }}" style="display: none;">
                                <input name="u" value="{{ $u }}" style="display: none;">
                                <input name="s" value="{{ $s }}" style="display: none;">
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
                                        <button id="submitupdateVolcano" class="layui-btn" type="submit" >Update</button>
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
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/heatmap_show.png" style="height:50%;width: 60%;">
                                </div>
                        </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 5 GO enrichment-->
                            <div class="col-md-12">
                                <form  id="Heatmap" class="layui-form" action="/update/updaternaenrich">
                                    <input name="downloadpath" value="{{ $downloadpath }}" style="display: none;">
                                    <input name="DEname" value="{{ $DEname }}" style="display: none;">
                                    <input name="path" value="{{ $path }}" style="display: none;">
                                    <input name="u" value="{{ $u }}" style="display: none;">
                                    <input name="v" value="{{ $v }}" style="display: none;">
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
                                            <input id="f" type="text" name="f" value="{{$f}}" style="width:50px; display:inline;" class="form-control" >
                                            </small>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>P-Value threshold:</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <input id="p" type="text" name="p" value="{{$p}}" style="width:50px; display:inline;" class="form-control" >
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
                                            <button id="submitupdateVolcano" class="layui-btn" type="submit" >Update</button>
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
                                <div class="col-md-2">
                                    <h4>Up-regulated genes:</h4>
                                </div>
                                <div class="col-md-10">
                                    {!! $up !!}
                                </div><br>
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
@endsection
