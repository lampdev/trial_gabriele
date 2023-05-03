<?php

namespace App\Services;

use App\DataTransferObjects\ContractAddressDTO;
use App\Models\Coin;
use App\Models\ContractAddress;
use Illuminate\Support\Collection;

class ContractAddressSavingService
{
    public function __construct(
        protected PlatformSavingService $platformSavingService
    ) {
    }

    public function saveContractAddress(
        Coin $coin,
        ContractAddressDTO $contractAddressDTO
    ): ContractAddress {
        $platform = $this->platformSavingService->findOrCreateByKey($contractAddressDTO->platformKey);

        $contractAddress = ContractAddress::firstOrNew([
            'coin_id' => $coin->id,
            'platform_id' => $platform->id,
        ]);

        $contractAddress->coin()->associate($coin);
        $contractAddress->platform()->associate($platform);

        $contractAddress->fill([
            'contract_address' => $contractAddressDTO->contractAddress,
        ]);

        $contractAddress->save();

        return $contractAddress;
    }

    public function saveMany(
        Coin $coin,
        ContractAddressDTO ...$contractAddressDTOArray
    ): Collection {
        $result = collect();

        foreach ($contractAddressDTOArray as $contractAddressDTO) {
            $result->push($this->saveContractAddress($coin, $contractAddressDTO));
        }

        return $result;
    }
}
