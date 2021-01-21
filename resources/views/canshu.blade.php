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
                    <h4>omics</h4>
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
                    <h4>analysis Option</h4>
                </div>
                <div class="col-md-9" id="analopt1">
                    <input  type="radio" value="all_together" name="analopt1" checked> <label>all_together</label><br>
                    <input  type="radio" value="other" name="analopt1"> <label>or choose a group</label><br>
                    <select name="analopt" id="groups" style="display: none;">
                        @foreach($groupsLevels as $k=>$i )
                            <option value="{{$i}}">{{$i}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>Control Group </h4>
                </div>
                <div class="col-md-9">
                    <select name="control">
                      @foreach($groupsLevels as $k=>$i )
                          <option value="{{$i}}">{{$i}}</option>
                      @endforeach
                    </select>
                </div>
            </div>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>dataType</h4>
                </div>
                <div class="col-md-9" id="dataType">
                    <input  type="radio" value="LipidSearch" name="data_type" checked> <label>LipidSearch</label><br>
                    <input  type="radio" value="MS_DIAL" name="data_type"> <label>MS_DIAL</label><br>
                    <input  type="radio" value="Metabolites" name="data_type"> <label>Metabolites</label><br>
                    <input  type="radio" value="Proteins" name="data_type"> <label>Proteins</label>
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>lip Field</h4>
                </div>
                <div class="col-md-9">
                    <select name="firstline">
                        @foreach($firstlines as $k=>$i )
                            <option value="{{$i}}">{{$i}}</option>
                        @endforeach
                    </select>
                </div>
            </div><br>
                <input type="radio" value={{$delodd}} name="delodd" style="display: none;">
                <input type="radio" value={{$NAstring}} name="NAstring" style="display: none;">
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
