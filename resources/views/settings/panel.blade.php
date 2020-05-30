@extends('layouts.master')

@section('content')
<br><br><br>

@if(session('auth') == true)



<div style="text-align: center;">
    <b>
        설정
    </b>

    <br><br>
    <button onclick="showChangeName()" class="btn btn-primary" style="width: 30%; height:60px">개인정보 변경</button>
    <button onclick="showChangePassword()" class="btn btn-primary" style="width: 30%; height:60px">비밀번호 변경</button>
    <button onclick="showQuitMembership()" class="btn btn-danger" style="width: 30%; height:60px">회원탈퇴</button>
    <br>
    <br>
    <br>
    <br>


    <div id="changeName" style="display: block;">
        <div style="float: left">
            개인정보 변경
        </div>
        <div style="clear: both;"></div>
        <hr style="border-top: 2px solid black;">
        <br>
        <br>

        <div style="height: 400px; border:2px solid grey; border-radius:20px;">

            <div style="padding-top: 10%; margin-left:30%;">

                <form action="/settings/panel/changename/{{ Auth::user()->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="form-group row">
                        <div for="fromName" class="col-sm-2 col-form-label"><b>아이디</b></div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="fromName" name="fromName"
                                value="{{ Auth::user()->name }}" disabled>
                        </div>
                    </label>
                    <div class="form-group row">
                        <label for="toName" class="col-sm-2 col-form-label"><b>변경할 아이디</b></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="toName" name="toName"
                                placeholder="{{ Auth::user()->name }}" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"
                        style="width: 20%; float: left; margin-left:17%;">확인</button>
                    <div style="clear: both;"></div>
                </form>
                {{-- <button class="btn btn-danger">회원 탈퇴</button> --}}
            </div>
        </div>
    </div>

    <div id="changePassword" style="display: none;">
        <div style="float: left">
            비밀번호 변경
        </div>
        <div style="clear: both;"></div>
        <hr style="border-top: 2px solid black;">
        <br>
        <br>

        <div style="height: 400px; border:2px solid grey; border-radius:20px;">

            <div style="padding-top: 5%; margin-left:30%;">

                <form action="/settings/panel/changepass/{{ Auth::user()->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="form-group row">
                        <div for="fromPass" class="col-sm-3 col-form-label"><b>현재 비밀번호</b></div>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="fromPass" minlength="8" maxlength="20"
                                name="fromPass" required>
                        </div>
                    </label>
                    <hr style="border-color: black; width:60%; float:left;">
                    <br><br>
                    <div style="clear: both;"></div>
                    <div class="form-group row">
                        <label for="toPass" class="col-sm-3 col-form-label"><b>변경할 비밀번호</b></label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="toPass" name="toPass" minlength="8"
                                maxlength="20" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="toPassConfirm" class="col-sm-3 col-form-label"><b>비밀번호 확인</b></label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="toPassConfirm" name="toPassConfirm"
                                minlength="8" maxlength="20" required>
                        </div>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary"
                        style="width: 20%; float: left; margin-left:17%;">확인</button>
                    <div style="clear: both;"></div>


                </form>

                {{-- <button class="btn btn-danger">회원 탈퇴</button> --}}
            </div>
        </div>
    </div>

    <div id="quitMembership" style="display: none;">
        <div style="float: left">
            비밀번호 변경
        </div>
        <div style="clear: both;"></div>
        <hr style="border-top: 2px solid black;">
        <br>
        <br>

        <div style="height: 400px; border:2px solid grey; border-radius:20px;">

            <div style="padding-top: 5%; margin-left:30%;">

                <form action="/settings/panel/delete/{{ Auth::user()->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <label class="form-group row">
                        <div for="confirmPass" class="col-sm-3 col-form-label"><b>현재 비밀번호</b></div>
                        <div class="col-sm-4">
                            <input type="password" class="form-control" id="confirmPass" name="confirmPass" required>
                        </div>
                    </label>
           <br>
                    <div class="form-group row">
                        <label for="confirmTest" class="col-sm-3 col-form-label"><b>'회원탈퇴' 입력</b></label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="confirmTest" name="confirmTest" placeholder="     한번만 봐주세요 잘할게요" required>
                        </div>
                    </div>
                    <br>
                    <button onclick="return confirm('정말 탈퇴하시겠습니까?\n등록하신 모든 글과 기프티콘들이 삭제됩니다.')" type="submit" class="btn btn-danger" style="width: 20%; float: left; margin-left:17%;">빠유
                        탈퇴</button>
                    <div style="clear: both;"></div>


                </form>

                {{-- <button class="btn btn-danger">회원 탈퇴</button> --}}
            </div>
        </div>
    </div>

    <br><br>

</div>





</div>
@else
<script>
    window.location = "/settings";
</script>
@endif


@endsection

@push('style')
@endpush

@push('script')

<script>
    var changeName = document.getElementById('changeName');
    var changePassword = document.getElementById('changePassword');
    var quitMembership = document.getElementById('quitMembership');
    function showChangeName(){
        changeName.style.display = 'block';
        changePassword.style.display = 'none';
        quitMembership.style.display = 'none';



    }

    function showChangePassword(){
        changeName.style.display = 'none';
        changePassword.style.display = 'block';
        quitMembership.style.display = 'none';
    }

    function showQuitMembership(){
        changeName.style.display = 'none';
        changePassword.style.display = 'none';
        quitMembership.style.display = 'block';
    }



</script>












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