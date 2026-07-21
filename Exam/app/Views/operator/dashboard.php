<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'Mobile Money' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    <style>
        .operator-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }
        .stat-box {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .stat-box .number {
            font-size: 28px;
            font-weight: 700;
            color: #2563eb;
        }
        .stat-box .label {
            font-size: 13px;
            color: #6b7280;
            margin-top: 4px;
        }
        .stat-box .sub {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }
        .operator-fees {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }
        .fee-box {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .fee-box-header {
            padding: 12px 20px;
            background: #f3f4f6;
            font-weight: 600;
            border-bottom: 1px solid #e5e7eb;
        }
        .fee-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 20px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }
        .fee-item:last-child {
            border-bottom: none;
        }
        .fee-value {
            font-weight: 600;
            color: #2563eb;
        }
        .badge-active {
            background: #22c55e;
            color: #fff;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
        }
        .badge-inactive {
            background: #ef4444;
            color: #fff;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
        }
        .client-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
        }
        .client-table th {
            background: #f3f4f6;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #e5e7eb;
        }
        .client-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #e5e7eb;
        }
        .client-table tr:last-child td {
            border-bottom: none;
        }
        .client-table tr:hover {
            background: #f9fafb;
        }
        .btn-sm {
            padding: 4px 12px;
            font-size: 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary-sm {
            background: #2563eb;
            color: #fff;
        }
        .btn-primary-sm:hover {
            background: #1d4ed8;
        }
        .btn-success-sm {
            background: #22c55e;
            color: #fff;
        }
        .btn-success-sm:hover {
            background: #16a34a;
        }
        .btn-danger-sm {
            background: #ef4444;
            color: #fff;
        }
        .btn-danger-sm:hover {
            background: #dc2626;
        }
        .btn-ghost-sm {
            background: transparent;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }
        .btn-ghost-sm:hover {
            background: #f3f4f6;
        }
        .nav-link {
            color: #d1d5db;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            transition: background 0.2s;
        }
        .nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .nav-link.active {
            background: rgba(37,99,235,0.2);
            color: #93bbfc;
        }
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 12px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
            margin-bottom: 16px;
        }
        .sidebar-brand .logo {
            background: #2563eb;
            padding: 8px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sidebar-brand .logo svg {
            width: 18px;
            height: 18px;
            stroke: #fff;
            fill: none;
            stroke-width: 2;
        }
        .sidebar-brand .name {
            font-weight: 700;
            font-size: 18px;
            color: #fff;
        }
        .sidebar-brand .sub {
            font-size: 11px;
            color: #9ca3af;
        }
        .sidebar-section {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #9ca3af;
            padding: 12px 12px 6px 12px;
        }
        .sidebar-bottom {
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }
        .user-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
            margin-bottom: 8px;
        }
        .user-row .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #2563eb;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 13px;
        }
        .user-row .info .name {
            color: #fff;
            font-weight: 600;
            font-size: 14px;
        }
        .user-row .info .role {
            color: #9ca3af;
            font-size: 11px;
        }
        .logout-btn {
            display: block;
            padding: 9px 14px;
            background: #2563eb;
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            font-size: 13.5px;
            text-align: center;
            margin-top: 4px;
        }
        .logout-btn:hover {
            background: #1d4ed8;
        }
        @media (max-width: 1024px) {
            .operator-stats { grid-template-columns: repeat(2, 1fr); }
            .operator-fees { grid-template-columns: 1fr; }
        }
        @media (max-width: 576px) {
            .operator-stats { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div style="display:flex;min-height:100vh;">
    <!-- Sidebar -->
    <aside style="width:260px;background:#1f2937;color:#e5e7eb;padding:16px;display:flex;flex-direction:column;flex-shrink:0;height:100vh;position:sticky;top:0;overflow-y:auto;">
        <div class="sidebar-brand">
            <div class="logo">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <div>
                <div class="name">Mobile Money</div>
                <div class="sub">Opérateur v1.0</div>
            </div>
        </div>

        <div class="sidebar-section">Gestion</div>

        <a href="<?= site_url('operator/dashboard') ?>" class="nav-link active" style="margin:2px 0;">
            <svg width="20" height="20" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                <rect width="7" height="9" x="3" y="3" rx="1"/>
                <rect width="7" height="5" x="14" y="3" rx="1"/>
                <rect width="7" height="9" x="14" y="12" rx="1"/>
                <rect width="7" height="5" x="3" y="16" rx="1"/>
            </svg>
            Tableau de bord
        </a>

        <a href="<?= site_url('operator/clients') ?>" class="nav-link" style="margin:2px 0;">
            <svg width="20" height="20" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Clients
            <span style="margin-left:auto;background:#2563eb;padding:1px 10px;border-radius:20px;font-size:11px;"><?= $total_clients ?? 0 ?></span>
        </a>

        <a href="<?= site_url('operator/fees') ?>" class="nav-link" style="margin:2px 0;">
            <svg width="20" height="20" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                <line x1="12" y1="1" x2="12" y2="23"/>
                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
            Barème des frais
        </a>

        <a href="<?= site_url('client/dashboard') ?>" class="nav-link" style="margin:2px 0;color:#93bbfc;">
            <svg width="20" height="20" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
            Espace Client
        </a>

        <div class="sidebar-bottom">
            <div class="user-row">
                <div class="avatar"><?= substr($username ?? 'U', 0, 2) ?></div>
                <div class="info">
                    <div class="name"><?= esc($username ?? 'Utilisateur') ?></div>
                    <div class="role">📱 <?= esc($phone_number ?? '') ?></div>
                </div>
            </div>
            <a href="<?= site_url('logout') ?>" class="logout-btn">Déconnexion</a>
        </div>
    </aside>

    <!-- Main Content -->
    <div style="flex:1;padding:0;min-height:100vh;background:#f3f4f6;">
        <!-- Topbar -->
        <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 32px;background:#fff;border-bottom:1px solid #e5e7eb;position:sticky;top:0;z-index:10;">
            <div style="font-size:16px;font-weight:600;">📊 Tableau de bord Opérateur</div>
            <div>
                <button style="background:transparent;border:none;padding:8px;cursor:pointer;color:#6b7280;">
                    <svg width="22" height="22" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Content -->
        <div style="padding:24px 32px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                <div>
                    <h2 style="font-size:22px;font-weight:700;">Tableau de bord</h2>
                    <div style="font-size:13px;color:#6b7280;">Opérateur / <span style="color:#111827;">Dashboard</span></div>
                </div>
                <a href="<?= site_url('operator/fees') ?>" class="btn-primary-sm btn-sm" style="padding:8px 16px;font-size:13px;">Gérer les frais</a>
            </div>

            <!-- Statistiques -->
            <div class="operator-stats">
                <div class="stat-box">
                    <div class="number"><?= $total_clients ?? 0 ?></div>
                    <div class="label">👥 Clients</div>
                    <div class="sub">Comptes actifs</div>
                </div>
                <div class="stat-box">
                    <div class="number"><?= $total_transactions ?? 0 ?></div>
                    <div class="label">📊 Transactions</div>
                    <div class="sub">Dernier mois</div>
                </div>
                <div class="stat-box">
                    <div class="number"><?= number_format($total_fees ?? 0, 0, ',', ' ') ?> Ar</div>
                    <div class="label">💰 Total des gains</div>
                    <div class="sub">Frais perçus</div>
                </div>
                <div class="stat-box">
                    <div class="number">99.8%</div>
                    <div class="label">✅ Disponibilité</div>
                    <div class="sub">SLA respecté</div>
                </div>
            </div>

            <!-- Barème des frais -->
            <div class="operator-fees">
                <div class="fee-box">
                    <div class="fee-box-header">💰 Frais de retrait</div>
                    <div class="fee-item">
                        <span>100 - 1 000 Ar</span>
                        <span class="fee-value">50 Ar</span>
                    </div>
                    <div class="fee-item">
                        <span>1 001 - 5 000 Ar</span>
                        <span class="fee-value">1.5%</span>
                    </div>
                    <div class="fee-item">
                        <span>5 001 - 10 000 Ar</span>
                        <span class="fee-value">1.2%</span>
                    </div>
                    <div class="fee-item" style="color:#6b7280;font-size:12px;justify-content:center;">
                        <a href="<?= site_url('operator/fees') ?>" style="color:#2563eb;text-decoration:none;">Voir tous les barèmes →</a>
                    </div>
                </div>

                <div class="fee-box">
                    <div class="fee-box-header">🔄 Frais de transfert</div>
                    <div class="fee-item">
                        <span>100 - 1 000 Ar</span>
                        <span class="fee-value">25 Ar</span>
                    </div>
                    <div class="fee-item">
                        <span>1 001 - 5 000 Ar</span>
                        <span class="fee-value">1.0%</span>
                    </div>
                    <div class="fee-item">
                        <span>5 001 - 10 000 Ar</span>
                        <span class="fee-value">0.8%</span>
                    </div>
                    <div class="fee-item" style="color:#6b7280;font-size:12px;justify-content:center;">
                        <a href="<?= site_url('operator/fees') ?>" style="color:#2563eb;text-decoration:none;">Voir tous les barèmes →</a>
                    </div>
                </div>
            </div>

            <!-- Liste des clients -->
            <div style="background:#fff;border-radius:12px;border:1px solid #e5e7eb;overflow:hidden;">
                <div style="display:flex;justify-content:space-between;align-items:center;padding:16px 20px;border-bottom:1px solid #e5e7eb;">
                    <div style="font-weight:600;">👥 Derniers clients</div>
                    <a href="<?= site_url('operator/clients') ?>" class="btn-ghost-sm btn-sm">Voir tout</a>
                </div>
                <table class="client-table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Téléphone</th>
                            <th>Solde</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($clients)): ?>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td><strong><?= esc($client['name']) ?></strong></td>
                                    <td><?= esc($client['phone']) ?></td>
                                    <td><?= number_format($client['balance'], 0, ',', ' ') ?> Ar</td>
                                    <td>
                                        <span class="<?= $client['status'] == 'Actif' ? 'badge-active' : 'badge-inactive' ?>">
                                            <?= $client['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn-primary-sm btn-sm">Voir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center;color:#6b7280;padding:40px;">
                                    Aucun client enregistré
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>