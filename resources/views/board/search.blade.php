@extends('layouts.master')

@push('header')
<script src="https://cdnjs.cloudflare.com/ajax/libs/mark.js/8.11.1/jquery.mark.es6.min.js"></script>


@endpush
@section('content')

<br>

<H3> {{ $board->board_korname }}</H3>
<br>
<br>
@if(count($posts))
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


        @foreach ($posts as $post)
        <tr>
            <th scope="row">{{ $post->id }}</th>


            <td><a href="/post/{{ $post->id }}">
                    <div class="searchhere">{{ $post->title }}</div>
                </a></td>
            <td>
                <div class="searchhere">{{ $post->user->name }}</div>
            </td>

            <td>{{ $post->created_at->diffforhumans()}}</td>
            <td>{{ $post->views }}</td>
            <td>{{ $post->ups }}</td>
        </tr>

        @endforeach
        @else
        <div style="text-align: center;">
            검색 결과가 없습니다.
        </div>
        @endif



    </tbody>
</table>

{{ $posts->links() }}

@endsection


@push('script')
<script>
    // let str = "<?php echo $value ?>"

    // console.log(str);

    // let replace = str;
    // let re = new RegExp(replace, "g");


    // var t = $(".searchhere").html();
    // t = t.replace(re, "<mark>$&</mark>");
    // $(".searchhere").html(t);

</script>

<script>
    let str = "<?php echo $value ?>"
    var context = document.querySelectorAll(".searchhere");
var instance = new Mark(context);
instance.mark(str);
</script>

@push('style')
<style>
    mark {
        background: orange;
        color: black;
        opacity: 0.5;
    }
</style>

@endpush

@endpush