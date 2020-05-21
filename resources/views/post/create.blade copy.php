@extends('layouts.master')

@section('content')


<h1>
    기프티콘 등록
</h1>

<br>
<hr>

<div class="row">
    <div id="firstSm" class="col-sm" style="text-align: center">
        <form id="main_form" method="POST" action="/post" enctype="multipart/form-data">
            @csrf
            <div style="display: inline-block;">
                <img id="img_prv" style="max-height: 500px; max-width:300 px; " src="/storage/noimage.png"
                    class="img-thumbnail">
            </div>



            <input type="file" id="cover_image" name='cover_image' style="display:none;">
            <div>(2mb 이내인 jpg, jpeg, png 파일만 가능합니다.)</div>
            <br>

            <label id="label_test" for="cover_image" class="btn btn-primary" style="width:300px;">기프티콘 업로드</label>
            <div id='mgs_ta'>

            </div>
            <div class="form-group">
                <button type="submit" id="submitbtn" class="btn btn-primary" style="width:300px;">기프티콘 확인</button>
            </div>
        </form>
    </div>

    <div class="col-sm" style="text-align: center" id="result_col_sm">

        <table>
            <tr>
                <th>항목</th>
                <th>값</th>
            </tr>
            <tr>
                <th>유효기간</th>
                <th>
                    <div id="expire_date" class="form-group"></div>
                </th>
            </tr>

            <tr>
                <th>주문번호</th>
                <th>
                    <div id="orderno" class="form-group"></div>
                </th>
            </tr>

            <tr>
                <th>교환처</th>
                <th>
                    <div id="place" class="form-group"></div>
                </th>
            </tr>

            <tr>
                <th>선물수신일</th>
                <th>
                    <div id="recieved_date" class="form-group"></div>
                </th>
            </tr>

            <tr>
                <th>쿠폰상태</th>
                <th>
                    <div id="used" class="form-group"></div>
                </th>
            </tr>

            <tr>
                <th>바코드</th>
                <th>
                    <div id="barcode" class="form-group"></div>
                </th>
            </tr>

            <tr>
                <th>파일경로//추후삭제</th>
                <th>
                    <div id="filepath" class="form-group"></div>
                </th>
            </tr>




        </table>


        <div class="form-group">
            <button type="submit" id="finalsubmitbtn" class="btn btn-primary">기프티콘 등록</button>
        </div>
        </form>


    </div>

</div>









@include('layouts.error')


@endsection


@push('script')
<script type="text/javascript">
    var x = document.getElementById("img_prv");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
    $('#cover_image').on('change', function(ev){
    console.log("here inside");
    var filedata=this.files[0];
    var imgtype=filedata.type;
    var match=['image/jpeg', 'image/jpg', 'image/png'];
    if(!((imgtype==match[0])||(imgtype==match[1])||(imgtype==match[2]))){
        $('#mgs_ta').html('<p style="color:red"> jpg, jpeg, png 파일만 업로드가 가능합니다. </p>')
        x.style.display = "none";
    }else{
    var reader = new FileReader();
    reader.onload=function(ev){
        $('#img_prv').attr('src',ev.target.result)
        var x = document.getElementById("img_prv");
    x.style.display = "block";

    
    }
    reader.readAsDataURL(this.files[0]);
    }

    var submitbtn = document.getElementById("submitbtn");
    submitbtn.disabled = false;
    submitbtn.style.visibility = "visible";

    document.getElementById("label_test").innerHTML = "다른 기프티콘 업로드";
    

});

</script>
{{-- 
<style>
    #submitbtn, #label_test,
    #body {
        border: 1px solid black;
        padding: 2px 4px;
        display: inline-block;
    }
</style>
--}}

{{-- JS 스타일 --}}
<script>
    // finalsubmitbtn 크기 관련
    $(document).ready(function() {
  $("#finalsubmitbtn").css({
    'width': ($("#result_col_sm").width() + 'px')
  }); 
});

// submitbtn 보이기
var submitbtn = document.getElementById("submitbtn");
submitbtn.disabled = true;
submitbtn.style.visibility = "hidden";

</script>

{{-- AJAX용 CSRF 토큰 --}}
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
</script>

{{-- 기프티콘 확인 관련 JS/AJAX --}}
<script>
    $(document).ready(function(){

        var finalsubmitbtn = document.getElementById("result_col_sm");
  if (finalsubmitbtn.style.display === "none") {
    finalsubmitbtn.style.display = "block";
  } else {
    finalsubmitbtn.style.display = "none";
  }
    
     $('#main_form').on('submit', function(event){
      event.preventDefault();
      $.ajax({
       url:"{{ route('ajaxupload.action') }}",
       method:"POST",
       data:new FormData(this),
       dataType:'JSON',
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {

        console.log('ajax json recieved');
                $('#expire_date').html(data.expire_date);
                $('#orderno').html(data.orderno);
                $('#place').html(data.place);
                $('#recieved_date').html(data.recieved_date);
                $('#used').html(data.usedstr);
                $('#barcode').html(data.barcode);
                $('#filepath').html(data.filepath);
       alert(data.message);
       finalsubmitbtn.style.display = "block";
       }
      })
     });
    
    });
</script>




@endpush