<?php

namespace App\Http\Controllers;

use App\Imports\ConsolidatedOrderImport;
use App\Imports\ValidateConsolidatedOrderImport;
use App\Models\ConsolidatedOrder;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class ImportConsolidatedOrderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate(['file' => ['required', 'file', 'mimes:xlsx', 'max:2048']]);

        // To avoid validation error in the queue whcih could lead to failure
        if($errorMessage = $this->validateFileFieldBeforeProcessing($request->file)){
            abort(422, $errorMessage);
        }

        //resetting the facade so it has to rebuild the Excel dependency putting it back in a state that can be serialized.
        Excel::clearResolvedInstances();
       
        Excel::import(new ConsolidatedOrderImport, $request->file);
        return response()->json(['message' => "File Importing"]);
    }

    function validateFileFieldBeforeProcessing($file){
        // Read the file and convert it to an array
        $rows = Excel::toArray(new ValidateConsolidatedOrderImport, $file)[0];
    
        $data = ['data' => $rows];

        $messages = [
            'data.*.id.required' => "There was an error on row :index. The id field is required.",
            'data.*.id.exists' => "There was an error on row :index. The id field is not a valid consolidated_orders table id.",

            'data.*.order_id.required' => "There was an error on row :index. The order_id field is required.",
            'data.*.order_id.exists' => "There was an error on row :index. The id field is not a valid orders table id.",

            'data.*.customer_id.required' => "There was an error on row :index. The customer_id field is required.",
            'data.*.customer_id.exists' => "There was an error on row :index. The id field is not a valid customers table id.",

            'data.*.customer_name.required' => "There was an error on row :index. The customer_name field is required.",
            'data.*.customer_email.required' => "There was an error on row :index. The customer_email field is required.",

            'data.*.customer_email.exists' => "There was an error on row :index. The id field is not a valid customers table email.",
            'data.*.customer_email.email' => "There was an error on row :index. The email provided is not a valid email address.",

            'data.*.product_id.required' => "There was an error on row :index. The product_id field is required.",
            'data.*.product_id.exists' => "There was an error on row :index. The id field is not a valid products table id.",

            'data.*.product_name.required' => "There was an error on row :index. The product_name field is required.",
            'data.*.product_name.exists' => "There was an error on row :index. The id field is not a valid products table name.",

            'data.*.sku.required' => "There was an error on row :index. The sku field is required.",
            'data.*.sku.exists' => "There was an error on row :index. The sku field is not a valid products table sku.",

            'data.*.quantity.required' => "There was an error on row :index. The quantity field is required.",
            'data.*.quantity.numeric' => "There was an error on row :index. The quantity field must be a number.",

            'data.*.item_price.required' => "There was an error on row :index. The item_price field is required.",
            'data.*.item_price.decimal' => "There was an error on row :index. The item_price field must be a number.",

            'data.*.line_total.required' => "There was an error on row :index. The line_total field is required.",
            'data.*.line_total.decimal' => "There was an error on row :index. The line_total field must be a decimal number.",

            'data.*.order_date.required' => "There was an error on row :index. The order_date field is required.",
            'data.*.order_date.decimal' => "There was an error on row :index. The order_date field must be a datetime",

            'data.*.order_status.required' => "There was an error on row :index. The order_status field is required.",
            'data.*.order_status.exists' => "There was an error on row :index. The order_status field is not a valid orders table status.",

            'data.*.order_total.required' => "There was an error on row :index. The order_total field is required.",
            'data.*.order_total.decimal' => "There was an error on row :index. The order_total field must be a datetime",
        ];

        $validator = Validator::make($data, [
            'data.*.id' => ['required', Rule::exists(ConsolidatedOrder::class, 'id')],
            'data.*.order_id' => ['required', Rule::exists(Order::class, 'id')],
            'data.*.customer_id' => ['required', Rule::exists(Customer::class, 'id')],
            'data.*.customer_name' => ['required', 'string'],
            'data.*.customer_email' => ['required', 'email:filter', Rule::exists(Customer::class, 'email')],
            'data.*.product_id' => ['required', Rule::exists(Product::class, 'id')],
            'data.*.product_name' => ['required', Rule::exists(Product::class, 'name')],
            'data.*.sku' => ['required', Rule::exists(Product::class, 'sku')],
            'data.*.quantity' => ['required', 'numeric'],
            'data.*.item_price' => ['required', 'numeric'],
            'data.*.line_total' => ['required', 'numeric'],
            'data.*.order_date' => ['required'],
            'data.*.order_status' => ['required', Rule::exists(Order::class, 'status')],
            'data.*.order_total' => ['required', 'numeric'],
        ],  $messages);

        if ($validator->stopOnFirstFailure()->fails()) {
            return $validator->errors()->first(); // Get the first error message
        }

    }
}
