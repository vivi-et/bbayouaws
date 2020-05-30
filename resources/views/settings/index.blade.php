@extends('layouts.master')

@section('content')
<br><br><br>



<div style="text-align: center;">
    <b>
        설정
    </b>

    <br><br>
    <button class="btn btn-primary" style="width: 30%; height:60px">개인정보 변경</button>
    <button class="btn btn-primary" style="width: 30%; height:60px">비밀번호 변경</button>
    <button class="btn btn-danger" style="width: 30%; height:60px">회원탈퇴</button>
    <br>
    <br>
    <br>
    <br>
    <div id="doAuth" style="display: block;">
        <div style="float: left">
            본인 확인
        </div>
        <div style="clear: both;"></div>
        <hr style="border-top: 2px solid black;">
        <br>
        <br>

        <div style="height: 400px; border:2px solid grey; border-radius:20px;">

            <form action="/settings/authenticate" method="POST">
                @method('POST')
                @csrf
                <div style="padding-top: 10%;">
                    <b style="color: red;">개인 정보 보호를 위해 비밀번호를 입력해주세요</b>
                    <br>
                    <br>

                    <input type="password" name="pwd" id="pwd" style="width: 35%; height:40px; padding-left:10px">
                    <br>
                    <br>
                    <button type="submit" class="btn btn-primary"
                        style="width: 35%; height:40px;">확인</button>
                </div>
            </form>
        </div>
    </div>







</div>
@endsection