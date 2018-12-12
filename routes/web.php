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
use Carbon\Carbon;
Route::get('/', function () {
    return view('index');
});
Route::any('captcha', function()
{
    return captcha_src();
})->middleware('web');
Route::any('/TransferAccounts','IndexController@transferAccounts')->middleware('web');
Route::get('/queue',function (){
   dispatch(new \App\Jobs\TransferAccounts())->delay(Carbon::now()->addRealMinutes(1));
   dd(222);
});
Route::get('q','IndexController@store');