<?php

namespace App\DataTransferObjects;

readonly class CoinDTO
{
    public function __construct(
        public string $key,
        public string $symbol,
        public string $name,
        public ?array $platforms = null
    ) {
    }

    public static function fromCoinGeckoCoinsRequest(array $attributes): CoinDTO
    {
        $assignedPlatforms = null;

        if (isset($attributes['platforms']) && is_array($attributes['platforms'])) {
            $assignedPlatforms = array_map(
                fn ($platformKey, $contractAddress) => new CoinPlatformDTO(
                    $attributes['id'],
                    $platformKey,
                    $contractAddress
                ),
                array_keys($attributes['platforms']),
                array_values($attributes['platforms'])
            );
        }

        return new CoinDTO(
            $attributes['id'],
            $attributes['symbol'],
            $attributes['name'],
            $assignedPlatforms
        );
    }
}
