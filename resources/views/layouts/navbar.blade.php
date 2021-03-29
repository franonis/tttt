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
      <a class="navbar-brand" href="{{ url('/') }}"><strong> AS Finder</strong></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
        <li class="{{ Request::path()=='/' ? 'active':'' }}">
          <a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;&nbsp;Home</a>
        </li>

        <li class="dropdown{{ (preg_match('/upload/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('upload') }}">AS Detection </a>
        </li>
        <li class="dropdown{{ (preg_match('/cross/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('cross') }}">Model training</a>
        </li>
        <li id="statistics" class="dropdown {{ ( preg_match('/statistics/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('statistics') }}">AS Classification  </a>
        </li>
        <li id="help" class="dropdown {{ ( preg_match('/help/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('help') }}">Help </a>
        </li>
        <li id="help" class="dropdown {{ ( preg_match('/help/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('help') }}">Download </a>
        </li>
        <li id="faq" class="dropdown {{ ( preg_match('/faq/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('faq') }}">FAQ </a>
        </li>
        <li id="about" class="dropdown{{ ( preg_match('/about/', Request::path()) ) ? ' active':'' }}">
          <a href="{{ url('about') }}">About</a>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
