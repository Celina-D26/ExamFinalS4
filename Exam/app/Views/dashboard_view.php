<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SysInfo</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body>
    <div style="max-width:800px; margin:50px auto; padding:40px; background:white; border-radius:12px; box-shadow:0 8px 32px rgba(0,0,0,0.1);">
        <h1>Bienvenue sur votre Dashboard</h1>
        <p>Bonjour <strong><?= esc($username) ?></strong>, vous êtes connecté !</p>
        <p>Ceci est une version statique sans base de données.</p>
        <br>
        <a href="<?= site_url('logout') ?>" style="display:inline-block; padding:10px 20px; background:#dc3545; color:white; text-decoration:none; border-radius:6px;">Se déconnecter</a>
    </div>
</body>
</html>