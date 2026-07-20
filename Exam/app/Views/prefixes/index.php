<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gestion des Préfixes' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    <style>
        /* Vos styles */
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
        body { margin: 0; background: var(--c-bg); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
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
        .status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }
        .status-actif { background: #dcfce7; color: #166534; }
        .status-inactif { background: #fee2e2; color: #991b1b; }
        .btn-primary { background: var(--c-primary); border: none; color: #fff; padding: 8px 16px; border-radius: var(--radius); font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-secondary { background: #f3f4f6; border: 1px solid var(--c-border); color: var(--c-text); padding: 8px 16px; border-radius: var(--radius); font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-secondary:hover { background: #e5e7eb; }
        .btn-sm { padding: 4px 10px; font-size: 12px; }
        .btn-warning { background: #f59e0b; border: none; color: #fff; }
        .btn-warning:hover { background: #d97706; }
        .btn-danger { background: #ef4444; border: none; color: #fff; }
        .btn-danger:hover { background: #dc2626; }
        .badge { padding: 4px 10px; border-radius: 12px; font-size: 11px; }
        .badge-info { background: #3b82f6; color: #fff; }
        .badge-warning { background: #f59e0b; color: #000; }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 22px;
        }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 22px;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        .toggle-switch input:checked + .toggle-slider { background-color: var(--c-success); }
        .toggle-switch input:checked + .toggle-slider:before { transform: translateX(18px); }
        .info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: var(--radius);
            padding: 20px;
            margin-bottom: 20px;
        }
        .info-card .info-stats { display: flex; gap: 30px; flex-wrap: wrap; }
        .info-card .stat-item { text-align: center; }
        .info-card .stat-item .number { font-size: 28px; font-weight: 700; }
        .info-card .stat-item .label { font-size: 12px; opacity: 0.8; }
        @media (max-width: 768px) {
            .sidebar { width: 60px; padding: 12px 8px; }
            .sidebar .brand-name, .sidebar .brand-sub, .sidebar .sidebar-section, 
            .sidebar .nav-item span, .sidebar .user-info { display: none; }
            .sidebar .nav-item { justify-content: center; padding: 10px; }
            .sidebar .sidebar-brand { justify-content: center; }
            .main { padding: 12px 16px; }
            .info-card .info-stats { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>

<div class="app">
    <?= view('partials/sidebar', ['username' => $username ?? 'Utilisateur', 'phone_number' => $phone_number ?? '']) ?>

    <div class="main">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div style="font-size:20px; font-weight:600;">📞 Configuration des Préfixes</div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPrefixModal">
                ➕ Ajouter un préfixe
            </button>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Statistiques -->
        <div class="info-card">
            <h4>📊 Statistiques des Préfixes</h4>
            <div class="info-stats">
                <div class="stat-item">
                    <div class="number"><?= count($prefixes ?? []) ?></div>
                    <div class="label">Total Préfixes</div>
                </div>
                <div class="stat-item">
                    <div class="number"><?= count(array_filter($prefixes ?? [], function($p) { return $p['est_actif'] == 1; })) ?></div>
                    <div class="label">Actifs</div>
                </div>
                <div class="stat-item">
                    <div class="number"><?= count(array_filter($prefixes ?? [], function($p) { return $p['est_actif'] == 0; })) ?></div>
                    <div class="label">Inactifs</div>
                </div>
                <div class="stat-item">
                    <div class="number"><?= count(array_unique(array_column($prefixes ?? [], 'operateur'))) ?></div>
                    <div class="label">Opérateurs</div>
                </div>
            </div>
        </div>

        <!-- Tableau -->
        <div class="card">
            <div class="card-header">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span>📋 Liste des Préfixes</span>
                    <span class="badge bg-primary"><?= count($prefixes ?? []) ?> préfixes</span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="prefixesTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Préfixe</th>
                                <th>Opérateur</th>
                                <th>Pays</th>
                                <th>Commission (%)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($prefixes)): ?>
                                <?php $i = 1; foreach ($prefixes as $p): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><code><strong><?= esc($p['prefixe']) ?></strong></code></td>
                                        <td><span class="badge badge-info"><?= esc($p['operateur']) ?></span></td>
                                        <td><?= esc($p['pays']) ?></td>
                                        <td><span class="badge badge-warning"><?= number_format($p['commission'], 2, ',', ' ') ?>%</span></td>
                                        <td>
                                            <span class="status-badge status-<?= $p['est_actif'] == 1 ? 'actif' : 'inactif' ?>">
                                                <?= $p['est_actif'] == 1 ? '✅ Actif' : '❌ Inactif' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <a href="<?= base_url('prefixes/modifier/' . $p['id']) ?>" class="btn btn-sm btn-warning">✏️</a>
                                                <a href="<?= base_url('prefixes/supprimer/' . $p['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce préfixe ?')">🗑️</a>
                                                <label class="toggle-switch">
                                                    <input type="checkbox" <?= $p['est_actif'] == 1 ? 'checked' : '' ?> 
                                                           onchange="togglePrefix(<?= $p['id'] ?>, this.checked)">
                                                    <span class="toggle-slider"></span>
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <div>📭 Aucun préfixe configuré</div>
                                        <small>Cliquez sur "Ajouter un préfixe" pour commencer</small>
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

<!-- Modal Ajouter -->
<div class="modal fade" id="addPrefixModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">➕ Ajouter un préfixe</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('prefixes/ajouter') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">📱 Préfixe</label>
                            <input type="text" name="prefixe" class="form-control" placeholder="Ex: 032" required maxlength="5">
                            <small class="text-muted">Les 2-3 premiers chiffres du numéro</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">🏢 Opérateur</label>
                            <input type="text" name="operateur" class="form-control" placeholder="Ex: Orange, Airtel, Telma" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">🌍 Pays</label>
                            <input type="text" name="pays" class="form-control" placeholder="Ex: Madagascar" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">💰 Commission (%)</label>
                            <input type="number" name="commission" class="form-control" placeholder="Ex: 2.5" step="0.01" min="0" max="100" required>
                            <small class="text-muted">Commission en % pour les transferts vers cet opérateur</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="est_actif" class="form-check-input" value="1" checked>
                            <label class="form-check-label">✅ Actif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function togglePrefix(id, checked) {
    fetch('<?= base_url("prefixes/toggle") ?>/' + id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erreur lors de la modification du statut');
    });
}
</script>

</body>
</html>