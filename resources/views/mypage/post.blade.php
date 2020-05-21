<?php use App\Board;?>
<?php use App\Post;?>
@extends('layouts.master')

@section('content')

<div style="text-align: center;">
    내 기프티콘 거래글

</div>
<br>
@if(count($posts))

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">제목</th>
            <th scope="col">게시판</th>
            <th scope="col">작성일</th>
            <th scope="col">조회</th>
            <th scope="col">추천</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($posts as $post)
        <tr>
            <th scope="row">{{ $post->id }}</th>

            <td><a href="/post/{{ $post->id }}">{{ $post->title }} @if(count($post->comments))
                    [{{ count($post->comments) }}] @endif </a></td>
            <td>{{ Board::find($post->board_id)->board_korname }}</td>
            <td>{{ $post->created_at->diffforhumans()}}</td>
            <td>{{ $post->views }}</td>
            <td>{{ $post->ups }}</td>
        </tr>

        @endforeach




    </tbody>
</table>

@else
<div style="text-align:center;">
    <h5>현재 작성한 글이 없습니다.</h5>
    <br>
    <br>
    <br>
</div>
@endif
<br>
<br>
<br>
<div style="text-align: center;">
    내 기프티콘 거래댓글
</div>
<br>

@if(count($comments))
<div style="width:100%;">
    <table class="table table-hover" style="width: 50%;">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">글</th>
                <th scope="col">댓글내용</th>
                <th scope="col">작성일</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($comments as $comment)
            <tr>
                <th scope="row">{{ $comment->id }}</th>
                
                    <td scope="row"><a href="/post/{{ $comment->post_id }}">{{ $comment->post->title }}</a></td>
                    <td>{{ $comment->body }} </td>
             
                <td>{{ $comment->created_at }}</td>
            </tr>

            @endforeach




        </tbody>
    </table>
</div>
@else
<div style="text-align:center;">
    <h5>현재 작성한 글이 없습니다.</h5>
    <br>
    <br>
    <br>
</div>
@endif

@endsection