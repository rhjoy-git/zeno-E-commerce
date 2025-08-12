Verification Required
====================================

We received a request to verify your identity for {{ config('app.name') }}.

Your OTP Code: {{ $otp }}

This code will expire at {{ $expires_at }}.

Do not share this OTP with anyone.

If you did not initiate this request, please contact support@{{ config('app.name') }}.

Verify now: {{ route('otp.verify', ['token' => $token]) }}

====================================
Thanks,
The {{ config('app.name') }} Team
Support: support@{{ config('app.name') }}
Website: {{ config('app.url') }}