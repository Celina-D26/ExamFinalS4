<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Gestion des Barèmes de Frais' ?></title>
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
            --c-input: #ffffff;
            --radius: 8px;
            --c-success: #22c55e;
            --c-warning: #eab308;
            --c-danger: #ef4444;
            --c-accent: #8b5cf6;
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
        }
        .card-body {
            padding: 20px;
        }

        .badge.bg-primary {
            background: var(--c-primary) !important;
        }
        .text-success {
            color: var(--c-success) !important;
        }
        .btn-primary {
            background: var(--c-primary);
            border: none;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .fw-bold {
            font-weight: 600 !important;
        }

        .phone-input-group {
            display: flex;
            align-items: center;
            background: var(--c-input);
            border: 1.5px solid var(--c-border);
            border-radius: var(--radius);
            transition: border-color .2s, box-shadow .2s;
            overflow: hidden;
        }
        .phone-input-group:focus-within {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px rgba(37,99,235,.12);
        }
        .phone-prefix {
            padding: 10px 8px 10px 14px;
            background: var(--c-bg);
            color: var(--c-muted);
            font-size: 14px;
            font-weight: 600;
            border-right: 1.5px solid var(--c-border);
            white-space: nowrap;
        }
        .phone-input-group input, 
        .phone-input-group select {
            border: none;
            background: transparent;
            padding: 12px 16px;
            font-size: 13px;
            color: var(--c-text);
            outline: none;
            width: 100%;
        }

        .login-info {
            padding: 12px 16px;
            background: var(--c-bg);
            border-radius: var(--radius);
            font-size: 13px;
            color: var(--c-muted);
            border-left: 3px solid var(--c-primary);
            margin-bottom: 20px;
        }
        .login-info strong {
            color: var(--c-text);
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
            .sidebar .avatar {
                width: 28px;
                height: 28px;
                font-size: 10px;
            }
            .main {
                padding: 12px 16px;
            }
        }
    </style>
</head>
<body>

<div class="app">
    <!-- SIDEBAR -->
    <?= view('partials/sidebar', ['username' => $username, 'phone_number' => $phone_number]) ?>

    <!-- MAIN CONTENT -->
    <div class="main">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div style="font-size:20px; font-weight:600;">📊 Gestion des Barèmes de Frais</div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="login-info">
            💰 Barèmes configurés : <strong><?= count($baremes ?? []) ?></strong>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">
                        📋 Liste des Barèmes
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Type d'opération</th>
                                    <th>Montant minimum</th>
                                    <th>Montant maximum</th>
                                    <th>Frais</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($baremes)): ?>
                                    <?php foreach ($baremes as $b): ?>
                                        <tr>
                                            <td><?= $b['id'] ?></td>
                                            <td>
                                                <span class="badge <?= $b['type_operation'] == 'retrait' ? 'bg-warning' : 'bg-primary' ?>">
                                                    <?= strtoupper($b['type_operation']) ?>
                                                </span>
                                            </td>
                                            <td><?= number_format($b['montant_min'], 0, ',', ' ') ?> Ar</td>
                                            <td><?= number_format($b['montant_max'], 0, ',', ' ') ?> Ar</td>
                                            <td class="fw-bold text-success"><?= number_format($b['frais'], 0, ',', ' ') ?> Ar</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-3">
                                            Aucun barème trouvé.
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>