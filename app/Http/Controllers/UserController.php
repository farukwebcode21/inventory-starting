<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function sendOtpCode(Request $request) {
        // validate the input
        $request->validate(['email' => 'required|email']);
        try {
            // Find the user or throw and exception
            $user = User::where('email', $request->input('email'))->firstOrFail();
            // Generate OTP
            $otp = rand(1000, 9000);
            // Send OTP via Email
            Mail::to($user->email)->send(new ResetPasswordMail($otp));

            // Update the OTP in the user table
            $user->update(['otp' => $otp]);
            // Return success response
            return ResponseHelper::out('send 4 dight otp', $otp, 200);
        } catch (Exception $e) {
            return ResponseHelper::out('failed', $e->getMessage(), 501);
        }
    }
}
