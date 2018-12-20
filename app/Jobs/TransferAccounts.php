<?php

namespace App\Jobs;

use App\Models\TransactionRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TransferAccounts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $uniqid;
    public $fromAddress;
    public $toAddress;
    public function __construct($uniqid,$fromAddress,$toAddress)
    {
        //
        $this->uniqid=$uniqid;
        $this->fromAddress=$fromAddress;
        $this->toAddress=$toAddress;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        try{
            \Log::info($this->uniqid);

            $postData=["jsonrpc"=>"2.0",
                "method"=>"wallet_getPtnTestCoin",
                "params"=>["$this->fromAddress","$this->toAddress","10","1",10],
                "id"=>1
            ];
            $postData=json_encode($postData);
            \Log::info($postData);
            $data=$this->http_request("http://124.251.111.61:8545",$postData);

            TransactionRecord::where('uniqid',$this->uniqid)->update(['data'=>$data,'updated_at'=>date('Y-m-d H:i:s')]);

        }catch (\Exception $e){
            \Log::error($e->getMessage());
        }
    }

    public function http_request($url, $data_string = null)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
            "Content-Length: " . strlen($data_string)
        ));

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return  curl_error($ch);
        }
        curl_close($ch);
        return  $result;
    }
}
