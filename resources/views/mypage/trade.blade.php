<?php use App\Giftcon;?>
<?php use App\GiftconTradePost;?>
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
            <th scope="col">글쓴이</th>
            <th scope="col">작성일</th>
            <th scope="col">상태</th>
            {{-- <th scope="col">추천</th> --}}
        </tr>
    </thead>
    <tbody>

        @foreach ($posts as $post)
        <tr>
            <th scope="row">{{ $post->id }}</th>

            <td><a href="/giftcon/trade/{{ $post->id }}">{{ Giftcon::find($post->giftcon_id)->title}} @if(count($post->comments)) [{{ count($post->comments) }}] @endif</a></td>
            <td>{{ $post->user->name }}</td>
            <td>{{ $post->created_at->diffforhumans()}}</td>
            <td><?php $status = $post->traded;

                switch ($status) {
                    case 0;
                        $status = '거래중';
                        break;
                    case 1;
                        $status = '거래완료';
                        break;
                    case 2;
                        $status = '미기재';
                        break;
                } echo $status ?></td>
            {{-- <td>{{ $post->ups }}</td> --}}
        </tr>

        @endforeach




    </tbody>
</table>
@else
<div style="text-align:center;">
    <h5>현재 작성한 거래글이 없습니다.</h5>
    <br>
    <br>
    <br>
</div>
@endif

<div style="text-align: center;">
    내 기프티콘 거래댓글
</div>
<br>

@if(count($comments))

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">제목</th>
            {{-- <th scope="col">글쓴이</th> --}}
            <th scope="col">작성일</th>
            <th scope="col">상태</th>
            {{-- <th scope="col">추천</th> --}}
        </tr>
    </thead>
    <tbody>

        @foreach ($comments as $comment)
        <tr>
            <th scope="row">{{ $comment->id }}</th>

            <td>
                <?php
                    $giftcontradepost = GiftconTradePost::find($comment->giftcon_trade_post_id);
                    $title = Giftcon::find($giftcontradepost->giftcon_id)->title;
            
                    ?>
                <a href="/giftcon/trade/{{ $giftcontradepost->id }}">
                    {{ $title }} [{{ count($giftcontradepost->comments) }}]
                </a>
            </td>
            {{-- <td>{{ $comment->user->name }}</td> --}}
            <td>{{ $comment->created_at->diffforhumans()}}</td>
            <td><?php $status = $comment->traded;

                switch ($status) {
                    case 0;
                        $status = '거래중';
                        break;
                    case 1;
                        $status = '거래완료';
                        break;
                    case 2;
                        $status = '미기재';
                        break;
                } echo $status ?></td>
            {{-- <td>{{ $post->ups }}</td> --}}
        </tr>

        @endforeach




    </tbody>
</table>

@else
<div style="text-align:center;">
    <h5>현재 작성한 거래댓글이 없습니다.</h5>
    <br>
    <br>
    <br>
</div>

@endif

@endsection