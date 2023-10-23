<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function User_Registation(Request $request) {
        try {
            $user = User::create($request->input());
            return ResponseHelper::out('success', $user, 200);
        } catch (Exception $e) {
            return ResponseHelper::out('failed', null, 500);
        }

    }

    // public function UserLogin(Request $request) {
    //     $count = User::where('email', '=', $request->input('email'))->where('password', '=', $request->input('password'))->count();
    //     if ($count == 1) {
    //         # User Login -> JWT Token Issue
    //         $data = JWTToken::CreateUserToken($request->input('email'));
    //         return ResponseHelper::out('user login successfull', $data, 200);
    //     } else {
    //         return ResponseHelper::out('failed', $count, 500);
    //     }

    // }

    public function userLogin(Request $request) {
        $credentials = $request->only('email', 'password');
        if (User::where($credentials)->count() === 1) {
            $token = JWTToken::createUserToken($request->input('email'));
            return ResponseHelper::out('User Login successful', $token, 200);
        } else {
            return ResponseHelper::out('Login failed', null, 500);
        }
    }

    // public function userLogin(Request $request) {
    //     $credentials = $request->only('email', 'password');
    //     if (Auth::attempt($credentials)) {
    //         $token = JWTToken::createUserToken($request->input('email'));
    //         return ResponseHelper::out('User Login successful', $token, 200);
    //     } else {
    //         return ResponseHelper::out('Login failed', null, 500);
    //     }
    // }
}
