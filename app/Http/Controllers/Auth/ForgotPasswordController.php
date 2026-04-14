<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TemplateMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $otp = random_int(100000, 999999);

            PasswordResetOtp::updateOrCreate(
                ['email' => $request->email],
                [
                    'otp' => Hash::make((string) $otp),
                    'expires_at' => Carbon::now()->addMinutes(10),
                ]
            );

            try {
                Mail::to($request->email)->send(new TemplateMail('password_reset_request', [
                    'member_name' => $user->name,
                    'reset_token' => $otp,
                    'reset_link' => route('password.otp', ['email' => $request->email]),
                ]));

                return redirect()->route('password.otp', ['email' => $request->email])
                    ->with('status', 'OTP sent successfully! Please check your email.');

            } catch (\Exception $e) {
                // Log the error for debugging
                \Log::error('Failed to send password reset OTP: '.$e->getMessage());

                return back()
                    ->withInput()
                    ->withErrors(['email' => 'Failed to send OTP. Please try again or contact support.']);
            }
        }

        // Same message for non-existent emails (prevents enumeration)
        return redirect()->route('password.otp', ['email' => $request->email])
            ->with('status', 'If this email is registered, you will receive an OTP shortly.');
    }

    public function showVerifyOtpForm(Request $request)
    {
        $email = $request->query('email');

        if (! $email) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (! $otpRecord || ! Hash::check($request->otp, $otpRecord->otp)) {
            return back()
                ->withErrors(['otp' => 'The OTP is invalid or has expired.'])
                ->withInput(['email' => $request->email]);
        }

        // Store authorisation in session — OTP record kept so resetPassword can re-verify
        session(['reset_email' => $request->email, 'reset_otp' => $request->otp]);

        return redirect()->route('password.reset');
    }

    public function showResetPasswordForm()
    {
        if (! session('reset_email') || ! session('reset_otp')) {
            return redirect()->route('password.request');
        }

        return view('auth.passwords.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
        ]);

        $email = session('reset_email');
        $otp = session('reset_otp');

        if (! $email || ! $otp) {
            return redirect()->route('password.request');
        }

        // Re-verify OTP against DB so a stale session cannot reset without a valid token
        $otpRecord = PasswordResetOtp::where('email', $email)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (! $otpRecord || ! Hash::check($otp, $otpRecord->otp)) {
            session()->forget(['reset_email', 'reset_otp']);

            return redirect()->route('password.request')
                ->withErrors(['email' => 'Your reset session has expired. Please request a new OTP.']);
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('password.request');
        }

        $user->update(['password' => Hash::make($request->password)]);

        // Invalidate OTP and clear session
        $otpRecord->delete();
        session()->forget(['reset_email', 'reset_otp']);

        return redirect()->route('login')->with('status', 'Password reset successful. Please log in.');
    }
}
