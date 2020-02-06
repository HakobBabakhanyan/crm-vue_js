<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller
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
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     */
    public function index(){
        $data = [
            'items'=>Tax::query()->paginate()
        ];

        return response()->json($data);
    }


    /**
     * @Oa\Get(
     *      path="/api/settings/taxes/get",
     *      tags={"settings"},
     *      security={ {"auth": {} } },
     *      description="get companies",
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
    public function get(){

        return [
            'taxes'=>Tax::query()->get()
        ];
    }


    public function create(Request $request){

        $data = $request->all();
        $types = Tax::TYPE;
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


        Tax::_save($data['item']);

        return ['message'=>'Created'];
    }

    public function update(Request $request,Tax $tax){

        $data = $request->all();
        $types = Tax::TYPE;
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


        Tax::_save($data['item'],$tax);

        return ['message'=>'Created'];
    }


    public function search(Request $request){

        $items = Tax::query();

        return [
            'taxes'=>$items->get()
        ];
    }

    public function destroy(Tax $tax){

        $tax->delete();
        $data = [
            'items'=>Tax::query()->paginate(),
            'message'=>'deleted'
        ];
        return response()->json($data);
    }
}
