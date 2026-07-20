-- Créer la table users
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

-- Créer les indexes
CREATE INDEX IF NOT EXISTS idx_phone ON users(phone_number);
CREATE INDEX IF NOT EXISTS idx_username ON users(username);

-- Insérer les données de test
INSERT OR IGNORE INTO users (username, phone_number, created_at, updated_at, login_count) 
VALUES 
    ('Jean Dupont', '340000001', datetime('now'), datetime('now'), 0),
    ('Marie Martin', '340000002', datetime('now'), datetime('now'), 0),
    ('Pierre Ravel', '340000003', datetime('now'), datetime('now'), 0),
    ('Sophie Raja', '340000004', datetime('now'), datetime('now'), 0),
    ('David Ran', '340000005', datetime('now'), datetime('now'), 0);

-- Afficher les données
SELECT '=== DONNÉES INSÉRÉES ===';
SELECT * FROM users;