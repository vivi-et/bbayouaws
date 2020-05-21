<?php

namespace App\Http\Controllers;

use App\Post;
use App\Giftcon;
use App\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PostController extends Controller

{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $board)
    {


        $posts = Post::latest()->get();
        //tasks
        return view('board.index', compact('posts'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(string $board)
    {
        switch ($board) {
            case 'free':
                $board = Board::find(1);
                break;
            case 'humor':
                $board = Board::find(2);
                break;
            case 'game':
                $board = Board::find(3);
                break;
            case 'sport':
                $board = Board::find(4);
                break;
            default:
                $board = 'error';
                break;
        }

        return view('post.create')->with('board', $board);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $board = Board::find($request->board);

        $boardno = $board->id;


        $this->validate($request, [

            'title' => 'required|max:60',
            'body' => 'required',

        ]);

        $body = $request->input('body');


        $dom = new \DomDocument();

        $dom->loadHtml('<?xml encoding="utf-8">' . $body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $k => $img) {

            $data = $img->getAttribute('src');

            list($type, $data) = explode(';', $data);

            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);

            $image_name = "/upload/" . time() . $k . '.png';

            $path = public_path() . $image_name;

            file_put_contents($path, $data);

            $img->removeAttribute('src');

            $img->setAttribute('src', $image_name);
        }
        $body = $dom->saveHTML();




        Post::create([
            'title' => $request->title,
            'body' => $body,
            'user_id' => auth()->id(),
            'board_id' => $boardno,
        ]);


        return redirect('/board/' . $board->board_name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

        $blogkey = 'blog_' . $post->id;

        //조회수 1증가
        if (!Session::has($blogkey)) {
            $post->increment('views');
            Session::put($blogkey, 1);
        }


        $boardposts = Post::select('posts.*')
        ->Join('boards', 'boards.id', '=', 'posts.board_id')
        ->where('board_id', $post->board_id)
        ->orderby('id','desc')
        ->paginate(5);


        switch ($post->board_id) {
            case 'free':
                $board = Board::find(1);
                break;
            case 'humor':
                $board = Board::find(2);
                break;
            case 'game':
                $board = Board::find(3);
                break;
            case 'sport':
                $board = Board::find(4);
                break;
            default:
                $board = 'error';
                break;
        }

        return view('post.show')->with('post', $post)->with('boardposts',$boardposts);
        // return view('post.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // GET /tasks/id/edit
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (auth()->user()->id !== $post->user_id) {
            return redirect('/posts')->withErrors('error', 'Unauthorized Page');
        }
        // PATCH /tasks/id

        // $boardno = $post->board_id;
        $board = Board::find($post->board_id)->board_name;



        $this->validate($request, [

            'title' => 'required|max:60',
            'body' => 'required',

        ]);

        $body = $request->input('body');


        $dom = new \DomDocument();

        $dom->loadHtml('<?xml encoding="utf-8">' . $body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $k => $img) {

            $data = $img->getAttribute('src');

            list($type, $data) = explode(';', $data);

            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);

            $image_name = "/upload/" . time() . $k . '.png';

            $path = public_path() . $image_name;

            file_put_contents($path, $data);

            $img->removeAttribute('src');

            $img->setAttribute('src', $image_name);
        }
        $body = $dom->saveHTML();




        // $post->update($request->all());
        $post->title = $request->title;
        $post->body = $body;
        $post->save();

        return redirect('/board/' . $board);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // DELETE /tasks/id

        //삭제할 파일 이름 가져오기
        $boardno = $post->board_id;
        $board = Board::find($boardno)->value('board_name');

        // $images = $dom->getElementsByTagName('img');

        // foreach ($images as $k => $img) {

        //     $data = $img->getAttribute('src');

        //     unlink($path);

        // 추후 explode 써서 링크된 이미지 삭제하기
        //기프티콘 파일 삭제

        //게시글 삭제
        $post->delete();

        //연결된 기프티콘 항목도 삭제


        return redirect('/board/' . $board);
    }
}
