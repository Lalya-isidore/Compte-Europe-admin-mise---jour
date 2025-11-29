# Exemple de SMS d'ouverture de compte

## 📱 Aperçu du SMS envoyé

```
┌─────────────────────────────────────┐
│  WhatsApp / SMS                     │
├─────────────────────────────────────┤
│                                     │
│  🏦 TRANSFERFLUX - Ouverture de compte │
│                                     │
│  Bonjour Jean Dupont,               │
│                                     │
│  Votre compte a été créé avec       │
│  succès !                           │
│                                     │
│  📧 Email: jean.dupont@example.com  │
│  🔑 Mot de passe: ABC12345          │
│  💰 Solde initial: 5 000,00 EUR     │
│                                     │
│  Connectez-vous dès maintenant à    │
│  votre espace client.               │
│                                     │
│  Les autres notifications vous      │
│  seront envoyées par e-mail.        │
│                                     │
│  Merci d'utiliser TRANSFERFLUX 🏦      │
│                                     │
└─────────────────────────────────────┘
```

## 📊 Comparaison Email vs SMS

| Information | Email | SMS |
|-------------|-------|-----|
| Nom complet | ✅ | ✅ |
| Email | ✅ | ✅ |
| Mot de passe | ✅ | ✅ |
| Solde initial | ✅ | ✅ |
| Bouton connexion | ✅ | ❌ (texte uniquement) |
| Design HTML | ✅ | ❌ (texte brut) |
| Logo/Images | ✅ | ❌ (émojis uniquement) |

## 🎯 Avantages du SMS

1. **Instantané** : Reçu en quelques secondes
2. **Accessible** : Même sans connexion Internet
3. **Mobile-first** : Parfait pour les clients en déplacement
4. **Complet** : Toutes les informations nécessaires pour se connecter
5. **Pas besoin d'ouvrir l'email** : Informations directement visibles

## ⚠️ Important

- Le SMS contient le mot de passe en clair
- Recommander au client de le supprimer après utilisation
- Le SMS est envoyé via WhatsApp Business (plus fiable)
- Uniquement envoyé si l'option est cochée lors de la création

## 📝 Exemple de cas d'usage

**Sans SMS (3 500 crédits)** :
- Client reçoit uniquement l'email
- Doit avoir accès à sa boîte mail
- Peut prendre plus de temps

**Avec SMS (4 500 crédits)** :
- Client reçoit email + SMS
- Peut se connecter immédiatement depuis son téléphone
- Plus rapide et pratique

## 🔍 Variables utilisées dans le SMS

```php
sprintf(
    "🏦 TRANSFERFLUX - Ouverture de compte\n\n" .
    "Bonjour %s %s,\n\n" .              // Nom + Prénom
    "Votre compte a été créé avec succès !\n\n" .
    "📧 Email: %s\n" .                  // Email de connexion
    "🔑 Mot de passe: %s\n" .           // Mot de passe généré
    "💰 Solde initial: %s %s\n\n" .     // Montant + Devise
    "Connectez-vous dès maintenant à votre espace client.\n\n" .
    "Les autres notifications vous seront envoyées par e-mail.\n\n" .
    "Merci d'utiliser TRANSFERFLUX 🏦",
    $nom,
    $prenom,
    $email,
    $password,
    $montant_formate,
    $devise
);
```

## 🚀 Test en conditions réelles

Pour tester le SMS d'ouverture :

1. Se connecter en tant qu'administrateur
2. Aller sur "Créer un compte"
3. Cocher "Activer l'alerte SMS d'ouverture"
4. Remplir tous les champs (y compris numéro de téléphone)
5. Créer le compte
6. Le SMS sera envoyé automatiquement
7. Vérifier la réception sur le téléphone du client

## 📱 Format du numéro de téléphone

Le numéro doit être au format international :
- ✅ +22912345678 (Bénin)
- ✅ +33612345678 (France)
- ❌ 0612345678 (Format local)
- ❌ 612345678 (Sans indicatif)
