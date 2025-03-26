<?php

namespace App\Exports;

use App\Models\ConsolidatedOrder;
use App\Notifications\ExportReady;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ConsolidatedOrderExport implements FromQuery, WithHeadings, ShouldQueue
{
    use Exportable;

    private array $column_names;

    function __construct()
    {
        $this->column_names = [
            'id',
            'order_id',
            'customer_id',
            'customer_name',
            'customer_email',
            'product_id',
            'product_name', 
            'sku', 
            'quantity', 
            'item_price', 
            'line_total', 
            'order_date', 
            'order_status', 
            'order_total'
        ];
    }

    public function query()
    {
        return ConsolidatedOrder::query()->select($this->column_names)->latest();
    }

    public function headings(): array
    {
        return $this->column_names;
    }

  
}
