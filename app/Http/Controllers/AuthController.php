<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
       return DB::transaction(function () use ($request){
            $fields = $request->validated();
        if($request->hasFile('photo')){
            $fields['photo'] = $this->saveFile($request->file('photo'));
        }
        $user = User::create($fields);
        $token = $user->createToken('Register Token')->plainTextToken;
        Wallet::create([
            'user_id'=> $user->id,
        ]);
        return $this->success([
            'user' => UserResource::make($user),
            'token' => $token
        ]);
        });
    }

    public function login(LoginRequest $request){
        if(Auth::attempt($request->only(['email','password']))){
            $user = Auth::user();
            if($request->fcm){
                $user->fcm = $request->fcm;
                $user->save(); 
            }
            return $this->success([
                'user' => UserResource::make($user),
                'token' => $user->createToken('Login Token')->plainTextToken
            ]);
        }
        return $this->fail("wrong email or password",401);
    }
}
