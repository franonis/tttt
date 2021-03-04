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
        <p>Upload your data /<a style="font-size: 200%;"> Set Parameters</a> / Show the statistical results</p>
        <hr>
        @include('partials.errors')

        <form id="blastform" action="/result/twotwo">
            {{ csrf_field() }}
            <input type="radio" value="{{$file_datafile_left}}" name="file_datafile_left" checked style="display: none;">
            <input type="radio" value="{{$file_descfile_left}}" name="file_descfile_left" checked style="display: none;">
            <input type="radio" value="{{$file_datafile_right}}" name="file_datafile_right" checked style="display: none;">
            <input type="radio" value="{{$file_descfile_right}}" name="file_descfile_right" checked style="display: none;">
            <input type="radio" value="{{$omics_left}}" name="omics_left" checked style="display: none;">
            <input type="radio" value="{{$omics_right}}" name="omics_right" checked style="display: none;">
            <input type="radio" value="{{$delodd}}" name="delodd" checked style="display: none;">
            <input type="radio" value="{{$data_type}}" name="data_type" checked style="display: none;">
            
            <div class="col-md-12" id="choosegroup" style="padding: 20px; background-color: #F2F2F2;">
                <div class="col-md-3">
                    <h4>missing value percent to delete</h4>
                </div>
                <div class="col-md-9">
                        <a>Remove features with more than</a>
                        <small>
                        <input id="m" type="text" name="m" value="{{$m}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                        <a> missing values</a>
                </div>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                <div class="col-md-3">
                    <h4>Set colum number(for gene/protein)</h4>
                </div>
                <div class="col-md-9">
                    <small>
                    <input id="g" type="text" name="g" value="{{$g}}" style="width:50px; display:inline;" class="form-control" >
                    </small>
                </div>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                <div class="col-md-3">
                    <h4>Set line number(for lipid/met)</h4>
                </div>
                <div class="col-md-9">
                    <small>
                    <input id="k" type="text" name="k" value="{{$k}}" style="width:50px; display:inline;" class="form-control" >
                    </small>
                </div>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                <div class="col-md-3">
                    <h4>Set filtering thread</h4>
                </div>
                <div class="col-md-9" id="filtering">
                    <input  type="radio" value="quantile" name="filtering" checked> <label>with 70% quantile of max value</label><br>
                    <input  type="radio" value="own" name="filtering"> <label>using my own thread</label>
                </div>
                <div class="col-md-12" id="ownfilter"  style="display: none;">
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                    <div class="col-md-3">
                        <h4>Set line number(for lipid/met)</h4>
                    </div>
                    <div class="col-md-9">
                        <a>Filter dataset with max correlations more than</a>
                        <small>
                        <input id="s" type="text" name="s" value="{{$s}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                <br>
                <button id="submit" class="layui-btn" type="submit" onclick="MsgBox()">RUN</button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('footer')
  @include('partials.footer')
@endsection
@section('js')
<script href="{{ asset('/layui/layui-2.4.5/dist/layui.all.js') }}" ></script>
<script href="{{ asset('/layer/layer.js') }}"></script>

<script>
    $(document).ready(function(){
        layui.use('form', function(){
          var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
        });
    });

    $("#filtering").click(function (){
        name =$("input[name='filtering']:checked").val();
        if (name == "quantile") {
            document.getElementById("ownfilter").style.display="none";
        }else{
            document.getElementById("ownfilter").style.display="block";
        }
        console.log(name);
   });

    function MsgBox() //声明标识符
    {
        alert("it will take few mins, don`t close this page"); //弹出对话框
    };

</script>
@endsection
