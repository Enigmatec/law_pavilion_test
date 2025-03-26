<?php

namespace App\Jobs;

use App\Actions\RefreshConsolidatedOrdersAction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RefreshConsolidatedOrdersJob implements ShouldQueue
{
    use Queueable;

    /**
     * Maximum job retries.
    */
    public $tries = 3;

    public $timeout = 900; // 15 minutes to avoid timeout

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        RefreshConsolidatedOrdersAction::handle();
    }
}
