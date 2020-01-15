<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Admin extends Authenticatable implements JWTSubject

{
    use Notifiable;
    protected $guard = 'admin';
    protected $fillable = [
        'name',  'password',
    ];
    protected $hidden = [
        'password',
    ];

    public static function _update($request,$user){

        $user->name = $request['name'];

        if(isset($request['img'])){
            $user->image = $request['img'];
        }

        if(isset($request['password'])){
            $user->password = Hash::make($request['password']);
        }

        $user->save();

        return $user;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }


}
