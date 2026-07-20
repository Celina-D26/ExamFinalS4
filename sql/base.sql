-- Table users
CREATE TABLE users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    phone_number VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(100),
    email VARCHAR(100),
    last_login DATETIME,
    login_count INTEGER DEFAULT 0,
    created_at DATETIME,
    updated_at DATETIME
);


-- Table des comptes clients
CREATE TABLE IF NOT EXISTS comptes_clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id VARCHAR(20) UNIQUE NOT NULL,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    phone_number VARCHAR(20) UNIQUE NOT NULL,

-- ============================================
-- BASE DE DONNÉES - SYSTÈME DE GESTION DES FRAIS
-- Projet: ExamFinalS4
-- Auteur: [Votre Nom]
-- Date: 2026-07-20
-- ============================================

-- ============================================
-- 1. SUPPRESSION DES TABLES (si elles existent)
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

-- 2.1 Table des barèmes de frais
CREATE TABLE IF NOT EXISTS frais_baremes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation VARCHAR(50) NOT NULL,
    montant_min DECIMAL(12,2) NOT NULL,
    montant_max DECIMAL(12,2) NOT NULL,
    frais DECIMAL(12,2) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2.2 Table des utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(50) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    last_login DATETIME,
    login_count INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2.3 Table des opérations
CREATE TABLE IF NOT EXISTS operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation VARCHAR(50) NOT NULL,
    montant DECIMAL(12,2) NOT NULL,
    frais_appliques DECIMAL(12,2) DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2.4 Table des comptes clients
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

    created_at DATETIME,
    updated_at DATETIME
);

-- Table des transactions
CREATE TABLE IF NOT EXISTS transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id VARCHAR(20) NOT NULL,
    type_operation VARCHAR(20) NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    frais_appliques DECIMAL(15,2) DEFAULT 0,
    montant_net DECIMAL(15,2),
    solde_apres DECIMAL(15,2),
    reference VARCHAR(50) UNIQUE,
    description TEXT,
    status VARCHAR(20) DEFAULT 'completed',
    created_at DATETIME,
    updated_at DATETIME
);

-- Table des barèmes de frais
CREATE TABLE IF NOT EXISTS frais_baremes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation VARCHAR(20) NOT NULL,
    montant_min DECIMAL(15,2) NOT NULL,
    montant_max DECIMAL(15,2) NOT NULL,
    frais DECIMAL(15,2) NOT NULL,
    created_at DATETIME,
    updated_at DATETIME
);


-- Barèmes de retrait
INSERT INTO frais_baremes (type_operation, montant_min, montant_max, frais) VALUES 
('retrait', 100, 1000, 50),
('retrait', 1001, 5000, 75),
('retrait', 5001, 10000, 100),
('retrait', 10001, 25000, 150),
('retrait', 25001, 50000, 200),
('retrait', 50001, 100000, 300),
('retrait', 100001, 250000, 500),
('retrait', 250001, 500000, 800),
('retrait', 500001, 1000000, 1200),
('retrait', 1000001, 2000000, 2000);

-- Barèmes de transfert
INSERT INTO frais_baremes (type_operation, montant_min, montant_max, frais) VALUES 
('transfert', 100, 1000, 25),
('transfert', 1001, 5000, 50),
('transfert', 5001, 10000, 75),
('transfert', 10001, 25000, 100),
('transfert', 25001, 50000, 150),
('transfert', 50001, 100000, 200),
('transfert', 100001, 250000, 300),
('transfert', 250001, 500000, 500),
('transfert', 500001, 1000000, 800),
('transfert', 1000001, 2000000, 1200);

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2.5 Table des transactions
CREATE TABLE IF NOT EXISTS transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id VARCHAR(50) NOT NULL,
    type_operation VARCHAR(20) NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    frais_appliques DECIMAL(15,2) DEFAULT 0,
    montant_net DECIMAL(15,2) NOT NULL,
    solde_apres DECIMAL(15,2) NOT NULL,
    reference VARCHAR(100),
    description TEXT,
    status VARCHAR(20) DEFAULT 'complete',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 2.6 Table des préfixes téléphoniques
