@component('mail::message')
# Your OTP Code

Your one-time verification code is:  
**{{ $otp }}**

@component('mail::panel')
This code will expire in **3 minutes**  
Please use it before {{ now()->addMinutes(3)->format('h:i A') }}
@endcomponent

@component('mail::button', ['url' => config('app.url')])
Visit {{ config('app.name') }}
@endcomponent

Thanks,<br>
{{ config('app.name') }} Team
@endcomponent