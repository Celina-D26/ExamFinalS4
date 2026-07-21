<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Situation des Comptes Clients' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    
    <style>
        :root {
            --c-primary: #2563eb;
            --c-bg: #f8fafc;
            --c-surface: #ffffff;
            --c-border: #e2e8f0;
            --c-text: #0f172a;
            --c-muted: #64748b;
            --c-success: #22c55e;
            --c-warning: #eab308;
            --c-danger: #ef4444;
            --c-accent: #8b5cf6;
            --radius: 8px;
        }

        body {
            margin: 0;
            background: var(--c-bg);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .app {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #0f172a;
            color: #e2e8f0;
            padding: 16px 14px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            padding-bottom: 14px;
        }

        .logo-icon {
            background: var(--c-primary);
            border-radius: 6px;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
        }

        .logo-icon svg {
            fill: #fff;
        }

        .brand-name {
            font-weight: 700;
            font-size: 16px;
            letter-spacing: -0.3px;
            color: #fff;
        }

        .brand-sub {
            font-size: 10px;
            opacity: 0.5;
            letter-spacing: 0.3px;
        }

        .sidebar-section {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            margin: 16px 10px 8px 10px;
            font-weight: 600;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            color: #94a3b8;
            text-decoration: none;
            border-radius: 7px;
            font-size: 13.5px;
            transition: all .15s;
            margin: 1px 0;
            position: relative;
        }

        .nav-item svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            flex-shrink: 0;
        }

        .nav-item:hover {
            background: rgba(255,255,255,0.06);
            color: #f1f5f9;
        }

        .nav-item.active {
            background: var(--c-primary);
            color: #fff;
        }

        .nav-item.active .nav-badge {
            background: rgba(255,255,255,0.2);
        }

        .sidebar-bottom {
            margin-top: auto;
            border-top: 1px solid rgba(255,255,255,0.06);
            padding-top: 12px;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: var(--c-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 13px;
            color: #fff;
            flex-shrink: 0;
        }

        .user-info .name {
            font-weight: 500;
            font-size: 13px;
            color: #f1f5f9;
        }

        .user-info .role {
            font-size: 11px;
            color: #94a3b8;
        }

        .main {
            flex: 1;
            padding: 20px 24px 32px;
            overflow-y: auto;
        }

        .card {
            background: var(--c-surface);
            border-radius: var(--radius);
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            border: 1px solid var(--c-border);
        }

        .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--c-border);
            background: transparent;
            font-weight: 600;
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }

        .kpi-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius);
            padding: 16px 20px;
        }

        .kpi-label {
            font-size: 12px;
            color: var(--c-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .kpi-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--c-text);
            margin-top: 4px;
        }

        .status-badge {
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        .status-actif {
            background: #dcfce7;
            color: #166534;
        }

        .status-inactif {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-suspendu {
            background: #fef3c7;
            color: #92400e;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px;
                padding: 12px 8px;
            }
            .sidebar .brand-name, .sidebar .brand-sub, .sidebar .sidebar-section, 
            .sidebar .nav-item span, .sidebar .nav-badge, .sidebar .user-info {
                display: none;
            }
            .sidebar .nav-item {
                justify-content: center;
                padding: 10px;
            }
            .sidebar .sidebar-brand {
                justify-content: center;
            }
            .main {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>

<div class="app">
    <!-- SIDEBAR -->
    <?= view('partials/sidebar') ?>

    <!-- MAIN CONTENT -->
    <div class="main">

        <div class="topbar" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div class="topbar-title" style="font-size:20px; font-weight:600;">📊 Situation des Comptes Clients</div>
            <div>
                <span style="font-size:14px; color:var(--c-muted);">Dernière mise à jour : <?= date('d/m/Y H:i') ?></span>
            </div>
        </div>

         <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <strong>Erreur :</strong> <?= $error ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- KPIs -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-label">Total Clients</div>
                <div class="kpi-value"><?= $stats['total_clients'] ?? 0 ?></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Total Soldes</div>
                <div class="kpi-value"><?= number_format($stats['total_soldes'] ?? 0, 0, ',', ' ') ?> Ar</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Total Dépôts</div>
                <div class="kpi-value"><?= number_format($stats['total_depots'] ?? 0, 0, ',', ' ') ?> Ar</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Total Frais Payés</div>
                <div class="kpi-value"><?= number_format($stats['total_frais_payes'] ?? 0, 0, ',', ' ') ?> Ar</div>
            </div>
        </div>

        <!-- Tableau des clients -->
        <div class="card">
            <div class="card-header">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span>Liste des Clients</span>
                    <div>
                        <span class="badge bg-primary"><?= $stats['total_clients'] ?? 0 ?> clients</span>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nom & Prénom</th>
                                <th>Téléphone</th>
                                <th>Solde</th>
                                <th>Dépôts</th>
                                <th>Retraits</th>
                                <th>Transferts</th>
                                <th>Frais payés</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($clients)): ?>
                                <?php foreach ($clients as $client): ?>
                                    <tr>
                                        <td><code><?= esc($client['client_id']) ?></code></td>
                                        <td><strong><?= esc($client['prenom']) ?> <?= esc($client['nom']) ?></strong></td>
                                        <td><?= esc($client['phone_number']) ?></td>
                                        <td class="fw-bold <?= $client['solde'] >= 0 ? 'text-success' : 'text-danger' ?>">
                                            <?= number_format($client['solde'], 0, ',', ' ') ?> Ar
                                        </td>
                                        <td><?= number_format($client['total_depots'], 0, ',', ' ') ?> Ar</td>
                                        <td><?= number_format($client['total_retraits'], 0, ',', ' ') ?> Ar</td>
                                        <td><?= number_format($client['total_transferts'], 0, ',', ' ') ?> Ar</td>
                                        <td class="text-primary"><?= number_format($client['total_frais_payes'], 0, ',', ' ') ?> Ar</td>
                                        <td>
                                            <span class="status-badge status-<?= $client['status'] ?>">
                                                <?= ucfirst($client['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-3">
                                        Aucun client enregistré
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div><!-- /main -->
</div><!-- /app -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>