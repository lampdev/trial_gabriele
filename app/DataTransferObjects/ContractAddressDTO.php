<?php

namespace App\DataTransferObjects;

readonly class ContractAddressDTO
{
    public function __construct(
        public string $platformKey,
        public string $coinKey,
        public ?string $contractAddress = null,
    ) {
    }
}
