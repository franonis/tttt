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
                <input name="downloadpath" value="{{ $downloadpath }}" style="display: none;">
                <input name="num_fapng" value="{{ $num_fapng }}" style="display: none;">
                <input name="num_headpng" value="{{ $num_headpng }}" style="display: none;">
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
                                    <a href="{{ url('download/mar/')}}/{{ $downloadpath }}MARresults++++DRA.zip">DRA.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                </div><br>
                    <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                                <div class="col-md-2">
                                    <h4>PCA score plot:</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/MARresults/PCA_show.png" style="width: 60%;">
                                </div>
                                <div class="col-md-2">
                                    <h4>OPLS-DA score plot:</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/MARresults/OPLSDA_show.png" style="width: 60%;">
                                </div>
                            </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 2 Volcano-->
                            <div class="col-md-12">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-12" id="sss" title="Lipid class information will be illustrated on volcano plot">
                                            <input type="checkbox" id="s" name="s[yes]" lay-skin="primary" value="Show lipid class">&nbsp; Show lipid class<i class="layui-icon layui-icon-about"></i>
                                        </div>
                                        <div id="wwwwww" style="display: none;" class="col-md-12" title="Applied along with “Show lipid class” option to display the chemical bond links of lipids">
                                            <input type="checkbox" id="w_vol" name="w[yes]" lay-skin="primary" checked="">&nbsp; Ignore subclass<i class="layui-icon layui-icon-about"></i>
                                        </div>
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
                                            <input id="k_volcano" type="text" name="k_volcano" value="{{$kk}}" style="width:50px; display:inline;" class="form-control" >
                                            </small>
                                        </div>
                                        <div class="col-md-4">
                                            <h4>Show TOP hits names:</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <small>
                                            <input id="m_volcano" type="text" name="m_volcano" value="{{$m}}" style="width:50px; display:inline;" class="form-control" >
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
                                    <img id="volcanopng1" src="http://www.lintwebomics.info/{{ $path }}results/MARresults/volcano_show.png" style="width: 60%; display: block;">
                                    <img id="volcanopng2"  src="http://www.lintwebomics.info/{{ $path }}results/MARresults/volcano_show2.png" style="width: 60%; display: none;">
                                </div>
                            </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 3 Heatmap-->
                            <div class="col-md-12">
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
                                    <img id="heatmappng" src="http://www.lintwebomics.info/{{ $path }}results/MARresults/heatmap_show.png" style="width: 60%;">
                                </div>
                            </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 4 Lipid Class statistics-->
                        <div class="col-md-10">
                            <div class="col-md-12">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-12" title="Applied along with “Show lipid class” option to display the chemical bond links of lipids">
                                            <input type="checkbox" id="w_head" id="w_head" name="w[yes]" lay-skin="primary"checked="">&nbsp; Ignore subclass<i class="layui-icon layui-icon-about"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" id="headupdateri" name="headupdateri" class="btn btn-success form-control" onclick="headgroupupdate()">Update</button>
                                        </div>
                                        <div class="col-md-3">
                                            <p id="headupdatebutton" style="display: none; margin-top: 4%; ">updating<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
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
                                                <img id="headgroupcolor" src="http://www.lintwebomics.info/{{ $path }}results/headgroup/headgroupcolor_show.png" style="width: 60%;">
                                                <div class="layui-carousel" id="test1" lay-filter="test1">
                                                  <div carousel-item="">
                                                    @for ($i = 0; $i < $num_headpng; $i++)
                                                        <div>
                                                            <img id="headpng{{$i}}" src="http://www.lintwebomics.info/{{ $path }}results/headgroup/others-{{$i}}.png" class="img1" style="width: 100%;height: auto" data-holder-rendered="true">
                                                        </div>
                                                    @endfor
                                                  </div>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Cumulation plot</h2>
                                            <div class="layui-colla-content">
                                                <img id="headgroupcum" src="http://www.lintwebomics.info/{{ $path }}results/headgroup/headgroupcum_show.png" style="width: 60%;">
                                            </div>
                                          </div>
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Heatmap</h2>
                                            <div class="layui-colla-content">
                                                <div class="col-md-12" title="Heatmap displaying lipid class information">
                                                    <input type="checkbox" name="z[yes]" lay-skin="primary">Show details<i class="layui-icon layui-icon-about"></i>
                                                    <div class="col-md-3">
                                                        <button type="button" id="headheatmapupdateri" name="headheatmapupdateri" class="btn btn-success form-control" onclick="headheatmapupdate()">Update</button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p id="headheatmapupdatebutton" style="display: none; margin-top: 4%; ">updating<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
                                                    </div>
                                                </div>
                                                <img id="headheatmappng" src="http://www.lintwebomics.info/{{ $path }}results/headgroup/headgroupheatmap_show.png" style="width: 60%;">
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 5 Lipid Fatty acid statistics-->
                            <div class="col-md-12">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-3" title="Lipid acyl-chain organization way 'FA_info': only consider the acyl-chain differences in each lipid; 'all_info' consider the summarized acyl-chain length number in each lipid">
                                            <h4>Set plot type <i class="layui-icon layui-icon-about"></i>:</h4>
                                        </div>
                                        <div class="col-md-9">
                                            <small>
                                            <select name="g" id="g">
                                                <option value="FA_info">FA_info</option>
                                                <option value="all_info">all_info</option>
                                            </select>
                                            </small>
                                        </div>
                                        <div class="col-md-12" title="Display the chemical bond links of lipids">
                                            <input type="checkbox" id="w_fa" name="w[yes]" lay-skin="primary" checked="">Ignore subclass<i class="layui-icon layui-icon-about"></i>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="button" id="faupdateri" name="faupdateri" class="btn btn-success form-control" onclick="faupdate()">Update</button>
                                        </div>
                                        <div class="col-md-3">
                                            <p id="faupdatebutton" style="display: none; margin-top: 4%; ">updating<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
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
                                                <img id="fashow" src="http://www.lintwebomics.info/{{ $path }}results/FAchainVisual/fa_show.png" style="width: 60%;">
                                            </div>
                                          </div>
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Heatmap</h2>
                                            <div class="layui-colla-content">
                                                <div class="col-md-3" title="Set the number of top significant changed lipids to display on the heatmap">
                                                    <h4>Show TOP hits <i class="layui-icon layui-icon-about"></i> :</h4>
                                                </div>
                                                <div class="col-md-9">
                                                    <small>
                                                    <input id="e_fa" type="text" name="e_fa" value="{{$e}}" style="width:50px; display:inline;" class="form-control" >
                                                    </small>
                                                
                                                    <div class="col-md-3">
                                                        <button type="button" id="faheatmapupdateri" name="faheatmapupdateri" class="btn btn-success form-control" onclick="faupdate()">Update</button>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p id="faheatmapupdatebutton" style="display: none; margin-top: 4%; ">updating<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
                                                    </div>
                                                </div>
                                                <img id="faheatmappng" src="http://www.lintwebomics.info/{{ $path }}results/FAchainVisual/faheatmap_show.png" style="width: 60%;">
                                            </div>
                                          </div>
                                          <div class="layui-colla-item">
                                            <h2 class="layui-colla-title">Box plot</h2>
                                            <div class="layui-colla-content">
                                                <div class="layui-carousel" id="test2" lay-filter="test2">
                                                  <div carousel-item="">
                                                    @for ($i = 0; $i < $num_fapng; $i++)
                                                        <div>
                                                            <img id="fapng{{$i}}" src="http://www.lintwebomics.info/{{ $path }}results/FAchainVisual/others-{{$i}}.png" class="img2" style="width: 100%;height: auto" data-holder-rendered="true">
                                                        </div>
                                                    @endfor
                                                  </div>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                            </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 6 LION enrichment-->
                        <div class="col-md-12">
                            <form  id="enrich" class="layui-form" action="/update/updaternaenrich">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-12">
                                            <div class="layui-form-item">
                                                <label class="layui-form-label" title="“Target-list mode” enrichment analysis of a subset of lipids of interest, which will be most significant change lipids in lint-web; 
