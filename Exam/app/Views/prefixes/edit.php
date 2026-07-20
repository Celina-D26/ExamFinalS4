<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Modifier le Préfixe' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    <style>
        :root {
            --c-primary: #2563eb;
            --c-bg: #f8fafc;
            --c-surface: #ffffff;
            --c-border: #e2e8f0;
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
            <div style="font-size:20px; font-weight:600;">✏️ Modifier le préfixe</div>
            <a href="<?= base_url('prefixes') ?>" class="btn btn-secondary">⬅️ Retour</a>
        </div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <div>• <?= $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('prefixes/update/' . $prefixe['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Préfixe <span class="text-danger">*</span></label>
                            <input type="text" name="prefixe" class="form-control" value="<?= esc($prefixe['prefixe']) ?>" required>
                            <small class="text-muted">2 à 5 chiffres</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Opérateur <span class="text-danger">*</span></label>
                            <input type="text" name="operateur" class="form-control" value="<?= esc($prefixe['operateur']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pays</label>
                            <input type="text" name="pays" class="form-control" value="<?= esc($prefixe['pays']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Commission (%) <span class="text-danger">*</span></label>
                            <input type="number" name="commission" class="form-control" step="0.01" min="0" max="100" value="<?= esc($prefixe['commission']) ?>" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-check">
                                <input type="checkbox" name="est_actif" class="form-check-input" value="1" <?= $prefixe['est_actif'] ? 'checked' : '' ?>>
                                <label class="form-check-label">Actif</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="<?= base_url('prefixes') ?>" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>