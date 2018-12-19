<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionRecord extends Model
{
    //
    protected $table = 'transaction_record';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $guarded = [];

    public static function addTransactionRecord($attributes)
    {
        return static::create($attributes);
    }
    public static function getTransactionRecord($uniqid)
    {
        return static :: query()->select('data')->where('uniqid',$uniqid)->get()->toArray();
    }

}
