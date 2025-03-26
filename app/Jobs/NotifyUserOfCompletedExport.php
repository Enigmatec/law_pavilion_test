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
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Notification::route('mail', [
            config('services.export_notification.recipient_email') =>  config('services.export_notification.recipient_name')
        ])->notify(new ExportReady());
    }
}
