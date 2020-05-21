@extends('layouts.master')
@section('content')


<div class="row">
    <div class="col-sm">
        <br>
        From OCR
        <br>
        @for ($i = 0; $i < 6; $i++){{$package['cat'][$i]}} :{{$package['catdata'][$i]}} 
            <br>
            {{-- @endif --}}
            @endfor
            바코드분리 : {{wordwrap($package['catdata'][5], 4, ' ', true)}}
            <br>
            <br>
            <br>
            {{-- From MYSQL
            <br>
            유효기간 : {{$package['giftcon']->expire_date}}
            <br>
            주문번호 : {{$package['giftcon']->orderno}}
            <br>
            교환처 : {{$package['giftcon']->place}}
            <br>
            바코드 : {{ $package['giftcon']->barcode }}
            <br>
            바코드분리 : {{ $package['sepCode']}}
            {!! $package['bobj']->getHtmlDiv() !!} --}}

            <br>
    </div>

    <div class="col-sm">
        <img style="max-height: 800px; max-width:500 px;" src="/storage/cover_images/{{ $package['path']}} ">
    </div>
</div>
@endsection