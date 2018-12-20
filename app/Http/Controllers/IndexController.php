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

            $fromAddress=$request->input('fromAddress');

            $toAddress=$request->input('toAddress');

            $uniqid=uniqid();

            if(!$fromAddress || !$toAddress){
                return ['code'=>400,'message'=>'请填写地址'];
            }
            if($fromAddress[0] !== "P" || $toAddress[0] !== "P"){
                return ['code'=>400,'message'=>'您填写的地址不合法，请重新添加'];
            }
            if(!$captcha->check($captchaCode)){

                return ['code'=>400,'message'=>'验证码错误,修改之后请重新提交'];
            }


            //入库

            $data=TransactionRecord::addTransactionRecord(['uniqid'=>$uniqid,'from_address'=>$fromAddress,'to_address'=>$toAddress,'created_at'=>date('Y-m-d H:i:s')]);

            //放入消息队列

            $this->dispatch(new TransferAccounts($uniqid,$fromAddress,$toAddress));

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
