<?php

namespace App\Http\Controllers;

use App\Models\Taxes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaxesController extends Controller
{
    /**
     * @Oa\Get(
     *      path="/api/settings/taxes/index",
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
            'items'=>Taxes::query()->paginate()
        ];

        return response()->json($data);
    }


    /**
     * @Oa\Get(
     *      path="/api/settings/taxes/get/{id}",
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
            'item'=>Taxes::query()->findOrFail($item)
        ];

        return response()->json($data);
    }


    public function sync(Request $request){

        $data = $request->all();
        $types = Taxes::TYPE;
        $validator = Validator::make($data['item'],[
            'name' => 'required|string',
            'type'=>['required','numeric',function($attribute, $value, $fail) use ($types){
                if (!isset($types[$value])) {
                    $fail($attribute.' is invalid.');
                }
            }],
            'rate'=>'required|numeric',
            'status'=>'boolean',
        ]);
        $validator->validate();

        if(isset($data['item']['id'])){
            $item = Taxes::query()->findOrFail($data['item']['id']);
        }else {
            $item = null;
        }

        Taxes::_save($data['item'],$item);

        return response()->json(['message'=>'Created']);
    }



    public function destroy(Taxes $item){

        $item->delete();
        $data = [
            'items'=>Taxes::query()->paginate(),
            'message'=>'deleted'
        ];
        return response()->json($data);
    }

}
