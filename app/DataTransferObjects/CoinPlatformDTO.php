<?php

namespace App\DataTransferObjects;

readonly class CoinPlatformDTO
{
    public function __construct(
        public string $coinKey,
        public string $platformKey,
        public ?string $contractAddress,
    ) {
    }
}
