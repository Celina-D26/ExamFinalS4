<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Modifier le Préfixe' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    
    <style>
        /* ... vos styles ... */
    </style>
</head>
<body>

<div class="app">
    <!-- Sidebar -->
    <?= view('partials/sidebar') ?>

    <!-- Main -->
    <div class="main">
        <div class="topbar" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div class="topbar-title" style="font-size:20px; font-weight:600;">✏️ Modifier le Préfixe</div>
            <div>
                <a href="<?= base_url('prefixes') ?>" class="btn btn-secondary">
                    ⬅️ Retour
                </a>
            </div>
        </div>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (isset($prefixe)): ?>
        <div class="card">
            <div class="card-header">
                <span>Modifier le préfixe : <code><strong><?= $prefixe['prefixe'] ?? '' ?></strong></code></span>
            </div>
            <div class="card-body">
                <form action="<?= base_url('prefixes/update/' . $prefixe['id']) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">📱 Préfixe</label>
                            <input type="text" name="prefixe" class="form-control" 
                                   value="<?= old('prefixe', $prefixe['prefixe']) ?>" required maxlength="5">
                            <small class="text-muted">Les 2-3 premiers chiffres du numéro</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">🏢 Opérateur</label>
                            <input type="text" name="operateur" class="form-control" 
                                   value="<?= old('operateur', $prefixe['operateur']) ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">🌍 Pays</label>
                            <input type="text" name="pays" class="form-control" 
                                   value="<?= old('pays', $prefixe['pays']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">💰 Commission (%)</label>
                            <input type="number" name="commission" class="form-control" 
                                   value="<?= old('commission', $prefixe['commission']) ?>" 
                                   step="0.01" min="0" max="100" required>
                            <small class="text-muted">Commission en % pour les transferts vers cet opérateur</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="est_actif" class="form-check-input" value="1" 
                                   <?= old('est_actif', $prefixe['est_actif']) == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label">✅ Actif</label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
                        <a href="<?= base_url('prefixes') ?>" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-danger">
            <p>Préfixe non trouvé !</p>
            <a href="<?= base_url('prefixes') ?>" class="btn btn-primary">Retour à la liste</a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>