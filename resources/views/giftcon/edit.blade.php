@extends('layouts.master')

@section('content')

<h1>
    Edit Post
</h1>

<form method="POST" action="/post/{{ $post->id }}" enctype="multipart/form-data">
    @csrf
     @method('PUT') 
    <div class=" form-group">
    <label for="exampleInputEmail1">Title</label>
    <textarea type="text" class="form-control" name="title">{{$post->title}}</textarea>
    </div>

    <div class="form-group">
        <label for="exampleInputPassword1">Body</label>
        <textarea name="body" id="body" cols="30" rows="10" class="form-control">{{$post->body}}</textarea>
    </div>

    <div class="form-group">
        <label for="exampleInputFile">File input</label>
        <input type="file" id="exampleInputFile" name='cover_image'>
        <p class="help-block">Example block-level help text here.</p>
    </div>

    {{-- <div class="checkbox">
        <label>
            <input type="checkbox"> Check me out
        </label>
    </div> --}}

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>

@include('layouts.error')


@endsection