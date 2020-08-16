@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-3"></div>
    <div class="col-6">
<div class="card rounded text-center bg-secondary text-light">
    <div class="card-header">
        <h3>{{$post->title}}</h3>
    </div>
<div class="card-body bg-light text-secondary">
    {{-- OVO JE SINTAKSA KOJA OMOGUCAVA PROSLEDJIVANJE HTML ELEMENATA --}}
    <img src="/storage/cover_images/{{$post->cover_image}}" alt="Image" width="100%" class="img-fluid">
    <hr>
    <h4>{!!$post->body!!}</h4>
</div>
<div class="card-footer">
    <small>Napisan: {{$post->created_at}} By: {{$post->user->name}}</small>
</div>
</div>
<br>
@if(!Auth::guest())
    @if(Auth::user()->id==$post->user_id)
<a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit post</a>
{!! Form::open(['action'=>['PostsController@destroy',$post->id],'class'=>'float-right']) !!}
{!! Form::hidden('_method', 'DELETE') !!}
{!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
{!! Form::close() !!}
    @endif
@endif
    </div>
    <div class="col-3"></div>

</div>


@endsection
