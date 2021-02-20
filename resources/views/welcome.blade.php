@extends('layouts.app')
@section('css')

@endsection

@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>

<link rel='stylesheet' id='hca-stylesheet-css'  href="{{ asset('/css/global.css') }}" type='text/css' media='all' />

</head>

  <div class="site-content">
        <div style="padding: 20px; background-color: #F2F2F2;">
                      <div class="layui-row layui-col-space15">
                        <div class="layui-col-md6">
                          <div class="layui-card">
                            <div class="layui-card-header">single omics analysis</div>
                            <div class="layui-card-body">
                              something introduce single omics analysis<br>
                              <a href="/single" style="color: deepskyblue;font-size: 180%;">>>>click here to start<<<</a>
                            </div>
                          </div>
                        </div>
                        <div class="layui-col-md6">
                          <div class="layui-card">
                            <div class="layui-card-header">intro omics analysis</div>
                            <div class="layui-card-body">
                              something introduce single omics analysis<br>
                              <a href="/intro" style="color: deepskyblue;font-size: 180%;">>>>click here to start<<<</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

        <section class="headintro">
            <div class="splitback">
                <div class="main">
                    <div class="img"></div>
                    <span class="over"><img src="{{ asset('images/welcome/bg.png') }}" style="height:120%"></span>
                    <br><a href="#two">&#8595;&#8595;&#8595;</a><br>
                </div>
                <div class="second"></div>
            </div>
            <div class="content-fp">
                <span class="vcenr"></span>
                <div class="vcenc">
                    <div class="col-md-12">
                    <div style="padding: 20px; background-color: #F2F2F2;">
                      <div class="layui-row layui-col-space15">
                        <div class="layui-col-md6">
                          <div class="layui-card">
                            <div class="layui-card-header">single omics analysis</div>
                            <div class="layui-card-body">
                              something introduce single omics analysis<br>
                              <a href="/single" style="color: deepskyblue;font-size: 180%;">>>>click here to start<<<</a>
                            </div>
                          </div>
                        </div>
                        <div class="layui-col-md6">
                          <div class="layui-card">
                            <div class="layui-card-header">intro omics analysis</div>
                            <div class="layui-card-body">
                              something introduce single omics analysis<br>
                              <a href="/intro" style="color: deepskyblue;font-size: 180%;">>>>click here to start<<<</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </div> 
                </div>
            </div>
        </section>

        <div class="container">
        <div class="grid-wrapper">
            <div class="grid-item-6">
            <blockquote class="fp-offset">
                <div class="quote">
                    <p>The most important this about this website. the most important this about this website. the most important this about this website. the most important this about this website. </p>
                </div>
            </blockquote>
        </div>
        <div class="grid-item-6">
            <h1>ABOUT LINT </h1>
            <div id="intro" class="intro">
                <p class="p1">something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. </p>
                <p class="p1">something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. something about this website. </p>

            </div>
        </div>
        </div>
        </div>

</html>
@endsection

@section('footer')
  @include('partials.footer')
@endsection
@section('js')
<script src="{{ asset('/layui/dist/layui.js') }}" charset="utf-8"></script>
<script>
layui.use(['element', 'layer'], function(){
  var element = layui.element;
  var layer = layui.layer;
  
  //监听折叠
  element.on('collapse(test)', function(data){
    layer.msg('展开状态：'+ data.show);
  });
});
</script>



@endsection
