<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Traits\Uploads;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{

    use Uploads;

    /**
     * @Oa\Get(
     *      path="/api/companies/index",
     *      tags={"companies"},
     *      security={ {"auth": {} } },
     *      description="get companies",
     *      @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="pages",
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
     * Returns list of companies
     */
    public function index(){
        $data=[
          'companies'=>Companies::paginate()
        ];

        return response()->json($data);
    }

    /**
     * @Oa\Get(
     *      path="/api/companies/get",
     *      tags={"companies"},
     *      security={ {"auth": {} } },
     *      description="get company id",
     *      @OA\Parameter(
     *         name="company",
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request){

        $companies = Companies::query();

        if(isset($request['id'])){
            $companies->where('id',$request['id']);
        }

        $data=[
          'companies'=>$companies->get()
        ];

        return response()->json($data);
    }

    public function sync(Request $request){

        $request->validate([
            'name'=>'required|unique:companies,name,'.(isset($request['id'])?$request['id']:null),
            'type'=>'required'
        ]);

        if(isset($request['id'])){
            $company = Companies::find($request['id']);
        }else {
            $company = null;
        }
        if(isset($request['image'])){
            $request['img'] = $this->imageUpload($request['image'],[300,300]);
            if($company){
                $this->imageDelete($company->logo);
            }
        }

        $company = Companies::_save($request->all(),$company);

        $data=[
            'message'=>'success',
            'company'=>$company
        ];

        return response()->json($data);

    }

    public function destroy(Request $request){

        $company = Companies::query()->findOrFail($request['id']);
        $company->delete();
        $data=[
          'message'=>'Company delete',
          'companies'=>Companies::paginate()
        ];
        return response()->json($data);
    }
}
