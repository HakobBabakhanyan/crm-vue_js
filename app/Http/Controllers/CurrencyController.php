<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    /**
     * @Oa\Get(
     *      path="/api/settings/currencies/index",
     *      tags={"settings"},
     *      security={ {"auth": {} } },
     *      description="get companies",
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
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     */
    public function index(){
        $data = [
            'items'=>Currency::query()->paginate()
        ];

        return response()->json($data);
    }

    public function get(){
        return [
         'currencies'=>Currency::query()->get()
        ];
    }

    /**
     * @Oa\Get(
     *      path="/api/settings/currencies/show/{id}",
     *      tags={"settings"},
     *      security={ {"auth": {} } },
     *      description="get companies",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of category",
     *         required=true,
     *        @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
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
     * @param Currency $currency
     * @return array
     */
    public function show(Currency $currency){

        return [
            'currency'=>$currency
        ];
    }

    public function create(Request $request){

        $data = $request->all();
        $validator = Validator::make($data['item'],[
            'name' => 'required|string',
            'code'=>'required|string',
            'rate'=>'required|numeric',
            'status'=>'boolean',
            'default'=>'boolean',
        ]);
        $validator->validate();

        Currency::_save($data['item']);

        return ['message'=>'Created'];
    }

    public function update(Request $request,Currency $currency){

        $data = $request->all();
        $validator = Validator::make($data['item'],[
            'name' => 'required|string',
            'code'=>'required|string',
            'rate'=>'required|numeric',
            'status'=>'boolean',
            'default'=>'boolean',
        ]);
        $validator->validate();

        Currency::_save($data['item'],$currency);

        return ['message'=>'updated'];
    }

    public function destroy(Currency $currency){

        $currency->delete();
        return [
            'items'=>Currency::query()->paginate(),
            'message'=>'deleted'
        ];
    }
}
