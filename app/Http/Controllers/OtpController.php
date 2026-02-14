<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    public function showForm()
    {
        if (!Session::has('otp_code')) {
            return redirect('/login');
        }

        return view('auth.otp');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        if (!Session::has('otp_code')) {
            return redirect('/login');
        }

        // Cek expired
        if (now()->greaterThan(Session::get('otp_expired_at'))) {
            Session::forget(['otp_code','otp_user_id','otp_expired_at']);
            return redirect('/login')->with('error','OTP sudah kadaluarsa');
        }

        // Cek OTP
        if ($request->otp == Session::get('otp_code')) {

            Auth::loginUsingId(Session::get('otp_user_id'));

            Session::forget(['otp_code','otp_user_id','otp_expired_at']);

            return redirect('/dashboard');
        }

        return back()->with('error','OTP salah');
    }
}
