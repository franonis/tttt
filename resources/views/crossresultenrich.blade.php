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
        <p>Upload your data / Set Parameters / Show the correlation results /<a style="font-size: 200%;"> Show the enrich results</a></p><a style="font-size: 180%;display: block;text-align:right;" >Enrichment</a>
        <hr>
            <div class="col-md-2">
                <input name="downloadpath" value="{{ $downloadpath }}{{$g}}{{$j}}" style="display: none;">
                <input name="omics2" value="{{ $omics2 }}" style="display: none;">
                <h3>Name list</h3>
            </div>
            <div class="col-md-10">
                <br>
                <div class="col-md-6">
                    <div class="col-md-12 text-center">
                        <h4>{{$omics1}}</h4>
                    </div>
                    <div class="col-md-12">
                        <a style="display: none;" name="tax" id="lipidname" value="{{ $downloadpath }}{{$lipid}}">{{ $downloadpath }}{{$lipid}}</a>
                        <table id="showlipid" lay-filter="test"></table>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="col-md-12 text-center">
                        <h4>{{$omics2}}</h4>
                    </div>
                    <div class="col-md-12">
                        <a style="display: none;" name="tax" id="genename" value="{{ $downloadpath }}{{$gene}}">{{ $downloadpath }}{{$gene}}</a>
                        <table id="showgene" lay-filter="test"></table>
                    </div>
                </div><br>
            </div>
            <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR><br>

            <div class="col-md-2">
                <h3>Download</h3>
            </div>
            <div class="col-md-10">
                <div class="col-md-6">
                    <br><div class="col-md-12" style="border:1px dashed #000;">
                        <a href="{{ url('download/file/')}}/{{ $downloadpath }}lipids_{{$j}}.csv">Download full lipid list file ↑</a>
                    </div><br>
                </div>
                <div class="col-md-6">
                    <br><div class="col-md-12" style="border:1px dashed #000;">
                        <a href="{{ url('download/file/')}}/{{ $downloadpath }}genes_{{$g}}.csv">Download the gene list file ↑</a>
                    </div><br>
                </div><br>
                <div class="col-md-6">
                    <br><div class="col-md-12" style="border:1px dashed #000;">
                        <a href="{{ url('download/zip/')}}/{{ $downloadpath }}{{$g}}{{$j}}enrich++++Enrichresult.zip">Download result of enrich and circos</a>
                    </div><br>
                </div><br>
            </div><br>
            <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR><br>
            <div class="col-md-2">
                <h3>Update</h3>
            </div>
            <div class="col-md-10">
                <div class="col-md-6">
                    <p>enrichment of lipid dont need update</p>
                </div>
                <div class="col-md-6">
                    <form id="regionform" class="layui-form">
                            <input name="k" value="{{ $g }}" style="display: none;">
                            <input name="j" value="{{ $j }}" style="display: none;">
                            <div class="col-md-12" style="margin-left: -10px;">
                                <div class="col-md-12">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">Choose species：</label>
                                        <div class="layui-input-block" id="t">
                                          <input type="radio" name="t" value="mmu" title="Mus musculus" checked="">
                                          <input type="radio" name="t" value="hsa" title="Homo sapiens">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="genetype" style="display: none;">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">Gene Type：</label>
                                        <div class="layui-input-block" id="g">
                                          <input type="radio" name="g" value="ENSEMBL" title="ENSEMBL">
                                          <input type="radio" name="g" value="SYMBOL" title="SYMBOL" checked="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">GO term：</label>
                                        <div class="layui-input-block" id="c" >
                                          <input type="radio" name="c" value="Biological_Process" title="Biological Process" checked="">
                                          <input type="radio" name="c" value="Cellular_Component" title="Cellular Component">
                                          <input type="radio" name="c" value="Molecular_Function" title="Molecular Function">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">Set top number：</label>
                                        <div class="layui-input-block" id="s">
                                          <input id="s" type="text" name="s" value="{{$s}}" style="width:50px; display:inline;" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="button" id="enrichupdateri" name="enrichupdateri" class="btn btn-success form-control" onclick="enrichupdate()">Update {{$omics2}} enrich</button>
                                </div>
                                <div class="col-md-3">
                                    <p id="enrichupdatebutton" style="display: none; margin-top: 4%; ">updating<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
                                </div>                            
                            </div>
                    </form>
                </div>
            </div>
            <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR><br>
            <div class="col-md-2">
                <h3>Enrich results</h3>
            </div>
            <div class="col-md-10">
                <div class="col-md-6">
                    {!! $resultpng1 !!}
                </div>
                <div class="col-md-6">
                    {!! $resultpng2 !!}
                </div>
            </div>
            <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR><br>
            <div class="col-md-2">
                <h3>Circos results</h3>
            </div>
            <div class="col-md-10">
                <div class="col-md-2">
                    <h4>Update with new parameters</h4>
                </div>
                <div class="col-md-10">
                    <div class="col-md-3">
                        <h4>Correlation threshold: </h4>
                    </div>
                    <div class="col-md-9">
                        <small>
                        <input id="t" type="text" name="t" value="{{$t}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div><br>
                    <div class="col-md-3">
                        <h4>Number of GO term: </h4>
                    </div>
                    <div class="col-md-9">
                        <small>
                        <input id="n" type="text" name="n" value="{{$n}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div>
                    <div class="col-md-3">
                        <button type="button" id="circosupdateri" name="circosupdateri" class="btn btn-success form-control" onclick="circosupdate()">Update</button>
                    </div>
                    <div class="col-md-9">
                        <p id="circosupdatebutton" style="display: none; margin-top: 4%; ">updating<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
                    </div>
                </div>
                <div class="col-md-2">
                    <h4>Circos plot result: </h4>
                </div>
                <div class="col-md-10">
                    {!! $circos !!}
                </div>
            </div>
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
        omics=$("input[name='omics2']").val();
        if (omics == "Proteomics") {
          document.getElementById("genetype").style.display="none";
        }
        if (omics == "Transcriptomics") {
          document.getElementById("genetype").style.display="block";
        }
        console.log(omics);
    });
