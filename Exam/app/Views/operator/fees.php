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

        .main { flex: 1; padding: 0; min-height: 100vh; background: #f3f4f6; }
        .topbar { display: flex; align-items: center; justify-content: space-between; padding: 16px 32px; background: #fff; border-bottom: 1px solid #e5e7eb; position: sticky; top: 0; z-index: 10; }
        .topbar-title { font-size: 16px; font-weight: 600; }
        .content { padding: 24px 32px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .page-header h2 { font-size: 22px; font-weight: 700; }
        .page-header .breadcrumb { font-size: 13px; color: #6b7280; }
        .page-header .breadcrumb span { color: #111827; }

        .fee-section { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        .fee-form { background: #fff; padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; }
        .fee-form h3 { margin-bottom: 16px; }
        .fee-list { background: #fff; border-radius: 12px; border: 1px solid #e5e7eb; overflow: hidden; }
        .fee-list-header { padding: 16px 20px; background: #f3f4f6; font-weight: 600; border-bottom: 1px solid #e5e7eb; }
        .fee-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 20px; border-bottom: 1px solid #e5e7eb; }
        .fee-item:last-child { border-bottom: none; }
        .fee-item-info { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .fee-item-actions { display: flex; gap: 8px; }
        
        .badge-active { background: #22c55e; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .badge-inactive { background: #ef4444; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .badge-fixed { background: #8b5cf6; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; display: inline-block; }
        .badge-percentage { background: #f59e0b; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; display: inline-block; }
        
        .btn-sm { padding: 4px 10px; font-size: 12px; border-radius: 6px; border: none; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary-sm { background: #2563eb; color: #fff; }
        .btn-primary-sm:hover { background: #1d4ed8; }
        .btn-success-sm { background: #22c55e; color: #fff; }
        .btn-success-sm:hover { background: #16a34a; }
        .btn-danger-sm { background: #ef4444; color: #fff; }
        .btn-danger-sm:hover { background: #dc2626; }
        .btn-warning-sm { background: #f59e0b; color: #fff; }
        .btn-warning-sm:hover { background: #d97706; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-weight: 500; font-size: 14px; margin-bottom: 4px; }
        .form-group input, .form-group select { width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 14px; outline: none; background: #fff; }
        .form-group input:focus, .form-group select:focus { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.1); }
        .btn-primary { background: #2563eb; color: #fff; padding: 10px 24px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-secondary { background: #f3f4f6; color: #111827; padding: 10px 24px; border: 1px solid #e5e7eb; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .btn-secondary:hover { background: #e5e7eb; }
        .form-actions { display: flex; gap: 10px; margin-top: 8px; }
        .result-message { padding: 12px 16px; border-radius: 8px; margin-top: 16px; display: none; }
        .result-message.success { display: block; background: #dcfce7; color: #16a34a; border: 1px solid #86efac; }
        .result-message.error { display: block; background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; }
        .empty-state { text-align: center; padding: 40px 20px; color: #6b7280; }

        @media (max-width: 1024px) { .fee-section { grid-template-columns: 1fr; } }
        @media (max-width: 576px) { .form-row { grid-template-columns: 1fr; } }
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
        <a href="<?= site_url('operator/clients') ?>" class="nav-link">👥 Clients</a>
        <a href="<?= site_url('operator/fees') ?>" class="nav-link active">💰 Barème des frais</a>

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
            <div class="topbar-title">💰 Gestion du barème des frais</div>
        </div>

        <div class="content">
            <div class="page-header">
                <div>
                    <h2>Barème des frais</h2>
                    <div class="breadcrumb">Opérateur / <span>Gestion des frais</span></div>
                </div>
            </div>

            <div class="fee-section">
                <!-- Formulaire -->
                <div class="fee-form">
                    <h3>➕ Ajouter un barème</h3>
                    <form id="feeForm" onsubmit="return false;">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Type d'opération <span style="color:#dc2626;">*</span></label>
                                <select id="operationType" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="withdrawal">Retrait</option>
                                    <option value="transfer">Transfert</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Type de frais <span style="color:#dc2626;">*</span></label>
                                <select id="feeType" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="fixed">Fixe (Ar)</option>
                                    <option value="percentage">Pourcentage (%)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Montant minimum (Ar) <span style="color:#dc2626;">*</span></label>
                                <input type="number" id="minAmount" placeholder="100" min="1" required />
                            </div>
                            <div class="form-group">
                                <label>Montant maximum (Ar) <span style="color:#dc2626;">*</span></label>
                                <input type="number" id="maxAmount" placeholder="1000" min="1" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Valeur du frais <span style="color:#dc2626;">*</span></label>
                            <input type="number" id="feeValue" placeholder="50" min="0.1" step="0.1" required />
                            <div style="font-size:12px;color:#6b7280;margin-top:4px;">
                                Pour un frais fixe, entrez un montant. Pour un pourcentage, entrez une valeur (ex: 1.5 pour 1.5%)
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn-primary" onclick="addFee()">Ajouter</button>
                            <button type="reset" class="btn-secondary">Réinitialiser</button>
                        </div>
                        <div id="feeResult" class="result-message"></div>
                    </form>
                </div>

                <!-- Liste -->
                <div>
                    <div class="fee-list">
                        <div class="fee-list-header">📋 Barèmes existants</div>
                        <?php if (empty($fees)): ?>
                            <div class="empty-state">Aucun barème configuré</div>
                        <?php else: ?>
                            <?php foreach ($fees as $fee): ?>
                                <div class="fee-item" id="fee-<?= $fee['id'] ?>">
                                    <div class="fee-item-info">
                                        <span>
                                            <?= number_format($fee['min_amount'], 0, ',', ' ') ?> - <?= number_format($fee['max_amount'], 0, ',', ' ') ?> Ar
                                        </span>
                                        <span class="<?= $fee['fee_type'] == 'fixed' ? 'badge-fixed' : 'badge-percentage' ?>">
                                            <?php if ($fee['fee_type'] == 'fixed'): ?>
                                                <?= number_format($fee['fee_value'], 0, ',', ' ') ?> Ar
                                            <?php else: ?>
                                                <?= $fee['fee_value'] ?>%
                                            <?php endif; ?>
                                        </span>
                                        <span class="<?= $fee['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                                            <?= $fee['is_active'] ? 'Actif' : 'Inactif' ?>
                                        </span>
                                        <span style="font-size:11px;color:#6b7280;">
                                            <?= $fee['operation_type'] == 'withdrawal' ? '💰 Retrait' : '🔄 Transfert' ?>
                                        </span>
                                    </div>
                                    <div class="fee-item-actions">
                                        <button class="btn-sm <?= $fee['is_active'] ? 'btn-warning-sm' : 'btn-success-sm' ?>" 
                                                onclick="toggleFee(<?= $fee['id'] ?>)">
                                            <?= $fee['is_active'] ? 'Désactiver' : 'Activer' ?>
                                        </button>
                                        <button class="btn-sm btn-danger-sm" onclick="deleteFee(<?= $fee['id'] ?>)">Supprimer</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function addFee() {
    const operationType = document.getElementById('operationType').value;
    const minAmount = document.getElementById('minAmount').value;
    const maxAmount = document.getElementById('maxAmount').value;
    const feeType = document.getElementById('feeType').value;
    const feeValue = document.getElementById('feeValue').value;

    if (!operationType || !minAmount || !maxAmount || !feeType || !feeValue) {
        showResult('Tous les champs sont obligatoires', 'error');
        return;
    }

    if (parseFloat(minAmount) >= parseFloat(maxAmount)) {
        showResult('Le montant minimum doit être inférieur au maximum', 'error');
        return;
    }

    try {
        const response = await fetch('<?= site_url("operator/fees/create") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                operation_type: operationType,
                min_amount: parseFloat(minAmount),
                max_amount: parseFloat(maxAmount),
                fee_type: feeType,
                fee_value: parseFloat(feeValue)
            })
        });
        const data = await response.json();

        if (data.success) {
            showResult('✅ ' + data.message, 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showResult('❌ ' + data.message, 'error');
        }
    } catch (error) {
        showResult('❌ Erreur lors de l\'ajout', 'error');
    }
}

async function toggleFee(id) {
    try {
        const response = await fetch('<?= site_url("operator/fees/toggleStatus") ?>/' + id, {
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

async function deleteFee(id) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce barème ?')) return;

    try {
        const response = await fetch('<?= site_url("operator/fees/delete") ?>/' + id, {
            method: 'DELETE'
        });
        const data = await response.json();

        if (data.success) {
            location.reload();
        } else {
            alert('Erreur: ' + data.message);
        }
    } catch (error) {
        alert('Erreur lors de la suppression');
    }
}

function showResult(message, type) {
    const el = document.getElementById('feeResult');
    el.textContent = message;
    el.className = 'result-message ' + type;
    el.style.display = 'block';
    
    setTimeout(() => {
        el.style.display = 'none';
    }, 5000);
}
</script>

</body>
</html>