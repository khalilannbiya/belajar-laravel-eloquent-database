<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wallet extends Model
{
    // use HasFactory;

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function virtualAccount(): HasOne
    {
        return $this->hasOne(VitualAccount::class, 'wallet_id', 'id');
    }
}
