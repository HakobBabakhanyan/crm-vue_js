<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Traits\Uploads;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{

    use Uploads;

    public function getCompanies(){
        $data=[
          'companies'=>Companies::paginate(2)
        ];

        return response()->json($data);
    }

    /**
     * @Oa\Get(
     *      path="/api/companies/get/{company}",
     *      tags={"companies"},
     *      security={ {"auth": {} } },
     *      description="get company id",
     *      @OA\Parameter(
     *         name="id",
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
     * Returns list of projects
     */
    public function getCompany(Companies $company){
        $data=[
          'company'=>$company
        ];

        return response()->json($data);
    }

    public function sync(Request $request){

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

    public function destroy(Companies $company){

        $company->delete();
        $data=[
          'message'=>'Company delete',
          'companies'=>Companies::all()
        ];
        return response()->json($data);
    }
}
