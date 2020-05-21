<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class GiftconTradePost extends Model
{
    protected $guarded = [];
    use Searchable;

    //
    public function giftcon()
    {
        return $this->hasMany(Giftcon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(GiftconTradeComment::class);
    }
}
