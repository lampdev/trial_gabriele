<?php

namespace App\Services;

use App\DataTransferObjects\CoinDTO;
use App\Models\Coin;
use Illuminate\Support\Collection;

class CoinSavingService
{
    public function __construct(
        protected ContractAddressSavingService $contractAddressSavingService,
    ) {
    }

    public function saveCoin(CoinDTO $coinDTO): Coin
    {
        $coin = Coin::firstOrNew(['key' => $coinDTO->key]);

        $coin->fill([
            'symbol' => $coinDTO->symbol,
            'name' => $coinDTO->name,
        ]);

        $coin->save();

        if (count($coinDTO->contractAddresses)) {
            $this->contractAddressSavingService->saveMany(
                $coin,
                ...$coinDTO->contractAddresses
            );
        }

        return $coin;
    }

    public function saveManyCoins(array $coins): Collection
    {
        $result = collect();

        foreach ($coins as $coinDTO) {
            if (! $coinDTO instanceof CoinDTO) {
                continue;
            }

            $result->push($this->saveCoin($coinDTO));
        }

        return $result;
    }
}
