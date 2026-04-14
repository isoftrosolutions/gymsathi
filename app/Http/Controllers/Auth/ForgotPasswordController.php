<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordResetOtp;
use App\Mail\SendOtpMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Stage 2: Show forgot password form.
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Stage 2: Send OTP to user's email.
     */
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate 6-digit OTP
            $otp = rand(100000, 999999);

            // Store OTP in database
            PasswordResetOtp::updateOrCreate(
                ['email' => $request->email],
                [
                    'otp' => $otp,
                    'expires_at' => Carbon::now()->addMinutes(10)
                ]
            );

            // Send Email
            Mail::to($request->email)->send(new SendOtpMail($otp));
        }

        // We show the same message even if email doesn't exist for security
        return redirect()->route('password.otp')
            ->with(['email' => $request->email, 'status' => 'If this email is registered, you will receive an OTP.']);
    }

    /**
     * Stage 4: Show OTP verification form.
     */
    public function showVerifyOtpForm(Request $request)
    {
        $email = session('email') ?? $request->email;

        if (!$email) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.otp', compact('email'));
    }

    /**
     * Stage 4: Validate OTP.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric'
        ]);

        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpRecord) {
            return back()
                ->withErrors(['otp' => 'The OTP is invalid or has expired.'])
                ->withInput(['email' => $request->email]);
        }

        // Store email and OTP in session to authorize reset form
        session(['reset_email' => $request->email, 'reset_otp' => $request->otp]);

        return redirect()->route('password.reset');
    }

    /**
     * Stage 5: Show password reset form.
     */
    public function showResetPasswordForm()
    {
        if (!session('reset_email') || !session('reset_otp')) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.reset');
    }

    /**
     * Stage 5: Update password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $email = session('reset_email');
        $otp = session('reset_otp');

        if (!$email || !$otp) {
            return redirect()->route('password.request');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['email' => 'User not found.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Clear OTP and session
        PasswordResetOtp::where('email', $email)->delete();
        session()->forget(['reset_email', 'reset_otp']);

        return redirect()->route('login')->with('status', 'Password reset successful. Please log in.');
    }
}
