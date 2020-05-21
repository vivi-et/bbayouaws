<?php

namespace App\Http\Controllers;

use App\Board;
use App\Post;
use DB;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

public function search(Request $request,String $board, String $string)
{
    //Route Model Binding 을 사용할경우 url에 board_name 대신 board_id 를 사용해야됨 -> 직관적이지 않은 url
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

    $posts = Post::query()
    ->where('board_id', '=', $board->id)
    ->where('title', 'LIKE', "%{$string}%") 
    ->orWhere('body', 'LIKE', "%{$string}%") 
    ->paginate(20);

    // return $posts;


    
return view('board.search')->with('board',$board)->with('posts',$posts)->with('value',$string);






}



    public function index(string $board)
    {

    
        $posts = Post::select('posts.*')
        ->Join('boards', 'boards.id', '=', 'posts.board_id')
        ->where('board_name', $board)
        ->orderby('id','desc')
        ->paginate(20);


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


  


        return  view('board.index')->with('posts', $posts)->with('board',$board);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        //
    }
}
