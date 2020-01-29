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
        $data = [
            'categories'=>ItemCategory::query()->paginate()
        ];

        return response()->json($data);
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
     * @param ItemCategory $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategory(ItemCategory $category){

        $data = [
            'category'=>$category
        ];

        return response()->json($data);
    }

    public function sync(Request $request){

        $data = $request->all();
        $validator = Validator::make($data['category'],[
            'name' => 'required',
        ]);
        $validator->validate();

        if(isset($data['category']['id'])){
            $category = ItemCategory::findOrFail($data['category']['id']);
        }else {
            $category = null;
        }
        ItemCategory::_save($data['category'],$category);

        return response()->json(['message'=>'Created']);
    }


    public function search(Request $request){
        $data = [
            'categories'=>ItemCategory::query()->where('name','like','%'.$request['name'].'%')->get()
        ];

        return response()->json($data);
    }

    public function destroy(ItemCategory $category){
        $category->delete();
        $data = [
            'categories'=>ItemCategory::query()->paginate(),
            'message'=>'deleted'
        ];
        return response()->json($data);
    }
}
