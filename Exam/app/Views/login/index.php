<?php // Copié depuis login_view.php pour correspondre au contrôleur Login::index() ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= esc($title ?? 'SysInfo — Connexion') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>

<body>

    <div class="login-page">
        <div class="login-card">

            <div class="login-logo">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" width="22" height="22">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                </div>
                <div>
                    <h1>SysInfo</h1>
                    <span>Système d'Information</span>
                </div>
            </div>

            <h2>Connexion</h2>
            <p class="subtitle">Connectez-vous à votre espace de travail</p>

            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?= esc($error) ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('login/authenticate') ?>" method="post">
                <?= csrf_field() ?>
                
                <div class="field-group">
                    <label>Adresse e-mail</label>
                    <div class="input-wrap">
                        <div class="icon">
                            <svg viewBox="0 0 24 24">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                        </div>
                        <input type="email" name="username" placeholder="vous@exemple.com" 
                               value="<?= old('username') ?>" />
                    </div>
                    <?php if (isset($validation) && $validation->hasError('username')): ?>
                        <small class="text-danger"><?= esc($validation->getError('username')) ?></small>
                    <?php endif; ?>
                </div>

                <div class="field-group">
                    <label>Mot de passe</label>
                    <div class="input-wrap">
                        <div class="icon">
                            <svg viewBox="0 0 24 24">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </div>
                        <input type="password" name="password" placeholder="••••••••" />
                    </div>
                    <?php if (isset($validation) && $validation->hasError('password')): ?>
                        <small class="text-danger"><?= esc($validation->getError('password')) ?></small>
                    <?php endif; ?>
                </div>

                <div class="remember-row">
                    <label>
                        <input type="checkbox" name="remember" checked />
                        Se souvenir de moi
                    </label>
                    <a href="#">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-full">
                    <svg viewBox="0 0 24 24">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                        <polyline points="10 17 15 12 10 7" />
                        <line x1="15" y1="12" x2="3" y2="12" />
                    </svg>
                    Se connecter
                </button>

                <div class="login-footer">
                    Pas encore de compte ? <a href="#">Contactez votre administrateur</a>
                </div>
            </form>

        </div>
    </div>

    <!-- Informations de test (à supprimer en production) -->
    <div class="test-info" style="position:fixed; bottom:20px; left:50%; transform:translateX(-50%); background:rgba(0,0,0,0.8); color:white; padding:15px 25px; border-radius:8px; font-size:14px; text-align:center; max-width:90%; z-index:999;">
        <strong>Comptes de test :</strong><br>
        admin@sysinfo.com / admin123 &nbsp;|&nbsp; user@sysinfo.com / user123 &nbsp;|&nbsp; demo@sysinfo.com / demo123
    </div>

</body>

</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $title ?? 'SysInfo — Connexion' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
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
        <p class="subtitle">Connectez-vous à votre espace de travail</p>

        <?php if (isset($error)): ?>
            <div class="error-message" style="background:#fee2e2; color:#dc2626; padding:10px 14px; border-radius:8px; margin-bottom:20px;">
                <?= esc($error) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('login/authenticate') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="field-group">
                <label>Adresse e-mail</label>
                <div class="input-wrap">
                    <div class="icon">
                        <svg viewBox="0 0 24 24">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </div>
                    <input type="email" name="username" placeholder="vous@exemple.com" 
                           value="<?= old('username') ?>" />
                </div>
                <?php if (isset($validation) && $validation->hasError('username')): ?>
                    <small style="color:#dc2626; font-size:12px; margin-top:4px; display:block;">
                        <?= esc($validation->getError('username')) ?>
                    </small>
                <?php endif; ?>
            </div>

            <div class="field-group">
                <label>Mot de passe</label>
                <div class="input-wrap">
                    <div class="icon">
                        <svg viewBox="0 0 24 24">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                    </div>
                    <input type="password" name="password" placeholder="••••••••" />
                </div>
                <?php if (isset($validation) && $validation->hasError('password')): ?>
                    <small style="color:#dc2626; font-size:12px; margin-top:4px; display:block;">
                        <?= esc($validation->getError('password')) ?>
                    </small>
                <?php endif; ?>
            </div>

            <div class="remember-row">
                <label>
                    <input type="checkbox" name="remember" checked />
                    Se souvenir de moi
                </label>
                <a href="#">Mot de passe oublié ?</a>
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                <svg viewBox="0 0 24 24">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Se connecter
            </button>

            <div class="login-footer">
                Pas encore de compte ? <a href="#">Contactez votre administrateur</a>
            </div>
        </form>

    </div>
</div>

<!-- Informations de test -->
<div style="position:fixed; bottom:20px; left:50%; transform:translateX(-50%); background:rgba(0,0,0,0.8); color:white; padding:12px 20px; border-radius:8px; font-size:13px; text-align:center; max-width:90%; z-index:999;">
    <strong>Comptes de test :</strong><br>
    admin@sysinfo.com / admin123 &nbsp;|&nbsp; user@sysinfo.com / user123 &nbsp;|&nbsp; demo@sysinfo.com / demo123
</div>

</body>
</html>