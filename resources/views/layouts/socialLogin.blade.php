<div class="form-group row mb-0">
    <div class="col-md-8 offset-md-4">

        <br><br>

        {{-- 소셜 로그인 --}}
        <a href="/login/github">
            <img src="/social/github.png" alt="">
        </a>

        <a href="/login/naver">
            <img src="/social/naver.png" style="width: 32px;" alt="">
        </a>


        <a href="/login/kakao">
            <img src="/social/kakao.png" style="width: 32px;" alt="">
        </a>

        {{-- 페북은 https 연결요구해서 제외 --}}
        {{-- <a href="/login/facebook">
            <img src="/social/facebook.png" style="width: 32px;" alt="">
        </a> --}}



        {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
        {{ __('비밀번호 찾기') }}
        </a>
        @endif --}}
    </div>

</div>