</script>
<script>
    layui.use(['element', 'layer','form','table'], function(){
        var element = layui.element;
        var layer = layui.layer;
        var table = layui.table;
        var genename = document.getElementById("genename").innerHTML;
        console.log("gene"+genename);
        table.render({
            elem: '#showgene'
            ,autoSort: true
            ,text: {
                none: 'no data avalible' //默认：无数据。
            }
            ,cellMinWidth: 90
            ,toolbar: '<div> just top 10 genes for show</div>'
            ,url: '{{url('/nametable/f')}}'+ genename//数据接口
            ,cols: [[ //表头
            {field: 'no', title: 'No.', sort: true}
            ,{field: 'name', title: 'Name', sort: true}            ]]
        });
    });
</script>

<script>
    layui.use(['element', 'layer','form','table'], function(){
        var element = layui.element;
        var layer = layui.layer;
        var table = layui.table;
        var lipidname = document.getElementById("lipidname").innerHTML;

        console.log("lip"+lipidname);
        table.render({
            elem: '#showlipid'
            ,autoSort: true
            ,text: {
                none: 'no data avalible' //默认：无数据。
            }
            ,cellMinWidth: 90
            ,toolbar: '<div> just top 10 lipids for show</div>'
            ,url: '{{url('/nametable/f')}}'+ lipidname//数据接口
            ,cols: [[ //表头
            {field: 'no', title: 'No.', sort: true}
            ,{field: 'name', title: 'Name', sort: true}
            ]]
        });
    });
</script>

<script type="text/javascript">
    function circosupdate() {
        var det = "----";
        var path = $("input[name='downloadpath']").val();
        var k = $("input[name='k']").val();
        var j = $("input[name='j']").val();
        var t = $("input[name='t']").val();
        var n = $("input[name='n']").val();
        console.log('/update/updatemutilcircos/'+path+det+j+det+k+det+t+det+n);

        document.getElementById("circosupdatebutton").style.display="block";
        $.ajax({
            type: "get",
            url: '/update/updatemutilcircos/'+path+det+j+det+k+det+t+det+n,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "path": path,
            },
            success: function (data) {
                if(data.code == 'success'){
                    console.log("keyi");
                    var sr = document.getElementById("circos").src;
                    document.getElementById("circos").src = sr+'?t='+'+Math.random()';
                    document.getElementById("circosupdatebutton").style.display="none";
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
        var k = $("input[name='k']").val();
        var g =$("input[name='g']:checked").val();
        var t = $("input[name='t']").val();
        var s = $("input[name='s']").val();
        var c = $("input[name='c']").val();
        omics=$("input[name='omics2']").val();
        if (omics == "Proteomics") {
            var link = '/update/updatemutilenrich/'+path+det+omics+det+k+det+t+det+s+det+c;
        }
        if (omics == "Transcriptomics") {
            var link = '/update/updatemutilenrich/'+path+det+omics+det+k+det+t+det+s+det+c+det+g;
        }
        console.log(link);

        document.getElementById("enrichupdatebutton").style.display="block";
        $.ajax({
            type: "get",
            url: link,
            dataType: 'json',
            header: {'X-CRSF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                "path": path,
            },
            success: function (data) {
                if(data.code == 'success'){
                    console.log("keyi");
                    var sr = document.getElementById("resultpng2").src;
                    document.getElementById("resultpng2").src = sr+'?t='+'+Math.random()';
                    document.getElementById("enrichupdatebutton").style.display="none";
                }else{
                    alert('register fail');
                }
            },
            error: function(request, status, error){
                alert(error);
            },
        });
    };circosupdate
</script>

@endsection
