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
        <p>Upload your data / Set Parameters / <a style="font-size: 200%;">Show the statistical results</a></p><a style="font-size: 180%;display: block;text-align:right;" >Lipidomics</a>
        <hr>
            <div class="col-md-2">
            </div>
            <div class="col-md-10"> 
                <div class="layui-tab">
                  <ul class="layui-tab-title">
                    <li class="layui-this">Dimensionality Reduction Analyses</li>
                    <li>Volcano</li>
                    <li>Heatmap</li>
                    <li>Lipid Class Statisitics</li>
                    <li>Lipid Fatty acid Statisics</li>
                    <li>LION enrichment</li>
                  </ul>
                  <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show">
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <h4>Download</h4>
                                </div>
                                <div class="col-md-10" style="border:1px dashed #000;">
                                    <div class="col-md-5">
                                        <a href="{{ url('download/file/')}}/{{ $downloadpath }}MARresults+PCA_score_plot_all.pdf">PCA_score_plot_all.pdf<i class="layui-icon layui-icon-download-circle"></i></a>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="{{ url('download/file/')}}/{{ $downloadpath }}MARresults+OPLSDA_score_plot_all.pdf">OPLSDA_score_plot_all.pdf<i class="layui-icon layui-icon-download-circle"></i></a>
                                    </div>
                                </div>
                    <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                                <div class="col-md-2">
                                    <h4>PCA result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/MARresults/PCA_show.png" style="height:50%;width: 60%;">
                                </div>
                                <div class="col-md-2">
                                    <h4>OPLSDA result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/MARresults/OPLSDA_show.png" style="height:50%;width: 60%;">
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
                            <div class="col-md-12">
                                <form  id="Heatmap" class="layui-form" action="/update/updatelipHeatmap">
                                    <input name="path" value="{{ $path }}" style="display: none;">
                                    <input name="s" value="{{ $s }}" style="display: none;">
                                    <input name="b" value="{{ $b }}" style="display: none;">
                                    <input name="x" value="{{ $x }}" style="display: none;">
                                    <input name="j" value="{{ $j }}" style="display: none;">
                                    <input name="k" value="{{ $k }}" style="display: none;">
                                    <input name="m" value="{{ $m }}" style="display: none;">
                                    <input name="w" value="{{ $w }}" style="display: none;">
                                    <input name="g" value="{{ $g }}" style="display: none;">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-2">
                                            <h4>Set top number</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <input id="e" type="text" name="e" value="{{ $e }}" style="width:50px; display:inline;" class="form-control" >
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
                                    <div class="col-md-12">
                                        @foreach($downloadfilename["heatmap"] as $k=>$i )
                                            <div class="col-md-3">
                                                <a href="{{ url('download/file/')}}/{{ $downloadpath }}++MARresults++{{$i}}">{{$i}}<i class="layui-icon layui-icon-download-circle"></i></a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <h4>Heatmap result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/MARresults/heatmap_show.png" style="height:50%;width: 60%;">
                                </div>
                            </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 4 Lipid Class Statisitics-->
                            <div class="col-md-12">
                                <form  id="Heatmap" class="layui-form" action="/update/updateliphead">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-12">
                                            <input type="checkbox" name="w[yes]" lay-skin="primary" title="Ignore subclass" checked="">
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
                                        <div class="col-md-12">
                                            @foreach($downloadfilename["headgroup"] as $k=>$i )
                                                <div class="col-md-4">
                                                    <a href="{{ url('download/file/')}}/{{ $downloadpath }}++headgroup++{{$i}}">{{$i}}<i class="layui-icon layui-icon-download-circle"></i></a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Lipid Class Statisitics</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="layui-collapse">
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Box plot</h2>
                                            <div class="layui-colla-content layui-show">
                                                <a href="{{ url('download/file/')}}/{{ $downloadpath }}headgroup++headgroupcolor_show.png"><i class="layui-icon layui-icon-download-circle" style="font-size: 30px;"></i>Download this picture</a>
                                                <img src="http://www.lintwebomics.info/{{ $path }}results/headgroup/headgroupcolor_show.png" style="height:50%;width: 60%;">
                                            </div>
                                          </div>
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Cumulation plot</h2>
                                            <div class="layui-colla-content">
                                                <a href="{{ url('download/file/')}}/{{ $downloadpath }}headgroup++headgroupcum_show.png"><i class="layui-icon layui-icon-download-circle" style="font-size: 30px;"></i>Download this picture</a>
                                                <img src="http://www.lintwebomics.info/{{ $path }}results/headgroup/headgroupcum_show.png" style="height:50%;width: 60%;">
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                            </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 5 Lipid Fatty acid Statisics-->
                            <div class="col-md-12">
                                <form  id="Heatmap" class="layui-form" action="/update/updatelipfa">
                                    <input name="path" value="{{ $path }}" style="display: none;">
                                    <input name="s" value="{{ $s }}" style="display: none;">
                                    <input name="b" value="{{ $b }}" style="display: none;">
                                    <input name="x" value="{{ $x }}" style="display: none;">
                                    <input name="j" value="{{ $j }}" style="display: none;">
                                    <input name="k" value="{{ $k }}" style="display: none;">
                                    <input name="m" value="{{ $m }}" style="display: none;">
                                    <input name="w" value="{{ $w }}" style="display: none;">
                                    <input name="e" value="{{ $e }}" style="display: none;">
                                    <div class="col-md-2">
                                        <h4>Set plot type</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <small>
                                        <select name="g">
                                            <option value="FA_info">FA_info</option>
                                            <option value="all_info">all_info</option>
                                        </select>
                                        </small>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>if ignore subclass</h4>
                                    </div>
                                    <div class="col-md-4">
                                        <small>
                                        <select name="w">
                                            <option value="T">T</option>
                                            <option value="F">F</option>
                                        </select>
                                        </small>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ url('download/file/')}}/{{ $downloadpath }}MARresults+heatmap_top.png"><i class="layui-icon layui-icon-download-circle" style="font-size: 30px;"></i>Download</a>
                                    </div>
                                    <div class="col-md-3">
                                        <button id="submitright" class="layui-btn" type="submit">Update</button>
                                    </div>
                                </form>
                                    <div class="col-md-2">
                                        <h4>Lipid Fatty acid Statisics</h4>
                                    </div>
                                    <div class="col-md-10">
                                    </div>
                            </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <p>Only the "one vs one" mode could give the GO enrichment result</p>
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
<script href="{{ asset('/layui/layui-2.4.5/dist/layui.all.js') }}" ></script>
<script src="{{ asset('/layui/dist/layui.js') }}" charset="utf-8"></script>
<script>
    $(document).ready(function(){
        changetheprogram();
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
        //layui.use('carousel', function(){
        //    var carousel = layui.carousel;
        //});

    });

</script>
@endsection
