<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coin extends Model
{
    use HasUuids;

    protected $fillable = [
        'key',
        'symbol',
        'name',
    ];

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'platform_coins')
            ->withPivot('contract_address');
    }
}
