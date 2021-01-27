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
            <input type="radio" value="{{$NAstring}}" name="NAstring" checked style="display: none;">
            <input type="radio" value="{{$delodd}}" name="delodd" checked style="display: none;">
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
                                <input type="checkbox" name="like[{{$i}}]" title="{{$i}}">{{$i}}&nbsp;&nbsp;
                            @endforeach
                        </div>
                    </div>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3>
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>Do you want delete the odd chain</h4>
                </div>
                <div class="col-md-9"  id="normalization" style="display: block;">
                    <input type="radio" value="T" name="delodd" checked> <label>Yes,delete it</label><br>
                    <input type="radio" value="F" name="delodd"> <label>No,keep it</label>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3>
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>How to deal with the missing value</h4>
                </div>
                <div class=" col-md-9" id="missing">
                    <div class="layui-input-inline">
                        <input type="radio" value="imputation" name="missing" checked> <label>Imputation</label><br>
                        <input type="radio" value="delete" name="missing"> <label>Delete</label>
                    </div>
                </div>
            </div><br>
            <div id="setprecent" style="display: none;">
                <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
                <div class="col-md-12">
                    <div class="col-md-3">
                        <h4>Set the precent to delete the missing column</h4>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="naperent" lay-verify="required" placeholder="80%" class="layui-input">
                    </div>
                </div><br>
            </div>
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
        name =$("input[name='data_type']:checked").val();
        if (name == "Metabolites" || name == "Proteins" ) {
            document.getElementById("normalization").style.display="none";
        }else{
            document.getElementById("normalization").style.display="block";
        }
    });

    $("#analopt1").click(function (){
        name =$("input[name='analopt1']:checked").val();
        if (name == "other" ) {
            document.getElementById("groups").style.display="block";
        }else{
            document.getElementById("groups").style.display="none";
        }
        console.log(name);
   });

    $("#dataType").click(function (){
        name =$("input[name='data_type']:checked").val();
        if (name == "Metabolites" || name == "Proteins" ) {
            document.getElementById("normalization").style.display="none";
        }else{
            document.getElementById("normalization").style.display="block";
        }
        console.log(name);
   });

</script>
@endsection
