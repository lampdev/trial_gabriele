<?php

namespace App\Services;

use App\Models\Platform;

class PlatformSavingService
{
    public function findOrCreateByKey(string $platformKey): Platform
    {
        return Platform::firstOrCreate([
            'key' => $platformKey,
        ]);
    }
}
