@extends('emails.layouts.modern')

@php
    $emailTitle = __('emails.welcome_title');
    $primaryFrom = '#7c3aed';
    $primaryTo = '#5b21b6';
@endphp

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align:center;padding-bottom:12px;">
                <span style="display:inline-block;width:80px;height:80px;line-height:80px;border-radius:50%;background:#ede9fe;text-align:center;font-size:36px;color:#5b21b6;vertical-align:middle;">
                    <span class="notranslate">👋</span>
                </span>
            </td>
        </tr>
        <tr>
            <td style="font-size:24px;color:#4c1d95;font-weight:700;text-align:center;padding-bottom:10px;">
                {{ __('emails.welcome_heading') }}
            </td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:15px;color:#5f6b7d;padding-bottom:16px;">
                {{ __('emails.greeting', ['name' => $user->nom.' '.$user->prenom]) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;padding-bottom:18px;text-align:center;">
                {{ __('emails.welcome_message') }}
            </td>
        </tr>
        <tr>
            <td>
                <div style="background:#f4f6ff;border-radius:18px;border:1px solid #dfe4ff;padding:20px 22px;margin-bottom:22px;">
                    <div style="font-weight:700;color:#4c1d95;font-size:14px;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:10px;">
                        {{ __('emails.login_credentials_title') }}
                    </div>
                    <div style="display:flex;align-items:center;gap:10px;background:#ffffff;border-radius:14px;padding:14px 16px;box-shadow:0 6px 16px rgba(93,63,211,0.08);">
                        <span style="font-size:20px;color:#7c3aed;">📧</span>
                        <span style="font-family:'Courier New',monospace;font-size:17px;font-weight:700;color:#1f2937;">{{ $user->email }}</span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;padding-bottom:12px;text-align:center;">
                {{ __('emails.access_member_area') }}
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;text-align:center;">
                {{ __('emails.pleasure_to_assist') }}
            </td>
        </tr>
    </table>
@endsection