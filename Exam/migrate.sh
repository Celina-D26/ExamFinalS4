#!/bin/bash

echo "=== MIGRATION ET SEEDING ==="

# Étape 1: Créer le dossier Database s'il n'existe pas
mkdir -p app/Database
chmod 755 app/Database

# Étape 2: Exécuter la migration
echo "📦 Exécution de la migration..."
php spark migrate

# Étape 3: Exécuter le seeder
echo "🌱 Exécution du seeder..."
php spark db:seed UserSeeder

echo "✅ Migration et seeding terminés !"