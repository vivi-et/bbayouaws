<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftconTradePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giftcon_trade_posts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('giftcon_id');
            $table->text('giftcon_title');
            $table->bigInteger('user_id');
            $table->boolean('traded')->default(0);
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
        Schema::dropIfExists('giftcon_trade_posts');
    }
}