CREATE TABLE IF NOT EXISTS prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefix VARCHAR(10) NOT NULL,
    pays VARCHAR(50) NOT NULL,
    operateur VARCHAR(50) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- 3. INSERTION DES DONNÉES
-- ============================================

-- 3.1 Barèmes de frais (20 enregistrements)
INSERT OR IGNORE INTO frais_baremes (type_operation, montant_min, montant_max, frais) VALUES
-- Retraits
('retrait', 100, 1000, 50),
('retrait', 1001, 5000, 50),
('retrait', 5001, 10000, 100),
('retrait', 10001, 25000, 200),
('retrait', 25001, 50000, 400),
('retrait', 50001, 100000, 800),
('retrait', 100001, 250000, 1500),
('retrait', 250001, 500000, 1500),
('retrait', 500001, 1000000, 2500),
('retrait', 1000001, 2000000, 3000),
-- Transferts
('transfert', 100, 1000, 50),
('transfert', 1001, 5000, 50),
('transfert', 5001, 10000, 100),
('transfert', 10001, 25000, 200),
('transfert', 25001, 50000, 400),
('transfert', 50001, 100000, 800),
('transfert', 100001, 250000, 1500),
('transfert', 250001, 500000, 1500),
('transfert', 500001, 1000000, 2500),
('transfert', 1000001, 2000000, 3000);

-- 3.2 Utilisateurs (5 enregistrements)
INSERT OR IGNORE INTO users (username, phone_number, email, login_count) VALUES
('Jean Dupont', '340000001', 'jean.dupont@email.com', 5),
('Marie Martin', '340000002', 'marie.martin@email.com', 3),
('Pierre Ravel', '340000003', 'pierre.ravel@email.com', 8),
('Sophie Raja', '340000004', 'sophie.raja@email.com', 2),
('David Ran', '340000005', 'david.ran@email.com', 6);

-- 3.3 Comptes clients (5 enregistrements)
INSERT OR IGNORE INTO comptes_clients (client_id, nom, prenom, phone_number, email, solde, total_depots, total_retraits, total_transferts, total_frais_payes, status) VALUES
('CLT001', 'Rakoto', 'Jean', '+261321234567', 'jean.rakoto@email.com', 150000, 250000, 80000, 20000, 3500, 'actif'),
('CLT002', 'Razafy', 'Marie', '+261332345678', 'marie.razafy@email.com', 75000, 150000, 50000, 25000, 2000, 'actif'),
('CLT003', 'Andrian', 'Tiana', '+261343456789', 'tiana.andrian@email.com', 250000, 400000, 120000, 30000, 5000, 'actif'),
('CLT004', 'Ralaimihoatra', 'Fano', '+261354567890', 'fano.ralaimihoatra@email.com', 45000, 80000, 30000, 5000, 1200, 'actif'),
('CLT005', 'Randrianarisoa', 'Lala', '+261365678901', 'lala.randrianarisoa@email.com', 120000, 200000, 60000, 20000, 2800, 'actif');

-- 3.4 Transactions (5 enregistrements)
INSERT OR IGNORE INTO transactions (client_id, type_operation, montant, frais_appliques, montant_net, solde_apres, status, created_at) VALUES
('CLT001', 'depot', 50000, 0, 50000, 200000, 'complete', datetime('now', '-2 hours')),
('CLT002', 'retrait', 15000, 50, 14950, 60000, 'complete', datetime('now', '-3 hours')),
('CLT003', 'transfert', 25000, 200, 24800, 225000, 'complete', datetime('now', '-5 hours')),
('CLT004', 'depot', 10000, 0, 10000, 55000, 'complete', datetime('now', '-1 day')),
('CLT005', 'retrait', 5000, 50, 4950, 115000, 'complete', datetime('now', '-2 days'));

-- 3.5 Préfixes téléphoniques (pour Madagascar)
INSERT OR IGNORE INTO prefixes (prefix, pays, operateur) VALUES
('034', 'Madagascar', 'Airtel'),
('033', 'Madagascar', 'Orange'),
('032', 'Madagascar', 'Telma'),
('038', 'Madagascar', 'Airtel'),
('039', 'Madagascar', 'Orange');
