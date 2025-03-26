<?php

namespace App\Imports;

use App\Models\ConsolidatedOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class ConsolidatedOrderImport implements ToModel, WithUpserts, WithHeadingRow, WithBatchInserts, WithChunkReading, ShouldQueue
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ConsolidatedOrder([
            'id' => $row['id'],
            'order_id' => $row['order_id'],
            'customer_id' => $row['customer_id'],
            'customer_name' => $row['customer_name'],
            'customer_email' => $row['customer_email'],
            'product_id' => $row['product_id'],
            'product_name' => $row['product_name'],
            'sku' => $row['sku'],
            'quantity' => $row['quantity'],
            'item_price' => $row['item_price'],
            'line_total' => $row['line_total'],
            'order_date' => $row['order_date'],
            'order_status' => $row['order_status'],
            'order_total' => $row['order_total']
        ]);
    }

    public function uniqueBy()
    {
        return 'id';
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

 
}