“Ranking mode” performs an enrichment analysis on a complete and ranked list of lipids.">Analysis data by <i class="layui-icon layui-icon-about"></i> : </label>
                                                <div class="layui-input-block" id="t">
                                                  <input type="radio" name="t" value="target_list" title="target_list" checked="">
                                                  <input type="radio" name="t" value="ranking" title="ranking">
                                                </div>
                                            </div>
                                        </div>
                                        <div  class="col-md-12" id="target_list"  style="display: block;">
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
                                                <input id="k_enrich" type="text" name="k_enrich" value="{{$kk}}" style="width:50px; display:inline;" class="form-control" >
                                                </small>
                                            </div>
                                        </div>
                                        <div  class="col-md-12" id="ranking"  style="display: none;">
                                            <div class="layui-form-item">
                                                <label class="layui-form-label">Analytical statistic：</label>
                                                <div class="layui-input-block" id="l">
                                                  <input type="radio" name="l" value="p_value" title="p_value" checked="">
                                                  <input type="radio" name="l" value="log2FC" title="Fold Change">
                                                </div>
                                            </div>
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
                                    <a href="{{ url('download/zip/')}}/{{ $downloadpath }}enrich++++lionenrichment.zip">lionenrichment.zip<i class="layui-icon layui-icon-download-circle"></i></a>
                                </div><br>
                                <div class="col-md-2">
                                    <h4>LION enrichment result</h4>
                                </div>
                                <div class="col-md-10" id="target_listblock" style="display: block;">
                                    <div class="col-md-2">
                                        <h4>Up-regulated lipids: </h4>
                                    </div>
                                    <div class="col-md-10">
                                        {!! $up !!}
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Down-regulated lipids:</h4>
                                    </div>
                                    <div class="col-md-10">
                                        {!! $down !!}
                                    </div>
                                </div>
                                <div class="col-md-10" id="rankingblock" style="display: none;">
                                    <div class="col-md-12">
                                        <img id="rankingpng" src="http://www.lintwebomics.info/{{ $path }}results/FAchainVisual/faheatmap_show.png" style="height:90%;width: 90%;">
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
            carousel.on('change(test1)', function(obj){
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
            carousel.on('change(test2)', function(obj){
                j = obj.index
                re2(ins2, j)
            });
        });

        //layui.use(['carousel'], function () {
        //    var carousel = layui.carousel;
        //    var j = 0
        //    var ins3
        //    // var width = $(".img")[i].width //获取图片宽度
        //    var height = $(".img3")[j].height //获取图片高度
        //    ins3 = carousel.render({
        //        elem: '#test3',
        //        width: '100%', //设置容器宽度
        //        height: height, //轮播图高度为图片高度
        //        arrow: 'hover', //始终显示箭头
        //        anim: 'default', //切换动画方式
        //    });
        //    re3(ins3, j)
        //    carousel.on('change(test3)', function(obj){
        //        j = obj.index
        //        re3(ins3, j)
        //    });
        //});


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

    //function re3(ins3, j){
    //    // var width = $(".img")[i].width
    //    var height = $(".img3")[j].height
    //    ins3.reload({
    //        elem: '#test3',
    //        width: '100%', //设置轮播图宽度
    //        height: height, //轮播图高度为图片高度
    //        arrow: 'hover', //始终显示箭头
    //        anim: 'default', //切换动画方式
    //    });
    //}  
