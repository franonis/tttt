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
                  <div class="layui-card-header">Correlation analysis result</div>
                  <div class="layui-card-body">
                    <div class="row text-center" style="width: {{ $bgwidth }}px;height: {{ $bgheigh }}px; background-image: url({{ asset($image) }}); ">
                        <img style="width: {{ $bgwidth }}px;height: {{ $kongbai[1] }}px;opacity: 100%; margin-bottom: 1%;" src="{{ asset('images/gg.png') }}" onmousemove="toumingImg(this)" onmouseout="normalImg(this)" />
                        @for ($i = 0; $i < $k2; $i++)
                            @for ($j = 0; $j < $k1; $j++)
                                <a href="{{ url('result/enrich/')}}/{{$j}}--{{$i}}--{{$enrichpath}}--{{$omics1}}--{{$omics2}}" target="_blank"><img style="width: {{ $hang[$j] }}px;height: {{ $lie[$i] }}px;opacity: 100%; margin-bottom: 1%;" src="{{ asset('images/gg.png') }}" onmousemove="toumingImg(this)" onmouseout="normalImg(this)" /></a>
                            @endfor
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
    x.style.opacity="100%";
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
            x.style.opacity="100%";
        }
    });
</script>
@endsection
