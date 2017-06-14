@extends('layouts.master')

@section('content')
  <div class="container">
    <div id="app">
      Initializing application...
    </div>
  </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/app.js') }}"></script>
<script src="{{ asset('assets/navbar.js') }}"></script>
@endpush

@push('meta')
<meta name="api-url" content="{{ config('app.url') }}/api">
<meta name="user-token" content="{{ JWTAuth::fromUser(Auth::user()) }}">
@endpush
