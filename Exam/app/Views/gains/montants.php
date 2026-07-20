<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Montants par Opérateur' ?></title>
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

        .badge-operateur {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        .badge-operateur.telma { background: #dbeafe; color: #1e40af; }
        .badge-operateur.orange { background: #fef3c7; color: #92400e; }
        .badge-operateur.airtel { background: #dcfce7; color: #166534; }
        .badge-operateur.reverser { background: #fef3c7; color: #92400e; }

        .operator-card {
            border-left: 4px solid var(--c-primary);
            transition: all 0.3s;
            height: 100%;
        }
        .operator-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

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
            <div class="topbar-title" style="font-size:20px; font-weight:600;">💰 Montants à envoyer par Opérateur</div>
            <div>
                <a href="<?= base_url('gains/export-montants-csv') ?>" class="btn btn-success">
                    📥 Exporter CSV
                </a>
                <a href="<?= base_url('gains') ?>" class="btn btn-secondary">
                    ⬅️ Retour
                </a>
            </div>
        </div>

        <!-- Résumé Général -->
        <div class="resume-box">
            <h4 class="mb-3">📊 Récapitulatif Général</h4>
            <div class="row">
                <div class="col-md-2 col-6 stat-item">
                    <div class="number"><?= $resumeGeneral['nombre_transactions'] ?? 0 ?></div>
                    <div class="label">Transactions</div>
                </div>
                <div class="col-md-2 col-6 stat-item">
                    <div class="number"><?= number_format($resumeGeneral['total_montant'] ?? 0, 0, ',', ' ') ?></div>
                    <div class="label">Montant Total</div>
                </div>
                <div class="col-md-2 col-6 stat-item">
                    <div class="number" style="color: #fca5a5;"><?= number_format($resumeGeneral['total_frais'] ?? 0, 0, ',', ' ') ?></div>
                    <div class="label">Frais</div>
                </div>
                <div class="col-md-2 col-6 stat-item">
                    <div class="number" style="color: #fcd34d;"><?= number_format($resumeGeneral['total_commission'] ?? 0, 0, ',', ' ') ?></div>
                    <div class="label">Commission Inter</div>
                </div>
                <div class="col-md-2 col-6 stat-item">
                    <div class="number" style="color: #86efac;"><?= number_format($resumeGeneral['total_a_envoyer'] ?? 0, 0, ',', ' ') ?></div>
                    <div class="label">✅ À Garder</div>
                </div>
                <div class="col-md-2 col-6 stat-item">
                    <div class="number" style="color: #fbbf24;"><?= number_format($resumeGeneral['total_a_reverser'] ?? 0, 0, ',', ' ') ?></div>
                    <div class="label">❌ À Reverser</div>
                </div>
            </div>
        </div>

        <!-- Cartes par opérateur -->
        <div class="row">
            <?php if (!empty($montantsParOperateur)): ?>
                <?php 
                $totalGeneral = $resumeGeneral['total_a_envoyer'] + $resumeGeneral['total_a_reverser'];
                $colors = ['primary', 'warning', 'info', 'danger'];
                $idx = 0;
                ?>
                <?php foreach ($montantsParOperateur as $op): ?>
                    <?php 
                    $totalOp = $op['total_a_envoyer'] + $op['total_a_reverser'];
                    $pourcentage = $totalGeneral > 0 ? ($totalOp / $totalGeneral) * 100 : 0;
                    $badgeClass = strtolower(str_replace(' (VOUS)', '', $op['operateur'] ?? 'inconnu'));
                    $color = $colors[$idx % count($colors)];
                    $idx++;
                    ?>
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="card operator-card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>
                                    <span class="badge-operateur <?= $badgeClass ?>">
                                        <?= esc($op['operateur'] ?? 'Inconnu') ?>
                                    </span>
                                </span>
                                <span class="badge bg-secondary"><?= $op['nombre_transactions'] ?? 0 ?> transactions</span>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-muted">Montant Total</small>
                                        <div class="fw-bold"><?= number_format($op['total_montant'] ?? 0, 0, ',', ' ') ?> Ar</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Frais</small>
                                        <div class="fw-bold text-danger"><?= number_format($op['total_frais'] ?? 0, 0, ',', ' ') ?> Ar</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Commission</small>
                                        <div class="fw-bold text-warning"><?= number_format($op['total_commission'] ?? 0, 0, ',', ' ') ?> Ar</div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Total</small>
                                        <div class="fw-bold text-success" style="font-size:18px;">
                                            <?= number_format($totalOp, 0, ',', ' ') ?> Ar
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between">
                                        <small>Progression</small>
                                        <small><?= number_format($pourcentage, 1, ',', ' ') ?>%</small>
                                    </div>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-<?= $color ?>" role="progressbar" 
                                             style="width: <?= $pourcentage ?>%;" 
                                             aria-valuenow="<?= $pourcentage ?>" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-sm btn-outline-primary mt-3 w-100" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#detail<?= $idx ?>">
                                    📋 Voir les détails
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <h5>📭 Aucune donnée disponible</h5>
                        <p>Il n'y a pas encore de transactions pour afficher les montants par opérateur.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Tableau récapitulatif -->
        <div class="card mt-4">
            <div class="card-header">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span>📊 Récapitulatif Détaillé</span>
                    <span class="badge bg-primary"><?= count($montantsParOperateur) ?> opérateurs</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Opérateur</th>
                                <th class="text-end">Nb Trans</th>
                                <th class="text-end">Montant Total</th>
                                <th class="text-end">Frais</th>
                                <th class="text-end">Commission</th>
                                <th class="text-end">✅ À Garder</th>
                                <th class="text-end">❌ À Reverser</th>
                                <th class="text-end">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($montantsParOperateur)): ?>
                                <?php 
                                $totalGeneral = $resumeGeneral['total_a_envoyer'] + $resumeGeneral['total_a_reverser'];
                                foreach ($montantsParOperateur as $op): 
                                    $totalOp = $op['total_a_envoyer'] + $op['total_a_reverser'];
                                    $pourcentage = $totalGeneral > 0 ? ($totalOp / $totalGeneral) * 100 : 0;
                                ?>
                                <tr>
                                    <td><strong><?= esc($op['operateur'] ?? 'Inconnu') ?></strong></td>
                                    <td class="text-end"><?= $op['nombre_transactions'] ?? 0 ?></td>
                                    <td class="text-end"><?= number_format($op['total_montant'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                    <td class="text-end text-danger"><?= number_format($op['total_frais'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                    <td class="text-end text-warning"><?= number_format($op['total_commission'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                    <td class="text-end text-success"><?= number_format($op['total_a_envoyer'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                    <td class="text-end text-warning"><?= number_format($op['total_a_reverser'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                    <td class="text-end"><?= number_format($pourcentage, 1, ',', ' ') ?>%</td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">
                                        <div>📭 Aucune donnée disponible</div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary fw-bold">
                                <td>TOTAL GÉNÉRAL</td>
                                <td class="text-end"><?= $resumeGeneral['nombre_transactions'] ?? 0 ?></td>
                                <td class="text-end"><?= number_format($resumeGeneral['total_montant'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                <td class="text-end"><?= number_format($resumeGeneral['total_frais'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                <td class="text-end"><?= number_format($resumeGeneral['total_commission'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                <td class="text-end text-success"><?= number_format($resumeGeneral['total_a_envoyer'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                <td class="text-end text-warning"><?= number_format($resumeGeneral['total_a_reverser'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                <td class="text-end">100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Détails par opérateur -->
        <?php if (!empty($montantsParOperateur)): ?>
            <?php $idx = 0; foreach ($montantsParOperateur as $op): $idx++; ?>
                <div class="collapse mt-3" id="detail<?= $idx ?>">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>
                                <strong><?= esc($op['operateur'] ?? 'Inconnu') ?></strong>
                                <span class="badge bg-secondary ms-2"><?= $op['nombre_transactions'] ?? 0 ?> transactions</span>
                                <span class="badge bg-success ms-2">✅ <?= number_format($op['total_a_envoyer'] ?? 0, 0, ',', ' ') ?> Ar</span>
                                <span class="badge bg-warning ms-2">❌ <?= number_format($op['total_a_reverser'] ?? 0, 0, ',', ' ') ?> Ar</span>
                            </span>
                            <button class="btn btn-sm btn-secondary" data-bs-toggle="collapse" data-bs-target="#detail<?= $idx ?>">✖ Fermer</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Client</th>
                                            <th>Type</th>
                                            <th class="text-end">Montant</th>
                                            <th class="text-end">Frais</th>
                                            <th class="text-end">Commission</th>
                                            <th class="text-end">✅ Gardé</th>
                                            <th class="text-end">❌ Reversé</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; foreach ($op['details'] as $detail): ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $detail['client_id'] ?? 'N/A' ?></td>
                                                <td><span class="badge bg-info"><?= ucfirst($detail['type']) ?></span></td>
                                                <td class="text-end"><?= number_format($detail['montant'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                                <td class="text-end text-danger"><?= number_format($detail['frais'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                                <td class="text-end text-warning"><?= number_format($detail['commission'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                                <td class="text-end text-success"><?= number_format($detail['a_envoyer'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                                <td class="text-end text-warning"><?= number_format($detail['a_reverser'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                                <td><?= date('d/m/Y H:i', strtotime($detail['date'] ?? 'now')) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-success">
                                            <td colspan="6" class="text-end"><strong>TOTAL</strong></td>
                                            <td class="text-end"><strong><?= number_format($op['total_a_envoyer'] ?? 0, 0, ',', ' ') ?> Ar</strong></td>
                                            <td class="text-end"><strong><?= number_format($op['total_a_reverser'] ?? 0, 0, ',', ' ') ?> Ar</strong></td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div><!-- /main -->
</div><!-- /app -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>