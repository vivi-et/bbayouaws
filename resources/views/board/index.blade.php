@extends('layouts.master')

@section('content')

<br>

<H3> {{ $board->board_korname }}</H3>
<br>
<br>
@if(count($posts))
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">제목</th>
      <th scope="col">글쓴이</th>
      <th scope="col">작성일</th>
      <th scope="col">조회</th>
      <th scope="col">추천</th>
    </tr>
  </thead>
  <tbody>

    @foreach ($posts as $post)
    <tr>
      <th scope="row">{{ $post->id }}</th>

      <td><a href="/post/{{ $post->id }}">{{ $post->title }} </a></td>
      <td>{{ $post->user->name }}</td>
      <td>{{ $post->created_at->diffforhumans()}}</td>
      <td>{{ $post->views }}</td>
      <td>{{ $post->ups }}</td>
    </tr>

    @endforeach




  </tbody>
</table>

{{ $posts->links() }}

<div style="text-align: center;">
  <div class="aa-input-container" id="aa-input-container">
    <form onsubmit="window.location = '/board/{{ $board->board_name }}/search/' + search.value; return false;">
      @csrf
      @method('POST')
      <input type="search" id="aa-search-input" class="aa-input-search" placeholder="검색" name="search"
        autocomplete="on" />
      <svg class="aa-input-icon" viewBox="654 -372 1664 1664">
        <path
          d="M1806,332c0-123.3-43.8-228.8-131.5-316.5C1586.8-72.2,1481.3-116,1358-116s-228.8,43.8-316.5,131.5  C953.8,103.2,910,208.7,910,332s43.8,228.8,131.5,316.5C1129.2,736.2,1234.7,780,1358,780s228.8-43.8,316.5-131.5  C1762.2,560.8,1806,455.3,1806,332z M2318,1164c0,34.7-12.7,64.7-38,90s-55.3,38-90,38c-36,0-66-12.7-90-38l-343-342  c-119.3,82.7-252.3,124-399,124c-95.3,0-186.5-18.5-273.5-55.5s-162-87-225-150s-113-138-150-225S654,427.3,654,332  s18.5-186.5,55.5-273.5s87-162,150-225s138-113,225-150S1262.7-372,1358-372s186.5,18.5,273.5,55.5s162,87,225,150s113,138,150,225  S2062,236.7,2062,332c0,146.7-41.3,279.7-124,399l343,343C2305.7,1098.7,2318,1128.7,2318,1164z" />
      </svg>
      <button type="submit" hidden></button>
    </form>
  </div>

</div>
@else
<div style="text-align: center;">
  <h4>현재 작성된 글이 없습니다.</h4>

</div>
@endif
<a style="float:right;" href="/post/create/{{ $board->board_name }}">
  <button class="btn btn-primary">글 작성</button>
</a>

@endsection


