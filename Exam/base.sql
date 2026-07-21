-- ============================================
-- SCRIPT COMPLET D'INSTALLATION DE LA BASE
-- Mobile Money - Système de Gestion des Frais
-- Date: 2026-07-20
-- ============================================

-- ============================================
-- 1. SUPPRESSION DES TABLES EXISTANTES
-- ============================================

DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS comptes_clients;
DROP TABLE IF EXISTS operations;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS frais_baremes;
DROP TABLE IF EXISTS prefixes;
DROP TABLE IF EXISTS migrations;

-- ============================================
-- 2. CRÉATION DES TABLES
-- ============================================

-- 2.1 Table des préfixes téléphoniques
CREATE TABLE IF NOT EXISTS prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe VARCHAR(10) NOT NULL UNIQUE,
    operateur VARCHAR(50) NOT NULL,
    pays VARCHAR(50) NOT NULL DEFAULT 'Madagascar',
    commission DECIMAL(5,2) DEFAULT 0,
    est_actif INTEGER DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2.2 Table des barèmes de frais
CREATE TABLE IF NOT EXISTS frais_baremes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation VARCHAR(50) NOT NULL,
    montant_min DECIMAL(12,2) NOT NULL,
    montant_max DECIMAL(12,2) NOT NULL,
    frais DECIMAL(12,2) NOT NULL,
    commission_inter_operateur DECIMAL(5,2) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2.3 Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(50) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    password VARCHAR(255),
    pin VARCHAR(6) DEFAULT '1234',
    last_login DATETIME,
    login_count INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2.4 Table des opérations
CREATE TABLE IF NOT EXISTS operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation VARCHAR(50) NOT NULL,
    montant DECIMAL(12,2) NOT NULL,
    frais_appliques DECIMAL(12,2) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2.5 Table des comptes clients
CREATE TABLE IF NOT EXISTS comptes_clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id VARCHAR(50) NOT NULL UNIQUE,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    phone_number VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100),
    solde DECIMAL(15,2) DEFAULT 0,
    total_depots DECIMAL(15,2) DEFAULT 0,
    total_retraits DECIMAL(15,2) DEFAULT 0,
    total_transferts DECIMAL(15,2) DEFAULT 0,
    total_frais_payes DECIMAL(15,2) DEFAULT 0,
    status VARCHAR(20) DEFAULT 'actif',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2.6 Table des transactions
CREATE TABLE IF NOT EXISTS transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id VARCHAR(50) NOT NULL,
    type_operation VARCHAR(20) NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    frais_appliques DECIMAL(15,2) DEFAULT 0,
    commission_inter_operateur DECIMAL(15,2) DEFAULT 0,
    montant_net DECIMAL(15,2),
    solde_apres DECIMAL(15,2),
    reference VARCHAR(100),
    description TEXT,
    status VARCHAR(20) DEFAULT 'complete',
    operateur_destinataire VARCHAR(50),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- 3. AJOUT DES COLONNES SI ELLES N'EXISTENT PAS
-- ============================================

-- 3.1 Pour la table prefixes (déjà créée avec toutes les colonnes)
-- Les colonnes sont déjà présentes dans la création

-- 3.2 Pour la table frais_baremes (déjà créée avec toutes les colonnes)
-- Les colonnes sont déjà présentes dans la création

-- 3.3 Pour la table transactions (déjà créée avec toutes les colonnes)
-- Les colonnes sont déjà présentes dans la création

-- ============================================
-- 4. INSERTION DES DONNÉES
-- ============================================

-- 4.1 Préfixes (8 enregistrements)
INSERT OR IGNORE INTO prefixes (prefixe, operateur, pays, commission, est_actif) VALUES
('031', 'Telma', 'Madagascar', 2.5, 1),
('032', 'Telma', 'Madagascar', 2.5, 1),
('033', 'Orange', 'Madagascar', 3.0, 1),
('034', 'Airtel', 'Madagascar', 2.0, 1),
('038', 'Airtel', 'Madagascar', 2.0, 1),
('039', 'Orange', 'Madagascar', 3.0, 1),
('041', 'Orange', 'France', 5.0, 1),
('077', 'Orange', "Côte d'Ivoire", 4.0, 1);

-- 4.2 Barèmes de frais (20 enregistrements)
INSERT OR IGNORE INTO frais_baremes (type_operation, montant_min, montant_max, frais, commission_inter_operateur) VALUES
-- Retraits
('retrait', 100, 1000, 50, 0),
('retrait', 1001, 5000, 50, 0),
('retrait', 5001, 10000, 100, 0),
('retrait', 10001, 25000, 200, 0),
('retrait', 25001, 50000, 400, 0),
('retrait', 50001, 100000, 800, 0),
('retrait', 100001, 250000, 1500, 0),
('retrait', 250001, 500000, 1500, 0),
('retrait', 500001, 1000000, 2500, 0),
('retrait', 1000001, 2000000, 3000, 0),
-- Transferts
('transfert', 100, 1000, 50, 2.5),
('transfert', 1001, 5000, 50, 2.5),
('transfert', 5001, 10000, 100, 3.0),
('transfert', 10001, 25000, 200, 3.0),
('transfert', 25001, 50000, 400, 4.0),
('transfert', 50001, 100000, 800, 4.0),
('transfert', 100001, 250000, 1500, 5.0),
('transfert', 250001, 500000, 1500, 5.0),
('transfert', 500001, 1000000, 2500, 5.0),
('transfert', 1000001, 2000000, 3000, 5.0);

