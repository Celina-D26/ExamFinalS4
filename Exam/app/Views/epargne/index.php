<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Mon Épargne' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body>

<div class="app d-flex">
    <?= view('partials/sidebar') ?>

    <div class="main flex-grow-1 p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 mb-0">💰 Mon Épargne</h2>
            <div>
                <span class="badge <?= $epargne['epargne_active'] == 1 ? 'bg-success' : 'bg-secondary' ?> fs-6">
                    <?= $epargne['epargne_active'] == 1 ? '✅ Active' : '❌ Inactive' ?>
                </span>
            </div>
        </div>

        <!-- Messages Flash -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Solde Épargne -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card text-center p-4" style="border-left: 4px solid #22c55e;">
                    <h5 class="text-muted">Solde Épargne</h5>
                    <h2 class="text-success"><?= number_format($stats['solde_epargne'] ?? 0, 0, ',', ' ') ?> Ar</h2>
                    <small class="text-muted">Total épargné: <?= number_format($stats['total_epargne'] ?? 0, 0, ',', ' ') ?> Ar</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center p-4" style="border-left: 4px solid #3b82f6;">
                    <h5 class="text-muted">Solde Principal</h5>
                    <h2 class="text-primary"><?= number_format($client['solde'] ?? 0, 0, ',', ' ') ?> Ar</h2>
                    <small class="text-muted">Retraits épargne: <?= number_format($stats['total_retraits_epargne'] ?? 0, 0, ',', ' ') ?> Ar</small>
                </div>
            </div>
        </div>

        <!-- Pourcentage d'épargne -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">⚙️ Configuration Épargne</h5>
            </div>
            <div class="card-body">
                <form action="<?= site_url('epargne/configurer') ?>" method="post" class="row g-3">
                    <?= csrf_field() ?>
                    <div class="col-md-4">
                        <label class="fw-bold">Pourcentage d'épargne (%)</label>
                        <div class="input-group">
                            <input type="number" name="pourcentage" class="form-control" 
                                   value="<?= $stats['pourcentage_defaut'] ?? 0 ?>" 
                                   min="0" max="100" step="0.5" required>
                            <span class="input-group-text">%</span>
                        </div>
                        <small class="text-muted">Ce pourcentage sera prélevé automatiquement sur chaque transfert</small>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">💾 Enregistrer</button>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <a href="<?= site_url('epargne/toggle') ?>" class="btn <?= $epargne['epargne_active'] == 1 ? 'btn-warning' : 'btn-success' ?> w-100">
                            <?= $epargne['epargne_active'] == 1 ? '🔴 Désactiver' : '🟢 Activer' ?>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Actions -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">📤 Ajouter à l'épargne</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('epargne/ajouter') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="input-group">
                                <input type="number" name="montant" class="form-control" placeholder="Montant à épargner" min="1" required>
                                <button type="submit" class="btn btn-success">Ajouter</button>
                            </div>
                            <small class="text-muted">Le montant sera prélevé de votre compte principal</small>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">📥 Retirer de l'épargne</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('epargne/retirer') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="input-group">
                                <input type="number" name="montant" class="form-control" placeholder="Montant à retirer" min="1" required>
                                <button type="submit" class="btn btn-warning">Retirer</button>
                            </div>
                            <small class="text-muted">Le montant sera ajouté à votre compte principal</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Historique des épargnes -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">📋 Historique des opérations d'épargne</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="epargneTable">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Montant</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $transactionModel = new \App\Models\TransactionModel();
                            $transactions = $transactionModel
                                ->where('client_id', $client['client_id'])
                                ->whereIn('type_operation', ['epargne', 'epargne_retrait'])
                                ->orderBy('created_at', 'DESC')
                                ->findAll(20);
                            ?>
                            <?php if (!empty($transactions)): ?>
                                <?php foreach ($transactions as $tx): ?>
                                    <tr>
                                        <td><?= date('d/m/Y H:i', strtotime($tx['created_at'])) ?></td>
                                        <td>
                                            <?php if ($tx['type_operation'] == 'epargne'): ?>
                                                <span class="badge bg-success">Dépôt</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">Retrait</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="fw-bold <?= $tx['type_operation'] == 'epargne' ? 'text-success' : 'text-danger' ?>">
                                            <?= $tx['type_operation'] == 'epargne' ? '+' : '-' ?>
                                            <?= number_format($tx['montant'], 0, ',', ' ') ?> Ar
                                        </td>
                                        <td><?= $tx['description'] ?? '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        Aucune opération d'épargne
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#epargneTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        order: [[0, 'desc']],
        pageLength: 10
    });
});
</script>

</body>
</html>