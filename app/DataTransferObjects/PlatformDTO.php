<?php

namespace App\DataTransferObjects;

readonly class PlatformDTO
{
    public function __construct(
        public string $key
    ) {
    }
}
