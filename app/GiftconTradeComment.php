<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftconTradeComment extends Model
{
    protected $guarded = [];

    //


    public function giftcons()
    {
        return $this->belongsToMany(Giftcon::class,'giftcon_giftcon_trade_comment','giftcon_trade_comment_id', 'giftcon_id' );
    }

    public function user()
    //$comment->post->user
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    //$comment->post->user
    {
        return $this->belongsTo(GiftconTradePost::class);
    }
}
