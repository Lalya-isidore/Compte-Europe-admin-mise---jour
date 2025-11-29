@echo off
REM Script pour exécuter le scheduler Laravel sur Windows
REM À exécuter via le Planificateur de tâches Windows

cd /d "c:\xampp\htdocs\CompteEurope"

php artisan schedule:run >> storage\logs\scheduler.log 2>&1

REM Pour configurer ce script dans le Planificateur de tâches Windows:
REM 1. Ouvrir "Planificateur de tâches"
REM 2. Créer une tâche de base
REM 3. Nom: "Laravel Scheduler - CompteEurope"
REM 4. Déclencheur: Quotidien, tous les jours à 03:00
REM 5. Action: Démarrer un programme
REM 6. Programme: C:\xampp\htdocs\CompteEurope\run-scheduler.bat
REM 7. Paramètres avancés: Cocher "Exécuter avec les autorisations maximales"
