@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/layui/dist/css/layui.css') }}"  media="all">
.panel{margin-bottom:40px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05)}
.panel-info{border-color:#bce8f1}
.panel-heading{padding:15px 15px;border-bottom:1px solid transparent;border-top-left-radius:3px;border-top-right-radius:3px;color:#333;background-color:#d9edf7;border-color:#ddd}
.panel-body{padding:15px}

<style>
      .pdfobject-container {
        height: 1000px;
      }
      .pdfobject {
        /*border: 1px solid #ccc;*/
      }
    </style>

@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container content" style="margin-top: 40px;">
    <div class="row" style="width: 100%">
        <div class="panel panel-info regionbox" style="width: 100%">
            <div class="panel-heading"><h4>ABOUT LINT</h4></div>
          <div class="panel-body">
        <p style="font-size: 110%">LINT is a lipidomic data processing website aims to provide users a friendly pipeline for statistical analyses and lipidomic data mining. LINT can take various types of "omic" datasets, and integrate multi-omics for data mining. Construction of multi-omic networks can readily accomplish on the LINT. We release the first version of LINT, and more functions and features are on the way...</p>
          </div>
        </div><br>
        <div class="panel panel-info regionbox" style="width: 100%">
            <div class="panel-heading"><h4>CONTACT US</h4></div>
          <div class="panel-body">
        <p style="font-size: 110%">This project welcomes all questions and comments regarding the lipidomic data analysis.</p>
        <p style="font-size: 110%">Please, send your questions, comments or suggestions to: <a href="mailto:lintwebomic_service@outlook.com" style="color: deepskyblue">lintwebomic_service@outlook.com</a>.</p>
          </div>
        </div><br>
        <div class="panel panel-info regionbox" style="width: 100%">
        <div class="panel-heading"><h4>Privacy</h4></div>
          <div class="panel-body">
        <p >Thank you for visiting this website. This dose not gather personal information about users. Information automatically collected in server log files, such as pages visited, will solely be used to improve the usefulness of the website, and not for any commercial purposes.</p>
          </div>
        </div><br>
        <div class="panel panel-info regionbox" style="width: 100%">
            <div class="panel-heading"><h4>User Manual</h4></div>
          <div class="panel-body">
        <p style="font-size: 110%">The user manual shows what LINT can do and the way you use it in deatils. Click <a href="{{ url('download/example').'/User_Manual_of_LINT.pdf' }}" style="color: deepskyblue">User Manual of LINT.pdf</a> to get the Manual.</p>
        <p style="font-size: 110%">Preview of user manual is shown below</p>
          </div>
        </div>
        <div id="pdf-viewer"></div>
    </div>
</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
<script src="{{ asset('/layui/dist/layui.js') }}" charset="utf-8"></script>
<script src="{{ asset('/PDFObject-master/pdfobject.min.js') }}" charset="utf-8"></script>
<script>
PDFObject.embed("/pdf/User_Manual_of_LINT.pdf", "#pdf-viewer");
</script>
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
