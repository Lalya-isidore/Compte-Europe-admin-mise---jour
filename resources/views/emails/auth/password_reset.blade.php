@extends('emails.layouts.modern')

@php
	$emailTitle = __('emails.password_reset_title');
	$primaryFrom = '#4c6ef5';
	$primaryTo = '#5f3dc4';
	$expirationKey = 'emails.password_reset_link_expiration';
	$expirationText = __($expirationKey, ['minutes' => $minutes]);
	if ($expirationText === $expirationKey) {
		$fallbackKey = 'emails.password_reset_link_fallback';
		$fallbackText = __($fallbackKey, ['minutes' => $minutes]);
		$expirationText = $fallbackText === $fallbackKey
			? 'Ce lien expirera dans ' . $minutes . ' minutes.'
			: $fallbackText;
	}
@endphp

@section('content')
	<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td style="text-align:center;padding-bottom:12px;">
				<span style="display:inline-block;width:66px;height:66px;line-height:66px;border-radius:50%;background:#e0e7ff;text-align:center;font-size:28px;color:#312e81;vertical-align:middle;">
					<span class="notranslate">🔐</span>
				</span>
			</td>
		</tr>
		<tr>
			<td style="font-size:22px;color:#312e81;font-weight:700;text-align:center;padding-bottom:8px;">
				{{ __('emails.password_reset_heading') }}
			</td>
		</tr>
		<tr>
			<td style="text-align:center;font-size:15px;color:#5f6b7d;padding-bottom:16px;">
				{{ __('emails.greeting', ['name' => $user->nom ?? $user->name ?? $user->email]) }}
			</td>
		</tr>
		<tr>
			<td style="font-size:15px;color:#4b5563;padding-bottom:14px;">
				{{ __('emails.password_reset_reason') }}
			</td>
		</tr>
		<tr>
			<td style="text-align:center;padding-bottom:22px;">
				<a href="{{ $url }}" style="display:inline-block;background:#111827;color:#f8fafc;padding:13px 28px;border-radius:999px;font-size:15px;font-weight:700;text-decoration:none;">
					{{ __('emails.password_reset_button') }}
				</a>
			</td>
		</tr>
		<tr>
			<td style="font-size:13px;color:#6b7280;text-align:center;padding-bottom:18px;">
				{{ $expirationText }}
			</td>
		</tr>
		<tr>
			<td style="font-size:13px;color:#6b7280;text-align:center;padding-bottom:6px;">
				{{ __('emails.password_reset_no_action_needed') }}
			</td>
		</tr>
		<tr>
			<td style="font-size:15px;color:#4b5563;text-align:center;">
				{{ __('emails.thanks') }}<br>
				<strong>{{ __('emails.footer_brand') }}</strong>
			</td>
		</tr>
	</table>
@endsection
