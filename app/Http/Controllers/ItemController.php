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
     * @return array
     */
    public function get(Request $request){

        return  [
            'item'=>Item::query()->with('category')->findOrFail($request['id'])
        ];


    }

    public function show($item){

        return [
          'item'=>Item::query()->with('category')->findOrFail($item)
        ];
    }



    public function search(Request $request){
        $items = Item::query();
        $items->where('name','LIKE','%'.$request['search'].'%');
        return [
          'items' =>$items->get()
        ];
    }
    public function create(Request $request){

        $data = $request->all();
        $validator = Validator::make($data['item'],[
            'name' => 'string|required',
            'description' => 'string|nullable',
            'sale_price' => 'string|required|numeric',
            'purchase_price' => 'string|required|numeric',
            'category_id' => 'numeric|exists:item_categories,id',
        ]);
        $validator->validate();

        Item::_save($data['item']);

        return response()->json(['message'=>'Created']);
    }


    /***
     * @param Request $request
     * @param Item $item
     * @return array
     */
    public function update(Request $request,Item $item){

        $data = $request->all();

        $validator = Validator::make($data['item'],[
            'name' => 'string|required',
            'description' => 'string|nullable',
            'sale_price' => 'string|required|numeric',
            'purchase_price' => 'string|required|numeric',
            'category_id' => 'numeric|exists:item_categories,id',
        ]);

        $validator->validate();

        Item::_save($data['item'],$item);

        return ['message'=>'Created'];
    }


    public function destroy(Item $item){
        $item->delete();
        return [
            'items'=>Item::query()->paginate(),
            'message'=>'deleted'
        ];
    }
}
