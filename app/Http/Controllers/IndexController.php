<?php

namespace App\Http\Controllers;

use App\Jobs\SendReminderEmail;
use App\Jobs\TransferAccounts;
use App\Models\TransactionRecord;
use App\User;
use Illuminate\Http\Request;
use Mews\Captcha\Captcha;

class IndexController extends Controller
{
    //
    public function transferAccounts(Request $request,Captcha $captcha)
    {
        try{
            $captchaCode=$request->input('captcha');

            $toAddress=$request->input('toAddress');

            $uniqid=uniqid();

            if(!$toAddress){
                return ['code'=>400,'message'=>'请填写地址'];
            }
            if( $toAddress[0] !== "P"  || !(preg_match('/^(1|3)[a-zA-Z\d]{24,33}$/', substr($toAddress,1)) && preg_match('/^[^0OlI]{25,34}$/', substr($toAddress,1)))){
                return ['code'=>400,'message'=>'您填写的地址不合法，请重新添加'];
            }
            if(!$captcha->check($captchaCode)){

                return ['code'=>400,'message'=>'验证码错误,修改之后请重新提交'];
            }


            //入库

            $data=TransactionRecord::addTransactionRecord(['uniqid'=>$uniqid,'from_address'=>config('palletone.fromaddress'),'to_address'=>$toAddress,'created_at'=>date('Y-m-d H:i:s')]);

            //放入消息队列

            $this->dispatch(new TransferAccounts($uniqid,$toAddress));

            return ['code'=>200,'uniqid'=>$uniqid];
        }catch (\Exception $e){
            \Log::error($e->getMessage());
        }
    }

    public function getTransferRecord(Request $request)
    {
        try{
            $uniqid=$request->input('uniqid');
            $data=TransactionRecord::getTransactionRecord($uniqid);

            return $data;
        }catch (\Exception $e){
            \Log::error($e->getMessage());
        }
    }

}
