<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Client\Response;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //User Registration
    public function register(Request $request){
        $this->validate($request,[
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:8',
        ]);
        $user= User::create([
            'first_name'=> $request->first_name,
            'last_name'=> $request->last_name,
            'name' =>$request->first_name." ".$request->last_name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;
        return response()->json(['token'=>$token],200);

    }

    //User Login
    public function login(Request $request){
        $login_credentials=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];
        if(auth()->attempt($login_credentials)){
            $user_login_token= auth()->user()->createToken('Laravel Password Grant Client')->accessToken;
            return response()->json(['token' => $user_login_token], 200);
        }
        else{
            return response()->json(['error' => 'UnAuthorised Access'], 401);
        }
    }

    //User Info
    public function userInfo(){
        return response()->json(['authenticated-user' => auth()->user()], 200);
    }

    public function searchUser($name)
    {
//        $search = $request->input('search');
//        $users = User::query()
//            ->where('name', 'LIKE', "%{$search}%")
//            ->orWhere('last_name', 'LIKE', "%{$search}%")
//            ->get();

        $users = User::where("name","like","%".$name."%")->get();
        return response()->json(array(
            'user-info' => $users,
        ));
    }
}
