<?php

namespace App\Console\Commands;

use App\DataTransferObjects\CoinDTO;
use App\Services\CoinGeckoAPIService;
use App\Services\CoinSavingService;
use Exception;
use Illuminate\Console\Command;

class FetchCoinGeckoCoinsList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'coin-gecko:get-coins';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(
        CoinGeckoAPIService $coinGeckoAPIService,
        CoinSavingService $coinSavingService

    ): void {
        $this->info('Fetching coins list from CoinGecko...');

        try {
            $coins = $coinGeckoAPIService->getCoinsList(true);
        } catch (Exception $exception) {
            $this->error($exception->getMessage());

            return;
        }

        $this->info('Mapping data...');

        $coins = array_map(
            fn ($coinData) => CoinDTO::fromCoinGeckoCoinsRequest($coinData),
            $coins
        );

        $this->info('Saving data to database...');

        $coinSavingService->saveManyCoins($coins);

        $this->info('Success!');
    }
}
