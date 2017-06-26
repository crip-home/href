<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Application configurations -->
  @stack('meta')

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Styles -->
  <link href="{{ asset('assets/styles.css') }}" rel="stylesheet">

  @stack('styles')

</head>
<body>
<div>
  <nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand" href="{{ url('/') }}">
          <span><img src="/images/crip_logo.png" alt="Crip logo"/></span>
        </a>
      </div>

      <div class="navbar-collapse" id="app-navbar-collapse">
        @include('layouts.nav')
      </div>
    </div>
  </nav>

  @yield('content')

</div>

<!-- Scripts -->
<script src="{{ asset('assets/vendor.js') }}"></script>

@stack('scripts')

</body>
</html>