-- 4.3 Utilisateurs (5 enregistrements)
INSERT OR IGNORE INTO users (username, phone_number, email, login_count) VALUES
('Jean Dupont', '340000001', 'jean.dupont@email.com', 5),
('Marie Martin', '340000002', 'marie.martin@email.com', 3),
('Pierre Ravel', '340000003', 'pierre.ravel@email.com', 8),
('Sophie Raja', '340000004', 'sophie.raja@email.com', 2),
('David Ran', '340000005', 'david.ran@email.com', 6);

-- 4.4 Comptes clients (10 enregistrements)
INSERT OR IGNORE INTO comptes_clients (client_id, nom, prenom, phone_number, email, solde, total_depots, total_retraits, total_transferts, total_frais_payes, status) VALUES
('CLT001', 'Rakoto', 'Jean', '321234567', 'jean.rakoto@email.com', 150000, 250000, 80000, 20000, 3500, 'actif'),
('CLT002', 'Razafy', 'Marie', '332345678', 'marie.razafy@email.com', 75000, 150000, 50000, 25000, 2000, 'actif'),
('CLT003', 'Andrian', 'Tiana', '343456789', 'tiana.andrian@email.com', 250000, 400000, 120000, 30000, 5000, 'actif'),
('CLT004', 'Ralaimihoatra', 'Fano', '354567890', 'fano.ralaimihoatra@email.com', 45000, 80000, 30000, 5000, 1200, 'actif'),
('CLT005', 'Randrianarisoa', 'Lala', '365678901', 'lala.randrianarisoa@email.com', 120000, 200000, 60000, 20000, 2800, 'actif'),
('CLT006', 'Dupont', 'Jean', '340000001', 'jean.dupont@email.com', 166000, 0, 0, 0, 0, 'actif'),
('CLT007', 'Rabe', 'Pierre', '340000003', 'pierre.rabe@email.com', 50000, 0, 0, 0, 0, 'actif'),
('CLT008', 'Rakotomalala', 'Fidy', '340000004', 'fidy.rakotomalala@email.com', 30000, 0, 0, 0, 0, 'actif'),
('CLT009', 'Rasoa', 'Mamy', '340000005', 'mamy.rasoa@email.com', 50000, 0, 0, 0, 0, 'actif'),
('CLT010', 'Randria', 'Tovo', '340000006', 'tovo.randria@email.com', 60000, 0, 0, 0, 0, 'actif');

-- 4.5 Transactions (5 enregistrements)
INSERT OR IGNORE INTO transactions (client_id, type_operation, montant, frais_appliques, commission_inter_operateur, montant_net, solde_apres, status, created_at, description) VALUES
('CLT006', 'depot', 50000, 0, 0, 50000, 216000, 'complete', datetime('now', '-2 hours'), 'Dépôt automatique'),
('CLT006', 'retrait', 15000, 50, 0, -15050, 200950, 'complete', datetime('now', '-1 hour'), 'Retrait'),
('CLT006', 'transfert', 30000, 200, 0, -30200, 170750, 'complete', datetime('now', '-30 minutes'), 'Transfert vers 340000005'),
('CLT009', 'depot', 30000, 0, 0, 30000, 80000, 'complete', datetime('now', '-30 minutes'), 'Transfert reçu de 340000001'),
('CLT001', 'retrait', 5000, 50, 0, -5050, 144950, 'complete', datetime('now', '-15 minutes'), 'Retrait');

-- ============================================
-- 5. VÉRIFICATION FINALE
-- ============================================

SELECT '=== RÉSUMÉ DE LA BASE DE DONNÉES ===' as '';
SELECT 'Préfixes' as Table, COUNT(*) as Total FROM prefixes
UNION ALL
SELECT 'Barèmes', COUNT(*) FROM frais_baremes
UNION ALL
SELECT 'Utilisateurs', COUNT(*) FROM users
UNION ALL
SELECT 'Clients', COUNT(*) FROM comptes_clients
UNION ALL
SELECT 'Transactions', COUNT(*) FROM transactions;

-- ============================================
-- 6. AFFICHAGE DES DONNÉES
-- ============================================

SELECT '=== PRÉFIXES ===' as '';
SELECT prefixe, operateur, pays, commission, est_actif FROM prefixes ORDER BY prefixe;

SELECT '=== BARÈMES DE FRAIS ===' as '';
SELECT type_operation, montant_min, montant_max, frais, commission_inter_operateur 
FROM frais_baremes 
ORDER BY type_operation, montant_min;

SELECT '=== COMPTES CLIENTS ===' as '';
SELECT client_id, nom, prenom, phone_number, solde, status 
FROM comptes_clients ORDER BY client_id;

SELECT '=== TRANSACTIONS ===' as '';
SELECT client_id, type_operation, montant, frais_appliques, status, created_at 
FROM transactions 
ORDER BY created_at DESC;

SELECT '=== UTILISATEURS ===' as '';
SELECT username, phone_number, email, login_count 
FROM users;

-- ============================================
-- 7. STATISTIQUES
-- ============================================

SELECT '=== STATISTIQUES ===' as '';
SELECT 
    (SELECT COUNT(*) FROM comptes_clients) as 'Total Clients',
    (SELECT SUM(solde) FROM comptes_clients) as 'Total Soldes (Ar)',
    (SELECT COUNT(*) FROM transactions) as 'Total Transactions',
    (SELECT SUM(montant) FROM transactions) as 'Total Montant (Ar)',
    (SELECT SUM(frais_appliques) FROM transactions) as 'Total Frais (Ar)',
    (SELECT COUNT(*) FROM frais_baremes) as 'Total Barèmes',
    (SELECT COUNT(*) FROM prefixes) as 'Total Préfixes';

-- ============================================
-- FIN DU SCRIPT
-- ============================================