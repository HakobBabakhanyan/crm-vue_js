<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * @Oa\Get(
     *      path="/api/incomes/invoices/index",
     *      tags={"incomes"},
     *      security={ {"auth": {} } },
     *      description="get index",
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(
     *             type="object",
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     */
    public function getNumber(){

        return response()
            ->json([
                'number'=>'INV-'.str_pad((Invoice::query()->max('id')+1), 5, '0', STR_PAD_LEFT)
            ]);
    }


    public function index(){
        return [
         'invoices'=> Invoice::query()->with('customer')->paginate()
        ];
    }

    public function show(Invoice $invoice){
        return [
          'invoice'=>$invoice->load(['invoiceItems'=>function($q){
              $q->with(['taxes','item']);
          },'currency','customer','category'])
        ];
    }

    public function create(Request $request){
        $data = $request->all();
        $validator = Validator::make($data['invoice'],[
            'currency_id'=>'integer|exists:currencies,id',
            'customer_id'=>'integer|exists:customers,id',
            'category_id'=>'integer|exists:invoice_categories,id',
            'items.*.item_id'=>'required|integer|exists:items,id',
            'items.*.tax.*'=>'exists:taxes,id',
            'invoice_number'=>'string|required',
            'order_number'=>'integer|required',
            'items.*'=>'required',
            'items.*.quantity'=>'required|integer',
            'items.*.tax'=>'array|nullable',
            'description'=>'required|string',
            'invoice_date'=>'required|date|before_or_equal:due_date',
            'due_date'=>'required|date|after_or_equal:invoice_date',
        ]);
        $validator->validate();

        Invoice::_save($request['invoice']);
        return [
            'message'=>'crated'
        ];
    }

    public function update(Request $request, Invoice $invoice){
        $data = $request->all();
        $validator = Validator::make($data['invoice'],[
            'currency_id'=>'integer|exists:currencies,id',
            'customer_id'=>'integer|exists:customers,id',
            'category_id'=>'integer|exists:invoice_categories,id',
            'invoice_number'=>'string|required',
            'order_number'=>'integer|required',
            'items.*'=>'required',
            'items.*.item_id'=>'required|integer|exists:items,id',
            'items.*.quantity'=>'required|integer',
            'items.*.tax'=>'array|nullable',
            'items.*.tax.*'=>'exists:taxes,id',
            'description'=>'required|string',
            'invoice_date'=>'required|date_format:d-m-Y|before_or_equal:due_date',
            'due_date'=>'required|date_format:d-m-Y|after_or_equal:invoice_date',
        ]);
        $validator->validate();

        Invoice::_save($request['invoice'],$invoice);
        return [
            'message'=>'update'
        ];
    }
}
