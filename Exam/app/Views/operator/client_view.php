<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'Mobile Money' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    <style>
        .client-detail { background: #fff; padding: 24px; border-radius: 12px; border: 1px solid #e5e7eb; margin-bottom: 24px; }
        .client-detail .info-row { display: flex; padding: 10px 0; border-bottom: 1px solid #e5e7eb; }
        .client-detail .info-row:last-child { border-bottom: none; }
        .client-detail .label { font-weight: 600; width: 150px; color: #6b7280; }
        .client-detail .value { font-weight: 500; }
        .badge-active { background: #22c55e; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; }
        .badge-inactive { background: #ef4444; color: #fff; padding: 2px 10px; border-radius: 20px; font-size: 11px; }
        .btn-back { display: inline-block; padding: 8px 16px; background: #6b7280; color: #fff; border-radius: 8px; text-decoration: none; }
        .btn-back:hover { background: #4b5563; }
    </style>
</head>
<body>

<div style="display:flex;min-height:100vh;">
    <?= view('operator/partials/sidebar', ['username' => $username, 'phone_number' => $phone_number]) ?>
    
    <div style="flex:1;padding:0;min-height:100vh;background:#f3f4f6;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 32px;background:#fff;border-bottom:1px solid #e5e7eb;position:sticky;top:0;z-index:10;">
            <div style="font-size:16px;font-weight:600;">👤 Détails du client</div>
        </div>

        <div style="padding:24px 32px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
                <div>
                    <h2 style="font-size:22px;font-weight:700;">Détails du client</h2>
                    <div style="font-size:13px;color:#6b7280;">Opérateur / Clients / <span style="color:#111827;">Détails</span></div>
                </div>
                <a href="<?= site_url('operator/clients') ?>" class="btn-back">← Retour</a>
            </div>

            <div class="client-detail">
                <div class="info-row">
                    <div class="label">Nom</div>
                    <div class="value"><?= esc($client['username'] ?? 'Inconnu') ?></div>
                </div>
                <div class="info-row">
                    <div class="label">Téléphone</div>
                    <div class="value"><?= esc($client['phone_number'] ?? '') ?></div>
                </div>
                <div class="info-row">
                    <div class="label">Email</div>
                    <div class="value"><?= esc($client['email'] ?? 'Non renseigné') ?></div>
                </div>
                <div class="info-row">
                    <div class="label">Solde</div>
                    <div class="value" style="font-size:20px;color:#2563eb;font-weight:700;">
                        <?= number_format($client['balance'] ?? 0, 0, ',', ' ') ?> Ar
                    </div>
                </div>
                <div class="info-row">
                    <div class="label">Statut</div>
                    <div class="value">
                        <span class="<?= ($client['is_active'] ?? 1) ? 'badge-active' : 'badge-inactive' ?>">
                            <?= ($client['is_active'] ?? 1) ? 'Actif' : 'Inactif' ?>
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="label">Date d'inscription</div>
                    <div class="value"><?= date('d/m/Y H:i', strtotime($client['created_at'] ?? 'now')) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>