@extends('emails.layouts.modern')

@php
    $emailTitle = __('emails.compte_created_subject');
    $primaryFrom = '#6a5af9';
    $primaryTo = '#a855f7';
@endphp

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align:center;padding-bottom:12px;">
                <span style="display:inline-block;width:70px;height:70px;line-height:70px;border-radius:50%;background:#ede9fe;text-align:center;font-size:30px;color:#6d28d9;vertical-align:middle;">
                    <span class="notranslate">✨</span>
                </span>
            </td>
        </tr>
        <tr>
            <td style="font-size:24px;color:#5b21b6;font-weight:700;text-align:center;padding-bottom:10px;">
                {{ __('emails.compte_created_title') }}
            </td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:15px;color:#5f6b7d;padding-bottom:16px;">
                {{ __('emails.greeting', ['name' => $compte->nom.' '.$compte->prenom]) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;padding-bottom:18px;">
                {{ __('emails.compte_created_message', ['amount' => number_format($compte->account_balance, 2, ',', ' ') . ' ' . $compte->devise]) }}
            </td>
        </tr>
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f1f5ff;border-radius:20px;padding:20px;border:1px solid #e0e7ff;margin-bottom:22px;">
                    <tr>
                        <td style="font-size:14px;font-weight:700;color:#4338ca;padding-bottom:10px;text-transform:uppercase;letter-spacing:0.08em;">{{ __('emails.credentials_title') }}</td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;border-bottom:1px solid #dde3ff;font-size:14px;color:#6b7280;">
                            <span style="display:block;font-weight:600;color:#1f2937;">{{ __('emails.label_email') }}</span>
                            <span style="font-size:16px;font-weight:700;color:#4c1d95;">{{ $compte->email }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;border-bottom:1px solid #dde3ff;font-size:14px;color:#6b7280;">
                            <span style="display:block;font-weight:600;color:#1f2937;">{{ __('emails.label_password') }}</span>
                            <span style="font-family:'Courier New',monospace;font-size:18px;font-weight:700;color:#6d28d9;letter-spacing:1px;">{{ $compte->password }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:10px 0;font-size:14px;color:#6b7280;">
                            <span style="display:block;font-weight:600;color:#1f2937;">{{ __('emails.label_initial_balance') }}</span>
                            <span style="font-size:17px;font-weight:700;color:#111827;">{{ number_format($compte->account_balance, 2, ',', ' ') }} {{ $compte->devise }}</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;padding-bottom:18px;">
                <a href="https://fluxtransfer.world" target="_blank" rel="noopener noreferrer" style="display:inline-block;background:#111827;color:#f8fafc;padding:14px 26px;border-radius:999px;font-size:15px;font-weight:700;text-decoration:none;">
                    {{ __('emails.cta_login') }}
                </a>
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;padding-bottom:12px;text-align:center;">
                {{ __('emails.info_access') }}
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;text-align:center;">
                {{ __('emails.support_contact') }}
            </td>
        </tr>
    </table>
@endsection