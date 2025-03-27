<?php


namespace App\Actions;

use App\Exports\ConsolidatedOrderExport;
use App\Jobs\NotifyUserOfCompletedExport;

class ExportConsolidatedAction {

    static function  handle($email){
        (new ConsolidatedOrderExport)->queue('consolidated_order.xlsx')->chain([
            new NotifyUserOfCompletedExport($email),
        ]);
    }
}