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