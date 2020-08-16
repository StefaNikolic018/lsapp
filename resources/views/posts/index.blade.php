@extends('layouts.app')

@section('content')

<h1>Posts</h1>
<br>
@if(!empty($posts))
    @foreach($posts as $post)
        <div class="well-lg">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                <img src="/storage/cover_images/{{$post->cover_image}}" alt="Image" width="100%" class="img-fluid">
                </div>
                <div class="col-md-8 col-sm-8">
                    <h3> <a href="/posts/{{$post->id}}">{{$post->title}}</a> </h3>
                    <small>Napisan: {{$post->created_at}} By: {{$post->user->name}}</small>
                </div>
            </div>
        </div>
        <br>
    @endforeach
    {{$posts->links()}}
@else
        <p>Nema postova</p>
@endif

@endsection
