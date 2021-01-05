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
                <form class="layui-form" action="/canshu">
                    <div style="padding: 20px; background-color: #F2F2F2;">
                        <div class="layui-form-item">
                            <label class="layui-form-label">Data Type：</label>
                            <div class="layui-input-block">
                              <input type="radio" name="omics" value="lipidomics" title="Lipidomics" checked="">
                              <input type="radio" name="omics" value="metabonomics" title="Metabonomics">
                              <input type="radio" name="omics" value="rna" title="RNA-seq/microarray" checked="">
                              <input type="radio" name="omics" value="proteinomics" title="Proteinomics">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">Data File</label>
                            <div class="layui-upload-drag" id="datafile">
                              <i class="layui-icon"></i>
                              <p>Click to upload, or drag the file here</p>
                                <hr>
                                <input id="file_datafile" name='file_datafile' value="no data" />
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">Desc File</label>
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
        <form class="layui-form" action="/examplecanshu">
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
                <tbody>
                  <tr>
                    <td><input type="radio" name="exampleomics" value="lipidomics" title="Lipidomics" checked=""></td><td>Cos7_integ_2.csv</td><td>Cos7_integ_sampleList.csv</td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="metabonomics" title="Metabonomics" checked=""></td><td>HANgene_tidy.CSV</td><td>HANsampleList.CSV</td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="rna" title="RNA-seq/microarray" checked=""></td><td>gene_tidy.CSV</td><td>sampleList.CSV</td>
                  </tr><tr>
                    <td><input type="radio" name="exampleomics" value="proteinomics" title="Proteinomics" checked=""></td><td>lipid_tidy2.CSV</td><td>sampleList_lip.csv</td>
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

</script>
@endsection
