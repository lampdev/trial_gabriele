<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    use HasUuids;

    protected $fillable = [
        'key',
    ];

    public function coins(): BelongsToMany
    {
        return $this->belongsToMany(Coin::class, 'platform_coins')
            ->withPivot('contract_address');
    }
}
