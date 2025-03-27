<?php

namespace App\Console\Commands;

use App\Jobs\RefreshConsolidatedOrdersJob;
use Illuminate\Console\Command;

class RefreshConsolidatedOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'refresh:consolidated-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        RefreshConsolidatedOrdersJob::dispatch();
    }
}
