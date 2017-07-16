@extends('layouts.master')

@section('content')
  <div class="container">
    <div class="row">

      <div class="col-sm-8 col-sm-offset-2">
        <div class="panel panel-primary">
          <div class="panel-heading">About CRIP hrefs</div>
          <div class="panel-body bookmark-panel">
            <p>
              Hrefs is site to post interesting stuff of web for web.
            </p>
            <p>
              You may <a href="https://goo.gl/W89ebh" target="_blank">download
                extension for browser</a> to publish stuff directly from browser
              bookmarks.
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection

@push('scripts')
<script src="{{ asset('assets/navbar.js') }}"></script>
@endpush