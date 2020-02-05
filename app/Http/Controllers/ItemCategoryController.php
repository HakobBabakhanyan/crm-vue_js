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
     *      path="/api/items/categories/show/{id}",
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
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     * @param ItemCategory $category
     * @return array
     */
    public function show(ItemCategory $category){

        return  [
            'category'=>$category
        ];
    }

    public function create(Request $request){

        $data = $request->all();
        $validator = Validator::make($data['category'],[
            'name' => 'required|string|',
        ]);

        $validator->validate();

        ItemCategory::_save($data['category']);

        return ['message'=>'Created'];
    }

    public function update(Request $request, ItemCategory $category){

        $data = $request->all();

        $validator = Validator::make($data['category'],[
            'name' => 'required|string'
        ]);

        $validator->validate();

        ItemCategory::_save($data['category'],$category);

        return ['message'=>'Created'];
    }


    public function search(Request $request){
        $data = [
            'categories'=>ItemCategory::query()->where('name','like','%'.$request['name'].'%')->get()
        ];

        return response()->json($data);
    }

    public function destroy(ItemCategory $category){
        $category->delete();

        return [
            'categories'=>ItemCategory::query()->paginate(),
            'message'=>'deleted'
        ];
    }
}
