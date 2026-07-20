<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-card {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        .error-card .icon { font-size: 48px; margin-bottom: 10px; }
        .error-card h2 { color: #dc2626; margin: 10px 0; }
        .error-card .details {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            text-align: left;
            font-size: 13px;
            color: #6b7280;
            margin: 15px 0;
            overflow: auto;
            max-height: 200px;
        }
        .btn-primary { 
            background: #2563eb; 
            color: #fff; 
            padding: 10px 24px; 
            border: none; 
            border-radius: 8px; 
            text-decoration: none; 
            display: inline-block;
        }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-secondary {
            background: #f3f4f6;
            color: #111827;
            padding: 10px 24px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
        }
    </style>
</head>
<body>
    <div class="error-card">
        <div class="icon">⚠️</div>
        <h2>Une erreur est survenue</h2>
        <p style="color: #6b7280;"><?= esc($message ?? 'Erreur inconnue') ?></p>
        <?php if (isset($exception) && ENVIRONMENT !== 'production'): ?>
            <div class="details">
                <strong><?= get_class($exception) ?></strong><br>
                <?= $exception->getMessage() ?><br>
                <span style="color: #9ca3af;">Fichier: <?= $exception->getFile() ?> ligne <?= $exception->getLine() ?></span>
            </div>
        <?php endif; ?>
        <div>
            <a href="<?= site_url('dashboard') ?>" class="btn-primary">Retour à l'accueil</a>
            <a href="javascript:history.back()" class="btn-secondary">Retour</a>
        </div>
    </div>
</body>
</html>