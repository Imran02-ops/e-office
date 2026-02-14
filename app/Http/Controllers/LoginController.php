<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) {

            // Generate OTP
            $otp = rand(100000,999999);

            // Simpan ke session
            Session::put('otp_code', $otp);
            Session::put('otp_user_id', Auth::id());
            Session::put('otp_expired_at', now()->addMinutes(2));

            // Logout sementara
            Auth::logout();

            // Nomor admin (Imran)
            $adminPhone = "62812XXXXXXXX"; // GANTI NOMOR IMRAN

            // Kirim OTP via Fonnte
            Http::withHeaders([
                'Authorization' => env('WA_TOKEN')
            ])->post('https://api.fonnte.com/send', [
                'target' => $adminPhone,
                'message' => "🔐 Kode OTP Login:\n\n$otp\n\nBerlaku 2 menit."
            ]);

            return redirect()->route('otp.form');
        }

        return back()->with('error','Email atau password salah');
    }
}
