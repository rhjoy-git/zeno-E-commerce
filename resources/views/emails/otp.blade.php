@component('mail::message')
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
        style="max-width: 600px; margin: 0 auto; font-family: Arial, Helvetica, sans-serif; background-color: #f8fafc; color: #1f2937;">

        {{-- Header --}}
        <tr>
            <td style="padding: 20px; text-align: center; background-color: #ffffff; border-bottom: 1px solid #e5e7eb;">
                <img src="{{ asset('images/Zeno.png') }}" alt="Zeno Logo"
                    style="height: 28px; width: auto; display: inline-block;">
            </td>
        </tr>

        {{-- Body --}}
        <tr>
            <td style="padding: 40px 24px; background-color: #ffffff;">
                <h1 style="font-size: 26px; font-weight: bold; color: #111827; margin-bottom: 20px;">
                    🔐 Verification Required
                </h1>

                <p style="font-size: 16px; line-height: 1.6; color: #4b5563; margin-bottom: 20px;">
                    We received a request to verify your identity for <strong>{{ config('app.name') }}</strong>.
                    Please use the following <strong>One-Time Password (OTP)</strong> to proceed:
                </p>

                {{-- OTP Panel --}}
                @component('mail::panel', [
                    'styles' => 'background-color: #f3e8ff; padding: 20px; border-radius: 8px; 
                                                 box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-align: center;',
                ])
                    <div style="margin-bottom: 8px; font-size: 20px; font-weight: bold; color: #1f2937;">
                        Your OTP Code:
                    </div>
                    <div style="font-size: 36px; font-weight: bold; color: #4f46e5; letter-spacing: 3px;">
                        {{ $otp }}
                    </div>
                    <div style="font-size: 14px; color: #6b7280; margin-top: 8px;">
                        This code will expire at <strong>{{ $expires_at }}</strong>.
                    </div>
                @endcomponent

                <p style="font-size: 16px; line-height: 1.6; color: #4b5563; margin-top: 20px;">
                    <strong>Do not share this OTP with anyone.</strong>
                    If you did not initiate this request, please contact us immediately at
                    <a href="mailto:support@{{ config('app.name') }}" style="color: #4f46e5; text-decoration: underline;">
                        support@{{ config('app.name') }}
                    </a>.
                </p>

                {{-- Button --}}
                @component('mail::button', [
                    'url' => route('otp.verify', ['token' => $token]),
                    'color' => 'primary',
                    'styles' => 'background-color: #4f46e5; border-color: #4f46e5; 
                                                 color: #ffffff; padding: 12px 24px; font-size: 16px; 
                                                 font-weight: bold; border-radius: 6px; text-transform: uppercase;',
                ])
                    Verify Now
                @endcomponent
            </td>
        </tr>

        {{-- Footer --}}
        <tr>
            <td
                style="padding: 20px; text-align: center; background-color: #f1f5f9; 
                       font-size: 14px; color: #6b7280; border-top: 1px solid #e5e7eb;">
                <p style="margin: 0;">Thanks,<br><strong>The {{ config('app.name') }} Team</strong></p>
                <p style="margin: 10px 0 0;">
                    <a href="mailto:support@{{ config('app.name') }}" style="color: #4f46e5; text-decoration: none;">Contact
                        Support</a> |
                    <a href="{{ config('app.url') }}" style="color: #4f46e5; text-decoration: none;">Visit
                        {{ config('app.name') }}</a>
                </p>
            </td>
        </tr>
    </table>
@endcomponent
