<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['web']], function () {

    //首页路由
    Route::get('/', function () {
        return view('index');
    });
    //获取验证码
    Route::any('captcha', function()
    {
        return captcha_src();
    });
    //提交转币
    Route::any('/TransferAccounts','IndexController@transferAccounts');
    //通过唯一标识获取api的处理结果
    Route::any('/getTransferRecord','IndexController@getTransferRecord');

    Route::any('/q','IndexController@store');

    Route::get('/test','IndexController@testAction');

});

