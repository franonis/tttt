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
        <h3>Upload your data</h3>
        <hr>
        <div class="col-md-12">
            <form class="layui-form" action="/crosscanshu">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div style="padding: 20px; background-color: #F2F2F2;">
                            <div class="layui-form-item">
                                <label class="layui-form-label">Data Type：</label>
                                <div class="layui-input-block">
                                  <input type="radio" name="omics" value="lipidomics" title="Lipidomics" checked="">
                                  <input type="radio" name="omics" value="metabonomics" title="Metabonomics">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">Data File</label>
                                <div class="layui-upload-drag" id="left1">
                                  <i class="layui-icon"></i>
                                  <p>Click to upload, or drag the file here</p>
                                    <hr>
                                    <input id="file_left1" name='file_left1' value="no data" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">Desc File</label>
                                <div class="layui-upload-drag" id="left2">
                                  <i class="layui-icon"></i>
                                  <p>Click to upload, or drag the file here</p>
                                    <hr>
                                    <input id="file_left2" name='file_left2' value="no data" />
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
                                  <input type="radio" name="omics" value="microarray" title="RNA-seq/microarray" checked="">
                                  <input type="radio" name="omics" value="proteinomics" title="Proteinomics">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">Data File</label>
                                <div class="layui-upload-drag" id="right1">
                                  <i class="layui-icon"></i>
                                  <p>Click to upload, or drag the file here</p>
                                    <hr>
                                    <input id="file_right1" name='file_right1' value="no data" />
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">Desc File</label>
                                <div class="layui-upload-drag" id="right2">
                                  <i class="layui-icon"></i>
                                  <p>Click to upload, or drag the file here</p>
                                    <hr>
                                    <input id="file_right2" name='file_right2' value="no data" />
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
        <br>
        <h3>Try example data</h3>
        <hr>
        <form class="layui-form" action="/crosscanshu">
            <div class="col-md-6">
                <div class="layui-form-item">
                    <label class="layui-form-label">Data Type：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="omicsl" value="lipidomics" title="Lipidomics" checked="">
                        <input type="radio" name="omicsl" value="metabonomics" title="Metabonomics">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">Data file：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="asl" value="lipidomics" title="Cos7_integ_2.csv" checked="">
                        <input type="radio" name="asl" value="lipidomics" title="HANgene_tidy.CSV" checked="">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">Desc file：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="afl" value="lipidomics" title="Cos7_integ_sampleList.csv" checked="">
                        <input type="radio" name="afl" value="lipidomics" title="HANsampleList.CSV" checked="">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="layui-form-item">
                    <label class="layui-form-label">Data Type：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="omicsr" value="microarray" title="RNA-seq/microarray" checked="">
                        <input type="radio" name="omicsr" value="proteinomics" title="Proteinomics">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">Data file：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="asr" value="lipidomics" title="gene_tidy.CSV" checked="">
                        <input type="radio" name="asr" value="lipidomics" title="lipid_tidy2.CSV" checked="">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">Desc file：</label>
                    <div class="layui-input-block">
                        <input type="radio" name="afr" value="lipidomics" title="sampleList.CSV" checked="">
                        <input type="radio" name="afr" value="lipidomics" title="sampleList_lip.csv" checked="">
                    </div>
                </div>
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
        changetheprogram();
        layui.use('form', function(){
          var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
        });

    });

    function changetheprogram() {
        query_type = $("input[name='query_type']:checked").val();
        subject_type = $("input[name='subject_type']:checked").val();
        if (query_type == 'dna') {
            if (subject_type == 'dna') {
                $("#program").html("<option value=blastn>BLASTN</option>");
                $("#program").append("<option value=tblastx>TBLASTX</option>");
            }else if (subject_type == 'protein') {
                $("#program").html("<option value=blastx>BLASTX</option>");
            }
        }else if (query_type == 'protein') {
            if (subject_type == 'dna') {
                $("#program").html("<option value=tblastn>TBLASTN</option>");
            }else if (subject_type == 'protein') {
                $("#program").html("<option value=blastp>BLASTP</option>");
            }
        }
        $("#program").trigger("change");
    }


    $("input:radio").change(function (){
            changetheprogram();
        });


    $('#blastform').submit(function(e) {
        if($('#seq').val() == ''){
            layer.msg('Sequence is empty!');
            e.preventDefault();
        }
    })
</script>
@endsection
