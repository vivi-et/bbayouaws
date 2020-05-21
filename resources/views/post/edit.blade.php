@extends('layouts.master')
@push('header')

<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script src="/js/summernote-ko-KR.js"></script>
@endpush
@section('content')

<h1>
    Edit Post
</h1>




<form method="POST" action="/post/{{ $post->id }}" enctype="multipart/form-data">
    @csrf
     @method('PUT') 
    <div class=" form-group">
    <input input name="title" id="title" type="text" class="form-control" value="{{$post->title}}" required>
    </div>

    <div class="form-group">
        <textarea name="body" id="body" class="summernote" required>{{$post->body}}</textarea>
    </div>


    <div class="form-group">
        <button type="submit" style="float: right;" class="btn btn-primary">Submit</button>
    </div>
</form>

@include('layouts.error')


@endsection



@push('script')
<script type="text/javascript">
    $(document).ready(function() {
           $('.summernote').summernote({
            lang: 'ko-KR', // default: 'en-US'
            height: 600,
            dialogsInBody: true,
            callbacks:{
                onInit:function(){
                $('body > .note-popover').hide();
                }
             },
         });
      });
</script>
@endpush
