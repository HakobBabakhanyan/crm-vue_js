<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
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
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     */


    public function index(){

        $data = [
            'items'=>Item::query()->paginate()
        ];

        return response()->json($data);
    }


    /**
     * @Oa\Get(
     *      path="/api/items/get",
     *      tags={"items"},
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
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request){

        $data = [
            'item'=>Item::query()->with('category')->findOrFail($request['id'])
        ];

        return response()->json($data);
    }



    public function search(Request $request){
        $items = Item::query();


        return [
          'items' =>$items->get()
        ];
    }


    public function sync(Request $request){

        $data = $request->all();
        $validator = Validator::make($data['item'],[
            'name' => 'required',
        ]);
        $validator->validate();

        if(isset($data['item']['id'])){
            $item = Item::findOrFail($data['item']['id']);
        }else {
            $item = null;
        }
        Item::_save($data['item'],$item);

        return response()->json(['message'=>'Created']);
    }


    public function destroy(Request $request){
        $item = Item::query()->find($request['id']);
        $item->delete();
        $data = [
            'items'=>Item::query()->paginate(),
            'message'=>'deleted'
        ];
        return response()->json($data);
    }
}
