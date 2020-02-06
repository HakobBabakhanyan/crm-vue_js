<?php

namespace App\Http\Controllers;

use App\Models\InvoiceCategory;
use Illuminate\Http\JsonResponse;
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
     * @return array
     */
    public function get()
    {

        return [
            'categories' => InvoiceCategory::query()->get()
        ];
    }


    /**
     * @Oa\Get(
     *      path="/api/incomes/categories/show/{id}",
     *      tags={"incomes"},
     *      security={ {"auth": {} } },
     *      description="get company by id",
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
     * @param InvoiceCategory $category
     * @return array
     */
    public function show(InvoiceCategory $category)
    {

        return [
            'category' => $category
        ];
    }


    /**
     * @Oa\Post(
     *      path="/api/incomes/categories/create",
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
     * @param Request $request
     * @return array
     */
    public function create(Request $request)
    {

        $data = $request->all();
        $validator = Validator::make($data['item'], [
            'name' => 'required|string',
        ]);
        $validator->validate();

        InvoiceCategory::_save($data['item']);

        return ['message' => 'Created'];
    }

    /**
     * @Oa\Put(
     *      path="/api/incomes/categories/update/{id}",
     *      tags={"incomes"},
     *      security={ {"auth": {} } },
     *      description="get company by id",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="item",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",),
     *     ),
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
     * @param Request $request
     * @param InvoiceCategory $category
     * @return array
     */
    public function update(Request $request,InvoiceCategory $category)
    {

        $data = $request->all();
        $validator = Validator::make($data['item'], [
            'name' => 'required|string',
        ]);
        $validator->validate();

        InvoiceCategory::_save($data['item'],$category);

        return ['message' => 'Created'];
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
     * @param InvoiceCategory $category
     * @return array
     * @throws \Exception
     */
    public function destroy(InvoiceCategory $category)
    {

        $category->delete();
        return [
            'items' => InvoiceCategory::query()->paginate(),
            'message' => 'deleted'
        ];
    }
}
