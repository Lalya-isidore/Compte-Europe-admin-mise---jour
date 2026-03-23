# Test des webhooks SMS en local avec ngrok

## Installation de ngrok

1. Téléchargez ngrok : https://ngrok.com/download
2. Créez un compte gratuit
3. Connectez votre token : `ngrok config add-authtoken VOTRE_TOKEN`

## Démarrer ngrok

```bash
ngrok http 8000
```

Vous obtiendrez une URL publique comme : `https://abc123.ngrok.io`

## Configurer Twilio avec ngrok

1. Copiez l'URL ngrok (ex: `https://abc123.ngrok.io`)
2. Dans la console Twilio, configurez le webhook :
   - **Status Callback URL** : `https://abc123.ngrok.io/api/sms/webhook/status`

## Tester le webhook

### 1. Envoyer un SMS de test

```bash
# Dans la console Twilio, envoyez un SMS ou utilisez l'interface SMS Pro
```

### 2. Vérifier les logs dans ngrok

Dans le terminal ngrok, vous verrez toutes les requêtes :
```
POST /api/sms/webhook/status    200 OK
```

### 3. Vérifier les logs Laravel

```bash
tail -f storage/logs/laravel.log
```

Vous devriez voir :
```
[2025-12-01 13:00:00] local.INFO: Webhook Twilio reçu
[2025-12-01 13:00:01] local.INFO: Statut SMS mis à jour
```

## Simuler un rejet

Pour tester le remboursement automatique, envoyez un SMS à un numéro invalide :
- **Numéro de test invalide** : +1234567890 (trop court)
- Twilio enverra un webhook avec `MessageStatus=undelivered`
- Notre système changera le statut en "Rejeté" et remboursera les crédits

## Vérifier le remboursement

```bash
php artisan tinker
```

```php
// Voir l'historique
$sms = \App\Models\SmsHistory::latest()->first();
echo "Statut: {$sms->status}\n";
echo "Crédits utilisés: {$sms->credits_used}\n";

// Voir les crédits de l'utilisateur
$user = \App\Models\User::find($sms->user_id);
echo "Crédits disponibles: {$user->credit_user}\n";
```

## Statuts Twilio

Les webhooks Twilio envoient ces paramètres :

```
MessageSid: SM1234567890abcdef
MessageStatus: delivered | undelivered | failed | sent | queued
To: +2290198201610
From: +1234567890
ErrorCode: 30006 (si erreur)
ErrorMessage: Landline or unreachable carrier (si erreur)
```

## Tester manuellement un webhook

Vous pouvez simuler un webhook avec cURL :

```bash
curl -X POST http://127.0.0.1:8000/api/sms/webhook/status \
  -d "MessageSid=SMS_YOUR_MESSAGE_ID" \
  -d "MessageStatus=undelivered" \
  -d "ErrorCode=30006" \
  -d "ErrorMessage=Unreachable destination"
```

Remplacez `SMS_YOUR_MESSAGE_ID` par un vrai ID de la table `sms_history`.
