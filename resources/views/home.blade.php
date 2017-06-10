@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row">

      <div class="col-sm-8">
        <div class="panel panel-default">
          <div class="panel-heading">People shared hrefs</div>
          <div class="panel-body bookmark-panel">

            @foreach($days as $day => $hrefs)

              <h3>{{$day}}</h3>

              @foreach($hrefs as $href)

                <p>
                  <a href="{{$href->url}}" 
                     target="_blank"
                     title="{{$href->url}}"
                  >{{ $href->title ? $href->title : $href->url }}</a>

                  @include('partials.user-filter', [
                    'user' => $href->creator,
                    'filters' => $filters
                  ])
                  {{--!! Form::filter($href->user, 'name', $filters, 'a', 'label label-success') !!--}}
                  {{--!! Form::filter($href->category, 'title', $filters, 'c', 'label label-default') !!--}}

                  @foreach($href->tags as $tag)
                    {{--!! Form::filter($tag, 'tag', $filters, 't') !!--}}
                  @endforeach
                </p>

              @endforeach

            @endforeach

            <br>
            <div class="text-center">
              {{ $paging->links() }}
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-4">

        <div class="panel panel-default">
          <div class="panel-heading">Authors</div>
          <div class="panel-body">
            @foreach($authors as $author)
              {{--!! Form::filter($author, 'name', $filters, 'a', 'label label-success') !!--}}
            @endforeach
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">Categories</div>
          <div class="panel-body">
            @foreach($categories as $category)
              {{--!! Form::filter($category, 'title', $filters, 'c', 'label label-default') !!--}}
            @endforeach
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">Tags</div>
          <div class="panel-body">
            @foreach($tags as $tag)
              {{--!! Form::filter($tag, 'tag', $filters, 't') !!--}}
            @endforeach
          </div>
        </div>

      </div>

    </div>
</div>
@endsection