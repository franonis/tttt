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

        <form id="blastform" class="layui-form" action="/result/two">
            {{ csrf_field() }}
            <input type="radio" value="{{$command}}" name="command" checked style="display: none;">
            <input type="radio" value="{{$outpath}}" name="outpath" checked style="display: none;">
            <input type="radio" value="{{$omics1}}" name="omics1" checked style="display: none;">
            <input type="radio" value="{{$omics2}}" name="omics2" checked style="display: none;">
            
            <div class="col-md-12" id="choosegroup" style="padding: 20px; background-color: #F2F2F2;">
                <div class="col-md-3">
                    <h4>missing value percent to delete</h4>
                </div>
                <div class="col-md-9">
                        <a>Remove features with ></a>
                        <small>
                        <input id="m" type="text" name="m" value="{{$m}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                        <a>% missing values</a>
                </div>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                <div class="col-md-12">
                    <div class="layui-form-item">
                        <label class="layui-form-label">Choose How to Hierarchical Clustering：</label>
                        <div class="layui-input-block" id="hierarchical">
                          <input type="radio" name="b" value="hierarchical" title="hierarchical" checked="">
                          <input type="radio" name="b" value="k_means" title="k_means">
                          <input type="radio" name="b" value="DBSCAN" title="DBSCAN">
                          <input type="radio" name="b" value="MCL" title="MCL">
                        </div>
                    </div>
                </div>
            <div id="canshu1" style="display: block;">
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
            </div> 
            <div id="canshu2" style="display: none;">
                <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                    <div class="col-md-3">
                        <h4>Set Minimum number of clustering units(for gene/protein)</h4>
                    </div>
                    <div class="col-md-9">
                        <small>
                        <input id="c" type="text" name="c" value="{{$c}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div>
                <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                    <div class="col-md-3">
                        <h4>Set Minimum number of clustering units(for lipid/met)</h4>
                    </div>
                    <div class="col-md-9">
                        <small>
                        <input id="f" type="text" name="f" value="{{$f}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div>
            </div>
            <div id="canshu3" style="display: none;">
                <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                    <div class="col-md-3">
                        <h4>The quantile threshold for the Markov dichotomy</h4>
                    </div>
                    <div class="col-md-9">
                        <small>
                        <input id="p" type="text" name="p" value="{{$p}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div>
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
                        <input id="k" type="text" name="k" value="{{$k}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
            <div class="col-md-12 text-center">
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
<script src="{{ asset('/layui/dist/layui.js') }}" charset="utf-8"></script>

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
    $("#hierarchical").click(function (){
        name =$("input[name='b']:checked").val();
        if (name == "hierarchical" or name == "k_means" ) {
            document.getElementById("canshu1").style.display="block";
            document.getElementById("canshu2").style.display="none";
            document.getElementById("canshu3").style.display="none";
        }
        if (name == "DBSCAN") {
            document.getElementById("canshu1").style.display="none";
            document.getElementById("canshu2").style.display="block";
            document.getElementById("canshu3").style.display="none";        }
        if (name == "DBSCAN") {
            document.getElementById("canshu1").style.display="none";
            document.getElementById("canshu2").style.display="none";
            document.getElementById("canshu3").style.display="block";
        }
   });

    function MsgBox() //声明标识符
    {
        alert("it will take few mins, don`t close this page"); //弹出对话框
    };

</script>
@endsection
