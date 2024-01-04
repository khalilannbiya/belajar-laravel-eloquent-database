<?php

namespace App\Models;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Customer extends Model
{
    use SoftDeletes;

    public $incrementing = false; // disabling the automatic incrementing behavior for the model's primary key
    protected $keyType = 'string'; // If your model's primary key is not an integer, you should define a protected $keyType property on your model

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class, 'customer_id', 'id');
    }

    public function virtualAccount(): HasOneThrough
    {
        return $this->hasOneThrough(VitualAccount::class, Wallet::class, 'customer_id', 'wallet_id', 'id', 'id');
    }
}
