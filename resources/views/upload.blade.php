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
                <form id="regionform" class="layui-form" action="/canshu">
                    <div style="padding: 20px; background-color: #F2F2F2;">
                        <div class="layui-form-item">
                            <label class="layui-form-label">Data Type：</label>
                            <div class="layui-input-block" id="omics">
                              <input type="radio" name="omics" value="Lipidomics" title="Lipidomics" checked="">
                              <input type="radio" name="omics" value="Metabolomics" title="Metabolomics">
                              <input type="radio" name="omics" value="Transcriptomics" title="Transcriptomics">
                              <input type="radio" name="omics" value="Proteomics" title="Proteomics">
                            </div>
                        </div>
                        <div class="layui-form-item" pane="" id="delodd" style="display: block;">
                          <label class="layui-form-label">analysis option：</label>
                          <div class="layui-input-block" title="Delete the lipid hits with odd acyl-chain fatty acid associated">
                            <input type="checkbox" name="delodd[yes]" lay-skin="primary" title="Odd acyl-chain clearance" checked=""><i class="layui-icon layui-icon-about" style="margin-top: 10px;"></i>
                          </div>
                          <i class="layui-icon layui-icon-about" style="margin-top: 10px;"></i>
                        </div>
                        <div class="col-md-12" id="dataType" style="display: none;">
                            <div class="col-md-2">
                                <h4>Which Type</h4>
                            </div>
                            <div class="col-md-10" >
                                <input  type="radio" value="rna" name="data_type" checked> <label>RNA-seq</label>
                                <input  type="radio" value="microarray" name="data_type"> <label>Microarray</label>
                            </div>
                        </div>
                        <p style="margin-left: 0px;">If you don`t know what to upload, you can click our example to download the file.</p><br>
                        <div class="layui-form-item">
                            <label class="layui-form-label">Data File：<a style="color: #F2F2F2;">.........</a></label>
                            <div class="layui-upload-drag" id="datafile">
                              <i class="layui-icon"></i>
                              <p>Click to upload, or drag the file here</p>
                                <hr>
                                <input id="file_datafile" name='file_datafile' value="no data" />
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">Description file：</label>
                            <div class="layui-upload-drag" id="descfile">
                              <i class="layui-icon"></i>
                              <p>Click to upload, or drag the file here</p>
                                <hr>
                                <input id="file_descfile" name='file_descfile' value="no data" />
                            </div>
                        </div>

                        <div class="col-md-12 text-center">
                            <button id="submitleft" class="layui-btn" type="submit">Continue</button>
                        </div>
                        <br>
                    </div>
                </form>
            </div>
        </div>

        <br>
        <h3>Try example data</h3>
        <hr>
        <form class="layui-form" action="/examplecanshu" id="example">
            <table class="layui-table">
                <colgroup>
                  <col width="33%">
                  <col width="33%">
                  <col>
                </colgroup>
                <thead>
                  <tr>
                    <th>Data Type</th>
                    <th>Data file</th>
                    <th>Descriptional file</th>
                  </tr>
                </thead>
                <tbody id="exampleomics">
                  <tr>
                    <td><input type="radio" name="exampleomics" value="Lipidomics" title="Lipidomics" checked=""></td><td><a href="{{ url('download/example').'/' }}HANlipid_tidy.csv" >Sample 1.csv</a></td><td><a href="{{ url('download/example').'/' }}HANsampleList_lipid.CSV" >Sample 1 description.csv</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Lipidomicscos" title="Lipidomics"></td><td><a href="{{ url('download/example').'/' }}Cos7_integ_2.csv" >Sample 2.csv</a></td><td><a href="{{ url('download/example').'/' }}Cos7_integ_sampleList.csv" >Sample 2 description.csv</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Metabolomics" title="Metabolomics"></td><td><a href="{{ url('download/example').'/' }}metabolites_tidy2.csv" >Sample 3.csv</a></td><td><a href="{{ url('download/example').'/' }}sampleList_lip.csv" >Sample 3 description.csv</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Transcriptomics" title="Transcriptomics"></td><td><a href="{{ url('download/example').'/' }}gene_tidy.CSV" >Sample 4.csv</a></td><td><a href="{{ url('download/example').'/' }}sampleList.CSV" >Sample 4 description.csv</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Transcriptomicshan" title="Transcriptomics"></td><td><a href="{{ url('download/example').'/' }}HANgene_tidy_geneid_allgroups.CSV" >Sample 5.csv</a></td><td><a href="{{ url('download/example').'/' }}HANsampleList_allgroups.CSV" >Sample 5 description.csv</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Proteomics" title="Proteomics"></td><td><a href="{{ url('download/example').'/' }}proteins_Depletion_tidy.csv" >Sample 6.csv</a></td><td><a href="{{ url('download/example').'/' }}sampleList_lip.csv" >Sample 6 description.csv</a></td>
                  </tr>
                </tbody>
            </table>
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
    elem: '#datafile'
    ,accept:'file'
    ,method: 'POST'
    ,data:{
        '_token':'{{csrf_token()}}'
    }
    ,url: '/uploadfile' //改成您自己的上传接口
    ,done: function(res){
      layer.msg('upload succeed');
      $("#file_datafile").val(res.originalname);
      console.log(res)
    }
  });
  var uploadInst = upload.render({
    elem: '#descfile'
    ,accept:'file'
    ,method: 'POST'
    ,data:{
        '_token':'{{csrf_token()}}'
    }
    ,url: '/uploadfile' //改成您自己的上传接口
    ,done: function(res){
      layer.msg('upload succeed');
      $("#file_descfile").val(res.originalname);
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
    $("#omics").click(function (){
        name =$("input[name='omics']:checked").val();
        if (name == "Lipidomics") {
          document.getElementById("delodd").style.display="block";
          document.getElementById("dataType").style.display="none";
        }
        if (name == "Metabolomics" || name == "Proteomics") {
          document.getElementById("delodd").style.display="none";
          document.getElementById("dataType").style.display="none";
        }
        if (name == "Transcriptomics") {
          document.getElementById("dataType").style.display="block";
          document.getElementById("delodd").style.display="none";
        }
        console.log(name);
   });
</script>
@endsection
