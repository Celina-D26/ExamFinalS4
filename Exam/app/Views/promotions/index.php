<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Situation des Comptes Clients' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
    
</head>
<body>
    <h2>Gestion des promotion</h2>
    <div>
        <span class="badge bg-succes fs-6">
            <?= count($promotion_actives ?? [])?> Promotion active

        </span>

    </div>
    <!--message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-succes alert-dimissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dimiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-succes alert-dimissible fade show">
            <?=  session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dimiss="alert"></button>  
        </div>
    <?php endif; ?>

    <!--Statistique -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text p-3" >
                <h3 class="text-success mb-0"><?= count($promotion_actives ?? []) ?></h3>
                <small class="text-muted">Promotion active</small>
            </div>
        </div>
        <div class=""></div>
    </div>



</body>
