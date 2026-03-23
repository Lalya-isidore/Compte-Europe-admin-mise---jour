@extends('emails.layouts.modern')

@php
    $emailTitle = __('emails.compte_activated_title');
    $primaryFrom = '#16a34a';
    $primaryTo = '#065f46';
@endphp

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align:center;padding-bottom:12px;">
                <span style="display:inline-block;width:72px;height:72px;line-height:72px;border-radius:50%;background:#ecfdf5;text-align:center;font-size:34px;color:#15803d;vertical-align:middle;">
                    <span class="notranslate">✅</span>
                </span>
            </td>
        </tr>
        <tr>
            <td style="font-size:24px;color:#15803d;font-weight:700;text-align:center;padding-bottom:8px;">
                {{ __('emails.compte_activated_heading') }}
            </td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:15px;color:#5f6b7d;padding-bottom:16px;">
                {{ __('emails.greeting', ['name' => $compte->nom . ' ' . $compte->prenom]) }}
            </td>
        </tr>
        <tr>
            <td>
                <div style="background:#ecfdf5;border-left:5px solid #10b981;padding:16px 18px;border-radius:16px;font-size:15px;color:#065f46;margin-bottom:18px;font-weight:600;">
                    {{ __('emails.good_news') }} — {{ __('emails.compte_activated_message') }}
                </div>
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;padding-bottom:18px;">
                {{ __('emails.compte_activated_explanation') }}
            </td>
        </tr>
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f7f8fc;border-radius:18px;padding:20px;border:1px solid #e4e7f2;margin-bottom:24px;">
                    <tr>
                        <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_holder') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:17px;font-weight:700;color:#111827;padding-bottom:14px;">{{ $compte->nom }} {{ $compte->prenom }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_email') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:15px;font-weight:600;color:#2563eb;padding-bottom:14px;">{{ $compte->email }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_current_balance') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:16px;font-weight:700;color:#111827;padding-bottom:14px;">{{ number_format($compte->account_balance, 2, ',', ' ') }} {{ $compte->devise }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_status') }}</td>
                    </tr>
                    <tr>
                        <td>
                            <span style="display:inline-flex;align-items:center;gap:6px;background:#dcfce7;color:#15803d;font-weight:700;font-size:13px;border-radius:999px;padding:6px 18px;text-transform:uppercase;">
                                <span style="font-size:10px;">●</span>{{ __('emails.status_active') }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="font-weight:700;font-size:15px;color:#111827;padding-bottom:8px;">{{ __('emails.you_can_now') }}</td>
        </tr>
        <tr>
            <td>
                <ul style="margin:0;padding-left:20px;color:#444955;font-size:15px;line-height:1.6;">
                    <li>{{ __('emails.can_make_transfers') }}</li>
                    <li>{{ __('emails.check_balance') }}</li>
                    <li>{{ __('emails.manage_transactions') }}</li>
                    <li>{{ __('emails.access_services') }}</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td style="padding-top:20px;font-size:15px;color:#4b5563;">
                {{ __('emails.thanks_welcome') }}
            </td>
        </tr>
        <tr>
            <td style="padding-top:20px;font-size:15px;color:#111827;font-weight:600;">
                {{ __('emails.cordially') }}<br>
                <span style="font-weight:700;">{{ "L'équipe " . __('emails.footer_brand') }}</span>
            </td>
        </tr>
    </table>
@endsection
