@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Dashboard
                    <a href="/posts/create" class="btn btn-primary float-right">Create post</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h3>Your blog posts</h3>
                        @if(count($posts)>0)
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            @foreach($posts as $post)
                            <tr>
                            <th>{{$post->title}}</th>
                            <th><a href="/posts/{{$post->id}}/edit" class="btn btn-secondary">Edit</a></th>
                            <th>
                                {!! Form::open(['action'=>['PostsController@destroy',$post->id],'class'=>'float-right']) !!}
                                {!! Form::hidden('_method', 'DELETE') !!}
                                {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
                                {!! Form::close() !!}
                            </th>

                            </tr>
                            @endforeach
                        </table>
                        @else
                        <h4>You don't have any posts yet!</h4>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