//https://blog.csdn.net/qq_37768929/article/details/106684781


    $("#t").click(function (){
        name =$("input[name='t']:checked").val();
        if (name == "target_list") {
          document.getElementById("target_list").style.display="block";
          document.getElementById("ranking").style.display="none";
        }        
        if (name == "ranking") {
          document.getElementById("ranking").style.display="block";
          document.getElementById("target_list").style.display="none";
        }
        console.log(name);
   });
    $("#sss").click(function (){
        if ($("#s").is(":checked")) {
            document.getElementById("wwwwww").style.display="block";
        }else{
            document.getElementById("wwwwww").style.display="none";
        }
        console.log("names");
    });


</script>

<script type="text/javascript">
    function volcanoupdate() {
        var det = "----";
        var path = $("input[name='downloadpath']").val();
        var s = "F";
        var w = "T";
        if ($("#s").is(":checked")) {
            var s = "T";
        }else{
            var s = "F";
        }
        if ($("#w_vol").is(":checked")) {
            var w = "T";
        }else{
            var w = "F";
        }

        var x = document.getElementById("x").value;
        var j = $("input[name='j_volcano']").val();
        var k = $("input[name='k_volcano']").val();
        var m = $("input[name='m_volcano']").val();
        console.log('/update/updatelipVolcano/'+path+det+s+det+x+det+j+det+k+det+m+det+w);

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

                    if (data.sub == "T") {
                        document.getElementById("volcanopng1").src = data.png1+'?t='+'+Math.random()';
                        document.getElementById("volcanopng2").src = data.png2+'?t='+'+Math.random()';
                        document.getElementById("volcanopng2").style.display="block";
                    }
                    if (data.sub == "F") {
                        document.getElementById("volcanopng1").src = data.png1+'?t='+'+Math.random()';
                        document.getElementById("volcanopng2").style.display="none";

                    }
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
        console.log('/update/updatelipHeatmap/'+path+det+e);
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
                    document.getElementById("heatmappng").src = data.png+'?t='+'+Math.random()';
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

    function headheatmapupdate() {
        var det = "----";
        var path = $("input[name='downloadpath']").val();
        var w = "T";
        var z = "F";
        if ($("#w_head").is(":checked")) {
            var w = "T";
        }else{
            var w = "F";
        }

        if ($("#z").is(":checked")) {
            var z = "T";
        }else{
            var z = "F";
        }
        console.log('/update/updatelipheadheatmap/'+path+det+w+det+z);
        document.getElementById("headheatmapupdatebutton").style.display="block";
        $.ajax({
            type: "get",
            url: '/update/updatelipheadheatmap/'+path+det+w+det+z,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "path": path,
            },
            success: function (data) {
                if(data.code == 'success'){
                    document.getElementById("headheatmappng").src = data.png+'?t='+'+Math.random()';
                    document.getElementById("headheatmapupdatebutton").style.display="none";
                }else{
                    alert('register fail');
                }
            },
            error: function(request, status, error){
                alert(error);
            },
        });
    };

    function headgroupupdate() {
        var det = "----";
        var path = $("input[name='downloadpath']").val();
        var num_headpng = $("input[name='num_headpng']").val();
        var w = "T";
        var z = "F";
        if ($("#w_head").is(":checked")) {
            var w = "T";
        }else{
            var w = "F";
        }

        if ($("#z").is(":checked")) {
            var z = "T";
        }else{
            var z = "F";
        }
        console.log('/update/updateliphead/'+path+det+w+det+z);
        document.getElementById("headupdatebutton").style.display="block";
        $.ajax({
            type: "get",
            url: '/update/updateliphead/'+path+det+w+det+z,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "path": path,
            },
            success: function (data) {
                if(data.code == 'success'){
                    document.getElementById("headgroupcolor").src = data.color+'?t='+'+Math.random()';
                    document.getElementById("headgroupcum").src = data.cum+'?t='+'+Math.random()';
                    document.getElementById("headheatmappng").src = data.heatmap+'?t='+'+Math.random()';
                    for (var i = 0; i < num_headpng; i++) {
                        var sr = document.getElementById("headpng"+i).src ;
                        document.getElementById("headpng"+i).src = sr+'?t='+'+Math.random()';
                    }
                    document.getElementById("headupdatebutton").style.display="none";
                }else{
                    alert('register fail');
                }
            },
            error: function(request, status, error){
                alert(error);
            },
        });
    };
    function faupdate() {
        var det = "----";
        var path = $("input[name='downloadpath']").val();
        var num_fapng = $("input[name='num_fapng']").val();
        var w = "T";
        if ($("#w_fa").is(":checked")) {
            var w = "T";
        }else{
            var w = "F";
        }
        var g = document.getElementById("g").value;
        var e = $("input[name='e_fa']").val();
        console.log('/update/updatelipfa/'+path+det+g+det+w+det+e);
        document.getElementById("faheatmapupdatebutton").style.display="block";
        document.getElementById("faupdatebutton").style.display="block";
        $.ajax({
            type: "get",
            url: '/update/updatelipfa/'+path+det+g+det+w+det+e,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "path": path,
            },
            success: function (data) {
                if(data.code == 'success'){
                    console.log("keyi");
                    var sr = document.getElementById("fashow").src;
                    getElementById("fashow").src = sr+'?t='+'+Math.random()';
                    document.getElementById("faheatmappng").src = data.heatmap+'?t='+'+Math.random()';
                    
                    for (var i = 0; i < num_fapng; i++) {
                        var sr = document.getElementById("fapng"+i).src ;
                        document.getElementById("fapng"+i).src = sr+'?t='+'+Math.random()';
                    }

                    document.getElementById("faheatmapupdatebutton").style.display="none";
                    document.getElementById("faupdatebutton").style.display="none";
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
        var j = $("input[name='j_enrich']").val();
        var k = $("input[name='k_enrich']").val();
        var l =$("input[name='l']:checked").val();
        console.log('/update/updatelipenrich/'+path+det+t+det+j+det+k+det+l);

        document.getElementById("enrichupdatebutton").style.display="block";
        $.ajax({
            type: "get",
            url: '/update/updatelipenrich/'+path+det+t+det+j+det+k+det+l,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "path": path,
            },
            success: function (data) {
                if(data.code == 'success'){
                    console.log("keyi");
                    if (t == "target_list") {
                        document.getElementById("target_listblock").style.display="block";
                        document.getElementById("rankingblock").style.display="none";
                        document.getElementById("up").src = data.pngup+'?t='+'+Math.random()';
                        document.getElementById("down").src = data.pngdown+'?t='+'+Math.random()';

                    }
                    if (t == "ranking") {
                        document.getElementById("rankingblock").style.display="block";
                        document.getElementById("target_listblock").style.display="none";
                        document.getElementById("rankingpng").src = data.png+'?t='+'+Math.random()';

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
