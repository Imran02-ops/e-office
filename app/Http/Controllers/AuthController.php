<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class AuthController extends Controller
{
    // FORM LOGIN (TIDAK DIUBAH)
    public function loginForm()
    {
        return view('login');
    }

    // PROSES LOGIN + OTP KE WA IMRAN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Email atau password salah');
        }

        // Login user dulu
        Auth::login($user);

        // Generate OTP
        $otp = rand(100000, 999999);

        // Simpan OTP ke session
        Session::put('otp_code', $otp);
        Session::put('otp_verified', false);
        Session::put('otp_expired', now()->addMinutes(2));

        // Nomor WA Imran (format 62)
        $nomorImran = '6281944872700'; // ganti jika perlu

        try {
            Http::withHeaders([
                'Authorization' => env('WA_TOKEN'),
            ])->post('https://api.fonnte.com/send', [
                'target' => $nomorImran,
                'message' => "Kode OTP Login Anda: $otp\nBerlaku 2 menit."
            ]);
        } catch (\Exception $e) {
            Auth::logout();
            return back()->with('error', 'Gagal mengirim OTP WhatsApp');
        }

        return redirect()->route('otp.form');
    }

    // FORM OTP
    public function showOtpForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        return view('otp');
    }

    // VERIFIKASI OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Cek expired
        if (now()->greaterThan(Session::get('otp_expired'))) {

            Session::forget(['otp_code','otp_verified','otp_expired']);
            Auth::logout();

            return redirect()->route('login')
                ->with('error','OTP sudah kadaluarsa, silakan login ulang');
        }

        // Cek OTP
        if ($request->otp == Session::get('otp_code')) {

            Session::put('otp_verified', true);
            Session::forget(['otp_code','otp_expired']);

            return redirect()->route('dashboard');
        }

        return back()->with('error','OTP salah');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
