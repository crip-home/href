<!-- Left Side Of Navbar -->
<ul class="nav navbar-nav navbar-left">
  <li><a href="/">Home</a></li>
  <li><a href="http://www.crip.lv" target="_blank">CRIP</a></li>
</ul>

<!-- Right Side Of Navbar -->
<ul class="nav navbar-nav navbar-right">
  <!-- Authentication Links -->
  @if (Auth::guest())
    <li><a href="{{ url('/login') }}">Login</a></li>
    <li><a href="{{ url('/register') }}">Register</a></li>
  @else
    @if(Route::currentRouteName() === 'index')
      <li><a href="{{ route('admin') }}">Dashboard</a></li>
    @endif
    <li id="navbar"></li>
  @endif
</ul>