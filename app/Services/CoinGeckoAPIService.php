<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CoinGeckoAPIService
{
    protected const API_KEY_HEADER_ATTRIBUTE_NAME = 'x-cg-pro-api-key';

    protected const INCLUDE_PLATFORM_REQUEST_ATTRIBUTE_NAME = 'include_platform';

    protected const DEFAULT_ERROR_MESSAGE = 'Something went wrong.';

    protected const COINS_LIST_PATH = '/coins/list';

    protected string $defaultURL;

    protected ?string $apiKey = null;

    public function __construct()
    {
        $this->defaultURL = config('coin_gecko.url');
        $this->apiKey = config('coin_gecko.api_key');
    }

    /**
     * Get error message from response or return default one.
     *
     * @param  Response  $response - response instance
     */
    protected function getResponseErrorMessage(Response $response): string
    {
        return $response->json('status.error_message') ?? self::DEFAULT_ERROR_MESSAGE;
    }

    /**
     * Return PendingRequest with set up headers.
     */
    protected function getHttpClient(): PendingRequest
    {
        $client = Http::acceptJson();

        if ($this->apiKey ?? false) {
            $client->withHeaders([self::API_KEY_HEADER_ATTRIBUTE_NAME => $this->apiKey]);
        }

        return $client;
    }

    /**
     * Fetch coins data. Throw Exception if error.
     *
     * @param  bool|null  $includePlatform flag to include platform contract addresses
     *
     * @throws Exception
     */
    public function getCoinsList(?bool $includePlatform = false): array
    {
        $response = $this->getHttpClient()
            ->get($this->defaultURL.self::COINS_LIST_PATH, [
                self::INCLUDE_PLATFORM_REQUEST_ATTRIBUTE_NAME => $includePlatform ? 'true' : 'false',
            ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new Exception($this->getResponseErrorMessage($response));
    }
}
