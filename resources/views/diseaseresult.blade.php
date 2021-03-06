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

        <p><a style="font-size: 200%;">Search disease by Gene name</a></p>
        <hr>
        <div class="col-md-12">
            <div style="padding: 80px; background-color: #F2F2F2;">
                <form class="layui-form" action="/searchdisease">
                    <div class="layui-form-item col-md-9">
                        <label class="layui-form-label">Search gene associated diseases</label>
                        <div class="layui-input-block">
                          <input type="text" name="gene" id="genename" lay-verify="name" autocomplete="off" value="{{$genename}}" placeholder="eg:AKT1" class="layui-input">
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <label class="layui-form-label" ><a style="color: #F2F2F2;">誓死捍卫加勒万河谷，致敬</a></label>
                        <div class="layui-input-block">
                          <button id="submitleft" class="layui-btn" type="submit">Search</button>
                        </div>
                        
                    </div>
                </form>
                <br>
                <br>
                <br>
                <a style="display: none;" name="tax" id="name" value="{{$genename }}">{{$genename}}</a>
                <table id="showdisease" lay-filter="test" style="margin-top: 4%;"></table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
  @include('partials.footer')
@endsection
@section('js')
<script src="{{ asset('/layui/dist/layui.js') }}" charset="utf-8"></script>
<script src="{{ asset('/PDFObject-master/pdfobject.js') }}" charset="utf-8"></script>
<script>
PDFObject.embed("/pdf/PCA_score_plot_all.pdf", "#pdf-viewer");
</script>
<script>
    layui.use(['element', 'layer','form','table'], function(){
        var element = layui.element;
        var layer = layui.layer;
        var table = layui.table;
        var name = document.getElementById("name").innerHTML;


        table.render({
            elem: '#showdisease'
            ,autoSort: true
            ,text: {
                none: 'no data avalible' //默认：无数据。
            }
            ,toolbar: '<div> </div>'
            ,defaultToolbar: ['filter', 'print', 'exports']
            ,url: '{{url('/diseasetable/f')}}'+ name//数据接口
            ,cols: [[ //表头
            {field: 'no', title: 'id', width: '20%', sort: true}
            ,{field: 'gene', title: 'Gene', width: '20%', sort: true}
            ,{field: 'disease', title: 'Disease', width: '60%', sort: true}
            ]]

        });


    });

</script>
<script>
    $(document).ready(function(){

        layui.use('form', function(){
          var form = layui.form; //只有执行了这一步，部分表单元素才会自动修饰成功
        });

    });

</script>
@endsection
