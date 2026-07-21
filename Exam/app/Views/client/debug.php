<!DOCTYPE html>
<html>
<head>
    <title>Debug</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .card { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f0f0f0; }
        .info { background: #e3f2fd; padding: 10px; border-radius: 4px; margin-bottom: 10px; }
        .error { background: #ffebee; padding: 10px; border-radius: 4px; margin-bottom: 10px; color: #c62828; }
        .success { background: #e8f5e9; padding: 10px; border-radius: 4px; margin-bottom: 10px; color: #2e7d32; }
    </style>
</head>
<body>
    <div class="card">
        <h2>🔍 Debug des transactions</h2>
        
        <div class="info">
            <strong>Client connecté:</strong> <?= $client['nom'] ?? 'Non trouvé' ?> (<?= $client['phone_number'] ?? 'N/A' ?>)<br>
            <strong>Client ID:</strong> <?= $client['client_id'] ?? 'N/A' ?><br>
            <strong>Solde:</strong> <?= number_format($client['solde'] ?? 0, 0, ',', ' ') ?> Ar
        </div>
        
        <h3>📊 Toutes les transactions (<?= count($all_transactions) ?>)</h3>
        <?php if (empty($all_transactions)): ?>
            <div class="error">Aucune transaction dans la base de données</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client ID</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Frais</th>
                        <th>Référence</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_transactions as $tx): ?>
                    <tr>
                        <td><?= $tx['id'] ?></td>
                        <td><?= $tx['client_id'] ?></td>
                        <td><?= $tx['type_operation'] ?></td>
                        <td><?= number_format($tx['montant'], 0, ',', ' ') ?></td>
                        <td><?= number_format($tx['frais_appliques'], 0, ',', ' ') ?></td>
                        <td><?= $tx['reference'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($tx['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <h3>📊 Transactions du client (<?= count($client_transactions) ?>)</h3>
        <?php if (empty($client_transactions)): ?>
            <div class="error">Aucune transaction pour ce client</div>
            <div class="info">
                <strong>Raison possible:</strong> Les transactions ont un client_id différent de <?= $client['client_id'] ?? 'N/A' ?>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Montant</th>
                        <th>Frais</th>
                        <th>Référence</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($client_transactions as $tx): ?>
                    <tr>
                        <td><?= $tx['id'] ?></td>
                        <td><?= $tx['type_operation'] ?></td>
                        <td><?= number_format($tx['montant'], 0, ',', ' ') ?></td>
                        <td><?= number_format($tx['frais_appliques'], 0, ',', ' ') ?></td>
                        <td><?= $tx['reference'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($tx['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <div style="margin-top: 20px;">
            <a href="<?= site_url('client/history') ?>" class="btn" style="padding: 10px 20px; background: #2563eb; color: white; border-radius: 5px; text-decoration: none;">Voir l'historique</a>
            <a href="<?= site_url('client/operations') ?>" class="btn" style="padding: 10px 20px; background: #22c55e; color: white; border-radius: 5px; text-decoration: none; margin-left: 10px;">Faire une opération</a>
        </div>
    </div>
</body>
</html>