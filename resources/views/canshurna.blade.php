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
            <input type="radio" value="{{$omics}}" name="omics" checked style="display: none;">
            <input type="radio" value="{{$file_data}}" name="file_data" checked style="display: none;">
            <input type="radio" value="{{$data_type}}" name="data_type" checked style="display: none;">
            <input type="radio" value="{{$file_desc}}" name="file_desc" checked style="display: none;">
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>There are three analysis mode,please choose one</h4>
                </div>
                <div class="col-md-9" id="mode">
                    <input  type="radio" value="all_together" name="mode" checked> <label>take all groups together into account</label><br>
                    <input  type="radio" value="onetoone" name="mode"> <label>one vs one</label><br>
                    <input  type="radio" value="subgroup" name="mode"> <label>take some groups together into account</label><br>
                </div>
            </div>
            <div class="col-md-12" id="choosegroup" style="display: none;">
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                <div class="col-md-3">
                    <h4>Choose the groups</h4>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12" id="onetoone" style="display: none;">
                        <div class="col-md-6"> 
                            <p>please choose the experiment group</p><br>
                            <select name="experiment">
                                @foreach($groupsLevels as $k=>$i )
                                    <option value="{{$i}}">{{$i}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6"> 
                            <p>please choose the control group</p><br>
                            <select name="control">
                                @foreach($groupsLevels as $k=>$i )
                                    <option value="{{$i}}">{{$i}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="layui-form-item" id="subgroup" style="display: none;">
                        <div class="layui-input-block">
                            @foreach($groupsLevels as $k=>$i )
                                <input type="checkbox" name="subgroup[{{$i}}]" title="{{$i}}">{{$i}}&nbsp;&nbsp;
                            @endforeach
                        </div>
                    </div>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3>
            <div class="col-md-12 text-center">
                <br>
                <button id="submit" class="layui-btn btn btn-primary btn-lg" type="submit" data-toggle="modal" data-target="#myModal">RUN</button>
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
        layui.use('form', function(){
          var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
        });
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

    //$.ajax({
    //    beforeSend: function(){       //ajax发送请求时的操作，得到请求结果前有效
    //        $('#myModal').modal({
    //            backdrop:'static'      //<span style="color:#FF6666;">设置模态框之外点击无效</span>
    //        });
    //        $('#myModal').modal('show');   //弹出模态框
    //    },
    //});
</script>
@endsection
