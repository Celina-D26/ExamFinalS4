<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24" width="18" height="18">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
            </svg>
        </div>
        <div>
            <div class="brand-name">Mobile Money</div>
            <div class="brand-sub">v1.0</div>
        </div>
    </div>

    <div class="sidebar-section">Navigation</div>

    <a href="<?= site_url('dashboard') ?>" class="nav-item <?= (current_url() == site_url('dashboard')) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24">
            <rect width="7" height="9" x="3" y="3" rx="1" />
            <rect width="7" height="5" x="14" y="3" rx="1" />
            <rect width="7" height="9" x="14" y="12" rx="1" />
            <rect width="7" height="5" x="3" y="16" rx="1" />
        </svg>
        <span>Tableau de bord</span>
    </a>

    <a href="<?= site_url('client/operations') ?>" class="nav-item <?= (current_url() == site_url('client/operations')) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24">
            <line x1="12" y1="1" x2="12" y2="23" />
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
        </svg>
        <span>Opérations</span>
    </a>

    <a href="<?= site_url('client/history') ?>" class="nav-item <?= (current_url() == site_url('client/history')) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10" />
            <polyline points="12 6 12 12 16 14" />
        </svg>
        <span>Historique</span>
    </a>

    <div class="sidebar-section">Administration</div>

    <a href="<?= site_url('comptes') ?>" class="nav-item <?= (current_url() == site_url('comptes')) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
        </svg>
        <span>Comptes Clients</span>
    </a>

    <a href="<?= site_url('frais') ?>" class="nav-item <?= (current_url() == site_url('frais')) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24">
            <line x1="12" y1="1" x2="12" y2="23" />
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
        </svg>
        <span>Barèmes Frais</span>
    </a>

    <a href="<?= site_url('prefixes') ?>" class="nav-item <?= (current_url() == site_url('prefixes')) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24">
            <path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z" />
        </svg>
        <span>Préfixes</span>
    </a>

    <a href="<?= site_url('gains') ?>" class="nav-item <?= (current_url() == site_url('gains')) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24">
            <line x1="12" y1="1" x2="12" y2="23" />
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
        </svg>
        <span>Gains</span>
    </a>

    <div class="sidebar-bottom">
        <div class="user-row" style="display:flex; align-items:center; gap:10px; padding:8px 12px; border-radius:8px; background:rgba(255,255,255,0.05); margin-bottom:8px;">
            <div class="avatar"><?= substr($username ?? 'U', 0, 2) ?></div>
            <div class="user-info">
                <div class="name"><?= esc($username ?? 'Utilisateur') ?></div>
                <div class="role">📱 <?= esc($phone_number ?? '') ?></div>
            </div>
        </div>
        <a href="<?= site_url('logout') ?>" class="nav-item" style="background:#ef4444; color:#fff; margin:4px 0 0 0; border-radius:7px; padding:9px 14px; text-decoration:none; display:flex; align-items:center; gap:10px; font-size:13.5px; font-weight:500;">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            Déconnexion
        </a>
    </div>
</aside>

<style>
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
        background: #2563eb;
        border-radius: 6px;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
    }
    .logo-icon svg { fill: #fff; }
    .brand-name { font-weight: 700; font-size: 16px; color: #fff; }
    .brand-sub { font-size: 10px; opacity: 0.5; }
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
    .nav-item svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
    .nav-item:hover { background: rgba(255,255,255,0.06); color: #f1f5f9; }
    .nav-item.active { background: #2563eb; color: #fff; }
    .sidebar-bottom { margin-top: auto; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 12px; }
    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        background: #2563eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 13px;
        color: #fff;
        flex-shrink: 0;
    }
    .user-info .name { font-weight: 500; font-size: 13px; color: #f1f5f9; }
    .user-info .role { font-size: 11px; color: #94a3b8; }
    @media (max-width: 768px) {
        .sidebar { width: 60px; padding: 12px 8px; }
        .sidebar .brand-name, .sidebar .brand-sub, .sidebar .sidebar-section, 
        .sidebar .nav-item span, .sidebar .user-info { display: none; }
        .sidebar .nav-item { justify-content: center; padding: 10px; }
        .sidebar .sidebar-brand { justify-content: center; }
        .sidebar .avatar { width: 28px; height: 28px; font-size: 10px; }
    }
</style>