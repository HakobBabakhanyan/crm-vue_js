<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Person;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    const PAGINATE = null;

    const TYPE = [
        'COMPANIES'=>Company::class,
        'PERSONS'=>  Person::class
    ];

    /**
     * @Oa\Get(
     *      path="/api/customers/index",
     *      tags={"customers"},
     *      security={ {"auth": {} } },
     *      description="get custumers",
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
     *      @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="get by type [COMPANIES,PERSONS]",
     *         required=false,
     *        @OA\Schema(
     *             type="string",
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $companies = null;
        $persons = null;

        if($request->has('type')){
            if(isset(self::TYPE[$request['type']])){
                ${strtolower($request['type'])} = (self::TYPE[$request['type']])::query()
                    ->whereHas('customer')
                    ->with('customer')->paginate(self::PAGINATE);
            }
        }else {
            $companies = Company::query()->whereHas('customer')
                ->with('customer')->paginate(self::PAGINATE);
            $persons = Person::query()->whereHas('customer')
                ->with('customer')->paginate(self::PAGINATE);
        };


        $data = [
            'companies' => $companies,
            'persons' => $persons
        ];
        return response()->json($data);
    }


    /**
     * @Oa\Get(
     *      path="/api/customers/search",
     *      tags={"customers"},
     *      security={ {"auth": {} } },
     *      @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="name  of  customer persons",
     *         required=false,
     *        @OA\Schema(
     *             type="string",
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
    public function search(Request $request){

            return [
            'customers' => Customer::with(['parent'=>function($q) use ($request){
                $q->where('name','LIKE','%'.$request['search'].'%');
            }])->get()
        ];
    }


    public function create(Request $request)
    {

        $customer = Customer::_save($request->all());

        $data = [
            'message' => 'Created'
        ];
        return response()->json($data);
    }

    public function destroy(Request $request)
    {

        $customer = Customer::query()->findOrFail($request['id']);

        $customer->delete();

        $data = [
            'companies' => Company::query()->whereHas('customer')
                ->with('customer')->paginate(self::PAGINATE),
            'persons' => Person::query()->whereHas('customer')
                ->with('customer')->paginate(self::PAGINATE),
            'message' => 'deleted'
        ];
        return response()->json($data);
    }


    public function getSelectsItems(Request $request)
    {
        if (isset($request['type'])) {
            $model = Customer::TYPE[$request['type']];
        } else $model = Company::class;

        return [
            'items' => $model::query()->doesntHave('customer')->get()
        ];
    }
}
