@push('header')
<link href="/css/useralgolia.css" rel=stylesheet />
@endpush

@extends('layouts.master')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js">
</script>


@section('content')


<main role="main">
    <section class="jumbotron text-center">
        <div class="container">
            <h2>내 기프티콘들</h2>

            <p>
                <a href="/giftcon/create" class="btn btn-primary my-2">기프티콘 추가하기</a>
                <a href="#" class="btn btn-secondary my-2">Secondary action</a>
            </p>
        </div>
    </section>

    @if (count($giftcons))
    @include('layouts.coccard')
    @endif



</main>



<!-- 모달 -->
<!-- 모달 -->
<!-- 모달 -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">기프티콘 선물하기</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div style="text-align: center;">
                    <input id="inputGiftconId" hidden>
                   기프티콘: <input id="inputGiftconTitle" style="text-align: center;" readonly>
                   <br>
                   받는사람: <input id="inputGiftconReciever" style="text-align: center;" readonly>
                    <br>
                    <br>
                    {{-- 유저 검색창 --}}
                    <div class="user-input-container" id="user-input-container" style="position: relative;">
                        <input type="search" id="user-search-input" class="user-input-search"
                            placeholder="선물할 사용자를 선택해주세요" name="search" autocomplete="off" />
                        <svg class="user-input-icon" viewBox="654 -372 1664 1664">
                            <path
                                d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
                        </svg>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <form action="/giftcon/present" id="formPresentGiftcon" method="POST">
                    @csrf
                    <input type="text" name="username" id="submitUsername" hidden>
                    <input type="text" name="userID" id="submitUserID" hidden>
                    <input type="text" name="giftconID" id="submitGiftconID" hidden>
                    <button id="btnSubmitFormPresentGiftcon" onclick="return confirm('정말 선물하시겠습니까? \n취소하실 수 없습니다.')" type="submit" class="btn btn-primary">선물하기</button>
                </form>
            </div>
        </div>
    </div>
</div>






@endsection

@push('script')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>

<style>
    .one-third:hover,
    .one-third:focus {
        background: rgb(141, 87, 21);
        cursor: pointer;
        border-bottom-left-radius: 14px;
        border-bottom-right-radius: 14px
    }
</style>

<style>
    input {
        border: 0;
    }
</style>


<script>
    function checkGiftcons(giftcon_id, giftcon_title) {
    $('#myModal').modal('toggle');

    let username = document.getElementById('user-search-input');
    let inputGiftconId = document.getElementById('inputGiftconId');
    let inputGiftconTitle = document.getElementById('inputGiftconTitle');
    let formPresentGiftcon = document.getElementById('formPresentGiftcon');
    let submitUsername = document.getElementById('submitUsername');
    let submitGiftconID = document.getElementById('submitGiftconID');
    let btnSubmitFormPresentGiftcon = document.getElementById('btnSubmitFormPresentGiftcon');



    inputGiftconId.value = giftcon_id;
    inputGiftconTitle.value = giftcon_title;

    btnSubmitFormPresentGiftcon.addEventListener("click", function (event) {
        event.preventDefault();
        submitUsername.value = username.value;
        submitGiftconID.value = giftcon_id;

        console.log(submitUsername.value);
        console.log(submitGiftconID.value);

        formPresentGiftcon.submit();

});
    }
</script>

<script>
    let thisclient = algoliasearch("RHC6DFKJ3V", "077a01059053b34f8e788089f4f1f3f2");
  let user = thisclient.initIndex('users');
  
  autocomplete('#user-search-input', {}, [
      {
        source: autocomplete.sources.hits(user, { hitsPerPage: 5 }),
        displayKey: 'name',
        templates: {
          header: '<div class="user-suggestions-category">선물할 사용자를 선택해주세요</div>',
          suggestion({_highlightResult}) {
            let thisUser = "<?php echo $thisUserID;?>";

            if(_highlightResult.id.value !== thisUser)
            return `<span>${_highlightResult.name.value}</span>`;
          },
          empty:function(result){
              return "<br> 일치하는 사용자가 없습니다. <br><br>"
          },
        }
      }
  ]).on('autocomplete:selected', function(event, suggestion, dataset){

      console.log(suggestion);
  
  document.getElementById('inputGiftconReciever').value = suggestion.name;
  document.getElementById('submitUserID').value = suggestion.id;

//   window.location.href = window.location.origin + '/giftcon/trade/' + suggestion.id;
  
  });
  
</script>

@endpush