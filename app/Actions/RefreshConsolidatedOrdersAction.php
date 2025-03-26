<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RefreshConsolidatedOrdersAction {

    public static function handle()
    {
        $batchSize = 10000; // Process in batches

        Log::info('🚀 Refreshing consolidated_orders table...');

         // ✅ Create a temporary table to avoid downtime
        DB::statement('CREATE TABLE consolidated_orders_temp LIKE consolidated_orders');

        // Step 2: Insert new data in chunks
        DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select([
                'customers.id as customer_id',
                'customers.name as customer_name',
                'customers.email as customer_email',
                'orders.id as order_id',
                'orders.order_date',
                'orders.status as order_status',
                'orders.total_amount as order_total',
                'products.id as product_id',
                'products.name as product_name',
                'products.sku',
                'order_items.quantity',
                'order_items.price as item_price',
                DB::raw('(order_items.quantity * order_items.price) AS line_total')
            ])
            ->orderBy('order_items.id', 'desc') 
            ->chunk($batchSize, function ($rows) {
                $data = json_decode(json_encode($rows), true);
                DB::table('consolidated_orders_temp')->insert($data);
            });

         // ✅ Swap tables instantly (Minimizes downtime)
        DB::statement('RENAME TABLE consolidated_orders TO consolidated_orders_old, consolidated_orders_temp TO consolidated_orders');
        DB::statement('DROP TABLE consolidated_orders_old');

        Log::info('✅ consolidated_orders table refreshed successfully.');
    }

}