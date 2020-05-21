<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Giftcon;
use App\GiftconTradePost;
use App\GiftconTradeComment;
use App\Post;
use App\Comment;
use App\Board;


class MyPageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


 public function mytrades()
 {
     $user = Auth::user();

     $posts = $user->giftcontradepost;
     $comments = $user->giftcontradecomment;



    //  return $posts;
    //  return Giftcon::find($posts[0]->giftcon_id)->title;

    
    return view('mypage.trade')->with('posts',$posts)->with('comments',$comments);
 }

 public function myposts()
 {
    $user = Auth::user();

    $posts = $user->posts;
    $comments = $user->comments;

    return view('mypage.post')->with('posts',$posts)->with('comments',$comments);
 }
}
