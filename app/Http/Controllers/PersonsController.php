<?php

namespace App\Http\Controllers;

use App\Models\Persons;
use App\Traits\Uploads;
use Illuminate\Http\Request;

class PersonsController extends Controller
{
    use Uploads;
    /**
     * @Oa\Get(
     *      path="/api/persons/index",
     *      tags={"persons"},
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
        $data=[
            'persons'=>Persons::paginate()
        ];
        return response()->json($data);
    }

    /**
     * @Oa\Get(
     *      path="/api/persons/get",
     *      tags={"persons"},
     *      security={ {"auth": {} } },
     *      description="get companies",
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request){
        $persons = Persons::query();

        if(isset($request['id'])){
            $persons->where('id',$request['id']);
        }
        $data=[
            'persons'=>$persons->with('companies')->get()
        ];
        return response()->json($data);
    }


    public function sync(Request $request){

        if(isset($request['id'])){
            $company = Persons::find($request['id']);
        }else {
            $company = null;
        }
        if(isset($request['image'])){
            $request['img'] = $this->imageUpload($request['image'],[300,300]);
            if($company){
                $this->imageDelete($company->logo);
            }
        }
        $company = Persons::_save($request->all(),$company);

        $data=[
            'message'=>'success',
            'person'=>$company
        ];

        return response()->json($data);

    }
    public function destroy(Request $request){

        $person = Persons::query()->findOrFail($request['id']);
        $person->delete();
        $data=[
            'message'=>'Person delete',
            'persons'=>Persons::paginate()
        ];
        return response()->json($data);
    }

}
