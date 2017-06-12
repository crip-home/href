<!-- Right Side Of Navbar -->
<ul class="nav navbar-nav navbar-right">
  <!-- Authentication Links -->
  @if (Auth::guest())
    <li><a href="{{ url('/login') }}">Login</a></li>
    <li><a href="{{ url('/register') }}">Register</a></li>
  @else
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        {{ Auth::user()->name }} <span class="caret"></span>
      </a>

      <ul class="dropdown-menu" role="menu">
        <li>
          <a href="{{ route('admin') }}">Dashboard</a>
        </li>
        <li>
          <a href="{{ route('logout') }}"
             onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();"
          >
            Logout
          </a>

          <form id="logout-form"
                action="{{ route('logout') }}"
                method="POST">
            {{ csrf_field() }}
          </form>
        </li>
      </ul>
    </li>
  @endif
</ul>