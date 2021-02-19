@extends('layouts.app')
@section('css')
.panel{margin-bottom:40px;background-color:#fff;border:1px solid transparent;border-radius:4px;-webkit-box-shadow:0 1px 1px rgba(0,0,0,.05);box-shadow:0 1px 1px rgba(0,0,0,.05)}
.panel-info{border-color:#bce8f1}
.panel-heading{padding:15px 15px;border-bottom:1px solid transparent;border-top-left-radius:3px;border-top-right-radius:3px;color:#333;background-color:#d9edf7;border-color:#ddd}
.panel-body{padding:15px}


@endsection
@section('navbar')
  @include('partials.navbar')
@endsection
@section('content')
<div class="container content" style="margin-top: 40px;">
    <div class="row" style="width: 100%">
        <div class="panel panel-info regionbox" style="width: 100%">
            <div class="panel-heading"><h4>ABOUT LINT</h4></div>
          <div class="panel-body">
        <p style="font-size: 110%">something about your lab.something about your lab.something about your lab.something about your lab.something about your lab.something about your lab.something about your lab.something about your lab.</p>
          </div>
        </div><br>
        <div class="panel panel-info regionbox" style="width: 100%">
            <div class="panel-heading"><h4>CONTACT US</h4></div>
          <div class="panel-body">
        <p style="font-size: 110%">This project welcomes all questions and comments regarding the microbiome.</p>
        <p style="font-size: 110%">Please, send your questions, comments or suggestions to: <a href="mailto:lintwebomic_service@outlook.com" style="color: deepskyblue">lintwebomic_service@outlook.com</a>.</p>
          </div>
        </div><br>
        <div class="panel panel-info regionbox" style="width: 100%">
        <div class="panel-heading"><h4>Privacy</h4></div>
          <div class="panel-body">
        <p >Thank you for visiting this website. This dose not gather personal information about users. Information automatically collected in server log files, such as pages visited, will solely be used to improve the usefulness of the website, and not for any commercial purposes.</p>
          </div>
        </div>

    </div>
</div>
@endsection

@section('footer')
  @include('layouts.footer')
@endsection
@section('js')
@endsection
