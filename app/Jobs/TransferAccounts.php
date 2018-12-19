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
    public function __construct($uniqid)
    {
        //
        $this->uniqid=$uniqid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        \Log::info($this->uniqid);
        TransactionRecord::where('uniqid',$this->uniqid)->update(['data'=>$this->uniqid]);
    }
}
