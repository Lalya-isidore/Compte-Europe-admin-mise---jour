# Configuration de l'API SMS Pro

## 📱 Fournisseurs SMS supportés

Le système supporte plusieurs fournisseurs SMS. Actuellement configuré pour **Twilio**.

## 🔧 Configuration Twilio

### Étape 1 : Créer un compte Twilio

1. Allez sur [https://www.twilio.com/try-twilio](https://www.twilio.com/try-twilio)
2. Créez un compte gratuit (vous recevrez des crédits de test)
3. Vérifiez votre email et numéro de téléphone

### Étape 2 : Obtenir vos identifiants

1. Connectez-vous à votre [Console Twilio](https://console.twilio.com/)
2. Sur le Dashboard, vous trouverez :
   - **Account SID** (ex: ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx)
   - **Auth Token** (cliquez sur "Show" pour le révéler)

### Étape 3 : Obtenir un numéro Twilio

1. Dans la console, allez dans **Phone Numbers** → **Manage** → **Buy a number**
2. Choisissez un pays et achetez un numéro (gratuit avec crédits test)
3. Le numéro aura le format : +1234567890

### Étape 4 : Configurer dans le fichier .env

Ajoutez ces lignes dans votre fichier `.env` :

```env
# Configuration SMS Twilio
TWILIO_ACCOUNT_SID=ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
TWILIO_AUTH_TOKEN=votre_auth_token_ici
TWILIO_PHONE_NUMBER=+1234567890
```

### Étape 5 : Configurer le webhook de statut (IMPORTANT)

Pour recevoir les vraies mises à jour de statut (livré/rejeté), configurez le webhook dans Twilio :

1. Allez dans votre [Console Twilio](https://console.twilio.com/)
2. Allez dans **Messaging** → **Settings** → **Geo permissions**
3. Activez les pays où vous voulez envoyer des SMS
4. Pour chaque numéro Twilio :
   - Allez dans **Phone Numbers** → **Manage** → **Active numbers**
   - Cliquez sur votre numéro
   - Dans la section **Messaging**, configurez :
     - **Status Callback URL** : `https://votre-domaine.com/api/sms/webhook/status`
     - Cochez : `Sent`, `Delivered`, `Undelivered`, `Failed`

**⚠️ Important** : En local (http://127.0.0.1), Twilio ne peut pas envoyer de webhooks. Utilisez :
- **ngrok** pour exposer votre serveur local : `ngrok http 8000`
- Ou testez directement sur votre serveur de production

### Étape 6 : Tester

1. Rechargez la page SMS Pro : http://127.0.0.1:8000/sms/pro
2. Envoyez un SMS de test
3. Le SMS sera initialement marqué comme "Livré ✓"
4. Quelques secondes plus tard, le webhook mettra à jour le statut réel :
   - ✅ **Livré** : Si le SMS est bien arrivé
   - ❌ **Rejeté** : Si l'opérateur a bloqué ou le numéro est invalide (crédits remboursés automatiquement)

## 💰 Tarification Twilio

- **Compte test** : Crédits gratuits (environ 15€)
- **SMS sortants** : ~0.07€ par SMS (varie selon le pays)
- **Numéro virtuel** : ~1€/mois

## 🌍 Expéditeur personnalisé (Alphanumeric Sender ID)

Pour envoyer des SMS avec un nom d'expéditeur personnalisé (ex: "TRANSFERFLU" au lieu d'un numéro), vous devez :

1. Créer un **Messaging Service** dans Twilio
2. Configurer l'**Alphanumeric Sender ID**
3. Mettre à jour le code pour utiliser `messagingServiceSid`

**Note** : Certains pays n'autorisent pas les Sender ID alphanumériques.

## 🔄 Comment fonctionne le système de statut ?

### Flux de statut d'un SMS :

1. **Envoi initial** : 
   - ✅ **API configurée** : SMS marqué comme "Envoyé ✉" → Crédits déduits immédiatement
   - ❌ **API non configurée** : SMS marqué comme "Rejeté ⚠" → Crédits remboursés immédiatement

2. **Twilio traite** : Le SMS est envoyé à l'opérateur télécom

3. **Webhook Twilio** : Twilio envoie une requête à votre serveur avec le statut final :
   - `delivered` → Notre système met "Livré ✓" (définitif, pas de remboursement)
   - `undelivered` → Notre système met "Rejeté ⚠" + remboursement automatique
   - `failed` → Notre système met "Rejeté ⚠" + remboursement automatique

### Causes de rejet possibles :

- ❌ Numéro invalide ou inexistant
- ❌ Téléphone éteint ou hors réseau trop longtemps
- ❌ Opérateur bloque les SMS (filtrage anti-spam)
- ❌ Compte prépayé sans crédit
- ❌ Numéro dans une zone non couverte
- ❌ Restriction géographique (certains pays bloquent les SMS internationaux)

### Remboursement automatique :

Quand un SMS est rejeté par l'opérateur :
1. Le webhook reçoit le statut `undelivered` ou `failed`
2. Notre système change le statut de "Envoyé" → "Rejeté"
3. Les crédits sont **automatiquement remboursés** à l'utilisateur
4. L'historique montre "0 crédits utilisés" pour ce SMS

### Les 3 statuts possibles :

- 🔵 **Envoyé** (badge bleu) : SMS envoyé à Twilio, en attente de confirmation de livraison
  - Crédits déjà déduits
  - En attente du webhook de confirmation
  
- ✅ **Livré** (badge vert) : SMS confirmé livré au destinataire
  - Crédits définitivement utilisés
  - Pas de remboursement
  
- ❌ **Rejeté** (badge rouge) : SMS non livré ou API non configurée
  - Crédits remboursés automatiquement
  - Message d'erreur disponible

## 🔄 Autres fournisseurs SMS

### Vonage (Nexmo)
```env
SMS_PROVIDER=vonage
VONAGE_API_KEY=votre_api_key
VONAGE_API_SECRET=votre_api_secret
VONAGE_FROM=VotreSenderID
```

### InfoBip
```env
SMS_PROVIDER=infobip
INFOBIP_API_KEY=votre_api_key
INFOBIP_BASE_URL=https://api.infobip.com
```

## 🐛 Dépannage

### Les SMS sont toujours rejetés
- Vérifiez que les 3 variables Twilio sont bien définies dans `.env`
- Vérifiez que les identifiants sont corrects
- Consultez les logs : `storage/logs/laravel.log`

### Erreur "Unable to create record"
- Le numéro de destination est peut-être invalide
- Votre compte Twilio n'est pas activé
- Vérifiez que le numéro est au format international (+33...)

### Erreur "Unverified numbers"
- En mode test, vous ne pouvez envoyer qu'aux numéros vérifiés
- Allez dans **Verified Caller IDs** pour ajouter des numéros de test
- Ou passez en compte production

## 📊 Monitoring

Les logs des SMS sont disponibles dans :
- **Base de données** : Table `sms_history`
- **Logs Laravel** : `storage/logs/laravel.log`
- **Dashboard Twilio** : [Console Twilio](https://console.twilio.com/)

## ⚠️ Mode Production

Avant de passer en production :

1. Activez votre compte Twilio (carte bancaire requise)
2. Configurez les webhooks de statut de livraison
3. Mettez en place une limite de taux (rate limiting)
4. Configurez un Messaging Service pour le Sender ID
5. Testez avec différents pays et opérateurs
