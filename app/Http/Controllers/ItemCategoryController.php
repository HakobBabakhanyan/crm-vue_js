<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemCategoryController extends Controller
{
    /**
     * @Oa\Get(
     *      path="/api/items/categories/index",
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
     *             @OA\Item()
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     */


    public function index(){

        return [
            'categories'=>ItemCategory::query()->paginate()
        ];
    }

    /**
     * @Oa\Get(
     *      path="/api/items/categories/get/{id}",
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

        return  [
            'category'=>ItemCategory::query()->findOrFail($request->get('id'))
        ];
    }

    public function sync(Request $request){

        $data = $request->all();
        $validator = Validator::make($data['category'],[
            'name' => 'required|string|unique:item_categories,name,'.((isset($data['category']['id']))?$data['category']['id']:null),
        ]);
        $validator->validate();

        if(isset($data['category']['id'])){
            $category = ItemCategory::findOrFail($data['category']['id']);
        }else {
            $category = null;
        }
        ItemCategory::_save($data['category'],$category);

        return ['message'=>'Created'];
    }


    public function search(Request $request){
        $data = [
            'categories'=>ItemCategory::query()->where('name','like','%'.$request['name'].'%')->get()
        ];

        return response()->json($data);
    }

    public function destroy(Request $request){
        $category = ItemCategory::query()->findOrFail($request->get('id'));
        $category->delete();

        return [
            'categories'=>ItemCategory::query()->paginate(),
            'message'=>'deleted'
        ];
    }
}
