@extends('layouts.master')


@section('content')
 


<section class="jumbotron text-center">
    <div class="container">
        <h2>BBAYOU</h2>
        <h1>뭐</h1>
        <p class="lead text-muted">디자인 구진거 안다</p>
    </div>
</section>

<div style="text-align: center">
    <h3>최근 게시물들</h3>
</div>
<br>
<div class="row">
    <br>
    @foreach ($boards as $board)


    @if(count($board->posts))
    <div class="col" style="outline: 1px solid black; margin-right:18px;">
        <br>
        {{ $board->board_korname }}
        <br>
        <br>
        <ul class="list-group">
            @foreach ($board->posts->take(6) as $post)
                <a href="/post/{{ $post->id }}" class="list-group-item" style="overflow: hidden; text-overflow: ellipsis; height:50px;">
                    {{ $post->title }}
                </a>
            @endforeach
        </ul>

        <br>
    </div>
    @else
    <div class="col">
    </div>
    @endif
    @endforeach
</div>


<br>

@if(count($tradeposts))
<br>
<div style="text-align: center">
    <h3>거래중인 기프티콘들</h3>
</div>
<br>
@include('layouts.cardhome')
@endif

</main>

@endsection