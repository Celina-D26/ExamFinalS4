<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Configuration des Préfixes' ?></title>
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
            --radius: 8px;
        }
        body { margin: 0; background: var(--c-bg); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        .app { display: flex; min-height: 100vh; }
        
        /* Sidebar */
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

        .btn-primary { background: var(--c-primary); border: none; color: #fff; padding: 8px 16px; border-radius: var(--radius); font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-secondary { background: #f3f4f6; border: 1px solid var(--c-border); color: var(--c-text); padding: 8px 16px; border-radius: var(--radius); font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-secondary:hover { background: #e5e7eb; }
        .btn-danger { background: #ef4444; border: none; color: #fff; padding: 8px 16px; border-radius: var(--radius); font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-danger:hover { background: #dc2626; }
        .btn-warning { background: #f59e0b; border: none; color: #fff; padding: 8px 16px; border-radius: var(--radius); font-size: 13px; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-warning:hover { background: #d97706; }

        .badge-active { background: #22c55e; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .badge-inactive { background: #ef4444; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; display: inline-block; }

        @media (max-width: 768px) {
            .sidebar { width: 60px; padding: 12px 8px; }
            .sidebar .brand-name, .sidebar .brand-sub, .sidebar .sidebar-section, 
            .sidebar .nav-item span, .sidebar .user-info { display: none; }
            .sidebar .nav-item { justify-content: center; padding: 10px; }
            .sidebar .sidebar-brand { justify-content: center; }
            .main { padding: 12px 16px; }
        }
    </style>
</head>
<body>

<div class="app">
    <!-- Sidebar -->
    <?= view('partials/sidebar', ['username' => $username ?? 'Utilisateur', 'phone_number' => $phone_number ?? '']) ?>

    <!-- Main -->
    <div class="main">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div style="font-size:20px; font-weight:600;">📱 Configuration des Préfixes</div>
            <a href="<?= base_url('prefixes') ?>" class="btn btn-secondary">🔄 Actualiser</a>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <div>• <?= $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Formulaire d'ajout -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">➕ Ajouter un préfixe</div>
                    <div class="card-body">
                        <form action="<?= base_url('prefixes/ajouter') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label class="form-label">Préfixe <span class="text-danger">*</span></label>
                                <input type="text" name="prefixe" class="form-control" placeholder="Ex: 034" required>
                                <small class="text-muted">2 à 5 chiffres</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Opérateur <span class="text-danger">*</span></label>
                                <input type="text" name="operateur" class="form-control" placeholder="Ex: Orange" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pays</label>
                                <input type="text" name="pays" class="form-control" placeholder="Ex: Madagascar" value="Madagascar">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Commission (%) <span class="text-danger">*</span></label>
                                <input type="number" name="commission" class="form-control" step="0.01" min="0" max="100" placeholder="Ex: 1.5" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="est_actif" class="form-check-input" value="1" checked>
                                <label class="form-check-label">Actif</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Liste des préfixes -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>📋 Liste des préfixes</span>
                        <span class="badge bg-secondary"><?= count($prefixes ?? []) ?></span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Préfixe</th>
                                        <th>Opérateur</th>
                                        <th>Pays</th>
                                        <th>Commission</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($prefixes)): ?>
                                        <?php foreach ($prefixes as $p): ?>
                                            <tr>
                                                <td><strong><?= esc($p['prefixe']) ?></strong></td>
                                                <td><?= esc($p['operateur']) ?></td>
                                                <td><?= esc($p['pays']) ?></td>
                                                <td><?= $p['commission'] ?>%</td>
                                                <td>
                                                    <span class="<?= $p['est_actif'] ? 'badge-active' : 'badge-inactive' ?>">
                                                        <?= $p['est_actif'] ? 'Actif' : 'Inactif' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('prefixes/modifier/' . $p['id']) ?>" class="btn btn-warning btn-sm">✏️</a>
                                                    <a href="<?= base_url('prefixes/supprimer/' . $p['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce préfixe ?')">🗑️</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-3">Aucun préfixe configuré</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>