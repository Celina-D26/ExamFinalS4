<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'Mobile Money' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f3f4f6; }
        .app { display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: #1f2937; color: #e5e7eb; padding: 16px; display: flex; flex-direction: column; flex-shrink: 0; height: 100vh; position: sticky; top: 0; overflow-y: auto; }
        .sidebar-brand { display: flex; align-items: center; gap: 12px; padding: 16px 12px; border-bottom: 1px solid rgba(255,255,255,0.08); margin-bottom: 16px; }
        .sidebar-brand .logo { background: #2563eb; padding: 8px; border-radius: 8px; }
        .sidebar-brand .logo svg { width: 18px; height: 18px; stroke: #fff; fill: none; stroke-width: 2; }
        .sidebar-brand .name { font-weight: 700; font-size: 18px; color: #fff; }
        .sidebar-brand .sub { font-size: 11px; color: #9ca3af; }
        .sidebar-section { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af; padding: 12px 12px 6px 12px; }
        .nav-link { color: #d1d5db; text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 8px; margin: 2px 0; transition: background 0.2s; }
        .nav-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-link.active { background: rgba(37,99,235,0.2); color: #93bbfc; }
        .nav-link svg { width: 20px; height: 20px; stroke: currentColor; fill: none; stroke-width: 2; }
        .sidebar-bottom { margin-top: auto; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.08); }
        .user-row { display: flex; align-items: center; gap: 10px; padding: 8px 12px; border-radius: 8px; background: rgba(255,255,255,0.05); margin-bottom: 8px; }
        .user-row .avatar { width: 32px; height: 32px; border-radius: 50%; background: #2563eb; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 13px; }
        .user-row .info .name { color: #fff; font-weight: 600; font-size: 14px; }
        .user-row .info .role { color: #9ca3af; font-size: 11px; }
        .logout-btn { display: block; padding: 9px 14px; background: #ef4444; color: #fff; border-radius: 8px; text-decoration: none; font-weight: 500; font-size: 13.5px; text-align: center; }
        .logout-btn:hover { background: #dc2626; }

        /* Main */
        .main { flex: 1; padding: 0; min-height: 100vh; background: #f3f4f6; }
        .topbar { display: flex; align-items: center; justify-content: space-between; padding: 16px 32px; background: #fff; border-bottom: 1px solid #e5e7eb; position: sticky; top: 0; z-index: 10; }
        .topbar-title { font-size: 16px; font-weight: 600; }
        .content { padding: 24px 32px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-header h2 { font-size: 22px; font-weight: 700; }
        .page-header .breadcrumb { font-size: 13px; color: #6b7280; }
        .page-header .breadcrumb span { color: #111827; }

        /* Table */
        .table-card { background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; }
        .table-card table { width: 100%; border-collapse: collapse; }
        .table-card th { background: #f3f4f6; padding: 12px 16px; text-align: left; font-weight: 600; border-bottom: 2px solid #e5e7eb; }
        .table-card td { padding: 12px 16px; border-bottom: 1px solid #e5e7eb; }
        .table-card tr:last-child td { border-bottom: none; }
        .table-card tr:hover { background: #f9fafb; }
        
        .badge-active { background: #22c55e; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .badge-inactive { background: #ef4444; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .btn-sm { padding: 4px 10px; font-size: 12px; border-radius: 6px; border: none; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary-sm { background: #2563eb; color: #fff; }
        .btn-primary-sm:hover { background: #1d4ed8; }
        .btn-success-sm { background: #22c55e; color: #fff; }
        .btn-success-sm:hover { background: #16a34a; }
        .btn-danger-sm { background: #ef4444; color: #fff; }
        .btn-danger-sm:hover { background: #dc2626; }
        .btn-warning-sm { background: #f59e0b; color: #fff; }
        .btn-warning-sm:hover { background: #d97706; }
        .avatar-sm { width: 32px; height: 32px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; color: #fff; font-weight: 600; font-size: 12px; }
        .empty-state { text-align: center; padding: 60px 20px; color: #6b7280; }
        .empty-state .icon { font-size: 48px; display: block; margin-bottom: 10px; }

        .total-badge { background: #2563eb; color: #fff; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; }
    </style>
</head>
<body>

<div class="app">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="logo">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div>
                <div class="name">Mobile Money</div>
                <div class="sub">Opérateur v1.0</div>
            </div>
        </div>

        <div class="sidebar-section">Gestion</div>
        <a href="<?= site_url('operator/dashboard') ?>" class="nav-link">📊 Tableau de bord</a>
        <a href="<?= site_url('operator/clients') ?>" class="nav-link active">👥 Clients</a>
        <a href="<?= site_url('operator/fees') ?>" class="nav-link">💰 Barème des frais</a>

        <div style="margin-top:12px;border-top:1px solid rgba(255,255,255,0.08);padding-top:12px;">
            <div class="sidebar-section">Espace</div>
            <a href="<?= site_url('client/dashboard') ?>" class="nav-link" style="color:#93bbfc;">👤 Client</a>
        </div>

        <div class="sidebar-bottom">
            <div class="user-row">
                <div class="avatar"><?= substr($username ?? 'U', 0, 2) ?></div>
                <div class="info">
                    <div class="name"><?= esc($username ?? 'Utilisateur') ?></div>
                    <div class="role">📱 <?= esc($phone_number ?? '') ?></div>
                </div>
            </div>
            <a href="<?= site_url('logout') ?>" class="logout-btn">Déconnexion</a>
        </div>
    </aside>

    <!-- Main -->
    <div class="main">
        <div class="topbar">
            <div class="topbar-title">👥 Gestion des clients</div>
        </div>

        <div class="content">
            <div class="page-header">
                <div>
                    <h2>Clients</h2>
                    <div class="breadcrumb">Opérateur / <span>Clients</span></div>
                </div>
                <span class="total-badge">Total: <?= count($clients ?? []) ?></span>
            </div>

            <div class="table-card">
                <?php if (empty($clients)): ?>
                    <div class="empty-state">
                        <span class="icon">📭</span>
                        <h3>Aucun client</h3>
                        <p>Il n'y a pas encore de clients enregistrés.</p>
                    </div>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Téléphone</th>
                                <th>Solde</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clients as $client): ?>
                                <tr>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <div class="avatar-sm" style="background:linear-gradient(135deg, #<?= substr(md5($client['username'] ?? ''), 0, 6) ?>, #<?= substr(md5($client['phone_number'] ?? ''), 0, 6) ?>)">
                                                <?= strtoupper(substr($client['username'] ?? 'U', 0, 2)) ?>
                                            </div>
                                            <?= esc($client['username'] ?? 'Inconnu') ?>
                                        </div>
                                    </td>
                                    <td><?= esc($client['phone_number'] ?? '') ?></td>
                                    <td><strong><?= number_format($client['balance'] ?? 0, 0, ',', ' ') ?> Ar</strong></td>
                                    <td>
                                        <span class="<?= ($client['is_active'] ?? 1) ? 'badge-active' : 'badge-inactive' ?>">
                                            <?= ($client['is_active'] ?? 1) ? 'Actif' : 'Inactif' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn-sm <?= ($client['is_active'] ?? 1) ? 'btn-warning-sm' : 'btn-success-sm' ?>" 
                                                onclick="toggleClient(<?= $client['id'] ?>)">
                                            <?= ($client['is_active'] ?? 1) ? 'Désactiver' : 'Activer' ?>
                                        </button>
                                        <a href="<?= site_url('operator/clients/view/' . $client['id']) ?>" class="btn-sm btn-primary-sm">Voir</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
async function toggleClient(id) {
    try {
        const response = await fetch('<?= site_url("operator/clients/toggle") ?>/' + id, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({})
        });
        const data = await response.json();

        if (data.success) {
            location.reload();
        } else {
            alert('Erreur: ' + data.message);
        }
    } catch (error) {
        alert('Erreur lors de l\'opération');
    }
}
</script>

</body>
</html>