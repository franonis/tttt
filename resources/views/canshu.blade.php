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
                    <h4>Control Group </h4>
                </div>
                <div class="col-md-9">
                    @foreach($groupsLevels as $k=>$i )
                        <input id="{{$i}}" type="radio" value="{{$i}}" name="groupsLevel" checked> <label>{{$i}}</label><br>
                    @endforeach
                </div>
            </div>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3></HR>
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>dataType</h4>
                </div>
                <div class="col-md-9" id="dataType">
                    <input  type="radio" value="LipidSearch" name="data_type"> <label>LipidSearch</label><br>
                    <input  type="radio" value="MS_DIAL" name="data_type" checked> <label>MS_DIAL</label><br>
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
                    @foreach($firstlines as $k=>$j )
                        <input id="{{$j}}" type="radio" value="{{$j}}" name="firstline" checked> <label>{{$j}}</label><br>
                    @endforeach
                </div>
            </div><br>
            <HR style="FILTER:alpha(opacity=100,finishopacity=0,style=3)" width="90%"color=#987cb9 SIZE=3>
            <div class="col-md-12">
                <div class="col-md-3">
                    <h4>delOddChainOpt</h4>
                </div>
                <div class="col-md-9">
                    <input id="query_dna" type="radio" value="dna" name="query_type" checked> <label> T</label><br>
                    <input id="query_protein" type="radio" value="protein" name="query_type"> <label> F</label>
                </div>
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
        changetheprogram();

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


    $('#example').click(function(){
        $('#seq').html('');
        name = $(this).val();
        name =$("input[name='query_type']:checked").val();
        if(name == 'protein'){
            $('#seq').html(">A0A0A0LTV1\nMSTSELACAYAALALHDDGIAITAEKIAAVVAAAGLCVESYWPSLFAKLAEKRNIGDLLLNVGCGGGAAASVAVAAPTASAAAAPAIEEKREEPKEESDDDMGFSLFD");
        } else if(name == 'dna'){
            $('#seq').html(">A0A0A0LTV1\nATGTCTACCAGTGAACTCGCGTGCGCGTACGCCGCCCTGGCTCTTCACGATGATGGAATCGCAATCACTGCGGAAAAGATTGCAGCCGTTGTAGCAGCTGCGGGGCTCTGTGTGGAATCTTACTGGCCTAGCTTGTTTGCTAAATTGGCCGAGAAGAGGAACATTGGGGACCTTCTTCTTAATGTTGGCTGTGGAGGTGGCGCTGCGGCTTCTGTGGCTGTAGCTGCTCCTACCGCCAGTGCTGCTGCCGCTCCTGCCATCGAGGAAAAGAGGGAGGAGCCAAAGGAGGAGAGCGATGATGACATGGGATTCAGCTTATTCGATTAA");
        }
    });

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
