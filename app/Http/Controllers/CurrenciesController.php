<?php

namespace App\Http\Controllers;

use App\Models\Currencies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrenciesController extends Controller
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
     *             @OA\Items()
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     */


    public function index(){
        $data = [
            'items'=>Currencies::query()->paginate()
        ];

        return response()->json($data);
    }



    /**
     * @Oa\Get(
     *      path="/api/settings/currencies/get/{id}",
     *      tags={"settings"},
     *      security={ {"auth": {} } },
     *      description="get companies",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
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
     *             @OA\Items()
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     * @param $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function getItem($item){

        $data = [
            'item'=>Currencies::query()->findOrFail($item)
        ];

        return response()->json($data);
    }


    public function sync(Request $request){

        $data = $request->all();
        $validator = Validator::make($data['item'],[
            'name' => 'required|unique:currencies,name,'.(isset($data['item']['id'])?$data['item']['id']:null),
            'code'=>'required|unique:currencies,code,'.(isset($data['item']['id'])?$data['item']['id']:null),
            'rate'=>'required|numeric',
            'status'=>'boolean',
            'default'=>'boolean',
        ]);
        $validator->validate();

        if(isset($data['item']['id'])){
            $item = Currencies::query()->findOrFail($data['item']['id']);
        }else {
            $item = null;
        }
        Currencies::_save($data['item'],$item);

        return response()->json(['message'=>'Created']);
    }


    public function destroy(Currencies $item){
        $item->delete();
        $data = [
            'items'=>Currencies::query()->paginate(),
            'message'=>'deleted'
        ];
        return response()->json($data);
    }

}
