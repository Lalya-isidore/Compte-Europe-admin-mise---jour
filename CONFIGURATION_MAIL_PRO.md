# Configuration Mail Flash Pro

## ✅ Ce qui a été créé

### 1. Base de données
- **Table `mail_history`** : Stocke l'historique des emails envoyés
  - user_id, expediteur, destinataire, objet, contenu
  - adresse_reponse (facultatif), fichier_joint (facultatif)
  - status (Envoyé/Livré/Rejeté), credits_used
  - message_id, error_message

### 2. Modèle
- **MailHistory.php** : Modèle Eloquent avec relation vers User

### 3. Contrôleur
- **MailProController.php** :
  - `index()` : Affiche la page avec formulaire et historique
  - `send()` : Envoie l'email et gère les crédits
  - `details($id)` : Retourne les détails d'un email
  - `deleteHistory()` : Supprime tout l'historique

### 4. Routes
- GET `/mail/flash-pro` : Page principale
- POST `/mail/flash-pro/send` : Envoi d'email
- GET `/mail/flash-pro/details/{id}` : Détails d'un email
- DELETE `/mail/flash-pro/history` : Suppression historique

### 5. Vue
- **resources/views/mail/flash-pro.blade.php** : Interface complète
  - Formulaire d'envoi avec éditeur de texte
  - Upload de fichier (max 2 Mo)
  - Historique des envois sur la droite
  - Modal d'utilité et fonctionnement
  - Modal de détails
  - Notifications persistantes

## 💰 Tarification

- **Coût fixe** : 1000 crédits par email envoyé
- **Remboursement automatique** si l'email est rejeté

## 📋 Fonctionnalités

### Formulaire d'envoi
- ✅ Nom de l'expéditeur (requis)
- ✅ Email du destinataire (requis, validation email)
- ✅ Objet (requis, max 500 caractères)
- ✅ Contenu HTML (requis)
- ✅ Adresse de réponse (facultatif)
- ✅ Pièce jointe (facultatif, PDF/Word/Image, max 2 Mo)

### Historique
- 📊 Affichage des 20 derniers envois
- 🔍 Clic pour voir les détails complets
- 🗑️ Suppression de tout l'historique

### Statuts
- 🔵 **Envoyé** : Email envoyé avec succès (crédits déduits)
- ✅ **Livré** : Confirmé livré (via webhook futur)
- ❌ **Rejeté** : Non livré (crédits remboursés)

## ⚙️ Configuration requise

Le système utilise la configuration email existante dans `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=fluxbank37@gmail.com
MAIL_PASSWORD=bzfkixrhdzydswvu
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="fluxbank37@gmail.com"
MAIL_FROM_NAME="TRANSFERFLUX"
```

### Si l'email n'est pas configuré
- Les emails seront automatiquement marqués comme "Rejeté"
- Les crédits seront remboursés immédiatement
- Un message d'erreur sera affiché

## 🔄 Flux de fonctionnement

1. **Utilisateur remplit le formulaire** → Clique sur "Envoyer"
2. **Vérification des crédits** → 1000 crédits nécessaires
3. **Déduction des crédits** → 1000 crédits déduits immédiatement
4. **Envoi de l'email** → Via le service SMTP configuré
   - ✅ **Succès** : Statut "Envoyé", crédits restent déduits
   - ❌ **Échec** : Statut "Rejeté", crédits remboursés
5. **Enregistrement dans l'historique** → Avec tous les détails
6. **Notification** → Succès ou erreur affiché à l'utilisateur

## 📧 Upload de fichiers

Les fichiers joints sont stockés dans :
```
storage/app/public/mail_attachments/
```

Pour que les fichiers soient accessibles publiquement :
```bash
php artisan storage:link
```

## 🧪 Test du système

### Test 1 : Envoi d'email basique
1. Allez sur `/mail/flash-pro`
2. Cliquez sur "Envoyer un mail pro"
3. Remplissez le formulaire
4. Cliquez sur "Envoyer le mail pro"
5. Vérifiez que l'email apparaît dans l'historique

### Test 2 : Envoi avec pièce jointe
1. Même procédure
2. Ajoutez une pièce jointe (PDF, Word ou Image)
3. Vérifiez que le fichier est uploadé
4. Dans les détails, le lien de téléchargement doit être présent

### Test 3 : Vérification des crédits
1. Notez les crédits avant envoi
2. Envoyez un email
3. Vérifiez que 1000 crédits ont été déduits
4. Si l'email est rejeté, vérifiez le remboursement

### Test 4 : Historique
1. Envoyez plusieurs emails
2. Vérifiez qu'ils apparaissent dans l'historique
3. Cliquez sur un email pour voir les détails
4. Testez la suppression de l'historique

## 🔐 Sécurité

- ✅ Validation des données côté serveur
- ✅ Protection CSRF sur tous les formulaires
- ✅ Vérification des crédits avant envoi
- ✅ Upload de fichiers sécurisé (taille et type)
- ✅ Relations de base de données avec foreign keys
- ✅ Authentification requise (middleware auth)

## 🐛 Dépannage

### Les emails ne sont pas envoyés
- Vérifiez la configuration SMTP dans `.env`
- Consultez les logs : `storage/logs/laravel.log`
- Testez avec `php artisan tinker` et `Mail::raw()`

### Erreur "Crédits insuffisants"
- Rechargez des crédits via FedaPay
- Vérifiez le solde actuel dans la table `users`

### Fichier non uploadé
- Vérifiez la taille (max 2 Mo)
- Vérifiez le type (PDF, DOC, DOCX, JPG, JPEG, PNG)
- Exécutez `php artisan storage:link`

## 📝 TODO (Améliorations futures)

- [ ] Intégrer un éditeur WYSIWYG (TinyMCE, CKEditor)
- [ ] Support de plusieurs destinataires (CC, BCC)
- [ ] Templates d'emails prédéfinis
- [ ] Statistiques d'ouverture et de clics
- [ ] Programmation d'envois différés
- [ ] Webhooks pour les statuts de livraison
- [ ] Export de l'historique en CSV

## 🎨 Interface

L'interface est identique à SMS Pro :
- **Colonne gauche (66%)** : Formulaire d'envoi
- **Colonne droite (33%)** : Historique des envois
- **Modal** : Utilité et fonctionnement
- **Modal** : Détails de l'email
- **Notifications** : Persistantes avec bouton de fermeture

La page est accessible depuis le dashboard via la carte "Mail Flash Pro".
