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
    public function store(Request $request)
    {
        $users=User::where('id','>',24)->get();
        foreach ($users as $user){
            \Log::info($user->email);
            $this->dispatch(new SendReminderEmail($user));
        }
        return 'Done';
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

    public  function request_post($url = '', $post_data = array()) {
        if (empty($url) || empty($post_data)) {
            return false;
        }

        $o = "";
        foreach ( $post_data as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);

        $postUrl = $url;
        $curlPost = $post_data;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        return $data;
    }
    public function testAction(){
        $url = 'http://mobile.jschina.com.cn/jschina/register.php';
        $post_data['appid']       = '10';
        $post_data['appkey']      = 'cmbohpffXVR03nIpkkQXaAA1Vf5nO4nQ';
        $post_data['member_name'] = 'zsjs124';
        $post_data['password']    = '123456';
        $post_data['email']    = 'zsjs124@126.com';
        //$post_data = array();
        $res = $this->request_post($url, $post_data);
        dd($res);

    }
}
