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
        <p>Upload your data / Set Parameters / <a style="font-size: 200%;">Show the statistical results</a></p>
        <hr>
        <div style="padding: 20px; background-color: #F2F2F2;">
            <div class="layui-row layui-col-space15">

              <div class="layui-col-md12">
                <div class="layui-card">
                  <div class="layui-card-header">{{$omics1}} and {{$omics2}} Correlation analysis result, click the brick for more details</div>
                  <div class="layui-card-body">
                    <div class="row text-center" style="width: {{ $bgwidth }}px;height: {{ $bgheigh }}px; background-image: url({{ asset($image) }}); ">
                        {!! $diyihangkongbai !!}
                        @for ($i = 0; $i < $k2; $i++)
                            <img style="width: {{ $kongbai[0] }}px;height: {{ $lie[$i] }}px;opacity: 88%; margin-bottom: {{ $hengjiange }}px;margin-left: -3px;" src="{{ asset('images/gg.png') }}" />
                            @for ($j = 0; $j < $g; $j++)
                                <a href="{{ url('result/enrich/')}}/{{$j}}--{{$i}}--{{$enrichpath}}--{{$omics1}}--{{$omics2}}" target="_blank"><img style="width: {{ $hang[$j] }}px;height: {{ $lie[$i] }}px;opacity: 50%; margin-bottom: {{ $hengjiange }}px;margin-left: {{ $shujiange }}px;" src="{{ asset('images/gg.png') }}" onmousemove="toumingImg(this)" onmouseout="normalImg(this)" /></a>
                            @endfor
                            <img style="width: {{ $kongbai2 }}px;height: {{ $lie[$i] }}px;opacity: 88%; margin-bottom: {{ $hengjiange }}px;" src="{{ asset('images/gg.png') }}" />
                        @endfor
                    </div>
                  </div>
                </div>
              </div>
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

<script type="text/javascript">
function toumingImg(x)
{
    x.style.opacity="1%";
};

function normalImg(x)
{
    x.style.opacity="50%";
};
</script>
<script>
    $(document).ready(function(){
        function toumingImg(x)
        {
            x.style.opacity="1%";
        }

        function normalImg(x)
        {
            x.style.opacity="50%";
        }
    });
</script>
@endsection
