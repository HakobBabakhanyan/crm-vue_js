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
     *             @OA\Item()
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


    /**
     * @Oa\Get(
     *      path="/api/settings/currencies/get",
     *      tags={"settings"},
     *      security={ {"auth": {} } },
     *      description="get companies",
     *      @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="id of category",
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
     *             @OA\Item()
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     * @param Request $request
     * @return array
     */
    public function get(Request $request){

        return [
            'item'=>Currency::query()->findOrFail($request->get('id'))
        ];
    }



    public function sync(Request $request){

        $data = $request->all();
        $validator = Validator::make($data['item'],[
            'name' => 'required|string|unique:currencies,name,'.(isset($data['item']['id'])?$data['item']['id']:null),
            'code'=>'required|string|unique:currencies,code,'.(isset($data['item']['id'])?$data['item']['id']:null),
            'rate'=>'required|numeric',
            'status'=>'boolean',
            'default'=>'boolean',
        ]);
        $validator->validate();

        if(isset($data['item']['id'])){
            $item = Currency::query()->findOrFail($data['item']['id']);
        }else {
            $item = null;
        }
        Currency::_save($data['item'],$item);

        return response()->json(['message'=>'Created']);
    }


    public function destroy(Request $request){
        $currency=Currency::query()->findOrFail($request->input('id'));
        $currency->delete();
        return [
            'items'=>Currency::query()->paginate(),
            'message'=>'deleted'
        ];
    }
}
