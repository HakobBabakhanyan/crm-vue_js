<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function getCompanies(){
        $data=[
          'companies'=>Companies::all()
        ];

        return response()->json($data);
    }

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

        $company = Companies::_save($request->all(),$company);

        $data=[
            'message'=>'company create',
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
