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

        <form id="blastform" class="layui-form" action="/result/twotwo">
            {{ csrf_field() }}
            <div class="col-md-12" style="display: none;">
                <input type="radio" value="{{$file_datafile_left}}" name="file_datafile_left" checked style="display: none;">
                <input type="radio" value="{{$file_descfile_left}}" name="file_descfile_left" checked style="display: none;">
                <input type="radio" value="{{$file_datafile_right}}" name="file_datafile_right" checked style="display: none;">
                <input type="radio" value="{{$file_descfile_right}}" name="file_descfile_right" checked style="display: none;">
                <input type="radio" value="{{$omics_left}}" name="omics_left" checked style="display: none;">
                <input type="radio" value="{{$omics_right}}" name="omics_right" checked style="display: none;">
                <input type="radio" value="{{$delodd}}" name="delodd" checked style="display: none;">
                <input type="radio" value="{{$data_type}}" name="data_type" checked style="display: none;">
            </div>
            
            <div class="col-md-12" id="choosegroup" style="padding: 20px; background-color: #F2F2F2;">
                <div class="col-md-3">
                    <h4>missing value percent to delete</h4>
                </div>
                <div class="col-md-9" style="margin-bottom: 1%;">
                        <a>Remove features with more than</a>
                        <small>
                        <input id="m" type="text" name="m" value="{{$m}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                        <a>% missing values</a>
                </div>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                <div class="col-md-12">
                    <div class="layui-form-item"  title="Clustering method to generate Intra-omics correlation matrix">
                        <label class="layui-form-label">Hierarchical Clustering algorithm:<i class="layui-icon layui-icon-about"></i></label>
                        <div class="layui-input-block" id="hierarchical">
                          <input type="radio" name="b" value="hierarchical" title="hierarchical" checked=""><i class="layui-icon layui-icon-about" title="Using hierarchical clustering to do correlation matrix clustering."></i>&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="b" value="k_means" title="k_means"><i class="layui-icon layui-icon-about" title="Using k-means clustering to do correlation matrix clustering."></i>&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="b" value="DBSCAN" title="DBSCAN"><i class="layui-icon layui-icon-about" title="Using DBSCAN clustering to do correlation matrix clustering."></i>&nbsp;&nbsp;&nbsp;&nbsp;
                          <input type="radio" name="b" value="MCL" title="MCL"><i class="layui-icon layui-icon-about" title="Using Markov clustering algorithm to do correlation matrix clustering."></i>&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                </div>
            <div id="canshu1" style="display: block;">
                <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                    <div class="col-md-3" title="Setting the number of blocks when dividing Transcriptomics/Proteomics data into blocks in the correlation matrix.">
                        <h4>Set colum number(for gene/protein) <i class="layui-icon layui-icon-about"></i></h4>
                    </div>
                    <div class="col-md-9">
                        <small>
                        <input id="g" type="text" name="g" value="{{$g}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div>
                <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                    <div class="col-md-3" title="Setting the number of blocks when dividing Lipidomics/Metabolomics data into blocks in the correlation matrix.">
                        <h4>Set line number(for lipid/met) <i class="layui-icon layui-icon-about"></i></h4>
                    </div>
                    <div class="col-md-9">
                        <small>
                        <input id="k" type="text" name="k" value="{{$k}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div>
            </div> 
            <div id="canshu2" style="display: none;">
                <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                    <div class="col-md-3" title="Setting minimum number of clustering units when dividing Transcriptomics/Proteomics data into blocks in the correlation matrix.">
                        <h4>Set Minimum number of clustering units(for gene/protein) <i class="layui-icon layui-icon-about"></i></h4>
                    </div>
                    <div class="col-md-9">
                        <small>
                        <input id="c" type="text" name="c" value="{{$c}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div>
                <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                    <div class="col-md-3" title="Setting minimum number of clustering units when dividing Lipidomics/Metabolomics data into blocks in the correlation matrix.">
                        <h4>Set Minimum number of clustering units(for lipid/met) <i class="layui-icon layui-icon-about"></i></h4>
                    </div>
                    <div class="col-md-9">
                        <small>
                        <input id="f" type="text" name="f" value="{{$f}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div>
            </div>
            <div id="canshu3" style="display: none;">
                <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                    <div class="col-md-3" title="Setting the quantile threshold for the Markov dichotomy when dividing intra-omics data into blocks in the correlation matrix.">
                        <h4>The quantile threshold for the Markov dichotomy <i class="layui-icon layui-icon-about"></i></h4>
                    </div>
                    <div class="col-md-9">
                        <small>
                        <input id="p" type="text" name="p" value="{{$p}}" style="width:50px; display:inline;" class="form-control" >
                        </small>
                    </div>
            </div>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                <div class="col-md-3" title="Filter the correlation matrix with a criterion">
                    <h4>Set filtering thread <i class="layui-icon layui-icon-about"></i>:</h4>
                </div>
                <div class="col-md-9" id="filtering">
                    <input  type="radio" value="quantile" name="filtering" checked> <label>with 70% quantile of max value</label><br>
                    <input  type="radio" value="own" name="filtering"> <label>customized thresholds</label>
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
            <br><HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3>
            <div class="col-md-12">
                <div class="col-md-3" style="margin-top: 1%;">
                    <h4>How to normalization: </h4>
                </div>
                <div class="col-md-9 layui-form">
                    <div class="layui-input-block" id="a">
                      <input type="radio" name="a" value="A" title="MedianNorm+LogTransformation+AutoScaling" checked=""><br>
                      <input type="radio" name="a" value="B" title="PQN+AutoScaling"><br>
                      <input type="radio" name="a" value="C" title="AutoScaling"><br>
                    </div>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
            <div class="col-md-12 text-center">
                <br>
                <button id="submit" class="layui-btn" type="submit" onclick="MsgBox()">RUN</button>
                <div id="runbutton" class="col-md-12 text-center" style="display: none; border:2px solid #000; margin-top: -5%; margin-bottom: 10%; background-color:darkgrey; ">
                    <p style="font-size: 20px; margin-top: 5%; margin-bottom: 5%;">it will take about few minutes, don`t close this page<i class="layui-icon layui-icon-loading layui-anim layui-anim-rotate layui-anim-loop"></i></p>
                </div>
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
        if (name == "hierarchical" || name == "k_means" ) {
            document.getElementById("canshu1").style.display="block";
            document.getElementById("canshu2").style.display="none";
            document.getElementById("canshu3").style.display="none";
        }
        if (name == "DBSCAN") {
            document.getElementById("canshu1").style.display="none";
            document.getElementById("canshu2").style.display="block";
            document.getElementById("canshu3").style.display="none";        }
        if (name == "MCL") {
            document.getElementById("canshu1").style.display="none";
            document.getElementById("canshu2").style.display="none";
            document.getElementById("canshu3").style.display="block";
        }
   });

    function MsgBox() //声明标识符
    {
        document.getElementById("runbutton").style.display="block";
        //alert("it will take few mins, don`t close this page"); //弹出对话框
    };

</script>
@endsection
