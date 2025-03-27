<?php

namespace App\Jobs;

use App\Notifications\ExportReady;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Notification;

class NotifyUserOfCompletedExport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $email)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::route('mail', [
            $this->email =>  config('app.name')
        ])->notify(new ExportReady());
    }
}
