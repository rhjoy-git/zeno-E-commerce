@component('mail::message')
# 🔐 Verification Required

We received a request to verify your identity.
Please use the following **One-Time Password (OTP)** to proceed:

@component('mail::panel')
<span style="font-size: 20px; font-weight: bold;">Your OTP Code:</span>
<span style="font-size: 24px; font-weight: bold; color: #663dff;">{{ $otp }}</span>

This code will expire at **{{ now()->addMinutes(3)->format('h:i A') }}**.
@endcomponent

If you did not initiate this request, please disregard this email.

@component('mail::button', ['url' => config('app.url')])
Go to {{ config('app.name') }}
@endcomponent

Thanks,
**The {{ config('app.name') }} Team**
@endcomponent