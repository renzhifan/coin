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
use Mews\Captcha\Captcha;
Route::get('/', function () {
    return captcha();
//    return view('index');
});
Route::any('captcha-test', function(\Illuminate\Http\Request $request ,Captcha $captcha)
{
    dd($captcha->check('dmfny'));
    dd( $request->session()->all());

   return captcha();
})->middleware('web');
