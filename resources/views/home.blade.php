@extends('layouts.master')


@section('content')




<section class="jumbotron text-center">
    <div class="container">
        <h2 style="color: #F27405;">BBAYOU</h2>
        <h1></h1>
        <p class="lead text-muted">사용하지 않는 기프티콘들을 거래해보세요</p>
    </div>
</section>

{{-- {{  $user }} --}}


<div style="text-align: center">
    <h4 style="color: grey;">최근 게시물들</h4>
</div>
<br>
<div class="row">
    <br>
    @foreach ($boards as $board)


    @if(count($board->posts))
    <div class="col" style="margin-right:18px;">
        <br>
        <div style="background-color: #F27405; height:40px; text-align:center; padding-top:10px;">
            {{ $board->board_korname }}
        </div>
        <ul class="list-group">
            @foreach ($board->posts->take(6) as $post)
            <a href="/post/{{ $post->id }}" class="list-group-item"
                style="overflow: hidden; text-overflow: ellipsis; height:50px;">
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
    <h4 style="color: grey;">거래중인 기프티콘들</h4>
</div>
<br>
@include('layouts.cardhome')
@endif

</main>

@endsection