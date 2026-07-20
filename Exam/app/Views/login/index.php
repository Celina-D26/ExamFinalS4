<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'SysInfo — Connexion' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    <style>
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
        .phone-input-group input {
            border: none;
            background: transparent;
            padding: 10px 14px;
            font-size: 14px;
            color: var(--c-text);
            outline: none;
            width: 100%;
        }
        .login-info {
            background: rgba(37,99,235,.06);
            border-radius: var(--radius);
            padding: 12px 16px;
            margin-bottom: 20px;
            font-size: 13px;
            color: var(--c-muted);
            border-left: 3px solid var(--c-primary);
        }
        .login-info strong {
            color: var(--c-text);
        }
        .test-numbers {
            margin-top: 16px;
            padding: 12px 16px;
            background: var(--c-bg);
            border-radius: var(--radius);
            font-size: 12px;
            color: var(--c-muted);
            text-align: center;
        }
        .test-numbers code {
            background: var(--c-surface);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: var(--c-primary);
            margin: 0 4px;
        }
    </style>
</head>
<body>

<div class="login-page">
    <div class="login-card">

        <div class="login-logo">
            <div class="logo-icon">
                <svg viewBox="0 0 24 24" width="22" height="22">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
            </div>
            <div>
                <h1>SysInfo</h1>
                <span>Système d'Information</span>
            </div>
        </div>

        <h2>Connexion</h2>
        <p class="subtitle">Connectez-vous avec votre numéro de téléphone</p>

        <div class="login-info">
            <svg viewBox="0 0 24 24" width="16" height="16" style="display:inline-block;vertical-align:middle;margin-right:8px;stroke:var(--c-primary);fill:none;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>Aucune inscription nécessaire. <strong>Entrez votre numéro</strong> pour vous connecter automatiquement.</span>
        </div>

        <?php if (isset($error)): ?>
            <div class="error-message" style="background:#fee2e2; color:#dc2626; padding:10px 14px; border-radius:8px; margin-bottom:20px;">
                <?= esc($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('login/authenticate') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="field-group">
                <label>Numéro de téléphone</label>
                <div class="phone-input-group">
                    <span class="phone-prefix">+261</span>
                    <input type="tel" name="phone" placeholder="34 00 000 00" 
                           value="<?= old('phone') ?>" autofocus />
                </div>
                <?php if (isset($validation) && $validation->hasError('phone')): ?>
                    <small style="color:#dc2626; font-size:12px; margin-top:4px; display:block;">
                        <?= esc($validation->getError('phone')) ?>
                    </small>
                <?php endif; ?>
                <div class="field-hint" style="font-size:11px; color:var(--c-muted); margin-top:5px;">
                    Format : 34 00 000 00 (9 chiffres)
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-full" style="margin-top:8px;">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" fill="none"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                Se connecter
            </button>

            <div class="test-numbers">
                <span style="display:block;margin-bottom:6px;font-weight:600;color:var(--c-text);">Numéros de test :</span>
                <code>340000001</code>
                <code>340000002</code>
                <code>340000003</code>
                <code>340000004</code>
                <code>340000005</code>
            </div>

            <div class="login-footer">
                <span style="font-size:11px;color:var(--c-muted);">
                    🔒 Connexion sécurisée - Aucun mot de passe requis
                </span>
            </div>
        </form>

    </div>
</div>

<script>
    // Formatage automatique du numéro de téléphone
    document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
        // Supprimer tous les caractères non numériques
        this.value = this.value.replace(/\D/g, '');
        // Limiter à 9 chiffres
        if (this.value.length > 9) {
            this.value = this.value.slice(0, 9);
        }
    });
</script>

</body>
</html>