<?php

namespace App\Http\Controllers;

use App\Models\InvoiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceCategoryController extends Controller
{
    /**
     * @Oa\Get(
     *      path="/api/incomes/categories/index",
     *      tags={"incomes"},
     *      security={ {"auth": {} } },
     *      description="get index",
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
    public function index()
    {
        $data = [
            'items' => InvoiceCategory::query()->paginate()
        ];

        return response()->json($data);
    }


    /**
     * @Oa\Get(
     *      path="/api/incomes/categories/get",
     *      tags={"incomes"},
     *      security={ {"auth": {} } },
     *      description="get company by id",
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
    public function get(Request $request)
    {

        $categories = InvoiceCategory::query();

        if($request->has('id')){
            $categories->where('id',$request['id']);
        }

        $data = [
            'items' => $categories->get()
        ];

        return response()->json($data);
    }


    /**
     * @Oa\Post(
     *      path="/api/incomes/categories/sync",
     *      tags={"incomes"},
     *      security={ {"auth": {} } },
     *      description="get company by id",
     *      @OA\Parameter(
     *         name="item",
     *         in="query",
     *         description="item",
     *         required=false,
     *        @OA\Schema(
     *         properties={
     *         @OA\Property(property="item[name]", type="string"),
     *        }
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
     * @param $item
     * @return \Illuminate\Http\JsonResponse
     */
    public function sync(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data['item'], [
            'name' => 'required|string',
        ]);
        $validator->validate();

        if (isset($data['item']['id'])) {
            $item = InvoiceCategory::query()->findOrFail($data['item']['id']);
        } else {
            $item = null;
        }

        InvoiceCategory::_save($data['item'], $item);

        return response()->json(['message' => 'Created']);
    }


    /**
     * @Oa\Delete(
     *      path="/api/incomes/categories/destroy/{item}",
     *      tags={"incomes"},
     *      security={ {"auth": {} } },
     *      description="get company by id",
     *      @OA\Parameter(
     *         name="item",
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
     * @param InvoiceCategory $item
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(InvoiceCategory $item)
    {

        $item->delete();
        $data = [
            'items' => InvoiceCategory::query()->paginate(),
            'message' => 'deleted'
        ];
        return response()->json($data);
    }
}
