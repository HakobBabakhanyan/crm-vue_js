<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Traits\Uploads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AdminController extends Controller
{
    use Uploads;

//    public function logout()
//    {
//        auth('admin')->logout();
//
//        return response()->json(['logout' => true]);
//    }

//    public function authenticate(Request $request)
//    {
//        $credentials = $request->only('name', 'password');
//
//        try {
//
//            if (! $token = auth('admin')->attempt($credentials)) {
//
//                return response()->json(['error' => 'invalid_credentials'], 400);
//            }
//        } catch (JWTException $e) {
//            return response()->json(['error' => 'could_not_create_token'], 500);
//        }
//
//        return response()->json(compact('token'));
//    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = Admin::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    /**
     * @OA\Post(
     *      path="/api/user",
     *      tags={"User"},
     *      summary="get user login",
     *      security={ {"auth": {} } },
     *      description="desc",
     *      @OA\Response(
     *          response=200,
     *          @OA\JsonContent(
     *             type="object",
     *         ),
     *          description="successful operation"
     *       ),
     *     )
     *
     * Returns list of projects
     */
    public function getAuthenticatedUser()
    {
        try {

            if (! $user = auth('admin')->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }

    public function update(Request $request){


        $validatedData =  $request->validate([
            'name' => 'required|string|unique:admins,name,'.auth('admin')->user()->id,
            'image' => ['nullable', 'image'],
            'old_password' => ['nullable', 'min:8', function($attribute, $value, $fail){
                if(!Hash::check($value, auth('admin')->user()->password)){
                    $fail($attribute.' is invalid password.');
                };
            }],
            'password' => ['nullable', 'min:8', 'confirmed', 'different:old_password'],
            'password_confirmation' => ['nullable', 'min:8','nullable'],
        ]);
        if(isset($request['image'])){
            $request['img'] = $this->imageUpload($request['image'],[300,300]);
            $this->imageDelete(auth('admin')->user()->image);
        }
        $admin = Admin::_update($request->all(),auth('admin')->user());

        $data = [
         'user'=>$admin,
         'message'=>'the users data updated'
        ];

        return response()->json($data);
    }
}
