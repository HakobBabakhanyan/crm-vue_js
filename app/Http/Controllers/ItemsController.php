<?php

namespace App\Http\Controllers;

use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemsController extends Controller
{
    /**
     * @Oa\Get(
     *      path="/api/items/index",
     *      tags={"items"},
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
            'items'=>Items::query()->paginate()
        ];

        return response()->json($data);
    }


    /**
     * @Oa\Get(
     *      path="/api/items/get/{id}",
     *      tags={"items"},
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
            'item'=>Items::query()->with('category')->findOrFail($item)
        ];

        return response()->json($data);
    }


    public function sync(Request $request){

        $data = $request->all();
        $validator = Validator::make($data['item'],[
            'name' => 'required',
        ]);
        $validator->validate();

        if(isset($data['item']['id'])){
            $item = Items::findOrFail($data['item']['id']);
        }else {
            $item = null;
        }
        Items::_save($data['item'],$item);

        return response()->json(['message'=>'Created']);
    }


    public function destroy(items $item){
        $item->delete();
        $data = [
            'items'=>Items::query()->paginate(),
            'message'=>'deleted'
        ];
        return response()->json($data);
    }
}
