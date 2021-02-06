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
                        <h4>Genes</h4>
                    </div>
                    <div class="col-md-4" style="border:1px dashed #000; overflow-y:auto; width:400px; height:400px;">
                        <pre>{{ $gene }}</pre>
                    </div>
                    <div class="col-md-3" style="border:1px dashed #000;">
                        <a href="">Enrichment</a>
                    </div>
                    <div class="col-md-3" style="border:1px dashed #000;">
                        <a href="{{ url('download/file/')}}/{{ $downloadpath }}genes_{{$k1}}csv">Download</a>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="col-md-2">
                        <h4>Lipids</h4>
                    </div>
                    <div class="col-md-4" style="border:1px dashed #000; overflow-y:auto; width:400px; height:400px;">
                        <pre>{{ $lipid }}</pre>
                    </div>
                    <div class="col-md-3" style="border:1px dashed #000;">
                        <a href="">Enrichment</a>
                    </div>
                    <div class="col-md-3" style="border:1px dashed #000;">
                        <a href="{{ url('download/file/')}}/{{ $downloadpath }}lipids_{{$k2}}csv">Download</a>
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
