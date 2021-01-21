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

        <form id="blastform" action="/result/set">
            {{ csrf_field() }}
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>Omics</h4>
                </div>
                <div class="col-md-9" id="omics">
                    <input  type="radio" value="{{$omics}}" name="omics" checked> <label>{{$omics}}</label><br>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>Data file</h4>
                </div>
                <div class="col-md-9" id="file_data">
                    <input  type="radio" value="{{$file_data}}" name="file_data" checked> <label>{{$file_data}}</label><br>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>Description file</h4>
                </div>
                <div class="col-md-9" id="file_desc">
                    <input  type="radio" value="{{$file_desc}}" name="file_desc" checked> <label>{{$file_desc}}</label><br>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>Groups </h4>

                </div>
                <div class="col-md-9">
                    <select name="analopt">
                        @foreach($groupsLevels as $k=>$i )
                            <option value="{{$i}}">{{$i}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>

            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>Control group</h4>
                </div>
                <div class="col-md-9">
                    <select name="control">
                        @foreach($groupsLevels as $k=>$i )
                            <option value="{{$i}}">{{$i}}</option>
                        @endforeach
                    </select>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3>
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>dataType</h4>
                </div>
                <div class="col-md-9" id="dataType">
                    <input  type="radio" value="rna" name="data_type" checked> <label>RNA-seq</label><br>
                    <input  type="radio" value="microarray" name="data_type"> <label>Microarray</label>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
            <div class="col-md-12" >
                <div class="col-md-3">
                    <h4>normalization</h4>
                </div>
                <div class="col-md-9" id="normalization" style="display: none;">
                    <input id="query_dna" type="radio" value="T" name="normalization" checked> <label> T</label><br>
                    <input id="query_protein" type="radio" value="F" name="normalization"> <label> F</label>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3>
            <div class="col-md-12 text-center">
                <br>
                <button id="submit" class="layui-btn" type="submit" data-toggle="modal" data-target="#myModal">RUN</button>
            </div>
        </form>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            模态框（Modal）标题
                        </h4>
                    </div>
                    <div class="modal-body">
                        在这里添加一些文本
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                        </button>
                        <button type="button" class="btn btn-primary">
                            提交更改
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal -->
        </div>
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

    });


    $("#dataType").click(function (){
        name =$("input[name='data_type']:checked").val();
        if (name == "rna") {
            document.getElementById("normalization").style.display="none";
        }else{
            document.getElementById("normalization").style.display="block";
        }
        console.log(name);
   });


    $('#blastform').submit(function(e) {
        if($('#seq').val() == ''){
            layer.msg('Sequence is empty!');
            e.preventDefault();
        }
    })
    $.ajax({
        beforeSend: function(){       //ajax发送请求时的操作，得到请求结果前有效
            $('#myModal').modal({
                backdrop:'static'      //<span style="color:#FF6666;">设置模态框之外点击无效</span>
            });
            $('#myModal').modal('show');   //弹出模态框
        },
    });
</script>
@endsection
