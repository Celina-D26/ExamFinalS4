<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'SysInfo — Tableau de bord' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <style>
        /* Variables et styles communs */
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

        .nav-badge {
            margin-left: auto;
            background: rgba(255,255,255,0.12);
            padding: 0 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: 600;
            color: #e2e8f0;
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

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0 20px;
            border-bottom: 1px solid var(--c-border);
            margin-bottom: 24px;
        }

        .topbar-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--c-text);
        }

        .topbar-search {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius);
            padding: 6px 14px;
            flex: 1;
            max-width: 320px;
        }

        .topbar-search svg {
            width: 16px;
            height: 16px;
            stroke: var(--c-muted);
            fill: none;
        }

        .topbar-search input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            color: var(--c-text);
            width: 100%;
        }

        .topbar-actions {
            display: flex;
            gap: 8px;
        }

        .icon-btn {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius);
            padding: 8px 10px;
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-btn svg {
            width: 18px;
            height: 18px;
            stroke: var(--c-muted);
            fill: none;
        }

        .notif-dot {
            width: 6px;
            height: 6px;
            background: var(--c-danger);
            border-radius: 50%;
            position: absolute;
            top: 6px;
            right: 6px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-header h2 {
            font-size: 24px;
            font-weight: 700;
            color: var(--c-text);
            margin: 0;
        }

        .breadcrumb {
            font-size: 13px;
            color: var(--c-muted);
        }

        .breadcrumb span {
            color: var(--c-text);
        }

        .btn-primary {
            background: var(--c-primary);
            border: none;
            color: #fff;
            padding: 8px 16px;
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-primary svg {
            width: 16px;
            height: 16px;
            stroke: #fff;
            fill: none;
        }

        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .kpi-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius);
            padding: 16px 20px;
        }

        .kpi-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }

        .kpi-label {
            font-size: 12px;
            color: var(--c-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .kpi-icon {
            width: 32px;
            height: 32px;
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .kpi-icon.bg-blue {
            background: #dbeafe;
        }
        .kpi-icon.bg-green {
            background: #dcfce7;
        }
        .kpi-icon.bg-amber {
            background: #fef3c7;
        }

        .kpi-icon svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
        }

        .kpi-icon.bg-blue svg {
            stroke: var(--c-primary);
        }
        .kpi-icon.bg-green svg {
            stroke: var(--c-success);
        }
        .kpi-icon.bg-amber svg {
            stroke: var(--c-warning);
        }

        .kpi-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--c-text);
            margin: 2px 0;
        }

        .kpi-delta {
            font-size: 12px;
            color: var(--c-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .kpi-delta.up {
            color: var(--c-success);
        }

        .kpi-delta.down {
            color: var(--c-danger);
        }

        .dash-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .card-header {
            padding: 14px 20px;
            border-bottom: 1px solid var(--c-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: transparent;
        }

        .card-title {
            font-weight: 600;
            font-size: 14px;
            color: var(--c-text);
        }

        .btn-ghost {
            background: transparent;
            border: none;
            color: var(--c-primary);
            font-size: 12px;
            cursor: pointer;
        }

        .chart-area {
            padding: 16px 20px 0 20px;
        }

        .chart-bars {
            display: flex;
            align-items: flex-end;
            gap: 4px;
            height: 120px;
        }

        .chart-bar {
            flex: 1;
            border-radius: 4px 4px 0 0;
            min-height: 8px;
        }

        .chart-bar.bar-primary {
            background: var(--c-primary);
        }
        .chart-bar.bar-accent {
            background: var(--c-accent);
        }

        .chart-labels {
            display: flex;
            justify-content: space-around;
            padding: 8px 20px 16px;
            font-size: 11px;
            color: var(--c-muted);
        }

        .activity-list {
            padding: 8px 0;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 20px;
            border-bottom: 1px solid var(--c-border);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-top: 4px;
            flex-shrink: 0;
        }

        .activity-body {
            flex: 1;
        }

        .act-title {
            font-size: 13px;
            font-weight: 500;
            color: var(--c-text);
        }

        .act-meta {
            font-size: 11px;
            color: var(--c-muted);
            margin-top: 2px;
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
            .dash-grid {
                grid-template-columns: 1fr;
            }
            .topbar-search {
                max-width: 160px;
            }
        }
    </style>
</head>
<body>

<div class="app">

    <!-- Sidebar -->
    <?= view('partials/sidebar') ?>

    <!-- Main -->
    <div class="main">

        <div class="topbar">
            <div class="topbar-title">Tableau de bord</div>
            <div class="topbar-search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" placeholder="Rechercher…" />
            </div>
            <div class="topbar-actions">
                <button class="icon-btn">
                    <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    <span class="notif-dot"></span>
                </button>
                <button class="icon-btn">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
                </button>
            </div>
        </div>

        <div class="content">

            <div class="page-header">
                <div>
                    <h2>Tableau de bord</h2>
                    <div class="breadcrumb">Accueil / <span>Tableau de bord</span></div>
                </div>
                <button class="btn btn-primary btn-sm">
                    <svg viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    Exporter
                </button>
            </div>

            <!-- KPIs avec données dynamiques -->
            <div class="kpi-grid">

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-label">Utilisateurs actifs</div>
                        <div class="kpi-icon bg-blue">
                            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                    </div>
                    <div class="kpi-value">1 284</div>
                    <div class="kpi-delta up">
                        <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor" fill="none"><polyline points="18 15 12 9 6 15"/></svg>
                        +12.5% ce mois
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-label">Clients</div>
                        <div class="kpi-icon bg-green">
                            <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                    </div>
                    <div class="kpi-value"><?= $totalClients ?? 0 ?></div>
                    <div class="kpi-delta up">
                        <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor" fill="none"><polyline points="18 15 12 9 6 15"/></svg>
                        +2 nouveaux
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-label">Gains totaux</div>
                        <div class="kpi-icon bg-amber">
                            <svg viewBox="0 0 24 24"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                    </div>
                    <div class="kpi-value"><?= number_format($totalGains ?? 0, 0, ',', ' ') ?> Ar</div>
                    <div class="kpi-delta up">
                        <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor" fill="none"><polyline points="18 15 12 9 6 15"/></svg>
                        +5.2% ce mois
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-header">
                        <div class="kpi-label">Disponibilité</div>
                        <div class="kpi-icon bg-green">
                            <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                        </div>
                    </div>
                    <div class="kpi-value">99.8<span style="font-size:16px">%</span></div>
                    <div class="kpi-delta up">
                        <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor" fill="none"><polyline points="18 15 12 9 6 15"/></svg>
                        SLA respecté
                    </div>
                </div>

            </div>

            <!-- Graphique + Activité récente -->
            <div class="dash-grid">

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Activité mensuelle</div>
                        <div style="display:flex;gap:12px;font-size:12px;color:var(--c-muted)">
                            <span style="display:flex;align-items:center;gap:5px">
                                <span style="width:10px;height:10px;background:var(--c-primary);border-radius:2px;display:inline-block"></span>
                                Créations
                            </span>
                            <span style="display:flex;align-items:center;gap:5px">
                                <span style="width:10px;height:10px;background:var(--c-accent);border-radius:2px;display:inline-block"></span>
                                Modifications
                            </span>
                        </div>
                    </div>
                    <div class="chart-area">
                        <div class="chart-bars">
                            <div class="chart-bar bar-primary" style="height:55%"></div><div class="chart-bar bar-accent" style="height:40%"></div>
                            <div class="chart-bar bar-primary" style="height:70%"></div><div class="chart-bar bar-accent" style="height:50%"></div>
                            <div class="chart-bar bar-primary" style="height:45%"></div><div class="chart-bar bar-accent" style="height:35%"></div>
                            <div class="chart-bar bar-primary" style="height:80%"></div><div class="chart-bar bar-accent" style="height:65%"></div>
                            <div class="chart-bar bar-primary" style="height:60%"></div><div class="chart-bar bar-accent" style="height:45%"></div>
                            <div class="chart-bar bar-primary" style="height:90%"></div><div class="chart-bar bar-accent" style="height:70%"></div>
                        </div>
                    </div>
                    <div class="chart-labels">
                        <span>Nov</span><span>Déc</span><span>Jan</span><span>Fév</span><span>Mar</span><span>Avr</span>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Activité récente</div>
                        <a href="<?= site_url('comptes') ?>" class="btn btn-primary btn-sm" style="padding:4px 12px;font-size:11px;">Voir tout</a>
                    </div>
                    <div class="activity-list">
                        <?php if (!empty($transactions)): ?>
                            <?php foreach ($transactions as $tx): ?>
                                <div class="activity-item">
                                    <div class="activity-dot" style="background:<?= $tx['type_operation'] == 'depot' ? 'var(--c-success)' : ($tx['type_operation'] == 'retrait' ? 'var(--c-danger)' : 'var(--c-warning)') ?>"></div>
                                    <div class="activity-body">
                                        <div class="act-title"><?= ucfirst($tx['type_operation']) ?> - <?= number_format($tx['montant'], 0, ',', ' ') ?> Ar</div>
                                        <div class="act-meta">Client #<?= $tx['client_id'] ?> — <?= date('d/m/Y H:i', strtotime($tx['created_at'])) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="activity-item">
                                <div class="activity-body">
                                    <div class="act-title">Aucune transaction récente</div>
                                    <div class="act-meta">Les transactions apparaîtront ici</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div><!-- /content -->
    </div><!-- /main -->
</div><!-- /app -->

</body>
</html>