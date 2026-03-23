@extends('emails.layouts.modern')

@php
    $emailTitle = __('emails.balance_increased_title');
    $primaryFrom = '#10b981';
    $primaryTo = '#059669';
@endphp

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align:center;padding-bottom:12px;">
                <span style="display:inline-block;width:68px;height:68px;line-height:68px;border-radius:50%;background:#ecfdf5;text-align:center;font-size:30px;color:#0f766e;vertical-align:middle;">
                    <span class="notranslate">📈</span>
                </span>
            </td>
        </tr>
        <tr>
            <td style="font-size:24px;color:#047857;font-weight:700;text-align:center;padding-bottom:10px;">
                {{ __('emails.balance_increased_heading') }}
            </td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:15px;color:#5f6b7d;padding-bottom:16px;">
                {{ __('emails.greeting', ['name' => $compte->nom . ' ' . $compte->prenom]) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;padding-bottom:18px;text-align:center;">
                {{ __('emails.balance_increased_message') }}
            </td>
        </tr>
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#ecfdf5;border-radius:20px;padding:20px;border:1px solid #bbf7d0;margin-bottom:22px;">
                    <tr>
                        <td style="font-size:15px;font-weight:700;color:#064e3b;padding-bottom:12px;">{{ __('emails.operation_details') }}</td>
                    </tr>
                    <tr>
                        <td>
                            <table role="presentation" width="100%" cellpadding="6" cellspacing="0" style="border-collapse:collapse;">
                                <tr>
                                    <td style="width:45%;font-size:14px;color:#6b7280;">{{ __('emails.label_amount_added') }}</td>
                                    <td style="width:55%;font-size:15px;font-weight:700;color:#047857;text-align:right;">{{ number_format($montant, 2, ',', ' ') }} {{ $compte->devise }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;">{{ __('emails.label_new_balance') }}</td>
                                    <td style="font-size:15px;font-weight:700;color:#111827;text-align:right;">{{ number_format($compte->account_balance, 2, ',', ' ') }} {{ $compte->devise }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;text-align:center;">
                {{ __('emails.footer_thanks') }}
            </td>
        </tr>
    </table>
@endsection
