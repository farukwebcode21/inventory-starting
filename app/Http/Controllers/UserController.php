<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller {

    public function User_Registation(Request $request) {
        try {
            // Validate input
            $validateData = $request->validate([
                'firstName' => 'required|string|max:50',
                "lastName"  => 'required|string|max:50',
                'email'     => 'required|email|unique:users|max:255',
                'mobile'    => 'required|string|unique:users|max:20',
                'password'  => 'required|string|min:8',

            ]);

            // Has the password
            $hashedPassword = Hash::make($validateData['password']);

            $user = User::create([
                'firstName' => $validateData['firstName'],
                'lastName'  => $validateData['lastName'],
                'email'     => $validateData['email'],
                'mobile'    => $validateData['mobile'],
                'password'  => $validateData['password'],
            ]);
            return ResponseHelper::out('success', $user, 201);
        } catch (Exception $e) {
            return ResponseHelper::out('failed' . $e->getMessage(), null, 500);
        }

    }

    public function userLogin(Request $request) {
        $credentials = $request->only('email', 'password');
        if (User::where($credentials)->count() === 1) {
            $token = JWTToken::createUserToken($request->input('email'));
            return ResponseHelper::out('User Login successful', $token, 200);
        } else {
            return ResponseHelper::out('Login failed', null, 500);
        }
    }

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

    public function VerifyOTP(Request $request) {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)->where('otp', '=', $otp)->count();
        if ($count == 1) {
            User::where('email', '=', $email)->update(['otp' => '0']);
            $token = JWTToken::createUserTokenForResetPassword($request->input('email'));
            return ResponseHelper::out('OTP Verification successfull', $token, 200);
        } else {
            return ResponseHelper::out('Please Try again Your OTP Does not match', 'Token is not Correct', 401);
        }

    }

    public function resetPassword(Request $request) {
        try {
            // Validate input
            $request->validate(['password' => 'required|min:8']);
            $email = $request->header('email');
            // Check if the user with the given email exists
            $user = User::where('email', $email)->first();
            if (!$user) {
                return ResponseHelper::out('User not found', null, 404);
            }
            // Update the password
            $user->update(['password' => $request->input('password')]);
            // $user->update(['password' => bcrypt($request->input('password'))]);
            return ResponseHelper::out('Password reset successfully', null, 200);

        } catch (Exception $e) {
            // return ResponseHelper::out('password Minimun 8 character required', null . $e->getMessage(), 500);
            return ResponseHelper::out('Error updating password: ' . $e->getMessage(), null, 500);
        }
    }

}
