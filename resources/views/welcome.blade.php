@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/layui/dist/css/layui.css') }}"  media="all">
@endsection

@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="jumbotron" style="padding-bottom: 0px;padding-top: 0px;">
      <div class="container">
          <div class="col-md-12">
              <h2>Welcome to</h2>
              <p><strong><i><a >LINT</a></i></strong>, a lipidomic data processing website aims to provide users a friendly pipeline for statistical analyses and lipidomic data mining. LINT can take various types of "omic" datasets, and integrate multi-omics for data mining. Construction of multi-omic networks can readily accomplish on the LINT. We release the first version of LINT, and more functions and features are on the way...
</p>
          </div>
        </div>
</div><br><br>
<div class="col-md-1">
</div>
<div class="col-md-10">
  <div class="col-md-12">
    <div style="padding: 20px; background-color: #F2F2F2; height: 150px;" >
      <div class="layui-row layui-col-space15">
        <div class="layui-col-md6"  style="height: 100px;">
          <div class="layui-card">
            <div class="layui-card-header">Single Omic Dataset Analysis</div>
            <div class="layui-card-body">
              Single Omic Dataset Analysis mostly processes the common statistical analyses on lipidomic dataset including lipid differential analysis, multivariate comparison, dimensionality reduction, lipid class summarization, lipid ontology analysis... We also integrate basic statistical analyses for metabolomic, transcriptomic, and proteomic datasets.<br>
              <a href="/single" style="color: deepskyblue;font-size: 180%;">>>>click here to start<<<</a>
            </div>
          </div>
        </div>
        <div class="layui-col-md6"  style="height: 100px;">
          <div class="layui-card">
            <div class="layui-card-header">Intra-omic Dataset Analysis</div>
            <div class="layui-card-body">
              Intra-omic Dataset Analysis (also named Multiomic Dataset Analysis) mostly connect two omic datasets to create correlation network. The data mining of such intra-omic correlation network would provide users a broader ontological view of lipidomic results.<br>
              <a href="/intra" style="color: deepskyblue;font-size: 180%;">>>>click here to start<<<</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br/><br/><br/><br/><br/><br/>
<div class="col-md-1">
</div><br/><br/><br/><br/><br/><br/>
<div style="height: 180px;">
  
</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
<script src="{{ asset('/layui/dist/layui.js') }}" charset="utf-8"></script>
<script>
layui.use(['element', 'layer'], function(){
  var element = layui.element;
  var layer = layui.layer;
  
  //监听折叠
  element.on('collapse(test)', function(data){
    layer.msg('展开状态：'+ data.show);
  });
});
</script>



@endsection
