<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use function Symfony\Component\String\b;

class UserController extends Controller
{
    function LoginPage(): View
    {
        return view('pages.auth.login-page');
    }

    function RegistrationPage(): View
    {
        return view('pages.auth.registration-page');
    }
    function SendOtpPage(): View
    {
        return view('pages.auth.send-otp-page');
    }
    function VerifyOTPPage(): View
    {
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage(): View
    {
        return view('pages.auth.reset-pass-page');
    }

    function ProfilePage(): View
    {
        return view('pages.dashboard.profile-page');
    }

    public function UserRegistration(Request $request)
    {
        try {
            $user = User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => bcrypt($request->input('password'))
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User registered successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'user registration failed'
            ], 200);
        }
    }

    public function UserLogin(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();

        if ($user && Hash::check($request->input('password'), $user->password)) {
            $token = JWTToken::createToken($user->email, $user->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Login successful',
                'token' => $token

            ], 200)->cookie('Authorization', $token, 60);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 200);
        }
    }

    public function SentOTPCode(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        $otp = rand(10000, 99999);
        if ($user) {

            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', $email)->update(['otp' => $otp]);
            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully',
                'otp' => $otp
            ], 200);
        } else {
            return response()->json([
                'success' => 'fail',
                'message' => 'User not found'
            ], 200);
        }


    }

    public function VerifyOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');
        $user = User::where('email', $email)->first();
        if ($user->otp == $otp) {
            User::where('email', $email)->update(['otp' => 0]);

            $token = JWTToken::createTokenForPassword($email, $user->id);

            return response()->json([
                'status' => 'success',
                'message' => 'OTP verified',
                'otp' => $user->otp,
            ], 200)->cookie('Authorization', $token, 60);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid OTP'
            ], 200);
        }
    }

    public function ResetPassword(Request $request)
    {
        try {
            $email = $request->header('email');
            $password = bcrypt($request->input('password'));
            User::where('email', $email)->update(['password' => $password]);
            return response()->json([
                'status' => 'success',
                'message' => 'Password changed successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 200);
        }

    }

    public function UserLogout()
    {
        return redirect('/userLogin')->cookie('Authorization', null, -1);
    }

    public function UserProfile(Request $request)
    {
        $email = $request->header('email');
        $user = User::where('email', $email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'request success',
            'data' => $user
        ], 200);

    }

    // function UserProfile(Request $request)
    // {
    //     $email = $request->header('email');
    //     $user = User::where('email', $email)->first();

    //     if ($user) {
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'Request Successful',
    //             'data' => [
    //                 'id' => $user->id,
    //                 'email' => $user->email,
    //                 'firstName' => $user->firstName,
    //                 'lastName' => $user->lastName,
    //                 'mobile' => $user->mobile,
    //                 'password' => $user->password
    //                 // পাসওয়ার্ড নিরাপত্তার জন্য ফর্মে পাঠাবেন না
    //             ]
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'User not found'
    //         ], 200);
    //     }
    // }

    function UserProfileUpdate(Request $request){
        $email = $request->header('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $mobile = $request->input('mobile');
        $password = bcrypt($request->input('password'));
        $user = User::where('email', $email)->first();
        if ($user) {
            User::where('email', $email)->update([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'mobile' => $mobile,
                'password' => $password
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User profile updated successfully'
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 200);
        }
    }
}
