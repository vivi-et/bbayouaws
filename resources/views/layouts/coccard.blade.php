<?php use App\GiftconTradePost; ?>
@push('header')
<link href="{{ asset('css/card.css') }}" rel="stylesheet" />
@endpush
<div class="row">
    {{-- barcode 번호 hidden 으로 숨겨짐! --}}
    @foreach ($giftcons as $giftcon)
    <div class="col-md-4" style="text-align: center">
        <div class="slide-container">
            <div class="wrapper" style="float: left; margin-left:5%">
                {{-- @if( $giftcon->used === 1)
                <div class="clash-card barbarian" style="background-color: grey" id="giftcon{{ $giftcon->id }}">
                @else --}}
                <div class="clash-card barbarian" id="giftcon{{ $giftcon->id }}">
                    {{-- @endif --}}
                    <div class="clash-card__image clash-card__image--barbarian">
                        <div style="  border-top-left-radius: 14px; border-top-right-radius: 14px;background-image: url('/storage/giftcon_images/{{ $giftcon->imagepath }}'); width: 100%;
                                    height: 100%;background-position: center center; background-repeat: no-repeat;"
                            alt="barbarian"></div>
                    </div>
                    <div class="clash-card__level clash-card__level--barbarian">
                        <a href="#">{{ $giftcon->user->name }}</a>
                    </div>
                    <div class="clash-card__unit-name" style="overflow: hidden; margin:0 20px; font-size:22px;">
                        <a href="/giftcon/{{ $giftcon->id }}"> {{ $giftcon->title }}</a></div>
                    <div class="clash-card__unit-description">
                        번호 : {{$giftcon->id}}
                        <br />
                        유효기간 : {{$giftcon->expire_date}}
                        <br />
                        {{-- 주문번호 : {{$giftcon->orderno}}
                        <br />
                        --}} 교환처 : {{$giftcon->place}}
                        <br />
                        {{-- 바코드 : {{wordwrap($giftcon->barcode, 4, ' ', true)}} --}}
                        상태 :
                        @switch($giftcon->used)
                        @case(0)
                        사용안함
                        @break
                        @case(1)
                        사용완료
                        @break
                        @case(2)
                        미기재
                        @break
                        @default

                        @endswitch


                        <br />
                        <br />
                        <div id="theBarcode{{ $giftcon->id }}"></div>
                        <div style="font-size: 20px; padding-top:8px" id="theBarcodeno{{ $giftcon->id }}"></div>
                        <br>
                        <p class="blog-post-meta">
                            {{ $giftcon->created_at->diffforhumans()}}
                        </p>
                    </div>

                    @if($giftcon->used == 1)
                    <div class="clash-card__unit-stats clash-card__unit-stats--giant clearfix">
                        사용완료
                    </div>
                    @elseif($giftcon->on_trade == 1)
                    <div class="clash-card__unit-stats clash-card__unit-stats--giant clearfix">
                        <?php 
                            $trade = GiftconTradePost::where('giftcon_id', '=', $giftcon->id)->latest()->first();
                            ?>
                        <a href="/giftcon/trade/{{$trade->id}}">
                            거래중입니다
                        </a>
                    </div>
                    @else
                    <div class="clash-card__unit-stats clash-card__unit-stats--giant clearfix">
                        <div class="one-third" onclick="checkGiftcons( '{{ $giftcon->id }}', '{{ $giftcon->title }}' )">
                            <div class="stat" >선물하기</div>
                            <div class="stat-value">Present</div>
                        </div>

                        <div class="one-third" onclick="return confirm('정말 사용하시겠습니까? \n더 이상 해당 기프티콘을 거래하실 수 없습니다')" tabindex="0" onclick="makeImage({{ $giftcon->id }})">
                            <div class="stat">사용하기</div>
                            <div class="stat-value">Use</div>
                        </div>

                        <div class="one-third no-border" id="trade{{ $giftcon->id }}"
                            onClick="javascript:document.forms[0].submit();">
                            <form action="/giftcon/trade" method="POST" hidden>
                                @csrf
                                <input type="text" name="giftcon" value="{{ $giftcon->id }}" hidden>
                            </form>
                            <div class="stat">
                                거래하기
                            </div>
                            <div class="stat-value">Trade</div>
                        </div>
                    </div>
                    @endif





                </div>
                <!-- end clash-card barbarian-->
            </div>
            <!-- end wrapper -->
        </div>
        <!-- end container -->
    </div>


    @endforeach
</div>

@push('script')
<script>
    function makeImage(x) {
        $.ajax({
            type: "PATCH",
            url: "/giftcon/" + x,
            cache: false,
            dataType: 'JSON',
            contentType: false,
            processData: false,
            data: {
                'text1': '1',
                'text2': '2',
                'text3': '3',
            },
            processData: false,
            success: function (data) {
            let base64image = data.barcode;
            let ajaxbarcodeno = data.barcodeno;
            let downloadAs = data.downloadAs;

            // alert(data.barcode);
            let theDiv = document.getElementById('theBarcode' + x);
            let theBarcodeno = document.getElementById('theBarcodeno' + x);
            let htmloutput = '<img src="data:image/png;base64,' +base64image+'">';
    
                
                theDiv.innerHTML += htmloutput;
                theBarcodeno.innerHTML +=  ajaxbarcodeno;

                let thisGiftcon = document.getElementById('giftcon' + x);

                html2canvas([thisGiftcon], {
                    onrendered: function (canvas) {
                        var data = canvas.toDataURL('image/jpeg');


                        var link = document.createElement('a');
                        link.download = downloadAs;
                        link.href = data;
                        link.click();
                        location.reload();
                    }

                });
            }
        });

    };

</script>

@endpush