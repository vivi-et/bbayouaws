<?php

namespace App\Http\Controllers;

use App\GiftconTradeComment;
use Illuminate\Support\Facades\Auth;
use App\Giftcon;
use App\GiftconTradePost;
use App\giftcon_comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GiftconTradeCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $getThis = $request->this;  //이걸 팝니다 Post
        $for = $request->for;       //이걸로 삽니다 Comment

        for ($i = 0; $i < count($for); $i++) {

            $item = Giftcon::find($for[$i]);
            $item->on_trade = 1;
            $item->save();
        }


        $comment = GiftconTradeComment::create([
            'user_id' => Auth::user()->id,
            'giftcon_trade_post_id' => $request->post_id,
            'traded' => 0,
        ]);


        $comment->giftcons()->attach($for);



        // 해야할것
        // GiftconTradeComment 생성
        // 주인 Giftcon 의 on trade 처리
        // 코멘트로 제시된 Giftcon 들의 on trade 처리


        // for ($i = 0; $i < count($for); $i++) {
        //     giftcon_comment::create([
        //         'giftcon_id' => $for[$i],
        //         'giftcon_trade_comment_id' => $comment->id,

        //     ]);
        // }

        return response()->json([
            'message' => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GiftconTradeComment  $giftconTradeComment
     * @return \Illuminate\Http\Response
     */
    public function show(GiftconTradeComment $giftconTradeComment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GiftconTradeComment  $giftconTradeComment
     * @return \Illuminate\Http\Response
     */
    public function edit(GiftconTradeComment $giftconTradeComment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GiftconTradeComment  $giftconTradeComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GiftconTradeComment $tradecomment)
    {

        //게시글 (게시글 기프티콘 -> 댓글 작성자)
        $thispost = GiftconTradePost::find($request->thispostid);           //이 게시글


        $othercommentGiftcons = GiftconTradeComment::with('giftcons')       //거래된 댓글외 나머지 댓글들 처리
            ->where('id', '!=', $tradecomment->id)                          //거래된 댓글이 아니고
            ->where('giftcon_trade_post_id', '=', $thispost->id)            //이 게시글에 달린 댓글들 불러오기
            ->get();

            // 채택된 댓글 외 나머지 댓글들 거래중 상태 해제 및 댓글 삭제
        foreach ($othercommentGiftcons as $othercommentGiftcon) {       //채택된 댓글을 제와한 나머지 댓글들

            foreach ($othercommentGiftcon->giftcons as $eachGiftcon) {  //그 댓글들의 기프티콘들
                $eachGiftcon->on_trade = 0;                             //거래상태 해제
                $eachGiftcon->save();                                   //저장
            }
            $othercommentGiftcon->giftcons()->detach($othercommentGiftcon->giftcons);   //pivot table에서 삭제
            $othercommentGiftcon->delete();                                             //댓글 삭제
        }
        


        $thispostGiftcon = Giftcon::find($thispost->giftcon_id)->first();   //이 게시글의 기프티콘
        $thispostGiftcon->user_id = $tradecomment->user_id;                 //소유자 바꿈 (to 댓글 작성자)
        $thispostGiftcon->on_trade = 0;                                     //현재 교환중 상태 해제
        $thispost->traded = 1;                                              //교환 완료 처리
        $thispost->save();
        $thispostGiftcon->save();

        //댓글 (댓글 기프티콘 -> 게시글 작성자)
        $hasTheseGiftcons = $tradecomment->giftcons;    // 이 댓글의 기프티콘들
        $tradecomment->traded = 1;                      // 댓글의 교환완료처리   
        $tradecomment->save();


        foreach ($hasTheseGiftcons as $item) {          //거래 완료된 댓글의 기프티콘들 처리
            $item->user_id = $thispost->user_id;        //거래된 댓글의 기프티콘의 소유권 이전 
            $item->on_trade = 0;                        //거래중 상태 해지
            $item->save();
        }



        // foreach($othercommentGiftcons as $othercommentGiftcon){
        //     $othercommentGiftcon->on_trade = 0;

        //     $othercommentGiftcon->save();
        // }




        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GiftconTradeComment  $giftconTradeComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(GiftconTradeComment $tradecomment)
    {
        // $arraycomments = GiftconTradeComment::with('giftcons')
        // ->where('giftcon_trade_post_id', '=', $thispost->id)->get();


        $hasTheseGiftcons = $tradecomment->giftcons;


        foreach ($hasTheseGiftcons as $item) {
            $item->on_trade = 0;
            $item->save();
        }


        $tradecomment->giftcons()->detach($hasTheseGiftcons); // pivot 삭제
        $tradecomment->delete(); // comment 삭제


        // $giftconTradeComment->giftcons()->attach($for);
        return redirect()->back();
    }
}
