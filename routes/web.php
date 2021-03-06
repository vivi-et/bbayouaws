<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\GiftconTradePostController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//         return view('welcome');
//     });

// Route::group(['middleware' => 'guest'], function() {
    
//     Route::get('/login/github', 'Auth\LoginController@gitgub');
//     Route::get('/login/github/redirect', 'Auth\LoginController@gitgubRedirect');
// });

// Route::get('/social/{provider}', [
//     'as' => 'social.login',
//     'uses' => 'Auth\SocialController@execute',
// ]);

Auth::routes();



Route::get('/login/{provider}', ['as' => 'redirect', 'uses' => 'Auth\LoginController@redirectToProvider']);
Route::get('/login/{provider}/callback', ['as' => 'callback', 'uses' => 'Auth\LoginController@handleProviderCallback']);

Route::post('/settings/authenticate','SettingController@authenticate');
// Route::get('/{giftcon}', 'TestController@show')->name('test');
Route::get('/mypage/trades', 'MyPageController@mytrades' );
Route::get('/mypage/posts', 'MyPageController@myposts' );
Route::get('/test', 'TestController@index')->name('test');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/giftcon/mygiftcons', 'GiftconController@mygiftcons');
Route::get('/giftcon/search/{string}', 'GiftconController@search');
Route::post('/giftcon/present', 'GiftconController@presentGiftcon');
Route::post('/ajax/saveImage', 'AjaxUploadController@saveImage')->name('ajax.saveImage');
Route::post('/ajax/makeTrade', 'AjaxUploadController@makeTrade')->name('ajax.makeTrade');
Route::post('/giftcon/action', 'AjaxUploadController@action')->name('ajaxupload.action');
Route::post('/giftcon/crop', 'AjaxUploadController@crop')->name('ajaxupload.crop');
Route::post('/comment/make/{post}', 'CommentController@store');

Route::get('/board/{board}/search/{string}', 'BoardController@search');

Route::get('/board/{board}', 'BoardController@index');
Route::get('/post/create/{board}', 'PostController@create');
Route::post('/post/{post}/upvote', 'PostController@upvote');
Route::post('/post/{post}/downvote', 'PostController@downvote');

// 내 계정설정 /settings
Route::get('/settings', 'SettingController@index');
Route::get('/settings/panel','SettingController@panel');
Route::DELETE('/settings/panel/delete/{user}','SettingController@destroy');
Route::put('/settings/panel/changename/{user}','SettingController@changename');
Route::put('/settings/panel/changepass/{user}','SettingController@changepass');
// Route::resource('/settings', 'SettingController');

//사용자


// Route::get('/giftcon/trade/{$trade}', 'GiftconTradePostController@show');
Route::resource('/giftcon/trade', 'GiftconTradePostController');
Route::resource('/giftcon/tradecomment', 'GiftconTradeCommentController');
// Route::resource('/giftcon/tradecommentaccept', 'GiftconTradeCommentController@accept');
Route::resource('/comment', 'CommentController');
Route::resource('/post', 'PostController');
Route::resource('/giftcon', 'GiftconController');


Route::get('/logout', 'SessionController@destroy');
Route::post('/logout', 'SessionController@destroy');
