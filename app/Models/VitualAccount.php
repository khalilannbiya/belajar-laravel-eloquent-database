<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VitualAccount extends Model
{
    use HasFactory;

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }
}
