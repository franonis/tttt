@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/layui/dist/css/layui.css') }}"  media="all">
.description{
    position: relative;
    margin: 0 auto;
    padding: 1em;
    max-width: 23em;
    background: hsla(0,0%,100%,.25) border-box;
    overflow: hidden;
    border-radius: .3em;
    box-shadow: 0 0 0 1px hsla(0,0%,100%,.3) inset,
                0 .5em 1em rgba(0, 0, 0, 0.6);
    text-shadow: 0 1px 1px hsla(0,0%,100%,.3);
}


.description::before{
    content: '';
    position: absolute;
    top: 0; rightright: 0; bottombottom: 0; left: 0;
    margin: -30px;
    z-index: -1;
    -webkit-filter: blur(20px);
    filter: blur(20px);
}

@endsection

@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container-fluid">
    <div class="carousel-inner">
        <div class="carousel-item active}}" style="margin-top: 10%;margin-bottom: 10%;background-image: url({{ asset('images/lion.png') }});background-repeat: no-repeat; background-size: 100%;background-position: center;">
            <div class="row" style="background-color: rgba(251, 225, 225, 0.7);">
                @for ($i = 1; $i < $k2; $i++)
                    @for ($j = 1; $j < $k1; $j++)
                    <div style="width: {{ $miniwidth }};height: {{ $miniheigh }}">
                        <a class="descriation">{{ $i }}-{{ $j }}</a>
                        <td style="position:relative;">
                            <img style="position:absolute; z-index:1;" width="150" height="200" src="{{ asset('images/gg.png') }}" />
                            <img style="position:absolute; top:60px; left:30px; z-index:2" width="95" height="125" src="{{ asset('images/lion.png') }}" />
                        </td>
                    </div>
                    @endfor
                @endfor
            </div>
            <p class="description">llladkdhfenbr</p>
        </div>
    </div>
</div>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
<script type="text/javascript">
function bigImg(x)
{
    x.style.height="10%";
    x.style.width="10%";
}

function normalImg(x)
{
    x.style.height="20%";
    x.style.width="20%";
}
</script>



@endsection
