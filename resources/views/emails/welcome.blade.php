<x-mail::message>
    @component('mail::message')
    # Welcome to {{ config('app.name') }}, {{ $user->name }}!

    Thank you for registering with us. Here's what you can do next:

    - Complete your profile
    - Browse our products
    - Contact support if you need help

    @component('mail::button', ['url' => route('dashboard')])
    Go to Your Dashboard
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }} Team
    @endcomponent
</x-mail::message>