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
                <h1>Mission</h1>
                    <p>What this website will do. what this website will do what this website will do what this website will do what this website will do what this website will do what this website will do what this website will do what this website will do what this website will do what this website will do what this website will do what this website will do what this website will do what this website will do what this website will do.</p>
                    <a href="/upload" style="color: white;font-size: 180%;">>>>click here to start<<<</a>
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




@endsection
