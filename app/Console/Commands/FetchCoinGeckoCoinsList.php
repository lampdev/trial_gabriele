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
    protected $signature = 'coin-gecko:get-coins {--include_platforms : Flag to include platform contract addresses (eg. 0x.... for Ethereum based tokens).}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch coins list from CoinGecko API and save it to database.';

    /**
     * Execute the console command.
     */
    public function handle(
        CoinGeckoAPIService $coinGeckoAPIService,
        CoinSavingService $coinSavingService

    ): void {
        $this->info('Fetching coins list from CoinGecko...');

        try {
            $coins = $coinGeckoAPIService->getCoinsList($this->option('include_platforms'));
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
