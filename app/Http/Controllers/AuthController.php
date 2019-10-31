<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
class AuthController extends Controller
{

    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] = $user->createToken('myApp')->accessToken;
            $success['is_admin'] = $user['is_admin'];

            return response()->json(['success' => $success], 200);
        } else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }
        /*
            Register api
            @return \Illuminate\Http\Response
        */
    public function register(Request $request) {
        $user = new User;
        $user->createUser($request);
        $success['token'] = $user->createToken('myApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success'=>$success], 200);

    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
}
