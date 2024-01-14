<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    function userLoginPage(Request $request){
        return view('pages.auth.login-page');
    }

    function userRegisterPage(Request $request){
        return view('pages.auth.register-page');
    }

    function sendOTPPage(Request $request){
        return view('pages.auth.sendOTP-page');
    }

    function verifyOTPPage(Request $request){
        return view('pages.auth.verifyOTP-page');
    }

    function passwordResetPage(Request $request){
        return view('pages.auth.reset-password');
    }


    function profilePage(){
        return view('pages.dashboard.profile-page');
    }

    function userRagistration(Request $request){
        try{
            User::create([
                "first_name" => $request->input("first_name"),
                "last_name" => $request->input("last_name"),
                "email" => $request->input("email"),
                "mobile" => $request->input("mobile"),
                "password" => $request->input("password")
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'You have been registered now successfully'
            ],201);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'You are fail to register'
            ],401);
        }

        }

    
    function userLoginAction(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        $count = User::where('email', '=', $email)->where('password', '=', $password)->select('id')->first();

        if($count !== null){
            $token = JWTToken::createJWTToken($email, $count->id);

            return response()->json([
                'status' => 'success',
                'message' => 'User Login successfully done',
                'token' => $token
            ])->cookie('token', $token, 60*60*24);
        }else{
            return response()->json([
                'status' => 'fail',
                'message' => 'Unauthorized',
            ]);
        }
    }

    function sendOTPCodeAction(Request $request){
        $email = $request->input('email');
        $otp = rand(100000, 999999);

        $count = User::where('email', '=', $email)->count();

        if($count == 1){
            // Send OTP Code to user email
            // Mail::to($email)->send(new OTPMail($otp));
            
            // Update OTP code to database
            User::where('email', '=', $email)->update(['otp'=>$otp]);

            return response()->json([
                'status' => 'success',
                'message' => '6 Digit OTP code has been sent to your email'
            ]);
        }else{
            return response()->json([
                'status' => 'fail',
                'message' => 'Unauthorized to send OTP from UserController'
            ]);
        }
    }


    function verifyOTPCodeAction(Request $request){
        $email = $request->input('email');
        $otp = $request->input('otp');

        $count = User::where('email', '=', $email)->where('otp', '=', $otp)->count();

        if($count === 1){
            // Otp Update
            User::where('email', '=', $email)->update(['otp' => "0"]);

            // Create Token for reset password
            $token = JWTToken::createJWTTokenForPassword($email);

            return response()->json([
                'status' => 'success',
                'message' => 'OTP code matched and verified successfully',
                'token' => $token
            ])->cookie('token', $token, 60*2);
        }else{
            return response()->json([
                'status' => 'fail',
                'message' => 'Something went wrong'
            ]);
        }
    }


    function resetPasswordAction(Request $request){
        try{
            $email = $request->header('email');
            $password = $request->input('password');

            User::where('email', '=', $email)->update(['password' => $password]);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successfully'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Password reset failed'
            ], 401);
        }
    }

    function logoutAction(Request $request){
        return redirect('/')->cookie('token', '', -1);
    }


    function userProfileInfo(Request $request){
        try{
            $email = $request->header('email');

            $data = User::where('email', '=', $email)->first();

            return response()->json([
                'status' => 'success',
                'message' => 'Request successfull',
                'data' => $data
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail'
            ]);
        }
    }

    function userProfileInfoUpdate(Request $request){
        try{
            $email = $request->header('email');
            User::where('email', '=', $email)->update([
                "first_name" => $request->input("first_name"),
                "last_name" => $request->input("last_name"),
                "mobile" => $request->input("mobile"),
                "password" => $request->input("password")
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Info updated successfully'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'status' => 'fail',
                'message' => 'Request fail to update'
            ],401);
        }
    }


}
