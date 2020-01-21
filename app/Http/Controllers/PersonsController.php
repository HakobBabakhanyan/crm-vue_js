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
     *      path="/api/persons/get",
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
    public function getPersons(){
        $data=[
            'persons'=>Persons::paginate(2)
        ];
        return response()->json($data);
    }
    /**
     * @Oa\Get(
     *      path="/api/persons/get/all",
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
     */
    public function getPersonsAll(){
        $data=[
            'persons'=>Persons::all()
        ];
        return response()->json($data);
    }

    /**
     * @Oa\Get(
     *      path="/api/persons/get/{person}",
     *      tags={"persons"},
     *      security={ {"auth": {} } },
     *      description="get perosn by id",
     *      @OA\Parameter(
     *         name="person",
     *         in="path",
     *         description="ID of pet to fetch",
     *         required=true,
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
     * Returns company by id
     * @param Persons $person
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPerson(Persons $person){
        $data=[
            'person'=>$person->with('companies')->first(),
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
    public function destroy(Persons $person){

        $person->delete();
        $data=[
            'message'=>'Person delete',
            'persons'=>Persons::paginate(2)
        ];
        return response()->json($data);
    }

}
