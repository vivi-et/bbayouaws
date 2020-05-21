@extends('layouts.master')

@section('content')

<style>
    .editablediv {
        width: 600px;
    }
</style>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

</head>

<br>
<div class="col-sm-8 blog-main">
    <h2 class="blog-post-title" style="word-wrap: break-word;">{{$post->title}}</h2>
    <br>
    <p class="blog-post-meta"> {{ $post -> created_at->toFormattedDateString() }} <a
            href="#">{{ $post->user->name }}</a></p>
    <br>



    <br>
    <br>
    {!! $post->body !!}






    @if(!empty(auth()->user()))
    @if(auth()->user()->id == $post->user_id)
    <hr>
    <br>
    <hr>
    <br>
    <div>
        <div class="btn-group" style="float:right;">
            <a href="/post/{{$post->id}}/edit">
                <button class="btn btn-primary">수정</button>
            </a>

            <form method="POST" action="/post/{{$post->id}}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" style="margin-left:5px;"
                    onclick="return confirm('정말 삭제하시겠습니까?')">삭제</button>
            </form>
        </div>
    </div>
    @endif
    <br style="clear:both;">
    <hr>
    @endif

    @if(count($post->comments))
    <div class="comments">
        @foreach ($post->comments as $comment)
        <li class="list-group-item">
            @if(Auth::check())
            @if(auth()->user()->id == $comment->user_id)
            <strong style="float: left;">{{ $comment->user->name }}</strong>
            <div style="float: left; margin-left:10px;">{{ $comment->created_at->diffforhumans() }}</div>
            <div style="clear: both;"></div>
            <form id="editform" action="/comment/{{ $comment->id }}" method="POST" style="display: none;">
                @csrf
                @method('PATCH')
                <input name="body" style="width: 100%; height:100px; margin-top:5px;" value="{{ $comment->body }}">
                <button type="submit" class="btn" id="commenteditsubmitbtn" style="float: right">수정하기</button>
                <button type="button" class="btn" onclick="toggleEditForm()" id="commenteditcancelbtn"
                    style="float: right">취소</button>
                <div style="clear: both;"></div>
            </form>
            <div id="editdiv" style="width:100%; margin-top:5px; display:block">{{ $comment->body }}</div>
            <div id="commentbuttons" class="buttons" style="float: right">
                <button id="toggleEditFormbtn" onclick="toggleEditForm()" class="btn">수정</button>

                <form action="/comment/{{ $comment->id }}" method="post" style="float: right">
                    <input type="text" value="{{ $comment->id }}" hidden>
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('정말 삭제하시겠습니까?')" id="commentdeletebtn"
                        class="btn">X</button>
                </form>
            </div>
            @endif
            @endif
            <div style="clear: both;"></div>

        </li>
        @endforeach
    </div>
    @endif


    <br>

    {{-- add a comment --}}

    @if(Auth::check())
    <div>
        <div>
            <form method="POST" action="/comment/make/{{ $post->id }}">
                @csrf
                @method('POST')

                <div class="form-group">
                    <textarea name="body" placeholder="Comment" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            @include('layouts.error')
        </div>
    </div>
    @endif
    {{-- 추후 게시판 테이블 넣을것 --}}
    <br>
    <hr>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">제목</th>
                <th scope="col">글쓴이</th>
                <th scope="col">작성일</th>
                <th scope="col">조회</th>
                <th scope="col">추천</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($boardposts as $boardpost)
            <tr>
                <th scope="row">{{ $boardpost->id }}</th>

                <td><a href="/post/{{ $boardpost->id }}">{{ $boardpost->title }} </a></td>
                <td>{{ $boardpost->user->name }}</td>
                <td>{{ $boardpost->created_at->diffforhumans()}}</td>
                <td>{{ $boardpost->views }}</td>
                <td>{{ $boardpost->ups }}</td>
            </tr>

            @endforeach




        </tbody>
    </table>
    {{ $boardposts->links() }}
    <hr>

    @endsection

    @push('script')

    <script>
        function toggleEditForm() {
  let editform = document.getElementById("editform");
  let editdiv = document.getElementById("editdiv");
  let commentbuttons = document.getElementById("commentbuttons");
  if (editform.style.display === "none") {
    editform.style.display = "block";
    editdiv.style.display = "none";
    commentbuttons.style.display = "none";
  } else {
    editform.style.display = "none";
    editdiv.style.display = "block";
    commentbuttons.style.display = "block";
  }






}
    </script>




    @endpush

    @push('style')
    <style>
        #commentdeletebtn:hover {
            background-color: red;
        }

        #toggleEditFormbtn:hover {
            background-color: khaki;

        }

        #commenteditsubmitbtn:hover {
            background-color: khaki;

        }

        #commenteditcancelbtn:hover {
            background-color: red;

        }
    </style>
    @endpush


    {{-- 
    <style>
        .center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            /* width: 50%; */
        }
    </style> --}}