<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Situation des Gains' ?></title>
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
            --radius: 8px;
        }

        body {
            margin: 0;
            background: var(--c-bg);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .app { display: flex; min-height: 100vh; }
        
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
        .logo-icon svg { fill: #fff; }
        .brand-name { font-weight: 700; font-size: 16px; color: #fff; }
        .brand-sub { font-size: 10px; opacity: 0.5; }

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
        }
        .nav-item svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,0.06); color: #f1f5f9; }
        .nav-item.active { background: var(--c-primary); color: #fff; }

        .sidebar-bottom { margin-top: auto; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 12px; }
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
        .user-info .name { font-weight: 500; font-size: 13px; color: #f1f5f9; }
        .user-info .role { font-size: 11px; color: #94a3b8; }

        .main { flex: 1; padding: 20px 24px 32px; overflow-y: auto; }

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
        .card-body { padding: 20px; }

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
            text-align: center;
        }
        .kpi-label { font-size: 12px; color: var(--c-muted); font-weight: 500; text-transform: uppercase; letter-spacing: 0.3px; }
        .kpi-value { font-size: 24px; font-weight: 700; margin-top: 4px; }

        .badge-operateur {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-operateur.telma { background: #dbeafe; color: #1e40af; }
        .badge-operateur.orange { background: #fef3c7; color: #92400e; }
        .badge-operateur.airtel { background: #dcfce7; color: #166534; }
        .badge-operateur.inconnu { background: #f3f4f6; color: #6b7280; }

        .resume-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .resume-box .stat-item { text-align: center; padding: 10px; }
        .resume-box .stat-item .number { font-size: 24px; font-weight: 700; }
        .resume-box .stat-item .label { font-size: 11px; opacity: 0.8; }

        @media (max-width: 768px) {
            .sidebar { width: 60px; padding: 12px 8px; }
            .sidebar .brand-name, .sidebar .brand-sub, .sidebar .sidebar-section, 
            .sidebar .nav-item span, .sidebar .nav-badge, .sidebar .user-info { display: none; }
            .sidebar .nav-item { justify-content: center; padding: 10px; }
            .sidebar .sidebar-brand { justify-content: center; }
            .main { padding: 12px 16px; }
            .resume-box .stat-item .number { font-size: 18px; }
        }
    </style>
</head>
<body>

<div class="app">
    <!-- Sidebar -->
    <?= view('partials/sidebar') ?>

    <!-- Main -->
    <div class="main">
        <div class="topbar" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div class="topbar-title" style="font-size:20px; font-weight:600;">💰 Situation des Gains</div>
            <div>
                <a href="<?= base_url('gains/montants') ?>" class="btn btn-primary">
                    📊 Montants par Opérateur
                </a>
                <a href="<?= base_url('gains/export-csv') ?>" class="btn btn-success">
                    📥 Exporter CSV
                </a>
            </div>
        </div>

        <!-- KPIs -->
        <div class="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-label">Total des Gains</div>
                <div class="kpi-value"><?= number_format($totalGains ?? 0, 2, ',', ' ') ?> Ar</div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Nombre de Transactions</div>
                <div class="kpi-value"><?= count($gainsDetail ?? []) ?></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Même Opérateur</div>
                <div class="kpi-value" style="color: var(--c-success);">
                    <?php 
                    $totalMeme = 0;
                    if (!empty($gainsParOperateur['meme_operateur'])) {
                        $totalMeme = array_sum(array_column($gainsParOperateur['meme_operateur'], 'total_frais'));
                    }
                    echo number_format($totalMeme, 2, ',', ' ');
                    ?> Ar
                </div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Autres Opérateurs</div>
                <div class="kpi-value" style="color: var(--c-warning);">
                    <?php 
                    $totalAutre = 0;
                    if (!empty($gainsParOperateur['autre_operateur'])) {
                        $totalAutre = array_sum(array_column($gainsParOperateur['autre_operateur'], 'total_frais'));
                    }
                    echo number_format($totalAutre, 2, ',', ' ');
                    ?> Ar
                </div>
            </div>
        </div>

        <!-- Gains par opérateur -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <span class="badge bg-success">🟢 Même Opérateur</span>
                        <span class="badge bg-secondary"><?= count($gainsParOperateur['meme_operateur'] ?? []) ?> types</span>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($gainsParOperateur['meme_operateur'])): ?>
                            <table class="table table-sm">
                                <thead><tr><th>Type</th><th class="text-end">Nb</th><th class="text-end">Gains</th></tr></thead>
                                <tbody>
                                    <?php foreach ($gainsParOperateur['meme_operateur'] as $g): ?>
                                    <tr>
                                        <td><span class="badge bg-primary"><?= ucfirst($g['type_operation']) ?></span></td>
                                        <td class="text-end"><?= $g['nombre'] ?></td>
                                        <td class="text-end fw-bold text-success"><?= number_format($g['total_frais'], 2, ',', ' ') ?> Ar</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <th>Total</th>
                                        <th class="text-end"><?= array_sum(array_column($gainsParOperateur['meme_operateur'], 'nombre')) ?></th>
                                        <th class="text-end"><?= number_format(array_sum(array_column($gainsParOperateur['meme_operateur'], 'total_frais')), 2, ',', ' ') ?> Ar</th>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php else: ?>
                            <p class="text-muted text-center">Aucun gain pour le même opérateur</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <span class="badge bg-warning">🟡 Autres Opérateurs</span>
                        <span class="badge bg-secondary"><?= count($gainsParOperateur['autre_operateur'] ?? []) ?> types</span>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($gainsParOperateur['autre_operateur'])): ?>
                            <table class="table table-sm">
                                <thead><tr><th>Type</th><th class="text-end">Nb</th><th class="text-end">Gains</th><th class="text-end">Commission</th></tr></thead>
                                <tbody>
                                    <?php foreach ($gainsParOperateur['autre_operateur'] as $g): ?>
                                    <tr>
                                        <td><span class="badge bg-warning"><?= ucfirst($g['type_operation']) ?></span></td>
                                        <td class="text-end"><?= $g['nombre'] ?></td>
                                        <td class="text-end fw-bold text-warning"><?= number_format($g['total_frais'], 2, ',', ' ') ?> Ar</td>
                                        <td class="text-end"><?= number_format($g['total_commission'] ?? 0, 2, ',', ' ') ?> Ar</td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-warning">
                                        <th>Total</th>
                                        <th class="text-end"><?= array_sum(array_column($gainsParOperateur['autre_operateur'], 'nombre')) ?></th>
                                        <th class="text-end"><?= number_format(array_sum(array_column($gainsParOperateur['autre_operateur'], 'total_frais')), 2, ',', ' ') ?> Ar</th>
                                        <th class="text-end"><?= number_format(array_sum(array_column($gainsParOperateur['autre_operateur'], 'total_commission')), 2, ',', ' ') ?> Ar</th>
                                    </tr>
                                </tfoot>
                            </table>
                        <?php else: ?>
                            <p class="text-muted text-center">Aucun gain pour les autres opérateurs</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /main -->
</div><!-- /app -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>