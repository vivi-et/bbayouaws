<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('board_name');
            $table->string('board_korname');
            $table->integer('board_auth')->default(1); // 1 공개 0 관리자만
            $table->timestamps();
        });

        DB::table('boards')->insert([

            ['board_name' => 'free', 'board_korname' => '자유게시판',  'created_at' => now(), 'updated_at' => now(),],
            ['board_name' => 'humor', 'board_korname' => '유머게시판',  'created_at' => now(), 'updated_at' => now(),],
            ['board_name' => 'game', 'board_korname' => '게임게시판',  'created_at' => now(), 'updated_at' => now(),],
            ['board_name' => 'sport', 'board_korname' => '스포츠게시판',  'created_at' => now(), 'updated_at' => now(),],


        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
