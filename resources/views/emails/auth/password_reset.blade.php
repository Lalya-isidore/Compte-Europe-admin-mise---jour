<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ __('emails.password_reset_title') }} - {{ __('emails.footer_brand') }}</title>
	
	<!-- Removed the google:notranslate meta tag to allow translation -->
	<style>body{margin:0;padding:0}</style>
</head>
<body style="margin:0;padding:20px;font-family:Segoe UI, Tahoma, Geneva, Verdana, sans-serif;background:#f5f5f7;">
	<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
		<tr>
			<td align="center">
				<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:10px;overflow:hidden;">
					<tr>
						<td style="background:#667eea;padding:20px;text-align:center;color:#fff;font-weight:700;">{{ __('emails.password_reset_heading') }}</td>
					</tr>
					<tr>
						<td style="padding:24px;color:#333;">
							<div style="margin-bottom:12px;">Bonjour {{ $user->nom ?? $user->name ?? $user->email }},</div>
							<div style="margin-bottom:12px;color:#555;">Vous recevez cet e-mail parce que nous avons reçu une demande de réinitialisation du mot de passe pour votre compte.</div>
							<div style="text-align:center;margin:18px 0;">
								<a href="{{ $url }}" style="display:inline-block;padding:12px 20px;background:#667eea;color:#fff;text-decoration:none;border-radius:6px;font-weight:600;">{{ __('emails.password_reset_button') }}</a>
							</div>
							<div style="color:#666;font-size:13px;">Ce lien expirera dans {{ $minutes }} minutes. Si vous n'avez pas demandé de réinitialisation, ignorez simplement cet e-mail.</div>
							<div style="margin-top:18px;color:#333;">{{ __('emails.thanks') }}<br>{{ __('emails.footer_brand') }}</div>
						</td>
					</tr>
					<tr>
						<td style="background:#f8f9fa;padding:16px;text-align:center;color:#777;font-size:13px;">{{ __('emails.footer_brand') }} - {{ __('emails.service_client') }}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>
