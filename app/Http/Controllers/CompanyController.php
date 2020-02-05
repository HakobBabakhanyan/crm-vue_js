<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Traits\Uploads;
use Illuminate\Http\Request;

class CompanyController extends Controller
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
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of companies
     */
    public function index(){

        return [
            'companies'=>Company::query()->paginate()
        ];
    }

    public function history(){
        return [
          'companies'=>Company::query()->withoutGlobalScope('real')->whereNotNull('company_id')->paginate()
        ];
    }


    /**
     * @Oa\Get(
     *      path="/api/companies/get",
     *      tags={"companies"},
     *      description="companies  list all"
     *      security={ {"auth": {} } },
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(
     *             type="object",
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * @return array
     */
    public function get(){
        return [
            'companies'=>Company::query()->get()
        ];
    }

    /**
     * @Oa\Get(
     *      path="/api/companies/show/{id}",
     *      tags={"companies"},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="pages id if null return list",
     *         required=true,
     *        @OA\Schema(
     *             type="integer",
     *             format="int64",
     *         )
     *     ),
     *      security={ {"auth": {} } },
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(
     *             type="object",
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * @param Company $company
     * @return array
     */
    public function show(Company $company){
        return [
            'company'=>$company
        ];
    }

    public function create(Request $request){

        $request->validate([
            'name'=>'required|string',
            'type'=>'required|string'
        ]);

        $company = Company::_save($request->all());

        return [
            'message'=>'success',
            'company'=>$company
        ];

    }

    public function update(Company $company,Request $request){
        $request->validate([
            'name'=>'required|string',
            'type'=>'required|string'
        ]);
        if(isset($request['image'])){
            $request['img'] = $this->imageUpload($request['image'],[300,300]);
            if($company){
                $this->imageDelete($company->logo);
            }
        }
        $company = Company::_save($request->all(),$company);

        return [
            'message'=>'success',
            'company'=>$company
        ];

    }

    public function destroy(Company $company){

        $company->delete();

        $data=[
            'message'=>'Company delete',
            'companies'=>Company::paginate()
        ];
        return response()->json($data);
    }



}
