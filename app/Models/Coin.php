<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coin extends Model
{
    use HasUuids;

    protected $fillable = [
        'key',
        'symbol',
        'name',
    ];

    public function contractAddresses(): HasMany
    {
        return $this->hasMany(ContractAddress::class);
    }
}
