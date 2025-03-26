<?php

namespace App\Imports;

use App\Models\ConsolidatedOrder;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ValidateConsolidatedOrderImport implements  WithHeadingRow
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
}
