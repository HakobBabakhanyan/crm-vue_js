<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Customers;
use App\Models\Persons;
use Illuminate\Http\Request;

class CustomersController extends Controller
{

    const PAGINATE = 2;

    /**
     * @Oa\Get(
     *      path="/api/customers/get",
     *      tags={"customers"},
     *      security={ {"auth": {} } },
     *      description="get custumers",
     *      @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="number of page",
     *         required=false,
     *        @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Items()
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     */


    public function getCustomers(){
        $data=[
            'companies'=>Companies::query()->whereHas('customers')
                ->with('customers')->paginate(self::PAGINATE),
            'persons'=>Persons::query()->whereHas('customers')
                ->with('customers')->paginate(self::PAGINATE)
        ];
        return response()->json($data);
    }


    public function getCustomersCompanies(){
        $data=[
            'companies'=>Companies::query()->whereHas('customers')
                ->with('customers')->paginate(self::PAGINATE),
        ];

        return response()->json($data);
    }

    public function getCustomersPersons(){
        $data=[
            'persons'=>Persons::query()->whereHas('customers')
                ->with('customers')->paginate(self::PAGINATE),
        ];

        return response()->json($data);
    }

    public function create(Request $request){


        $customer =  Customers::_save($request->all());

        $data=[
            'message'=>'Created'
        ];
        return response()->json($data);
    }

    public function destroy(Customers $customer){

        $customer->delete();

        $data=[
            'companies'=>Companies::query()->whereHas('customers')
                ->with('customers')->paginate(self::PAGINATE),
            'persons'=>Persons::query()->whereHas('customers')
                ->with('customers')->paginate(self::PAGINATE),
            'message'=>'deleted'
        ];
        return response()->json($data);
    }


    public function getSelectsItems(Request $request){


        if(isset($request['type'])){
            $model = Customers::TYPE[$request['type']];
        }else $model = Companies::class;

        $data=[
            'items'=>$model::query()->doesntHave('customers')->get()
        ];

        return response()->json($data);
    }
}
