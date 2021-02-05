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
        <p><a style="font-size: 200%;">Upload your data</a> / Set Parameters / Show the statistical results</p>
        <hr>
        <div class="col-md-12">
            <div class="col-md-12">
                <form class="layui-form" action="/crosscanshu">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div style="padding: 20px; background-color: #F2F2F2;">
                            <div class="layui-form-item">
                                <label class="layui-form-label">Data Type：</label>
                                <div class="layui-input-block">
                                  <input type="radio" name="omics_left" value="Lipidomics" title="Lipidomics" checked="">
                                  <input type="radio" name="omics_left" value="Metabolomics" title="Metabolomics">
                                </div>
                            </div>
                            <div class="layui-form-item" pane="" id="delodd" style="display: none;">
                              <label class="layui-form-label">analysis option：</label>
                              <div class="layui-input-block">
                                <input type="checkbox" name="delodd[yes]" lay-skin="primary" title="I want to delete the odd chain" checked="">
                              </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">Data File</label>
                                <div class="layui-upload-drag" id="left1">
                                  <i class="layui-icon"></i>
                                  <p>Click to upload, or drag the file here</p>
                                    <hr>
                                    <input id="file_datafile_left" name='file_datafile_left' value="no data" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">Desc File</label>
                                <div class="layui-upload-drag" id="left2">
                                  <i class="layui-icon"></i>
                                  <p>Click to upload, or drag the file here</p>
                                    <hr>
                                    <input id="file_descfile_left" name='file_descfile_left' value="no data" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div style="padding: 20px; background-color: #F2F2F2;">
                            <div class="layui-form-item">
                                <label class="layui-form-label">Data Type：</label>
                                <div class="layui-input-block">
                                  <input type="radio" name="omics_right" value="Transcriptomics" title="Transcriptomics" checked="">
                                  <input type="radio" name="omics_right" value="Proteomics" title="Proteomics">
                                </div>
                            </div>
                            <div class="layui-form-item" id="dataType" style="display: none;">
                                <label class="layui-form-label">Which Type：</label>
                                <div class="layui-input-block">
                                  <input  type="radio" value="rna" name="data_type" checked> <label>RNA-seq</label>
                                    <input  type="radio" value="microarray" name="data_type"> <label>Microarray</label>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">Data File</label>
                                <div class="layui-upload-drag" id="right1">
                                  <i class="layui-icon"></i>
                                  <p>Click to upload, or drag the file here</p>
                                    <hr>
                                    <input id="datafile_right" name='datafile_right' value="no data" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">Desc File</label>
                                <div class="layui-upload-drag" id="right2">
                                  <i class="layui-icon"></i>
                                  <p>Click to upload, or drag the file here</p>
                                    <hr>
                                    <input id="file_descfile_right" name='file_descfile_right' value="no data" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button id="submitright" class="layui-btn" type="submit">Continue</button>
                </div>
                <br>
            </form>
            </div>
        </div>

        <br>
        <h3>Try example data</h3>
        <hr>
        <form class="layui-form" action="/examplecanshu" id="example">
            <div class="col-md-12">
                <table class="layui-table">
                <colgroup>
                  <col>
                  <col>
                  <col>
                  <col>
                </colgroup>
                <thead>
                  <tr>
                    <th>Example</th>
                    <th>Omics1 file</th>
                    <th>Omics2 file</th>
                    <th>Descriptional file</th>
                  </tr>
                </thead>
                <tbody id="exampleomics">
                  <tr>
                    <td><input type="radio" name="exampleomics" value="Example1" title="Example1" checked=""></td><td><a href="{{ url('download/example').'/' }}HANLipidMediator_imm_forcor.CSV " >HANLipidMediator_imm_forcor.CSV </a></td><td><a href="{{ url('download/example').'/' }}HANgene_tidy.CSV" >HANgene_tidy.CSV</a></td><td><a href="{{ url('download/example').'/' }}HANsampleList_lipmid.csv" >HANsampleList_lipmid.csv</a><br><a href="{{ url('download/example').'/' }}HANsampleList.CSV" >HANsampleList.CSV</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Example2" title="Example2"></td><td><a href="{{ url('download/example').'/' }}lipids.csv" >lipids.csv</a></td><td><a href="{{ url('download/example').'/' }}RNAseq_genesymbol.csv" >RNAseq_genesymbol.csv</a></td><td><a href="{{ url('download/example').'/' }}sampleList.csv" >sampleList.csv</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Example3" title="Example3"></td><td><a href="{{ url('download/example').'/' }}metabolites.csv" >metabolites.csv</a></td><td><a href="{{ url('download/example').'/' }}RNAseq_genesymbol.csv" >RNAseq_genesymbol.csv</a></td><td><a href="{{ url('download/example').'/' }}sampleList.csv" >sampleList.csv</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Example4" title="Example4"></td><td><a href="{{ url('download/example').'/' }}metabolites_tidy2.csv" >metabolites_tidy2.csv</a></td><td><a href="{{ url('download/example').'/' }}proteins_Depletion_tidy.csv " >proteins_Depletion_tidy.csv </a></td><td><a href="{{ url('download/example').'/' }}sampleList_lip.csv" >sampleList_lip.csv</a></td>
                  </tr>
                </tbody>
            </table>
            </div>
            <div class="col-md-12 text-center">
                <br>
                <button id="submitexample" class="layui-btn" type="submit">Continue</button>
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

