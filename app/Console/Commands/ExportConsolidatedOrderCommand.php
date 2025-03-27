<?php

namespace App\Console\Commands;

use App\Actions\ExportConsolidatedAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class ExportConsolidatedOrderCommand extends Command 
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:consolidated-order {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Consolidated Orders table data to excel file and send it to the provided email addressphp';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->ask('Provide the email address to recieve the mail containing the exported file?');

        $validator = Validator::make(
            ['email' => $email],
            ['email' => 'required|email:filter']
        );

        // Handle validation failure
        if ($validator->fails()) {
            $this->error('Provide a valid email address');
            return 1; // Return error code
        }

        ExportConsolidatedAction::handle($email);

        $this->info('You will receive a mail after the file generating is completed');

    }

}
