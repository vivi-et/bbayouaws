<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\GiftconTradePost;
use App\Giftcon;
use App\Board;
use SebastianBergmann\Environment\Console;
use thiagoalessio\TesseractOCR\TesseractOCR;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $giftcons = Auth::user()->giftcons->where('on_trade', '!=', 1)->all();

        // return $giftcons;


        $boards = Board::get();










        // $giftcons = GiftconTradePost::select('giftcon_trade_posts.*', 'giftcons.*', 'users.name')
        // ->Join('giftcons', 'giftcons.id', '=', 'giftcon_trade_posts.giftcon_id')
        // ->Join('users', 'users.id', '=', 'giftcon_trade_posts.user_id')
        // ->get()->take(6);

        $tradeposts =  GiftconTradePost::latest()->get()->take(6);

        $giftcons = collect(new Giftcon);
        foreach ($tradeposts as $tradepost)
            $giftcons->push(Giftcon::find($tradepost->giftcon_id));




        $posts = Post::latest()->get()->take(6);



        return view('home')->with('giftcons', $giftcons)->with('boards', $boards)->with('tradeposts', $tradeposts);
    }
}
