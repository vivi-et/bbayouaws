@extends('layouts.master')
@push('header')

<link href="/css/summernote.css" rel="stylesheet">
<script src="/js/summernote.js"></script>
<script src="/js/lang/summernote-ko-KR.min.js"></script>


@endpush
@section('content')
<h3>
{{ $board->board_korname }}
</h3>
<hr>
<br>


<form method="POST" action="/post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <input name="title" id="title" type="text" class="form-control" placeholder="제목" required>
    </div>
    
    <div class="form-group">
        <textarea name="body" id="body" class="summernote" required hidden></textarea>
    </div>

    <input type="hidden" id="board" name="board" value={{ $board->id }}>
    <div class="form-group">
        <button type="submit" id="submitbtn" class="btn btn-primary">Submit</button>
    </div>
</form>



@endsection

@push('script')
<script type="text/javascript">
    $(document).ready(function() {
           $('.summernote').summernote({
            lang: "ko-KR",
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


