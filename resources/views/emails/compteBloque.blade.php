@extends('emails.layouts.modern')

@php
    $emailTitle = __('emails.account_blocked_title');
    $primaryFrom = '#e11d48';
    $primaryTo = '#b91c1c';
@endphp

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align:center;padding-bottom:12px;">
                <span style="display:inline-block;width:72px;height:72px;line-height:72px;border-radius:50%;background:#fff1d6;text-align:center;font-size:32px;color:#d97706;vertical-align:middle;">
                    <span class="notranslate">⚠️</span>
                </span>
            </td>
        </tr>
        <tr>
            <td style="font-size:26px;color:#dc2626;font-weight:700;text-align:center;padding-bottom:8px;">{{ __('emails.account_blocked_title') }}</td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:15px;color:#5f6b7d;padding-bottom:16px;">{{ __('emails.greeting', ['name' => $compte->nom . ' ' . $compte->prenom]) }}</td>
        </tr>
        <tr>
            <td>
                <div style="background:#fff9e6;border-left:5px solid #f4b400;padding:16px 18px;border-radius:14px;font-size:15px;color:#8a6116;margin-bottom:18px;">
                    {{ __('emails.account_blocked_message') }}
                </div>
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;padding-bottom:18px;">
                {{ __('emails.account_blocked_intro') }}
            </td>
        </tr>
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f7f8fc;border-radius:18px;padding:18px 20px;margin-bottom:24px;border:1px solid #e4e7f2;">
                    <tr>
                        <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_holder') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:16px;font-weight:700;color:#111827;padding-bottom:14px;">{{ $compte->nom }} {{ $compte->prenom }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_email') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:16px;font-weight:600;color:#2563eb;padding-bottom:14px;">{{ $compte->email }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_status') }}</td>
                    </tr>
                    <tr>
                        <td>
                            <span style="display:inline-flex;align-items:center;gap:6px;background:#fee2e2;color:#b91c1c;font-weight:700;font-size:14px;border-radius:999px;padding:6px 18px;text-transform:uppercase;">
                                <span style="font-size:12px;">●</span>{{ __('emails.status_blocked') }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="font-weight:700;font-size:16px;color:#111827;padding-bottom:8px;">{{ __('emails.account_blocked_actions_title') }}</td>
        </tr>
        <tr>
            <td>
                <ul style="margin:0;padding-left:20px;color:#444955;font-size:15px;line-height:1.6;">
                    <li>{{ __('emails.account_blocked_action_contact') }}</li>
                    <li>{{ __('emails.account_blocked_action_check') }}</li>
                    <li>{{ __('emails.account_blocked_action_prepare_docs') }}</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td style="padding-top:22px;font-size:15px;color:#4b5563;">
                {{ __('emails.account_blocked_team_available') }}
            </td>
        </tr>
        <tr>
            <td style="padding-top:22px;font-size:15px;color:#111827;font-weight:600;">
                {{ __('emails.cordially') }}<br>
                <span style="font-weight:700;">L'équipe {{ __('emails.footer_brand') }}</span>
            </td>
        </tr>
    </table>
@endsection
