  <!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ url('/') }}"><strong> LINT</strong></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="dropdown{{ (preg_match('/single/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('single') }}">Single Omic Dataset Analysis</a>
        </li>
        <li class="dropdown{{ (preg_match('/intra/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('intra') }}">Intra-omic Dataset Analysis</a>
        </li>
        <li id="disease" class="dropdown {{ ( preg_match('/disease/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('disease') }}">Search Disease </a>
        </li>
        <li id="about" class="dropdown{{ ( preg_match('/about/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('about') }}">About</a>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
