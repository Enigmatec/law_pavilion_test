<?php

namespace App\Http\Controllers;

use App\Exports\ConsolidatedOrderExport;
use App\Jobs\NotifyUserOfCompletedExport;
use App\Notifications\ExportReady;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class ExportConsolidatedOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(['email' => ['required', 'email:filter']]);

        (new ConsolidatedOrderExport)->queue('consolidated_order.xlsx')->chain([
            new NotifyUserOfCompletedExport($request->email),
        ]);

        return response()->json(['message' => "Excel File Generating: You will be mailed the excel file after generating is completed"]);

    }
}
