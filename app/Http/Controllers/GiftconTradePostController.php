<?php

namespace App\Http\Controllers;

use App\GiftconTradePost    ;
use App\GiftconTradeComment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Giftcon;
use App\r;
use Illuminate\Support\Facades\Auth;

class GiftconTradePostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }


    public function index()
    {
        $user = Auth::user();

        $giftcons = GiftconTradePost::select('giftcons.*', 'users.name', 'giftcon_trade_posts.*')
            ->Join('giftcons', 'giftcons.id', '=', 'giftcon_trade_posts.giftcon_id')
            ->Join('users', 'users.id', '=', 'giftcon_trade_posts.user_id')
            ->get();



        // 바코드 생성기 개체
        // 결국 view에서 data를 처리하는데 맞는 설계인가?
        // ajax 없이 controller에서 foreach 마다 다르게 생성해줄수있는가
        // return $generator->getBarcode('946058883978', $generator::TYPE_CODE_128);

        //tasks
        return view('giftcontradepost.index')->with('giftcons', $giftcons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('giftcontradepost.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $giftcon = Giftcon::find($request)->first();
        $day = Carbon::now()->day;
        $month = Carbon::now()->month;



        // 같은날, 같은 사용자가, 중복된 기프티콘을 거래할려는지 확인
        // $whereClause = ['user_id' => Auth::user()->id, 'giftcon_id' => $giftcon->id];
        $results = GiftconTradePost::where('giftcon_id', '=', $giftcon->id)
            ->whereDay('created_at', '=', $day)
            ->whereMonth('created_at', '=', $month)
            ->get();

            GiftconTradePost::create([
                'giftcon_id' => $giftcon->id,
                'giftcon_title' => $giftcon->title,
                'user_id' => Auth::user()->id,
            ]);

            $giftcon->on_trade = 1;
            $giftcon->save();
            session()->flash('message', '기프티콘이 거래게시판에 등록되었습니다!');


            // $giftcons = GiftconTradePost::select('giftcon_trade_posts.*')
            // ->Join('giftcons', 'giftcons.id', '=', 'giftcon_trade_posts.giftcon_id')
            // ->get();

            return redirect()->back();
        



        // GiftconTradePost::create([
        //     'giftcon_id' => $giftcon->id,
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show(GiftconTradePost $trade)
    {

        $thispost = $trade;
        if (Auth::check())
            $myGiftcons = Auth::user()->giftcons->where('on_trade', '!=', 1)->where('used','!=',1);
        else
            $myGiftcons = 0;

        $giftcon = GiftconTradePost::select('giftcon_trade_posts.*', 'giftcons.*', 'users.name')
            ->Join('giftcons', 'giftcons.id', '=', 'giftcon_trade_posts.giftcon_id')
            ->Join('users', 'users.id', '=', 'giftcon_trade_posts.user_id')
            ->where('giftcon_trade_posts.id', '=', $thispost->id)
            ->first();

        $arraycomments = GiftconTradeComment::with('giftcons')
            ->where('giftcon_trade_post_id', '=', $thispost->id)->get();


        // dd($comment);



        // $comment = GiftconTradeComment::find(11)->with('giftcons')->first();

        // dd($comment);


        $status = $giftcon->used;

        switch ($status) {
            case 0;
                $status = '사용안함';
                break;
            case 1;
                $status = '사용함';
                break;
            case 2;
                $status = '미기재';
                break;
        }


        if (count($thispost->comments) > 0) {
            // $thispostscomments = $thispost->comments;

            // for ($i = 0; $i < count($thispostscomments); $i++) {
            //     $arraycomments[$i] = $thispostscomments->with('giftcons')->find($i + 1);
            // }

            return view('giftcontradepost.show')
                ->with('giftcon', $giftcon)
                ->with('status', $status)
                ->with('myGiftcons', $myGiftcons)
                ->with('thispost', $thispost)
                ->with('arraycomments', $arraycomments);
        } else {

            return view('giftcontradepost.show')
                ->with('giftcon', $giftcon)
                ->with('status', $status)
                ->with('myGiftcons', $myGiftcons)
                ->with('thispost', $thispost);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(GiftconTradePost $trade)
    {
        $thispost = $trade; // 편의상 변수명 변경
        $thispostCommentGiftcons = GiftconTradeComment::with('giftcons')    //삭제된 게시글의 댓글들 처리
            ->where('giftcon_trade_post_id', '=', $thispost->id)            //이 게시글에 달린 댓글들 불러오기
            ->get();

        // 채택된 댓글 외 나머지 댓글들 거래중 상태 해제 및 댓글 삭제
        foreach ($thispostCommentGiftcons as $thispostCommentGiftcon) {     //이 게시글의 각 댓글들

            foreach ($thispostCommentGiftcon->giftcons as $eachGiftcon) {   //그 댓글들속의 기프티콘들
                $eachGiftcon->on_trade = 0;                                 //거래상태 해제
                $eachGiftcon->save();                                       //저장
            }
            $thispostCommentGiftcon->giftcons()->detach($thispostCommentGiftcon->giftcons); //pivot table에서 삭제
            $thispostCommentGiftcon->delete();                                              //댓글 삭제
        }

        
        $thispostGiftcon = Giftcon::find($thispost->giftcon_id);  //이 게시글의 기프티콘 거래중 상태 해제      
        $thispostGiftcon->on_trade = 0;     
        $thispostGiftcon->save();


        $thispost->delete();     //게시글 삭제


        return redirect()->action('GiftconTradePostController@index');

    }
}
