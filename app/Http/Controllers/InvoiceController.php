<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

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
         'invoices'=> Invoice::query()->paginate()
        ];
    }

    public function show(Invoice $invoice){
        return [
          'invoice'=>$invoice->load(['invoiceItems'=>function($q){
              $q->with(['taxes','item']);
          },'currency','customer'])
        ];
    }

    public function create(Request $request){
        Invoice::_save($request['invoice']);
        return [
            'message'=>'crated'
        ];
    }
}
