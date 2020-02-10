<?php

namespace App\Http\Controllers;

use App\Models\BankingAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankingAccountController extends Controller
{
    public function  index(){
        return BankingAccount::query()->paginate();
    }

    public function show(BankingAccount $account){

        return [
          'data'=>$account->load('currency')
        ];
    }

    public function create(Request $request){

        $this->validator($request->get('item'));

        $account = BankingAccount::create_or_save($request->get('item'));
        return [
          'massage'=>'crated'
        ];
    }

    public function update(Request $request,BankingAccount $account){
        $this->validator($request->get('item'));

        $account = BankingAccount::create_or_save($request->get('item'),$account);

        return [
            'massage'=>'update'
        ];
    }
    public function validator($data, $id = null){
        $validator = Validator::make($data,[
            'currency'=>'integer|exists:currencies,id',
            'name'=>'string|required',
            'number'=>'integer|required',
            'balance'=>'numeric|required',
            'bank_name'=>'string|required',
            'bank_phone'=>'numeric|required',
            'bank_address'=>'string|required',
            'status'=>'boolean',
            'default'=>'boolean'
        ]);
        $validator->validate();
    }

    public function destroy(BankingAccount $account){

        $account->delete();

        $accounts = BankingAccount::query()->paginate();
        return collect(['massage' =>'delete'])->mergeRecursive($accounts);
    }
}
