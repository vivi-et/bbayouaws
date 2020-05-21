@extends('layouts.master')




@section('content')

<main role="main">

    <section class="jumbotron text-center">
        <div class="container">
            <h2>BBAYOU</h2>
            <h1>뭐</h1>
            <p class="lead text-muted">디자인 구진거 안다</p>
            {{-- <p>
                <a href="#" class="btn btn-primary my-2">Main call to action</a>
                <a href="#" class="btn btn-secondary my-2">Secondary action</a>
            </p> --}}
        </div>
    </section>

    @if(count($giftcons))
    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">
                @foreach($giftcons as $giftcon)
                @include('layouts.card')
                @endforeach

            </div>
        </div>
    </div>
    @else
    <div style="text-align: center;">
       <h4>현재 거래중인 기프티콘이 없습니다</h4>
    </div>
    @endif



</main>


@endsection