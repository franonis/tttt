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
                            <div class="col-md-12">
                                <form  id="Volcano" class="layui-form" action="/update/updatelipVolcano">
                                    <input name="path" value="{{ $path }}" style="display: none;">
                                    <input name="e" value="{{ $e }}" style="display: none;">
                                    <input name="g" value="{{ $g }}" style="display: none;">
                                    <div class="col-md-2">
                                        <h4>Update with new parameters</h4>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="col-md-12">
                                            <input type="checkbox" name="s[yes]" lay-skin="primary" title="Show lipid class" checked="">
                                            <input type="checkbox" name="w[yes]" lay-skin="primary" title="Ignore subclass" checked="">
                                            <input type="checkbox" name="b[yes]" lay-skin="primary" title="If paired" checked="">
                                        </div>
                                        <div class="col-md-2">
                                            <h4>Set p type</h4>
                                        </div>
                                        <div class="col-md-10">
                                            <small>
                                            <select name="x">
                                                <option value="raw">raw</option>
                                                <option value="fdr">fdr</option>
                                            </select>
                                            </small>
                                        </div>
                                        <div class="col-md-2">
                                            <h4>Set FC thresh</h4>
                                        </div>
                                        <div class="col-md-10">
                                            <small>
                                            <input id="j" type="text" name="j" value="{{$j}}" style="width:50px; display:inline;" class="form-control" >
                                            </small>
                                        </div>
                                        <div class="col-md-2">
                                            <h4>Set p thresh</h4>
                                        </div>
                                        <div class="col-md-10">
                                            <small>
                                            <input id="k" type="text" name="k" value="{{$k}}" style="width:50px; display:inline;" class="form-control" >
                                            </small>
                                        </div>
                                        <div class="col-md-2">
                                            <h4>Set top number</h4>
                                        </div>
                                        <div class="col-md-10">
                                            <small>
                                            <input id="m" type="text" name="m" value="{{$m}}" style="width:50px; display:inline;" class="form-control" >
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
                                        @foreach($downloadfilename["volcano"] as $k=>$i )
                                            <div class="col-md-3">
                                                <a href="{{ url('download/file/')}}/{{ $downloadpath }}++MARresults++{{$i}}">{{$i}}<i class="layui-icon layui-icon-download-circle"></i></a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <h4>Volcano result</h4>
                                </div>
                                <div class="col-md-10">
                                    <img src="http://www.lintwebomics.info/{{ $path }}results/MARresults/volcano_show.png" style="height:50%;width: 60%;">
                                </div>
                            </div>
                    </div>
                    <div class="layui-tab-item">
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
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
                    </div>
                    <div class="layui-tab-item"><!--第一部分 4 Lipid Class Statisitics-->
                        
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
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
                                        <div class="col-md-12">>
                                            @foreach($downloadfilename["headgroup"] as $k=>$i )
                                                <div class="col-md-3">
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
                                                <div id="carousel-example-captions" class="carousel slide" data-ride="carousel">
                                                    <div class="carousel-inner" role="listbox">
                                                    @foreach($headpng as $k=>$i )
                                                        <div class="item active">
                                                            <img src="http://www.lintwebomics.info/{{ $path }}results/headgroup/other_{{$i}}.png" style="height:50%;width: 60%;" data-holder-rendered="true">
                                                            <div class="carousel-caption">
                                                                <h5>{{$i}}</h5>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    </div>
                                                </div>
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
                    </div>
                    <div class="layui-tab-item"><!--第一部分 5 Lipid Fatty acid Statisics-->
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
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
                                        @foreach($fapng as $k=>$i )
                                        <div id="carousel-example-captions" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner" role="listbox">
                                                <div class="item active">
                                                    <img src="http://www.lintwebomics.info/{{ $path }}results/FAchainVisual/other_{{$i}}.png" style="height:50%;width: 60%;" data-holder-rendered="true">
                                                    <div class="carousel-caption">
                                                        <h5>{{$i}}</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item"><!--第一部分 6 LION-->
                        <div class="col-md-2">
                        </div>
                        <div class="col-md-10">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <h4>Not finished yet</h4>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ url('download/file/')}}/{{ $downloadpath }}MARresults+lion.png"><i class="layui-icon layui-icon-download-circle" style="font-size: 30px;"></i>Download</a>
                                </div>
                                <div class="col-md-3">
                                    <button id="submitright" class="layui-btn" type="submit">Update</button>

                                </div>
                                <div class="col-md-2">
                                    <h4>LION enrichment</h4>
                                </div>
                                <div class="col-md-10">
                                    <p>not finished</p>
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

    function changetheprogram() {
        query_type = $("input[name='query_type']:checked").val();
        subject_type = $("input[name='subject_type']:checked").val();
        if (query_type == 'dna') {
            if (subject_type == 'dna') {
                $("#program").html("<option value=blastn>BLASTN</option>");
                $("#program").append("<option value=tblastx>TBLASTX</option>");
            }else if (subject_type == 'protein') {
                $("#program").html("<option value=blastx>BLASTX</option>");
            }
        }else if (query_type == 'protein') {
            if (subject_type == 'dna') {
                $("#program").html("<option value=tblastn>TBLASTN</option>");
            }else if (subject_type == 'protein') {
                $("#program").html("<option value=blastp>BLASTP</option>");
            }
        }
        $("#program").trigger("change");
    }


    $("input:radio").change(function (){
            changetheprogram();
        });


    $('#blastform').submit(function(e) {
        if($('#seq').val() == ''){
            layer.msg('Sequence is empty!');
            e.preventDefault();
        }
    })
</script>
@endsection
