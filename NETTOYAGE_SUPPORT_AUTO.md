# Système de Nettoyage Automatique des Conversations Support

## 📋 Description

Ce système supprime automatiquement les tickets de support et leurs messages après **7 jours** pour maintenir la base de données propre et les conversations fraîches.

## ⏰ Planification Automatique

- **Fréquence** : Tous les jours à **3h00 du matin**
- **Action** : Suppression des tickets créés il y a plus de 7 jours
- **Logs** : Enregistrés automatiquement dans `storage/logs/laravel.log`

## 🔧 Commandes Disponibles

### Vérifier les statistiques
```bash
php check_support_cleanup.php
```
Affiche la répartition des tickets par période et ceux qui seront supprimés.

### Nettoyer manuellement (avec confirmation)
```bash
php artisan support:clean-old
```

### Nettoyer avec un délai personnalisé
```bash
php artisan support:clean-old --days=14
```

### Nettoyer sans confirmation (automatique)
```bash
php artisan support:clean-old --force
```

## 📊 Ce qui est supprimé

Après 7 jours, le système supprime :
- ✅ Le ticket de support
- ✅ Tous les messages du ticket (utilisateur + admin)
- ✅ Les pièces jointes associées

## 🎯 Objectifs

1. **Base de données propre** : Évite l'accumulation de vieux tickets
2. **Conversations fraîches** : Chaque nouvelle conversation repart à zéro
3. **Performance** : Améliore les performances des requêtes
4. **Confidentialité** : Supprime automatiquement les anciennes données

## 🚀 Activation

Le système est **automatiquement actif** grâce au Task Scheduler de Laravel.

Pour que la planification fonctionne en production, ajoutez cette ligne au cron :
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## 📝 Exemples de Logs

### Succès
```
[2025-11-11 03:00:00] INFO: Nettoyage automatique des tickets de support
{
    "days": 7,
    "cutoff_date": "2025-11-04 03:00:00",
    "tickets_deleted": 5,
    "messages_deleted": 47
}
```

### Échec
```
[2025-11-11 03:00:00] ERROR: Échec du nettoyage automatique des tickets de support
```

## ⚙️ Configuration

Le délai de suppression peut être modifié dans `app/Console/Kernel.php` :

```php
// Changer --days=7 pour un autre délai
$schedule->command('support:clean-old --days=14 --force')
         ->dailyAt('03:00');
```

## 🔍 Vérification

Pour vérifier que la tâche est bien planifiée :
```bash
php artisan schedule:list
```

## ⚠️ Important

- Les tickets supprimés ne peuvent **pas** être récupérés
- La suppression est définitive et irréversible
- Les utilisateurs ne reçoivent **aucune notification** avant suppression
- Le système fonctionne en arrière-plan sans impact sur les performances

## 📞 Support

Pour toute question sur ce système, consultez la documentation Laravel sur le Task Scheduling :
https://laravel.com/docs/10.x/scheduling
