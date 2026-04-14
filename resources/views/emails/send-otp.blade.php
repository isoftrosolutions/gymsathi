<x-mail::message>
# Password Reset Request

Hello,

You are receiving this email because we received a password reset request for your account.

Your One-Time Password (OTP) is:

# **{{ $otp }}**

This code will expire in 10 minutes.

If you did not request a password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
