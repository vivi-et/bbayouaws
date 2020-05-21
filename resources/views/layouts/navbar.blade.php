<div class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container d-flex justify-content-between">


        <a href="/" class="navbar-brand d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor"
                stroke-linecap="round" stroke-linejoin="round" stroke-width="2" aria-hidden="true" class="mr-2"
                viewBox="0 0 24 24" focusable="false">
                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                <circle cx="12" cy="13" r="4" /></svg>
            <strong>BBAYOU</strong>

        </a>

        <a href="/giftcon" style="color: white">
            <strong>GIFTCON</strong>
        </a>

        <a href="/board/free" style="color: white; margin-left:10px;">
            <strong>자유게시판</strong>
        </a>


        <a href="/board/humor" style="color: white; margin-left:10px;">
            <strong>유머게시판</strong>
        </a>


        <a href="/board/game" style="color: white; margin-left:10px;">
            <strong>게임게시판</strong>
        </a>


        <a href="/board/sport" style="color: white; margin-left:10px;">
            <strong>스포츠게시판</strong>
        </a>

        @if(Auth::check())
        <a href="/giftcon/mygiftcons" style="color: #FEE715FF; margin-left:10px;">
            <strong>내 기프티콘</strong>
        </a>
        @endif



        @if(Auth::check())
        <div class="ml-auto">
            <div class="dropdown">
                <button class="btn"> <a href="#"> <strong>{{ Auth::user()->name}}님 안녕하세요!</strong> </a></button>
                <div class="dropdown-content">
                    <a href="/mypage/trades">기프티콘 거래현황</a>
                    <a href="/mypage/posts">내 글들</a>
                    <a href="#">설정</a>
                </div>
            </div>

            <a href="/logout">
                <strong style="color: #FEE715FF; margin-left:30px">로그아웃</strong>
            </a>

        </div>
        @else
        <div class="ml-auto">
            <a href="/login">
                <strong style="color: white;">로그인</strong>
            </a>
            <a href="/register">
                <strong style="color: white;">회원가입</strong>
            </a>
        </div>
        @endif
    </div>

    <div class="aa-input-container" id="aa-input-container" style="position: relative;">
        <input type="search" id="aa-search-input" class="aa-input-search" placeholder="" name="search"
            autocomplete="off" />
        <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
            <path
                d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
        </svg>
    </div>
</div>



@push('script')
<script>
    const client = algoliasearch("RHC6DFKJ3V", "077a01059053b34f8e788089f4f1f3f2");
    const index1 = client.initIndex('posts');
    const index2 = client.initIndex('giftcon_trade_posts');

    autocomplete('#aa-search-input', {}, [{
            source: autocomplete.sources.hits(index1, {
                hitsPerPage: 5
            }),
            displayKey: 'name',
            templates: {
                header: '<div class="aa-suggestions-category">게시글</div>',
                suggestion({
                    _highlightResult
                }) {

                  console.log(_highlightResult.board_id);
                    let board_name = '';
                    if (_highlightResult.board_id.value == 1)
                    _highlightResult.board_id.value = '자유게시판';
                    if (_highlightResult.board_id.value == 2)
                    _highlightResult.board_id.value = '유머게시판';
                    if (_highlightResult.board_id.value == 3)
                    _highlightResult.board_id.value = '게임게시판';
                    if (_highlightResult.board_id.value == 4)
                    _highlightResult.board_id.value = '스포츠게시판';


                    console.log(board_name);


                    return `<span>${_highlightResult.title.value}</span><span>${_highlightResult.board_id.value}</span>`;
                    // return `<span>${_highlightResult.title.value}</span><span>${_highlightResult.body.value}</span>`;
                },
                empty: function (result) {
                    return "<br>&nbsp&nbsp&nbsp&nbsp&nbsp" + result.query + " 에 대한 검색결과가 없습니다. <br><br>" 
                },
            }
        },
        {
            source: autocomplete.sources.hits(index2, {
                hitsPerPage: 5
            }),
            displayKey: 'name',
            templates: {
                header: '<div class="aa-suggestions-category">거래중인 기프티콘</div>',
                suggestion({
                    _highlightResult
                }) {
                    return `<span>${_highlightResult.giftcon_title.value}</span>`;
                },
                empty: function (result) {
                    return "<br>&nbsp&nbsp&nbsp&nbsp&nbsp" + result.query + " 에 대한 검색결과가 없습니다. <br><br>"
                },
            }
        }
    ]).on('autocomplete:selected', function (event, suggestion, dataset) {

        console.log(dataset);
        if (dataset == 1)
            window.location.href = window.location.origin + '/post/' + suggestion.id;
        else
            window.location.href = window.location.origin + '/giftcon/trade/' + suggestion.id;

    });

</script>
@endpush


@push('style')

<style>
    /* Dropdown Button */
    .dropbtn {
        background-color: #4CAF50;
        color: white;
        padding: 16px;
        font-size: 16px;
        border: none;
    }

    .btn a {
        color: white;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #ddd;
    }

    /* Show the dropdown menu on hover */
    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }
</style>

@endpush