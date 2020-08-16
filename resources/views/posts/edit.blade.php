@extends('layouts.app')

@section('content')

<h1>Edit post</h1>
<br>

    {!! Form::open(['action'=> ['PostsController@update',$post->id], 'files'=>true, 'enctype'=>'multipart/form-data' ]) !!}
    <div class="form-group">
        {!! Form::label('title', 'Title') !!}
        {!! Form::text('title', $post->title, ['class'=>'form-control', 'placeholder'=>'Title of the post']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('body', 'Body') !!}
        {!! Form::textarea('body', $post->body, ['id'=>'editor', 'class'=>'form-control']) !!}
    </div>
    {{-- Skripta za CKEDITOR --}}
        <script>
                        ClassicEditor
                                .create( document.querySelector( '#editor' ) )
                                .then( editor => {
                                        console.log( editor );
                                } )
                                .catch( error => {
                                        console.error( error );
                                } );
        </script>
        <br>
        <div class="form-group">
        {!! Form::file('cover_image') !!}
        </div>
    {!! Form::hidden('_method', 'PUT') !!}
    {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
    {!! Form::close() !!}

@endsection
