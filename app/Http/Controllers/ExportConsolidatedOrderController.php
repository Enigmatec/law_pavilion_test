<?php

namespace App\Http\Controllers;

use App\Actions\ExportConsolidatedAction;
use App\Exports\ConsolidatedOrderExport;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Http\Request;


class ExportConsolidatedOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(['email' => ['required', 'email:filter']]);

        ExportConsolidatedAction::handle($request->email);

        return response()->json(['message' => "Excel File Generating: You will be mailed the excel file after generating is completed"]);

    }
}
