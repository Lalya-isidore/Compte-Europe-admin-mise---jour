@extends('emails.layouts.modern')

@php
    $emailLang = $compte->lang ?? app()->getLocale();
    $emailDir = in_array($emailLang, ['ar','he','fa']) ? 'rtl' : 'ltr';
    $emailTitle = __('emails.refund_subject');
    $primaryFrom = '#f59e0b';
    $primaryTo = '#d97706';
    $amountFormatted = number_format($compte->account_balance2, 2, ',', ' ') . ' ' . $compte->devise;
    $amountHtml = '<strong>' . $amountFormatted . '</strong>';
    $refundRaw = str_replace(':amount', $amountHtml, __('emails.refund_notice'));
@endphp

@section('content')
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="text-align:center;padding-bottom:12px;">
                <span style="display:inline-block;width:70px;height:70px;line-height:70px;border-radius:50%;background:#fff7ed;text-align:center;font-size:32px;color:#c2410c;vertical-align:middle;">
                    <span class="notranslate">⚠️</span>
                </span>
            </td>
        </tr>
        <tr>
            <td style="font-size:24px;color:#c2410c;font-weight:700;text-align:center;padding-bottom:8px;">
                {{ __('emails.refund_title') }}
            </td>
        </tr>
        <tr>
            <td style="text-align:center;font-size:15px;color:#5f6b7d;padding-bottom:16px;">
                {{ __('emails.greeting', ['name' => $compte->nom . ' ' . $compte->prenom]) }}
            </td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;padding-bottom:18px;">
                {{ __('emails.refund_failed_message') }}
            </td>
        </tr>
        <tr>
            <td>
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#fff7e5;border-left:5px solid #f59e0b;border-radius:20px;padding:20px;border:1px solid #fde7c3;margin-bottom:22px;">
                    <tr>
                        <td style="font-size:15px;font-weight:700;color:#92400e;padding-bottom:12px;">{{ __('emails.details_title') }}</td>
                    </tr>
                    <tr>
                        <td>
                            <table role="presentation" width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse;">
                                <tr>
                                    <td style="width:45%;font-size:14px;color:#6b7280;">{{ __('emails.label_amount') }}</td>
                                    <td style="width:55%;font-size:15px;font-weight:700;color:#c2410c;text-align:{{ $emailDir === 'rtl' ? 'left' : 'right' }};">{{ $amountFormatted }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;">{{ __('emails.label_date') }}</td>
                                    <td style="font-size:14px;color:#111827;text-align:{{ $emailDir === 'rtl' ? 'left' : 'right' }};">{{ optional($transfer)->created_at }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;">{{ __('emails.label_recipient') }}</td>
                                    <td style="font-size:14px;color:#111827;text-align:{{ $emailDir === 'rtl' ? 'left' : 'right' }};">{{ optional($transfer)->beneficiary_name }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;">{{ __('emails.label_reason') }}</td>
                                    <td style="font-size:14px;color:#111827;text-align:{{ $emailDir === 'rtl' ? 'left' : 'right' }};">{{ optional($transfer)->reason }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <div style="background:#e0edff;border-left:5px solid #2563eb;border-radius:18px;padding:18px 20px;margin-bottom:20px;font-size:15px;color:#1d4ed8;font-weight:600;">
                    <span class="notranslate">💳&nbsp;&nbsp;</span>{!! $refundRaw !!}
                </div>
            </td>
        </tr>
        <tr>
            <td style="height:1px;background:#e5e7eb;margin:22px 0;display:block;"></td>
        </tr>
        <tr>
            <td style="font-size:15px;color:#4b5563;text-align:center;">
                {{ __('emails.apology') }}
            </td>
        </tr>
    </table>
@endsection
