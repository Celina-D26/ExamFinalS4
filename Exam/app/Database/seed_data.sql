-- Insérer les utilisateurs
INSERT OR IGNORE INTO users (username, phone_number, email, login_count, created_at, updated_at) VALUES
('Jean Dupont', '340000001', 'jean.dupont@example.com', 0, datetime('now'), datetime('now')),
('Marie Martin', '340000002', 'marie.martin@example.com', 0, datetime('now'), datetime('now')),
('Pierre Ravel', '340000003', 'pierre.ravel@example.com', 0, datetime('now'), datetime('now')),
('Sophie Raja', '340000004', 'sophie.raja@example.com', 0, datetime('now'), datetime('now')),
('David Ran', '340000005', 'david.ran@example.com', 0, datetime('now'), datetime('now'));

-- Insérer les clients
INSERT OR IGNORE INTO comptes_clients (client_id, nom, prenom, phone_number, email, solde, total_depots, total_retraits, total_transferts, total_frais_payes, status, created_at, updated_at) VALUES
('CLT0001', 'Jean', 'Dupont', '340000001', 'jean.dupont@example.com', 150000, 250000, 80000, 20000, 3500, 'actif', datetime('now'), datetime('now')),
('CLT0002', 'Marie', 'Martin', '340000002', 'marie.martin@example.com', 75000, 150000, 50000, 25000, 2000, 'actif', datetime('now'), datetime('now')),
('CLT0003', 'Pierre', 'Ravel', '340000003', 'pierre.ravel@example.com', 250000, 400000, 120000, 30000, 5000, 'actif', datetime('now'), datetime('now')),
('CLT0004', 'Sophie', 'Raja', '340000004', 'sophie.raja@example.com', 120000, 200000, 60000, 20000, 2800, 'actif', datetime('now'), datetime('now')),
('CLT0005', 'David', 'Ran', '340000005', 'david.ran@example.com', 180000, 300000, 100000, 20000, 4200, 'actif', datetime('now'), datetime('now'));

-- Insérer les préfixes
INSERT OR IGNORE INTO prefixes (prefixe, operateur, pays, commission, est_actif, created_at, updated_at) VALUES
('032', 'Orange', 'Madagascar', 2.5, 1, datetime('now'), datetime('now')),
('033', 'Telma', 'Madagascar', 1.5, 1, datetime('now'), datetime('now')),
('034', 'Orange', 'Madagascar', 2.5, 1, datetime('now'), datetime('now')),
('036', 'Telma', 'Madagascar', 1.5, 1, datetime('now'), datetime('now')),
('038', 'Airtel', 'Madagascar', 2.0, 1, datetime('now'), datetime('now')),
('039', 'Airtel', 'Madagascar', 2.0, 1, datetime('now'), datetime('now'));

-- Insérer les frais (retrait)
INSERT OR IGNORE INTO frais_baremes (type_operation, montant_min, montant_max, frais, created_at, updated_at) VALUES
('retrait', 100, 1000, 50, datetime('now'), datetime('now')),
('retrait', 1001, 5000, 75, datetime('now'), datetime('now')),
('retrait', 5001, 10000, 100, datetime('now'), datetime('now')),
('retrait', 10001, 25000, 150, datetime('now'), datetime('now')),
('retrait', 25001, 50000, 200, datetime('now'), datetime('now')),
('retrait', 50001, 100000, 300, datetime('now'), datetime('now')),
('retrait', 100001, 250000, 500, datetime('now'), datetime('now')),
('retrait', 250001, 500000, 800, datetime('now'), datetime('now')),
('retrait', 500001, 1000000, 1200, datetime('now'), datetime('now')),
('retrait', 1000001, 2000000, 2000, datetime('now'), datetime('now'));

-- Insérer les frais (transfert)
INSERT OR IGNORE INTO frais_baremes (type_operation, montant_min, montant_max, frais, created_at, updated_at) VALUES
('transfert', 100, 1000, 25, datetime('now'), datetime('now')),
('transfert', 1001, 5000, 50, datetime('now'), datetime('now')),
('transfert', 5001, 10000, 75, datetime('now'), datetime('now')),
('transfert', 10001, 25000, 100, datetime('now'), datetime('now')),
('transfert', 25001, 50000, 150, datetime('now'), datetime('now')),
('transfert', 50001, 100000, 200, datetime('now'), datetime('now')),
('transfert', 100001, 250000, 300, datetime('now'), datetime('now')),
('transfert', 250001, 500000, 500, datetime('now'), datetime('now')),
('transfert', 500001, 1000000, 800, datetime('now'), datetime('now')),
('transfert', 1000001, 2000000, 1200, datetime('now'), datetime('now'));

-- Insérer les transactions
INSERT OR IGNORE INTO transactions (client_id, type_operation, montant, frais_appliques, commission_inter_operateur, montant_net, solde_apres, reference, description, status, created_at) VALUES
('CLT0001', 'depot', 50000, 0, 0, 50000, 150000, 'TXN' || strftime('%Y%m%d') || '000001', 'Dépôt initial', 'completed', datetime('now', '-5 days')),
('CLT0001', 'retrait', 20000, 100, 0, -20100, 129900, 'TXN' || strftime('%Y%m%d') || '000002', 'Retrait automatique', 'completed', datetime('now', '-3 days')),
('CLT0001', 'transfert', 10000, 50, 0, -10050, 119850, 'TXN' || strftime('%Y%m%d') || '000003', 'Transfert vers 340000002', 'completed', datetime('now', '-1 days')),
('CLT0002', 'depot', 30000, 0, 0, 30000, 75000, 'TXN' || strftime('%Y%m%d') || '000004', 'Dépôt initial', 'completed', datetime('now', '-4 days'));