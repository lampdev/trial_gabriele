<?php

namespace App\DataTransferObjects;

readonly class CoinDTO
{
    public function __construct(
        public ?string $id,
        public string $key,
        public string $symbol,
        public string $name,
        public array $contractAddresses = []
    ) {
    }

    public static function fromCoinGeckoCoinsRequest(array $attributes): CoinDTO
    {
        $contractAddresses = [];

        if (isset($attributes['platforms']) && is_array($attributes['platforms'])) {
            $contractAddresses = array_map(
                fn ($platformKey, $contractAddress) => new ContractAddressDTO(
                    $platformKey,
                    $attributes['id'],
                    $contractAddress
                ),
                array_keys($attributes['platforms']),
                array_values($attributes['platforms'])
            );
        }

        return new CoinDTO(
            null,
            $attributes['id'],
            $attributes['symbol'],
            $attributes['name'],
            $contractAddresses
        );
    }
}
