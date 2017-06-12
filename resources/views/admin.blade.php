@extends('layouts.master')

@section('content')
  <div class="container">
    <div id="app">
      Initializing application...
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('assets/vendor.js') }}"></script>
  <script src="{{ asset('assets/app.js') }}"></script>
@endpush
