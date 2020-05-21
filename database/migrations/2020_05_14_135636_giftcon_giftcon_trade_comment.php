<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GiftconGiftconTradeComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giftcon_giftcon_trade_comment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('giftcon_id');
            $table->bigInteger('giftcon_trade_comment_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('giftcon_giftcon_trade_comment');
    }
}
