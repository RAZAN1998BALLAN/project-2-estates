<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(
            UserResource::collection(User::all())
        );
    }

    
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['wallets']);
        return $this->success(
            UserResource::make($user)
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }


    public function updateProfile(UpdateProfileRequest $request){
        $fields = $request->validated();
        if($request->password){
            $fields['password'] = Hash::make($request->password);
        }
        if($request->hasFile('photo')){
            $fields['photo'] = $this->saveFile($request->file('photo'));
        }
        $user = User::findOrFail(Auth::id());
        $user->update($fields);
        return $this->show($user);
    }

    public function getProfile(){
        return $this->show(Auth::user()->load(['wallets']));
    }

    public function disableUser(User $user){
        if($user->is_admin){
            return $this->fail('cannot disable admin',409);
        }
        $user->is_active = false;
        $user->save();
        return $this->show($user);
    }


    public function enableUser(User $user){ 
        $user->is_active = true;
        $user->save();
        return $this->show($user);
    }
}
