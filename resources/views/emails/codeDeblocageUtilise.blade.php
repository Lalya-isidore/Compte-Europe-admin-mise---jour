@extends('emails.layouts.modern')

@php
    $emailTitle = __('emails.unlock_code_used_title');
    $primaryFrom = '#f97316';
    $primaryTo = '#ea580c';
@endphp

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align:center;padding-bottom:12px;">
                <span style="display:inline-block;width:68px;height:68px;line-height:68px;border-radius:50%;background:#fff4e6;text-align:center;font-size:30px;color:#c2410c;vertical-align:middle;">
                    <span class="notranslate">🔓</span>
                </span>
            </td>
        </tr>
        <tr>
            <td style="font-size:22px;color:#b45309;font-weight:700;text-align:center;padding-bottom:6px;">{{ __('emails.unlock_code_used_heading') }}</td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:15px;color:#5f6b7d;padding-bottom:14px;">{{ __('emails.greeting_simple') }}</td>
        </tr>
        <tr>
            <td>
                <div style="background:#fff7e0;border-left:5px solid #f97316;padding:15px;border-radius:14px;font-size:14px;color:#92400e;margin-bottom:18px;">
                    {{ __('emails.info_notification') }} {{ __('emails.unlock_code_used_alert') }}
                </div>
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;padding-bottom:18px;">
                {{ __('emails.unlock_code_used_explanation') }}
            </td>
        </tr>
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f7f8fc;border-radius:18px;padding:18px 20px;margin-bottom:24px;border:1px solid #e4e7f2;">
                    <tr>
                        <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_holder') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:16px;font-weight:700;color:#111827;padding-bottom:12px;">{{ $compte->nom }} {{ $compte->prenom }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_email') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:15px;font-weight:600;color:#2563eb;padding-bottom:12px;">{{ $compte->email }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_date_time') }}</td>
                    </tr>
                    <tr>
                        <td style="font-size:15px;color:#111827;padding-bottom:12px;">{{ now()->format('d/m/Y \à H:i') }}</td>
                    </tr>
                    @if($transferDetails)
                        <tr>
                            <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_transfer_amount') }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:15px;color:#111827;padding-bottom:12px;">{{ number_format($transferDetails['montant'] ?? 0, 2, ',', ' ') }} {{ $compte->devise }}</td>
                        </tr>
                        @if(isset($transferDetails['destinataire']))
                            <tr>
                                <td style="font-size:14px;font-weight:600;color:#6b7280;padding-bottom:6px;">{{ __('emails.label_recipient') }}</td>
                            </tr>
                            <tr>
                                <td style="font-size:15px;color:#111827;padding-bottom:12px;">{{ $transferDetails['destinataire'] }}</td>
                            </tr>
                        @endif
                    @endif
                </table>
            </td>
        </tr>
        <tr>
            <td style="font-weight:700;font-size:15px;color:#111827;padding-bottom:6px;">{{ __('emails.urgent_if_not_you') }}</td>
        </tr>
        <tr>
            <td>
                <ul style="margin:0;padding-left:20px;color:#444955;font-size:15px;line-height:1.6;">
                    <li>{{ __('emails.contact_support_immediately') }}</li>
                    <li>{{ __('emails.check_recent_transactions') }}</li>
                    <li>{{ __('emails.change_access_codes') }}</li>
                </ul>
            </td>
        </tr>
        <tr>
            <td style="padding-top:20px;font-size:15px;color:#4b5563;">
                {{ __('emails.regards') }}<br>
                <strong>{{ __('emails.footer_brand') }}</strong>
            </td>
        </tr>
    </table>
@endsection
