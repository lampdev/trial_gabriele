<?php

namespace App\Services;

use App\DataTransferObjects\CoinDTO;
use App\Models\Coin;
use Illuminate\Support\Collection;

class CoinSavingService
{
    public function __construct(
        private readonly PlatformSavingService $platformSavingService
    ) {
    }

    public function attachPlatforms(Coin $coin, CoinDTO $coinDTO): void
    {
        if (! isset($coinDTO->platforms)) {
            return;
        }

        $syncPlatforms = [];

        foreach ($coinDTO->platforms as $coinPlatformDTO) {
            $platform = $this->platformSavingService->findOrCreateByKey($coinPlatformDTO->platformKey);

            $syncPlatforms[$platform->id] = ['contract_address' => $coinPlatformDTO->contractAddress];
        }

        $coin->platforms()->sync($syncPlatforms);
    }

    public function saveCoin(CoinDTO $coinDTO): Coin
    {
        $coin = Coin::firstOrNew(['key' => $coinDTO->key]);

        $coin->fill([
            'symbol' => $coinDTO->symbol,
            'name' => $coinDTO->name,
        ]);

        $coin->save();
        $this->attachPlatforms($coin, $coinDTO);

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
