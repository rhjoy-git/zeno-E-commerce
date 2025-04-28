@component('mail::message')
# Your OTP Code

Your one-time password is: **{{ $otp }}**

This code will expire in 10 minutes.

@component('mail::button', ['url' => config('app.url')])
Visit Site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent