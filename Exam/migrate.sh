#!/bin/bash

echo "=== CORRECTION DE LA BASE DE DONNÉES SQLITE ==="

# Chemin du projet
PROJECT_PATH="/opt/lampp/htdocs/S4/Perpa-exam/Exam/Exam"
cd $PROJECT_PATH

# 1. Créer le dossier Database avec les bonnes permissions
echo "📁 Création du dossier Database..."
sudo mkdir -p app/Database
sudo chmod 777 app/Database

# 2. Supprimer l'ancienne base
echo "🗑️ Suppression de l'ancienne base..."
sudo rm -f app/Database/sysinfo.db

# 3. Créer la nouvelle base
echo "📦 Création de la nouvelle base..."
sudo touch app/Database/sysinfo.db
sudo chmod 666 app/Database/sysinfo.db

# 4. Vérifier les permissions
echo "🔍 Vérification des permissions..."
ls -la app/Database/

# 5. Créer la table et les données directement
echo "📊 Création de la table et des données..."
sqlite3 app/Database/sysinfo.db << 'EOF'
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(50) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    last_login DATETIME,
    login_count INTEGER DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
);

INSERT OR IGNORE INTO users (username, phone_number, created_at, updated_at) 
VALUES 
    ('Jean Dupont', '340000001', datetime('now'), datetime('now')),
    ('Marie Martin', '340000002', datetime('now'), datetime('now')),
    ('Pierre Ravel', '340000003', datetime('now'), datetime('now')),
    ('Sophie Raja', '340000004', datetime('now'), datetime('now')),
    ('David Ran', '340000005', datetime('now'), datetime('now'));

SELECT '=== DONNÉES INSÉRÉES ===';
SELECT id, username, phone_number FROM users;
EOF

# 6. Donner les bonnes permissions après création
sudo chmod 666 app/Database/sysinfo.db
sudo chmod 777 app/Database

echo "✅ Correction terminée !"
echo ""
echo "📱 Comptes de test :"
echo "   Jean Dupont / 340000001"
echo "   Marie Martin / 340000002"
echo "   Pierre Ravel / 340000003"
echo "   Sophie Raja / 340000004"
echo "   David Ran / 340000005"