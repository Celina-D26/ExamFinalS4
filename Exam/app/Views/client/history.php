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

        .balance-info { background: #fff; padding: 16px 20px; border-radius: 12px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #e5e7eb; }
        .balance-info .amount { font-size: 24px; font-weight: 700; color: #2563eb; }

        .filter-bar { display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
        .filter-bar select { padding: 8px 12px; border: 1.5px solid #e5e7eb; border-radius: 8px; background: #fff; outline: none; }
        .filter-bar select:focus { border-color: #2563eb; }

        .transaction-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb; }
        .transaction-table th { background: #f3f4f6; padding: 12px 16px; text-align: left; font-weight: 600; border-bottom: 2px solid #e5e7eb; }
        .transaction-table td { padding: 12px 16px; border-bottom: 1px solid #e5e7eb; }
        .transaction-table tr:last-child td { border-bottom: none; }
        .transaction-table tr:hover { background: #f9fafb; }

        .badge-deposit { background: #22c55e; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .badge-withdrawal { background: #f59e0b; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .badge-transfer { background: #3b82f6; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; display: inline-block; }

        .positive { color: #22c55e; font-weight: 600; }
        .negative { color: #dc2626; font-weight: 600; }
        .text-muted { color: #6b7280; font-size: 12px; }

        .empty-state { text-align: center; padding: 60px 20px; color: #6b7280; }
        .empty-state .icon { font-size: 48px; display: block; margin-bottom: 10px; }

        .debug-info { background: #fef3c7; padding: 10px 15px; border-radius: 8px; margin-bottom: 15px; font-size: 13px; }
        .debug-info strong { color: #92400e; }

        @media (max-width: 768px) {
            .main { padding: 12px 16px; }
            .transaction-table { font-size: 12px; }
            .transaction-table th, .transaction-table td { padding: 8px 10px; }
        }
    </style>
</head>
<body>

<div class="app">
    <?= view('partials/sidebar', ['username' => $username, 'phone_number' => $phone_number]) ?>
    
    <div class="main">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div style="font-size:20px; font-weight:600;">📊 Historique des transactions</div>
        </div>

        <div class="balance-info">
            <span style="font-weight:600;">💰 Solde actuel</span>
            <span class="amount"><?= number_format($client['solde'] ?? 0, 0, ',', ' ') ?> Ar</span>
        </div>

        <!-- Debug Info -->
        <div class="debug-info">
            <strong>🔍 Debug:</strong> 
            Client ID: <?= $client['client_id'] ?? 'N/A' ?> | 
            Nom: <?= $client['nom'] ?? 'N/A' ?> | 
            Transactions trouvées: <?= $total_transactions ?? 0 ?>
            <?php if (!empty($all_transactions)): ?>
                | Total dans la base: <?= count($all_transactions) ?>
            <?php endif; ?>
        </div>

        <div class="filter-bar">
            <select id="filterType" onchange="window.location.href='?type='+this.value">
                <option value="">📋 Tous les types</option>
                <option value="depot" <?= ($current_type ?? '') == 'depot' ? 'selected' : '' ?>>💰 Dépôts</option>
                <option value="retrait" <?= ($current_type ?? '') == 'retrait' ? 'selected' : '' ?>>🏦 Retraits</option>
                <option value="transfert" <?= ($current_type ?? '') == 'transfert' ? 'selected' : '' ?>>🔄 Transferts</option>
            </select>
            <span style="font-size:13px; color:#6b7280; margin-left:auto;">
                Total: <strong><?= count($transactions ?? []) ?></strong> transactions
            </span>
        </div>

        <div style="background:#fff; border-radius:12px; border:1px solid #e5e7eb; overflow:hidden;">
            <?php if (empty($transactions)): ?>
                <div class="empty-state">
                    <span class="icon">📭</span>
                    <h3>Aucune transaction</h3>
                    <p>Vous n'avez pas encore effectué de transactions.</p>
                    <a href="<?= site_url('client/operations') ?>" style="display:inline-block; margin-top:10px; padding:8px 16px; background:#2563eb; color:#fff; border-radius:8px; text-decoration:none;">
                        Faire une opération
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="transaction-table">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Type</th>
                                <th>Montant</th>
                                <th>Frais</th>
                                <th>Description</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $tx): ?>
                                <tr>
                                    <td class="text-muted" style="font-family:monospace;"><?= $tx['reference'] ?? 'N/A' ?></td>
                                    <td>
                                        <?php if (($tx['type_operation'] ?? '') == 'depot'): ?>
                                            <span class="badge-deposit">Dépôt</span>
                                        <?php elseif (($tx['type_operation'] ?? '') == 'retrait'): ?>
                                            <span class="badge-withdrawal">Retrait</span>
                                        <?php else: ?>
                                            <span class="badge-transfer">Transfert</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (($tx['type_operation'] ?? '') == 'depot'): ?>
                                            <span class="positive">+<?= number_format($tx['montant'] ?? 0, 0, ',', ' ') ?> Ar</span>
                                        <?php else: ?>
                                            <span class="negative">-<?= number_format($tx['montant'] ?? 0, 0, ',', ' ') ?> Ar</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= number_format($tx['frais_appliques'] ?? 0, 0, ',', ' ') ?> Ar</td>
                                    <td><?= $tx['description'] ?? '-' ?></td>
                                    <td class="text-muted"><?= date('d/m/Y H:i', strtotime($tx['created_at'] ?? 'now')) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>