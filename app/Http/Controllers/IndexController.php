<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mews\Captcha\Captcha;

class IndexController extends Controller
{
    //
    public function transferAccounts(Request $request,Captcha $captcha)
    {
        try{
            $captchaCode=$request->input('captcha');
            $address=$request->input('address');
            if($captcha->check($captchaCode)){
                dd($address);
            }
        }catch (\Exception $e){
            \Log::error($e->getMessage());
        }
    }
}
