@extends('layouts.master')

@section('content')

<style>
    .editablediv {
        width: 600px;
    }

</style>


<br>
<div class="col-sm-8 blog-main">
    @if($giftcon->used = 1)
    <div class="row" style=" padding:20px 0px; outline: 3px solid grey; opacity:0.5; background-color: grey">

        @else
        <div class="row" style="padding:20px 0px; outline: 3px solid black; ">
            @endif
            <div class="col-sm">
                <img style="max-width:100%;
    max-height:100%;" class="center" src="/storage/giftcon_images/{{ $giftcon->imagepath }}">

            </div>
            <div class="col-sm">
                <h2 class="blog-post-title">{{$giftcon->title}} </h2>
                유효기간 : {{$giftcon->expire_date}}
                <br>
                {{-- 주문번호 : {{$giftcon->orderno}}
                <br> --}}
                교환처 : {{$giftcon->place}}
                <br>
                상태 : {{ $status }}
                {{-- 바코드 : {{wordwrap($giftcon->barcode, 4, ' ', true)}} --}}
                <br>
                <br>
                <br>
                <p class="blog-post-meta"> <a href="#">{{ $giftcon->user->name }}</a>
                    {{ $giftcon->created_at->diffforhumans()}} </p>
            </div>
        </div>
        <br>
        <br>
        @if(!empty(auth()->user()))
        @if(auth()->user()->id == $giftcon->user_id)
        <div class="btn-group" style="float:right;">
            <form method="POST" action="/post/{{$giftcon->id}}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-primary" style="margin-left:5px;">Delete</button>
            </form>
        </div>
        @endif
        @endif
        <br style="clear:both;">
        <br>
        <hr>
        <br>

        <br>

        <div>


            <br>

            <hr>
            <br>

            <hr>



            </li>
            </ul>

            <br>

            {{-- add a comment --}}

            <div>

                <div>


                    @include('layouts.error')
                </div>
            </div>

            <script>
                function divClicked() {
                    var divHtml = $(this).prev('div').html();
                    var editableText = $("<textarea class='editablediv'/>");
                    editableText.val(divHtml);
                    $(this).prev('div').replaceWith(editableText);
                    editableText.focus();
                    // setup the blur event for this new textarea
                    editableText.blur(editableTextBlurred);
                }

                function editableTextBlurred() {
                    var html = $(this).val();
                    var viewableText = $("<div>");
                    viewableText.html(html);
                    $(this).replaceWith(viewableText);
                    // setup the click event for this new div
                    viewableText.click(divClicked);
                }

                $(document).ready(function () {
                    $(".btn").click(divClicked);
                });

            </script>

            @endsection

            <style>
                .center {
                    display: block;
                    margin-left: auto;
                    margin-right: auto;
                    /* width: 50%; */
                }

            </style>
