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
                    <li>Lipid Class statistics</li>
                    <li>Lipid Fatty acid statistics</li> 
                    <li>LION enrichment</li>
                  </ul>
                  <div class="layui-tab-content">
                    <div class="layui-tab-item layui-show"><!--第一部分 1 Dimensionality Reduction Analyses-->
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <h4>Download</h4>
                                </div>
                                <div class="col-md-10" style="border:1px dashed #000;">
                                    <a href="{{ url('download/zip/')}}/{{ $downloadpath }}MARresults++++MARresults.zip">MARresults.zip<i class="layui-icon layui-icon-download-circle"></i></a>
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
                    <div class="layui-tab-item">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <p>Only the "one vs one" mode could give the Volcano result</p>
                        </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 3 Heatmap-->
                            <div class="col-md-12">
                                <form  id="Heatmap" class="layui-form" action="/update/updatelipHeatmap">
                                    <input name="downloadpath" value="{{ $downloadpath }}" style="display: none;">
                                    <input name="path" value="{{ $path }}" style="display: none;">
                                    <input name="jb" value="{{ $jb }}" style="display: none;">
                                    <input name="j" value="{{ $j }}" style="display: none;">
                                    <input name="k" value="{{ $k }}" style="display: none;">
                                    <input name="m" value="{{ $m }}" style="display: none;">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-4" title="Set the number of top significant changed lipids to display on the heatmap">
                                            <h4>Show TOP hits <i class="layui-icon layui-icon-about"></i> :</h4>
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
                                    <a href="{{ url('download/zip/')}}/{{ $downloadpath }}MARresults++++MARresults.zip">MARresults.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                </div>
                                <div class="col-md-2">
                                    <h4>Heatmap result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/MARresults/heatmap_show.png" style="height:50%;width: 60%;">
                                </div>
                            </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 4 Lipid Class statistics-->
                        <div class="col-md-10">
                            <div class="col-md-12">
                                <form  id="Heatmap" class="layui-form" action="/update/updateliphead">
                                    <input name="downloadpath" value="{{ $downloadpath }}" style="display: none;">
                                    <input name="path" value="{{ $path }}" style="display: none;">
                                    <input name="jb" value="{{ $jb }}" style="display: none;">
                                    <input name="j" value="{{ $j }}" style="display: none;">
                                    <input name="k" value="{{ $k }}" style="display: none;">
                                    <input name="m" value="{{ $m }}" style="display: none;">
                                    <input name="e" value="{{ $e }}" style="display: none;">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-12" title="Applied along with “Show lipid class” option to display the chemical bond links of lipids">
                                            <input type="checkbox" name="w[yes]" lay-skin="primary" title="Ignore subclass" checked=""><i class="layui-icon layui-icon-about"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <button id="submitupdateVolcano" class="layui-btn" type="submit" >Update</button>
                                        </div>
                                    </div>
                                
                                    <div class="col-md-2">
                                        <h4>Download</h4>
                                    </div>
                                    <div class="col-md-10" style="border:1px dashed #000;">
                                        <a href="{{ url('download/zip/')}}/{{ $downloadpath }}headgroup++++headgroup.zip">headgroup.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Lipid Class statistics</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="layui-collapse">
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Box plot</h2>
                                            <div class="layui-colla-content layui-show">
                                                <img src="http://www.lintwebomics.info/{{ $path }}results/headgroup/headgroupcolor_show.png" style="height:50%;width: 60%;">
                                                <div class="layui-carousel" id="test1" lay-filter="test1">
                                                  <div carousel-item="">
                                                    @foreach($headpng as $k=>$i )
                                                        <div>
                                                            <img src="http://www.lintwebomics.info/{{ $path }}results/headgroup/others_{{$i}}.png" class="img1" style="width: 100%;height: auto" data-holder-rendered="true">
                                                        </div>
                                                    @endforeach
                                                  </div>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Cumulation plot</h2>
                                            <div class="layui-colla-content">
                                                <img src="http://www.lintwebomics.info/{{ $path }}results/headgroup/headgroupcum_show.png" style="height:50%;width: 60%;">
                                            </div>
                                          </div>
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Heatmap</h2>
                                            <div class="layui-colla-content">
                                                <div class="col-md-12" title="Heatmap displaying lipid class information">
                                                    <input type="checkbox" name="z[yes]" lay-skin="primary" title="Show details" checked=""><i class="layui-icon layui-icon-about"></i>
                                                </div>
                                                <img src="http://www.lintwebomics.info/{{ $path }}results/headgroup/headgroupheatmap_show.png" style="height:50%;width: 60%;">
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 5 Lipid Fatty acid statistics-->
                            <div class="col-md-12">
                                <form  id="Heatmap" class="layui-form" action="/update/updatelipfa">
                                    <input name="downloadpath" value="{{ $downloadpath }}" style="display: none;">
                                    <input name="path" value="{{ $path }}" style="display: none;">
                                    <input name="jb" value="{{ $jb }}" style="display: none;">
                                    <input name="j" value="{{ $j }}" style="display: none;">
                                    <input name="k" value="{{ $k }}" style="display: none;">
                                    <input name="m" value="{{ $m }}" style="display: none;">
                                    <input name="e" value="{{ $e }}" style="display: none;">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-4" title="Lipid acyl-chain organization way 'FA_info': only consider the acyl-chain differences in each lipid; 'all_info' consider the summarized acyl-chain length number in each lipid">
                                            <h4>Set plot type <i class="layui-icon layui-icon-about"></i>:</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <select name="g">
                                                <option value="FA_info">FA_info</option>
                                                <option value="all_info">all_info</option>
                                            </select>
                                            </small>
                                        </div>
                                        <div class="col-md-12" title="Display the chemical bond links of lipids">
                                            <input type="checkbox" name="w[yes]" lay-skin="primary" title="Ignore subclass" checked=""><i class="layui-icon layui-icon-about"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <button id="submitright" class="layui-btn" type="submit">Update</button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Download</h4>
                                    </div>
                                    <div class="col-md-10" style="border:1px dashed #000;">
                                        <a href="{{ url('download/zip/')}}/{{ $downloadpath }}FAchainVisual++++FAchainVisual.zip">FAchainVisual.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Lipid Fatty acid statistics</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="layui-collapse">
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Grid plot</h2>
                                            <div class="layui-colla-content layui-show">
                                                <img src="http://www.lintwebomics.info/{{ $path }}results/FAchainVisual/fa_show.png" style="height:50%;width: 60%;">
                                            </div>
                                          </div>
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Heatmap</h2>
                                            <div class="layui-colla-content">
                                                <div class="col-md-4" title="Set the number of top significant changed lipids to display on the heatmap">
                                                    <h4>Show TOP hits <i class="layui-icon layui-icon-about"></i> :</h4>
                                                </div>
                                                <div class="col-md-8">
                                                    <small>
                                                    <input id="m" type="text" name="m" value="{{$m}}" style="width:50px; display:inline;" class="form-control" >
                                                    </small>
                                                </div>
                                                <img src="http://www.lintwebomics.info/{{ $path }}results/FAchainVisual/faheatmap_show.png" style="height:50%;width: 60%;">
                                            </div>
                                          </div>
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Box plot</h2>
                                            <div class="layui-colla-content">
                                                <div class="layui-carousel" id="test2" lay-filter="test2">
                                                  <div carousel-item="">
                                                    @foreach($fapng as $k=>$i )
                                                        <div>
                                                            <img src="http://www.lintwebomics.info/{{ $path }}results/FAchainVisual/others_{{$i}}.png" class="img2" style="width: 100%;height: auto" data-holder-rendered="true">
                                                        </div>
                                                    @endforeach
                                                  </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <p>Only the "one vs one" mode could give the LION enrichment result</p>
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
        layui.use(['carousel'], function () {
            var carousel = layui.carousel;
            var i = 0
            var ins1
            // var width = $(".img")[i].width //获取图片宽度
            var height = $(".img1")[i].height //获取图片高度
            ins1 = carousel.render({
                elem: '#test1',
                width: '100%', //设置容器宽度
                height: height, //轮播图高度为图片高度
                arrow: 'hover', //始终显示箭头
                anim: 'default', //切换动画方式
            });
            re1(ins1, i)
            carousel.on('change(carofilter)', function(obj){
                i = obj.index
                re1(ins1, i)
            });
        });

        layui.use(['carousel'], function () {
            var carousel = layui.carousel;
            var j = 0
            var ins2
            // var width = $(".img")[i].width //获取图片宽度
            var height = $(".img2")[j].height //获取图片高度
            ins2 = carousel.render({
                elem: '#test2',
                width: '100%', //设置容器宽度
                height: height, //轮播图高度为图片高度
                arrow: 'hover', //始终显示箭头
                anim: 'default', //切换动画方式
            });
            re2(ins2, j)
            carousel.on('change(carofilter)', function(obj){
                j = obj.index
                re2(ins2, j)
            });
        });

    });

    function re1(ins1, i){
        // var width = $(".img")[i].width
        var height = $(".img1")[i].height
        ins1.reload({
            elem: '#test1',
            width: '100%', //设置轮播图宽度
            height: height, //轮播图高度为图片高度
            arrow: 'hover', //始终显示箭头
            anim: 'default', //切换动画方式
        });
    }

    function re2(ins2, j){
        // var width = $(".img")[i].width
        var height = $(".img2")[j].height
        ins2.reload({
            elem: '#test2',
            width: '100%', //设置轮播图宽度
            height: height, //轮播图高度为图片高度
            arrow: 'hover', //始终显示箭头
            anim: 'default', //切换动画方式
        });
    }
    
    
//https://blog.csdn.net/qq_37768929/article/details/106684781


</script>
@endsection
