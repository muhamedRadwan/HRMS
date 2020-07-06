@extends('layouts.app')

@role('admin|super.admin') 
  @push('nav-items')
    <li class="m-2 nav-item">
      <a class="btn btn-outline-success my-2 my-sm-0" href="{{ route('posts.index') }}">{{ __('master.posts') }}</a>
    </li>
    <li class="m-2 nav-item">
      <a class="btn btn-outline-primary my-2 my-sm-0" href="{{ route('posts.edit', $post->id) }}">{{ __('master.edit') }}</a>
    </li>
  @endpush
@endrole
@section('content')

   <!-- Page Content -->
   <div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4">{{$post->title}}</h1>

        {{-- <!-- Author -->
        <p class="lead">
          by
          <a href="#">Start Bootstrap</a>
        </p> --}}

        <hr>

        <!-- Date/Time -->
        <p>{{$post->created_at->diffForHumans()}}</p>

        <hr>

        <!-- Preview Image -->
      <img class="img-fluid rounded" src="{{asset('storage/'.$post->image)}}" alt="">

        <hr>
        {!! $post->body !!}
        <!-- Post Content -->
        
        <hr>
      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        {{-- <!-- Search Widget -->
        <div class="card my-4">
          <h5 class="card-header">Search</h5>
          <div class="card-body">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-append">
                <button class="btn btn-secondary" type="button">Go!</button>
              </span>
            </div>
          </div>
        </div> --}}

        <!-- Categories Widget -->
        <div class="card my-4">
          <h5 class="card-header">@lang("master.latestnews")</h5>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                  @php
                    $len = count($posts);
                    $firsthalf = array_slice($posts, 0, $len / 2);
                    $secondhalf = array_slice($posts, $len / 2); 
                  @endphp
                  @foreach ($firsthalf as $post)
                    <li>
                      <a href="{{route('posts.show', $post["id"])}}">{{$post["title"]}}</a>
                    </li>
                  @endforeach
                </ul>
              </div>
              <div class="col-lg-6">
                <ul class="list-unstyled mb-0">
                  @foreach ($secondhalf as $post)
                    <li>
                      <a href="{{route('posts.show', $post["id"])}}">{{$post["title"]}}</a>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

@endsection


@section('javascript')

@endsection