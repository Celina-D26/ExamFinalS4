<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'Mobile Money' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f3f4f6; }
        .app { display: flex; min-height: 100vh; }
        .main { flex: 1; padding: 20px 24px 32px; background: #f3f4f6; }

        .balance-card {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #fff;
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 24px;
        }
        .balance-card .amount { font-size: 36px; font-weight: 700; margin: 8px 0; }
        .balance-card .label { opacity: 0.8; font-size: 14px; }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }
        .quick-actions .action {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            color: #111827;
        }
        .quick-actions .action:hover {
            border-color: #2563eb;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37,99,235,0.15);
        }
        .quick-actions .action .icon { font-size: 28px; display: block; margin-bottom: 6px; }
        .quick-actions .action .label { font-size: 13px; font-weight: 600; }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }
        .stats-grid .stat {
            background: #fff;
            padding: 16px 20px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }
        .stats-grid .stat .value { font-size: 20px; font-weight: 700; color: #2563eb; }
        .stats-grid .stat .label { font-size: 12px; color: #6b7280; }

        .transaction-list {
            background: #fff;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }
        .transaction-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .transaction-item:last-child { border-bottom: none; }
        .badge-deposit { background: #22c55e; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; }
        .badge-transfer { background: #3b82f6; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; }
        .badge-withdrawal { background: #f59e0b; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; }
        .positive { color: #22c55e; font-weight: 600; }
        .negative { color: #dc2626; font-weight: 600; }
        .tx-date { font-size: 12px; color: #6b7280; }

        .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }

        @media (max-width: 768px) {
            .quick-actions { grid-template-columns: repeat(2, 1fr); }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .main { padding: 12px 16px; }
        }
        @media (max-width: 576px) {
            .quick-actions { grid-template-columns: 1fr 1fr; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="app">
    <?= view('partials/sidebar', ['username' => $username, 'phone_number' => $phone_number]) ?>
    
    <div class="main">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div style="font-size:20px; font-weight:600;">👤 Tableau de bord</div>
            <span style="font-size:13px; color:#6b7280;"><?= date('d/m/Y H:i') ?></span>
        </div>

        <!-- Balance -->
        <div class="balance-card">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <div class="label">Solde disponible</div>
                    <div class="amount"><?= number_format($client['solde'] ?? 0, 0, ',', ' ') ?> Ar</div>
                </div>
                <div style="text-align:right;">
                    <div class="label">Compte</div>
                    <div style="font-weight:600;"><?= $phone_number ?? '' ?></div>
                    <div style="font-size:12px; opacity:0.8;"><?= $client['client_id'] ?? '' ?></div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <a href="<?= site_url('client/operations') ?>" class="action">
                <span class="icon">💰</span>
                <span class="label">Dépôt</span>
            </a>
            <a href="<?= site_url('client/operations') ?>" class="action">
                <span class="icon">🏦</span>
                <span class="label">Retrait</span>
            </a>
            <a href="<?= site_url('client/operations') ?>" class="action">
                <span class="icon">🔄</span>
                <span class="label">Transfert</span>
            </a>
            <a href="<?= site_url('client/history') ?>" class="action">
                <span class="icon">📊</span>
                <span class="label">Historique</span>
            </a>
        </div>

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat">
                <div class="value"><?= number_format($stats['total'] ?? 0) ?></div>
                <div class="label">Total Transactions</div>
            </div>
            <div class="stat">
                <div class="value"><?= number_format($stats['total_montant'] ?? 0, 0, ',', ' ') ?> Ar</div>
                <div class="label">Montant Total</div>
            </div>
            <div class="stat">
                <div class="value"><?= number_format($stats['total_frais'] ?? 0, 0, ',', ' ') ?> Ar</div>
                <div class="label">Total Frais Payés</div>
            </div>
            <div class="stat">
                <div class="value"><?= number_format($stats['total_net'] ?? 0, 0, ',', ' ') ?> Ar</div>
                <div class="label">Montant Net</div>
            </div>
        </div>

        <!-- Dernières transactions -->
        <div class="transaction-list">
            <div style="display:flex; justify-content:space-between; align-items:center; padding:16px 20px; border-bottom:1px solid #e5e7eb;">
                <div style="font-weight:600;">📋 Dernières transactions</div>
                <a href="<?= site_url('client/history') ?>" style="color:#2563eb; text-decoration:none; font-size:13px;">Voir tout</a>
            </div>
            <?php if (empty($transactions)): ?>
                <div class="empty-state">Aucune transaction</div>
            <?php else: ?>
                <?php foreach ($transactions as $tx): ?>
                    <div class="transaction-item">
                        <div>
                            <?php if ($tx['type_operation'] == 'depot'): ?>
                                <span class="badge-deposit">Dépôt</span>
                            <?php elseif ($tx['type_operation'] == 'transfert'): ?>
                                <span class="badge-transfer">Transfert</span>
                            <?php else: ?>
                                <span class="badge-withdrawal">Retrait</span>
                            <?php endif; ?>
                            <div class="tx-date"><?= date('d/m/Y H:i', strtotime($tx['created_at'])) ?></div>
                            <div style="font-size:11px; color:#6b7280;"><?= $tx['reference'] ?? '' ?></div>
                        </div>
                        <div style="text-align:right;">
                            <?php if ($tx['type_operation'] == 'depot'): ?>
                                <div class="positive">+<?= number_format($tx['montant'], 0, ',', ' ') ?> Ar</div>
                            <?php else: ?>
                                <div class="negative">-<?= number_format($tx['montant'], 0, ',', ' ') ?> Ar</div>
                            <?php endif; ?>
                            <?php if ($tx['frais_appliques'] > 0): ?>
                                <div style="font-size:11px; color:#6b7280;">Frais: <?= number_format($tx['frais_appliques'], 0, ',', ' ') ?> Ar</div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>