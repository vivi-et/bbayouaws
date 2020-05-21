<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giftcons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('expire_date');
            $table->integer('orderno');
            $table->string('place');
            $table->string('imagepath');
            $table->date('recieved_date')->nullable()->default(null);
            //0 사용안함 1 사용함 2 미기재
            $table->integer('used');
            $table->boolean('on_trade')->default(0);
            $table->string('barcode');
            $table->timestamp('used_on')->nullable()->default(null);
            $table->bigInteger('user_id');
            // $table->bigInteger('user_name');
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
        Schema::dropIfExists('giftcons');
    }
}
