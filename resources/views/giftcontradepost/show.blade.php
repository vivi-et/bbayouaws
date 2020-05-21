@extends('layouts.master')

@section('content')

<style>
    .editablediv {
        width: 600px;
    }
</style>

<br>
<div class="col-sm-8 blog-main">
    {{-- 본문(거래) --}}
    @if($thispost->traded == 1)
   <h4>거래가 완료된 게시물입니다</h4> 
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
        @if(auth()->user())
        @if(auth()->user()->id == $giftcon->user_id && $thispost->traded === 0)
        <div class="btn-group" style="float:right;">
            <form method="POST" action="/giftcon/trade/{{$thispost->id}}">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('정말 삭제하시겠습니까?')" type="submit" class="btn btn-danger"
                    style="margin-left:5px;">글 삭제</button>
            </form>
            <div style="clear:both;"></div>
        </div>
        @endif
        @endif
        <br>
        <br>
        <hr>
        <br>

        @if(Auth::user())
        @if (Auth::user()->id !== $thispost->user->id && $thispost->traded == 0)
        <div style="text-align: center;">
            <button id="btn_checkGiftcons" onclick="checkGiftcons()" type="button" class="btn btn-info btn-lg">
                {{-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"> --}}
                교환 요청하기</button>
        </div>
        <br>
        <hr>
        @endif
        @endif
        {{-- 댓글(거래 제안) --}}
        {{-- 댓글(거래 제안) --}}
        {{-- 댓글(거래 제안) --}}
        @isset($arraycomments)
        @foreach($arraycomments as $comment)
        {{ $comment->user->name }},
        {{ $comment->created_at->diffforhumans() }}
        @if(Auth::user())
        {{-- 버튼 모음 --}}
        <div class="button-group">
            {{-- 승낙하기 버튼 --}}
            @if(Auth::user()->id === $thispost->user->id && $comment->traded !== 1)
            <div style="float: right; margin-left:12px;">
                <form action="/giftcon/tradecomment/{{ $comment->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" name="thiscommentid" value="{{ $comment->id }}" hidden>
                    <input type="text" name="thispostid" value="{{ $thispost->id }}" hidden>
                    <button onclick="return confirm('정말 교환하시겠습니까?\n취소하실 수 없습니다')" class="btn btn-primary"
                        type="submit">승낙하기</button>
                </form>
            </div>
            @endif

            {{-- 삭제하기 버튼 --}}
            @if(Auth::user()->id === $comment->user->id && $comment->traded == 0)
            <div style="float: right; margin-left:12px;">
                <form action="/giftcon/tradecomment/{{ $comment->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" onclick="return confirm('정말 삭제하시겠습니까?')" type="submit">X</button>
                </form>
            </div>
            @endif
        </div>
        @endif
        <br>
        <br>
        @if($comment->traded == 1 )
        <div class="row" style="opacity:0.5; background-color: grey">
            @else
            <div class="row">
                @endif
                @foreach($comment->giftcons as $giftcon)
                <div class="card" style="margin-left: 18px; margin-top:8px">
                    <div class="col" style="text-align: center;">
                        <img style="width:100px; height:100px;" class="center"
                            src="/storage/giftcon_images/{{ $giftcon->imagepath }}">
                        <br>
                        상품명 : {{ $giftcon->title }}
                        <br>
                        만료일 : {{ $giftcon->expire_date }}
                        <br>
                        교환처 : {{ $giftcon->place }}
                        <br>
                    </div>
                </div>
                @endforeach

            </div>
            <br>
            <hr style="clear: both;">
            @endforeach
            @endisset
            {{-- comments --}}

            {{-- comments --}}




            <br>

            {{-- 모달모달모달모달모달모달모달모달모달모달모달모달모달모달모달모달 --}}
            @if($myGiftcons !== 0)
            <div id="myModal" class="modal fade bd-example-modal-xl" role="dialog">
                <div class="modal-dialog modal-xl">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">교환할 기프티콘을 선택해주세요 (최대 3개)</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" id="div_modalBody">

                            @if(count($myGiftcons))
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">상품</th>
                                        <th scope="col">만료일</th>
                                        <th scope="col">장소</th>
                                        <th scope="col">등록일</th>
                                        <th scope="col">사용</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($myGiftcons as $myGiftcon)
                                    <tr>
                                        <th scope="row">{{ $myGiftcon->id }}</th>
                                        <td>{{ $myGiftcon->title }}</td>
                                        <td>{{ $myGiftcon->expire_date }}</td>
                                        <td>{{ $myGiftcon->place }}</td>
                                        <td>{{ $myGiftcon->created_at->diffforhumans()}}</td>
                                        <td><input type="checkbox" id="vehicle3" name="vehicle3"
                                                value="{{ $myGiftcon->id }}">
                                        </td>
                                    </tr>

                                    @endforeach

                                </tbody>
                            </table>
                            @endif


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                            <button type="button" onclick="submitOffer({{ $giftcon->id }}, {{ $thispost->id }})"
                                class="btn btn-primary">확인</button>
                        </div>
                    </div>

                </div>
            </div>
            @endif

            @include('layouts.error')


            @endsection

            @push('script')



            <script type="text/javascript">
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            </script>

            {{-- 교환할 기프티콘들을 체크하고 최종 확인 --}}
            <script>
                function submitOffer(iWantThisGiftcon, TradePostId) {
                var checkout = Array();
                $("input:checkbox[type=checkbox]:checked").each(function () {
                    checkout.push($(this).val());
                });

                if (checkout.length > 3) {
                    alert('최대 3개까지만 교환가능합니다')
                } else {

                    // let checkedJSON = JSON.stringify(checkout);
                    $.ajax({
                        type: "POST",
                        url: "/giftcon/tradecomment",
                        dataType: 'JSON',
                        data: {
                            'post_id' : TradePostId,
                            'this': iWantThisGiftcon,
                            'for': checkout,
                        },
                        // contentType: false,
                        // cache: false,
                        // processData: false,

                        success: function (data) {
                            // alert('교환신청이 완료되었습니다!');
                            alert(data.message);
                            $('#myModal').modal('toggle');
                            location.reload();
                            
                        }
                    });



                }
            }

            </script>


            <script>
                // When the user clicks on <div>, open the popup
            function myFunction() {
                var popup = document.getElementById("myPopup");
                popup.classList.toggle("show");
            }

            </script>

            <script>
                function checkGiftcons() {
                $('#myModal').modal('toggle');


            };

            </script>



            @endpush