<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasUuids, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true;

    protected $fillable = ['name', 'voucher_code'];

    /**
     * Get the columns that should receive a unique identifier.
     * you may specify which columns should receive UUIDs by defining a uniqueIds method on the model
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['id', 'voucher_code'];
    }
}
