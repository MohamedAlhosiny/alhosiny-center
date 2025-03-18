<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserApiController extends Controller
{

    //ده لو انت عايز الشخص يخش على صفحة اللوجين بعد ما يعمل ريجستر
    public function register(Request $request) {

        $request->validate([
            'name' => 'string|required|min:5',
            'email' => 'string|required|email|unique:users',
            'password'=> 'required|min:8|string|confirmed'
        ]);
        $user = User::create([
            'name'=> $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $response = [
            'message'=>'user created success',
            // 'data' => $user,
            'status'=> 200
        ];
        return response($response , 200);
    }



   // دي لو عايز اليوزر بعد ما يعمل ريجستر يخش على الابليكيشن علطول
    public function registerSecond (Request $request) {

        $request->validate([
            'name' => 'string|required|min:5',
            'email' => 'string|required|unique:users',
            'password'=>'required|min:8|string|confirmed'
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('myToken')->plainTextToken;

        $response = [
            'message' => 'user created success',
            'token' => $token,
            'data' => $user,
            'status' => 200
        ];

        return response($response , 200);
    }



    public function loginUser(Request $request) {

        $request->validate([
            'email' => 'string|email|required',
            'password' => 'string|required'
        ]);
        if(Auth::guard('web')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]))  {

            $response = [
                'message' => 'check is true',
                'status' => 200
            ];

        }else {
            $response = [
                'message' => 'pass or email not valid',
                'status' => 401
            ];

        }

        return response($response , 200);


    }
    //=====================================
    public function loginAdmin(Request $request) {

        $request->validate([
            'email' => 'string|email|required',
            'password' => 'string|required'
        ]);
        if(Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ]))  {

            $response = [
                'message' => 'check is true',
                'status' => 200
            ];

        }else {
            $response = [
                'message' => 'pass or email not valid',
                'status' => 401
            ];

        }

        return response($response , 200);


    }


    //login by token

    public function login(Request $request) {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required|string'
        ]);

        $user = User::where( 'email' ,$request->email)->first();

        if(!$user || !HASH::check($request->password , $user->password )) {
            $response = [
                'message' => 'pass or email not valid',
                'status' => 401
            ];
            return response($response , 200);

        }

        $token = $user->createToken('mytoken')->plainTextToken;
        $response = [
            'message' => 'hello to our APP',
            'user' => $user->name,
            'token' => $token,
            'status' => 200
        ];

        return response($response , 200);
    }

//==============================

    public function logout(){
        auth()->user()->currentAccessToken()->delete();
        $response = [
            'message' => 'logout successfully',
            'status' => 200
        ];

        return response($response , 200);
    }

    // public function login(Request $request) {
    //     $request->validate([
    //         'email' => 'string|email|required', // ✅ إزالة `unique:users`
    //         'password' => 'string|required'
    //     ]);

    //     if (Auth::guard('web')->attempt([
    //         'email' => $request->email,
    //         'password' => $request->password
    //     ])) {
    //         return response()->json([
    //             'message' => 'Login successful',
    //             'status' => 200
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'message' => 'Email or password is incorrect'
    //         ], 401); // ✅ استخدام كود 401 عند فشل تسجيل الدخول
    //     }
    // }


}


