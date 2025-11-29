# Système d'Alerte SMS - Documentation

## 📱 Vue d'ensemble

Le système d'alerte SMS a été configuré pour **envoyer un seul SMS** lors de l'ouverture du compte client. Tous les autres messages sont envoyés uniquement par e-mail.

## ✅ Comportement

### SMS d'ouverture (Unique)

Lorsque l'option **"Activer l'alerte SMS d'ouverture"** est cochée lors de la création d'un compte :

1. ✅ Un **SMS unique** est envoyé au numéro de téléphone du client
2. 📝 Contenu du SMS (identique à l'email d'ouverture) :
   ```
    🏦 TRANSFERFLUX - Ouverture de compte
   
   Bonjour [Nom] [Prénom],
   
   Votre compte a été créé avec succès !
   
   📧 Email: [email]
   🔑 Mot de passe: [password]
   💰 Solde initial: [montant] [devise]
   
   Connectez-vous dès maintenant à votre espace client.
   
   Les autres notifications vous seront envoyées par e-mail.
   
    Merci d'utiliser TRANSFERFLUX 🏦
   ```
3. 💰 Coût : **1 000 crédits** (prélevés une seule fois lors de la création)
4. 🔒 Ce SMS n'est envoyé **qu'une seule fois** et ne se répète jamais

### Toutes les autres notifications (Email uniquement)

Les notifications suivantes sont **toujours envoyées par e-mail** uniquement :

- 📨 Ouverture de compte (détails du compte)
- 💸 Notification de virement
- ✅ Validation de virement
- ❌ Échec de virement
- 🔑 Code de déblocage de transfert
- 💰 Augmentation de solde
- 📉 Diminution de solde
- 🔒 Compte bloqué
- 🔓 Compte débloqué
- 💵 Notification de remboursement

## 💰 Tarification

| Option | Coût |
|--------|------|
| Création sans SMS | **3 500 crédits** |
| Création avec SMS d'ouverture | **4 500 crédits** (3 500 + 1 000) |

## 🔧 Implémentation technique

### Base de données

Le champ `alert_sms` dans la table `comptes` indique si l'option SMS a été choisie :
- `true` = SMS d'ouverture envoyé
- `false` = Pas de SMS

### Code

**Fichier** : `app/Http/Controllers/compteController.php`

```php
// Envoi du SMS d'ouverture unique si l'option est activée
if ($alertSmsEnabled) {
    $smsMessage = sprintf(
        "🏦 TRANSFERFLUX - Ouverture de compte\n\n" .
        "Bonjour %s %s,\n\n" .
        "Votre compte a été créé avec succès !\n\n" .
        "📧 Email: %s\n" .
        "🔑 Mot de passe: %s\n" .
        "💰 Solde initial: %s %s\n\n" .
        "Connectez-vous dès maintenant à votre espace client.\n\n" .
        "Les autres notifications vous seront envoyées par e-mail.\n\n" .
        "Merci d'utiliser TRANSFERFLUX 🏦",
        $request->nom,
        $request->prenom,
        $request->email,
        $password,
        number_format($request->input('account_balance', 5000.00), 2, ',', ' '),
        $request->devise
    );
    
    $twilioService->sendWhatsAppMessage($request->phone_number, $smsMessage);
}
```

### Service utilisé

- **Twilio Service** : `app/Services/TwilioService.php`
- Méthode : `sendWhatsAppMessage()`
- Format : WhatsApp Business API

## 📊 Vérification

Pour vérifier l'état des alertes SMS :

```bash
php check_sms_alerts.php
```

Affiche :
- Nombre total de comptes
- Comptes avec SMS d'ouverture activé
- Comptes sans SMS
- Détails de chaque compte

## 🎯 Avantages

1. **Économies** : Un seul SMS au lieu de plusieurs
2. **Fiabilité** : Les emails sont plus fiables (SafeMailService)
3. **Clarté** : Le client sait que les notifications seront par email
4. **Coût prévisible** : 1 000 crédits une seule fois

## ⚠️ Important

- Le SMS d'ouverture **ne peut pas être renvoyé**
- Une fois le compte créé, il est impossible d'activer/désactiver l'option SMS
- Tous les emails utilisent **SafeMailService** pour garantir la livraison
- Le champ `alert_sms` est uniquement informatif (historique)

## 🔍 Logs

Les SMS sont logués dans `storage/logs/laravel.log` :

```json
{
    "message": "SMS d'ouverture avec identifiants envoyé",
    "compte_id": 123,
    "phone_number": "+22912345678",
    "email": "client@example.com"
}
```

En cas d'erreur :

```json
{
    "message": "Erreur lors de l'envoi du SMS d'ouverture",
    "compte_id": 123,
    "error": "..."
}
```

## 📝 Texte de l'interface

### Formulaire de création

```
Alerte par SMS (Facultatif)
☐ Activer l'alerte SMS d'ouverture

ℹ️ Un seul SMS sera envoyé : le message d'ouverture du compte.
Tous les autres messages (virements, validation, etc.) seront uniquement par e-mail.
Coût : 1 000 Crédits (envoi unique).
```

## 🚀 Tests

### Créer un compte avec SMS

1. Se connecter à l'admin
2. Aller sur "Créer un compte"
3. Cocher "Activer l'alerte SMS d'ouverture"
4. Remplir le formulaire
5. Vérifier que le coût est bien 4 500 crédits
6. Créer le compte
7. Le SMS est envoyé automatiquement

### Vérifier qu'aucun autre SMS n'est envoyé

1. Créer un virement sur le compte
2. Valider ou refuser le virement
3. Vérifier que seul un email est envoyé

## 📞 Support

Pour toute question sur ce système, consulter :
- La documentation Twilio : https://www.twilio.com/docs
- Le code source : `app/Http/Controllers/compteController.php`
- Les logs : `storage/logs/laravel.log`
