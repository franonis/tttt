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
                            <div class="layui-form-item" pane="" id="delodd" style="display: block;">
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
                    <td><input type="radio" name="exampleomics" value="Lipidomics" title="Lipidomics" checked=""></td><td><a href="{{ url('download/example').'/' }}HANlipid_tidy.csv" >HANlipid_tidy.csv</a></td><td><a href="{{ url('download/example').'/' }}HANsampleList_lipid.CSV" >HANsampleList_lipid.CSV</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Lipidomicscos" title="Lipidomics"></td><td><a href="{{ url('download/example').'/' }}Cos7_integ_2.csv" >Cos7_integ_2.csv</a></td><td><a href="{{ url('download/example').'/' }}Cos7_integ_sampleList.csv" >Cos7_integ_sampleList.csv</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Metabolomics" title="Metabolomics"></td><td><a href="{{ url('download/example').'/' }}metabolites_tidy2.csv" >metabolites_tidy2.csv</a></td><td><a href="{{ url('download/example').'/' }}sampleList_lip.csv" >sampleList_lip.csv</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Transcriptomics" title="Transcriptomics"></td><td><a href="{{ url('download/example').'/' }}gene_tidy.CSV" >gene_tidy.CSV</a></td><td><a href="{{ url('download/example').'/' }}sampleList.CSV" >sampleList.CSV</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Transcriptomicshan" title="Transcriptomics"></td><td><a href="{{ url('download/example').'/' }}HANgene_tidy_geneid_allgroups.CSV" >HANgene_tidy_geneid_allgroups.CSV</a></td><td><a href="{{ url('download/example').'/' }}HANsampleList_allgroups.CSV" >HANsampleList_allgroups.CSV</a></td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="Proteomics" title="Proteomics"></td><td><a href="{{ url('download/example').'/' }}proteins_Depletion_tidy.csv" >proteins_Depletion_tidy.csv</a></td><td><a href="{{ url('download/example').'/' }}sampleList_lip.csv" >sampleList_lip.csv</a></td>
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
