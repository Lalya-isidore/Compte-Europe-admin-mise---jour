@extends('emails.layouts.modern')

@php
    $emailTitle = __('emails.transfer_unlock_code_title');
    $primaryFrom = '#4f46e5';
    $primaryTo = '#7c3aed';
@endphp

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align:center;padding-bottom:12px;">
                <span style="display:inline-block;width:70px;height:70px;line-height:70px;border-radius:50%;background:#ede9fe;text-align:center;font-size:30px;color:#5b21b6;vertical-align:middle;">
                    <span class="notranslate">🔐</span>
                </span>
            </td>
        </tr>
        <tr>
            <td style="font-size:24px;color:#312e81;font-weight:700;text-align:center;padding-bottom:8px;">{{ __('emails.transfer_unlock_heading') }}</td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:15px;color:#5f6b7d;padding-bottom:16px;">{{ __('emails.greeting', ['name' => $compte->nom.' '.$compte->prenom]) }}</td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;padding-bottom:16px;">{{ __('emails.transfer_unlock_message_intro') }}</td>
        </tr>
        <tr>
            <td>
                <div style="background:#eef2ff;border-radius:18px;padding:18px;border:1px solid #c7d2fe;text-align:center;font-size:18px;font-weight:700;color:#312e81;margin-bottom:20px;">
                    {{ number_format($compte->account_balance2, 2, ',', ' ') }} {{ $compte->devise }}
                </div>
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;padding-bottom:10px;text-align:center;">{{ __('emails.transfer_unlock_code_label') }}</td>
        </tr>
        <tr>
            <td style="text-align:center;padding:12px 0 24px;">
                <div style="display:inline-block;background:#0f172a;color:#f8fafc;padding:22px 28px;border-radius:18px;font-family:'Courier New',monospace;font-size:34px;letter-spacing:6px;font-weight:800;">
                    {{ $compte->code_virement }}
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="background:#fff5f5;border-left:5px solid #f87171;padding:14px 16px;border-radius:14px;font-size:14px;color:#b91c1c;margin-bottom:18px;font-weight:600;">
                    {{ __('emails.do_not_share_unlock_code') }} {{ __('emails.unlock_code_personal_confidential') }}
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:15px;color:#4b5563;">
                {{ __('emails.unlock_code_needed_finalize') }}<br>
                {{ __('emails.contact_support_for_questions') }}
            </td>
        </tr>
    </table>
@endsection