layui.use('upload', function(){
  var upload = layui.upload;

  //执行实例
  var uploadInst = upload.render({
    elem: '#right1'
    ,accept:'file'
    ,method: 'POST'
    ,data:{
        '_token':'{{csrf_token()}}'
    }
    ,url: '/uploadfile' //改成您自己的上传接口
    ,done: function(res){
      layer.msg('upload succeed');
      $("#file_right1").val(res.originalname);
      console.log(res)
    }
  });
  var uploadInst = upload.render({
    elem: '#right2'
    ,accept:'file'
    ,method: 'POST'
    ,data:{
        '_token':'{{csrf_token()}}'
    }
    ,url: '/uploadfile' //改成您自己的上传接口
    ,done: function(res){
      layer.msg('upload succeed');
      $("#file_right2").val(res.originalname);
      console.log(res)
    }
  });
  var uploadInst = upload.render({
    elem: '#left1'
    ,accept:'file'
    ,method: 'POST'
    ,data:{
        '_token':'{{csrf_token()}}'
    }
    ,url: '/uploadfile' //改成您自己的上传接口
    ,done: function(res){
      layer.msg('upload succeed');
      $("#file_left1").val(res.originalname);
      console.log(res)
    }
  });
  var uploadInst = upload.render({
    elem: '#left2'
    ,accept:'file'
    ,method: 'POST'
    ,data:{
        '_token':'{{csrf_token()}}'
    }
    ,url: '/uploadfile' //改成您自己的上传接口
    ,done: function(res){
      layer.msg('upload succeed');
      $("#file_left2").val(res.originalname);
      console.log(res)
    }
  });
});
</script>
<script>
    $(document).ready(function(){
        layui.use('form', function(){
          var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
        });

        layui.use('table', function(){
          var table = layui.table; //只有执行了这一步，部分表单元素才会自动修饰成功
        });
    });
    $("#omics_left").click(function (){
        name =$("input[name='omics_left']:checked").val();
        if (name == "Lipidomics") {
          document.getElementById("delodd").style.display="block";
        }
        if (name == "Metabolomics") {
          document.getElementById("delodd").style.display="none";
        }
    });
    $("#omics_right").click(function (){
        name =$("input[name='omics_right']:checked").val();
        if (name == "Proteomics") {
          document.getElementById("dataType").style.display="none";
        }
        if (name == "Transcriptomics") {
          document.getElementById("dataType").style.display="block";
        }
        console.log(name);
    });
</script>
@endsection
