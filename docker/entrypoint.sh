#!/bin/sh
set -e

echo "Attente de la base de données..."
until php -r "require 'config/bootstrap.php';" 2>/dev/null; do
    sleep 1
done

echo "Exécution des migrations..."
php marieme:migrate

echo "Exécution des seeders..."
php marieme:seed

echo "Démarrage du serveur PHP..."
exec php -S 0.0.0.0:8000 -t public