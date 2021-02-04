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
            <input type="radio" value="{{$file_desc}}" name="file_desc" checked style="display: none;">
            <input type="radio" value="{{$data_type}}" name="data_type" checked style="display: none;">
            <input type="radio" value="{{$delodd}}" name="delodd" checked style="display: none;">
            
            <div class="col-md-12" id="choosegroup" style="padding: 20px; background-color: #F2F2F2;">
                <div class="col-md-5" style="padding: 2%; margin-left: 4%; margin-right: 4%; background-color: #FFFFFF;"> 
                    <p>please choose one control group</p><br>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            @foreach($groupsLevels as $k=>$i )
                                <input  type="radio" value="{{$i}}" name="control" checked> <label>{{$i}}</label><br>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-md-5" style="padding: 2%; margin-left: 4%; margin-right: 4%;background-color: #FFFFFF;"> 
                    <p>please choose the group(s)</p><br>
                    <div class="layui-form-item" id="subgroup">
                        <div class="layui-input-block">
                            @foreach($groupsLevels as $k=>$i )
                                <input type="checkbox" name="subgroup[{{$i}}]" checked=""><label>{{$i}}</label><br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
            <div class="col-md-12">
                <div class="col-md-4">
                    <h4 style="margin-top: 2%;">Set the precent to delete the missing column</h4>
                </div>
                <div class="col-md-1">
                    <small>
                        <input type="text" name="naperent" lay-verify="required" placeholder="80" value="80" class="layui-input">
                    </small>
                </div>
                <div class="layui-form-mid layui-word-aux">%</div><br>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3>
            <div class="col-md-12 text-center">
                <br>
                <button id="submit" class="layui-btn" type="submit">RUN</button>
            </div>
        </form>
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

</script>
@endsection
