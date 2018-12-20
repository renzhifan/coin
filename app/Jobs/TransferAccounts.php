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

            $postData=['jsonrpc'=>'2.0',
                'method'=>'wallet_createPaymentTx',
                'params'=>[$this->fromAddress,$this->toAddress,config('palletone.password'),config('palletone.limit')],
                'id'=>1
            ];
            $postData=json_encode($postData);
            \Log::info($postData);

            TransactionRecord::where('uniqid',$this->uniqid)->update(['data'=>$this->uniqid,'updated_at'=>date('Y-m-d H:i:s')]);

        }catch (\Exception $e){
            \Log::error($e->getMessage());
        }
    }

    public function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
}
