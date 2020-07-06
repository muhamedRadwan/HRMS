@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <h1 class="my-4">{{__("master.news")}}
            </h1>

            @foreach ($posts as $post)
                <!-- Blog Post -->
                <div class="card mb-4">
                    <img class="card-img-top" src="{{asset('storage/'.$post->image)}}" alt="Card image cap">
                    <div class="card-body">
                        <h2 class="card-title">{{$post->title}}</h2>
                        <a href="{{route("post-view", $post->id)}}" class="btn btn-primary">@lang("master.read_more") &rarr;</a>
                    </div>
                    <div class="card-footer text-muted">
                        {{$post->created_at->diffForHumans()}}
                    </div>
                </div>
            @endforeach
            

            <!-- Pagination -->
            {{ $posts->links() }}
        </div>

        <div class="col-md-4">
            <!-- Search Widget -->
            {{-- <div class="card my-4">
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
                        $len = count($latestposts);
                        $firsthalf = array_slice($latestposts, 0, $len / 2);
                        $secondhalf = array_slice($latestposts, $len / 2); 
                        @endphp
                        @foreach ($firsthalf as $post)
                        <li>
                            <a href="{{route('post-view', $post["id"])}}">{{$post["title"]}}</a>
                        </li>
                        @endforeach
                    </ul>
                    </div>
                    <div class="col-lg-6">
                    <ul class="list-unstyled mb-0">
                        @foreach ($secondhalf as $post)
                        <li>
                            <a href="{{route('post-view', $post["id"])}}">{{$post["title"]}}</a>
                        </li>
                        @endforeach
                    </ul>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
