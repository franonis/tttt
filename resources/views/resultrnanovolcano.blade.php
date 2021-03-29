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
        <div class="col-md-12">
                <div class="layui-tab">
                  <ul class="layui-tab-title">
                    <li  class="layui-this">show_variability</li>
                    <li>Volcano</li>
                    <li>Heatmap</li>
                  </ul>
                  <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ url('download/png/')}}/{{ $downloadpath }}results+PCA_show.png"><i class="layui-icon layui-icon-download-circle" style="font-size: 30px;"></i>Download</a>
                                </div>
                                <div class="col-md-2">
                                    <h4>PCA result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/PCA_show.png" style="height:50%;width: 60%;">
                                </div>
                                <div class="col-md-2">
                                    <h4>Heatmap allgroup result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/heatmap_allgroups.png" style="height:50%;width: 60%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <p>Only the "one vs one" mode could give the Volcano result</p>
                        </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <div class="col-md-12">
                                <form  id="Heatmap" class="layui-form" action="/update/updaternaHeatmap">
                                    <input name="path" value="{{ $path }}" style="display: none;">
                                    <input name="f" value="{{ $f }}" style="display: none;">
                                    <input name="p" value="{{ $p }}" style="display: none;">
                                    <input name="u" value="{{ $u }}" style="display: none;">
                                    <div class="col-md-2">
                                        <h4>Set top number</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <small>
                                        <input id="v" type="text" name="v" value="{{ $v }}" style="width:50px; display:inline;" class="form-control" >
                                        </small>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ url('download/png/')}}/{{ $downloadpath }}results+heatmap_top.png"><i class="layui-icon layui-icon-download-circle" style="font-size: 30px;"></i>Download</a>
                                    </div>
                                    <div class="col-md-3">
                                        <button id="submitupdateVolcano" class="layui-btn" type="submit" >Update</button>
                                    </div>
                                </form>
                                <div class="col-md-2">
                                    <h4>Heatmap result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/heatmap_top.png" style="height:50%;width: 60%;">
                                </div>
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
@endsection
