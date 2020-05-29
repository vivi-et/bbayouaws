@extends('layouts.master')

@section('content')
<br><br><br>

@if(session('auth') == true)



<div style="text-align: center;">
    <b>
        설정
    </b>

    <br><br>
    <button class="btn btn-primary" style="width: 30%; height:60px">개인정보 변경</button>
    <button class="btn btn-primary" style="width: 30%; height:60px">비밀번호 변경</button>
    <button class="btn btn-primary" style="width: 30%; height:60px">개인정보 변경</button>
    <br>
    <br>
    <br>
    <br>
 

    <div id="doChange" style="display: block;">
        <div style="float: left">
            개인정보 변경
        </div>
        <div style="clear: both;"></div>
        <hr style="border-top: 2px solid black;">
        <br>
        <br>

        <div style="height: 400px; border:2px solid grey; border-radius:20px;">

            <div style="padding-top: 10%; margin-left:30%;">

                <form>
                    <div class="form-group row">
                        <div for="ID" class="col-sm-2 col-form-label"><b>아이디</b></div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ID" value="{{ Auth::user()->name }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div for="toName" class="col-sm-2 col-form-label">변경할 아이디</div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="toName" placeholder="{{ Auth::user()->name }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 20%;">확인</button>
                </form>
            </div>
        </div>
    </div>
</div>
@else
<script>window.location = "/settings";</script>
@endif


@endsection

@push('style')
@endpush

@push('script')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    function authenticate() {
        let pwd = document.getElementById('pwd').value;
        // console.log(pwd);
        $.ajax({
            type: "POST",
            url: "/settings/authenticate",
            cache: false,
            dataType: 'JSON',
            data: {
                'pwd': pwd,
                'test': 'tesssst'

            },
            success: function (data) {

                let status = data.status;

                if (status == true) {
                    alert(status);
                } else {
                    alert(status);
                }
            }
        });

    }
</script>
@endpush