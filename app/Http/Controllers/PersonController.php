<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Person;
use App\Traits\Uploads;
use Illuminate\Http\Request;

class PersonController extends Controller
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
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     */
    public function index(){
        $data=[
            'persons'=>Person::paginate()
        ];
        return response()->json($data);
    }

    /**
     * @Oa\Get(
     *      path="/api/persons/show/{id}",
     *      tags={"persons"},
     *      security={ {"auth": {} } },
     *      description="get companies",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="number of page",
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
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of persons
     * @param $person
     * @return array
     */
    public function show($person){

        return [
            'person'=>Person::query()->with('companies')->find($person)
        ];
    }


    public function create(Request $request){

        $request->validate([
            'name'=>'required|string',
        ]);

        if(isset($request['image'])){
            $request['img'] = $this->imageUpload($request['image'],[300,300]);
        }
        $company = Person::_save($request->all());

        return [
            'message'=>'success',
            'person'=>$company
        ];

    }
    public function update(Request $request,Person $person){


        $request->validate([
            'name'=>'required|string',
        ]);

        if(isset($request['image'])){
            $request['img'] = $this->imageUpload($request['image'],[300,300]);

                $this->imageDelete($person->logo);
        }
        $company = Person::_save($request->all(),$person);

        $data=[
            'message'=>'success',
            'person'=>$company
        ];

        return response()->json($data);

    }
    public function destroy(Person $person){

        $person->delete();
        $data=[
            'message'=>'Person delete',
            'persons'=>Person::paginate()
        ];
        return response()->json($data);
    }
}
