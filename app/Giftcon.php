<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Giftcon extends Model
{
    protected $guarded = [];

    protected $hidden = [
        'barcode',
        'imagepath',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }


    public function GiftconTradeComments()
    {
        return $this->belongsToMany(GiftconTradeComment::class, 'giftcon_giftcon_trade_comment', 'giftcon_id', 'giftcon_trade_comment_id')->withTimestamps();
    }


    
    public function GiftconTradePosts()
    {
        return $this->belongsTo(GiftconTradePost::class);
    }





    



    
}
