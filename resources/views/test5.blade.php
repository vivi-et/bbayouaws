@extends('layouts.master')
@section('content')

<main>
    <br>
    <br>
    <br>
    <br>
    <br>
    <div style="margin-left: 100px">
        <img src="/storage/cover_images/2020-05-06 14:21:03" alt="">
        <br>
        {{ $code }}

        

        {{-- 이 이미지를 ajax로 받아서 쏴주거나
https://stackoverflow.com/questions/18545034/how-do-i-convert-my-entire-div-data-into-image-and-save-it-into-directory-withou/18545150

를 사용해서 아무튼 주기!! --}}
    </div>

    <br>
    <br>
    <br>

    <img src="data:image/png;base64,{!! base64_encode($generator->getBarcode('946058883978', $generator::TYPE_CODE_128,3,100)) !!}">

    <br>
    <br>

    <img src="data:image/png;base64,{!! base64_encode($generator->getBarcode('123412341234', $generator::TYPE_CODE_128,1,100)) !!}">
    <br>
    <br>
    <br>
    <br>
    <img src="data:image/png;base64,{!! base64_encode($generator->getBarcode('123412341234', $generator::TYPE_CODE_128,3,100)) !!}">
</main>
@endsection