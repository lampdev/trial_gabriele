<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractAddress extends Model
{
    use HasUuids;

    protected $fillable = [
        'contract_address',
    ];

    public function coin(): BelongsTo
    {
        return $this->belongsTo(Coin::class);
    }

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }
}
