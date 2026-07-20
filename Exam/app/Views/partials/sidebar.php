<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-icon">
            <svg viewBox="0 0 24 24" width="18" height="18">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
            </svg>
        </div>
        <div>
            <div class="brand-name">SysInfo</div>
            <div class="brand-sub">v2.4.0</div>
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
        Tableau de bord
    </a>
    
    <a href="<?= site_url('users') ?>" class="nav-item <?= (current_url() == site_url('users')) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24">
            <line x1="8" y1="6" x2="21" y2="6" />
            <line x1="8" y1="12" x2="21" y2="12" />
            <line x1="8" y1="18" x2="21" y2="18" />
            <line x1="3" y1="6" x2="3.01" y2="6" />
            <line x1="3" y1="12" x2="3.01" y2="12" />
            <line x1="3" y1="18" x2="3.01" y2="18" />
        </svg>
        Utilisateurs
        <span class="nav-badge">24</span>
    </a>
    
    <a href="<?= site_url('form') ?>" class="nav-item <?= (current_url() == site_url('form')) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
        </svg>
        Formulaire
    </a>

    <div class="sidebar-section">Gestion Financière</div>

    <a href="<?= site_url('frais') ?>" class="nav-item <?= (current_url() == site_url('frais')) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24">
            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
        </svg>
        Barèmes Frais
    </a>

    <a href="<?= site_url('comptes') ?>" class="nav-item <?= (current_url() == site_url('comptes') || strpos(current_url(), 'comptes') !== false) ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="3" />
            <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14" />
        </svg>
        Comptes Clients
        <span class="nav-badge"><?= $totalClients ?? '5' ?></span>
    </a>

    <div class="sidebar-section">Modules</div>

    <a href="#" class="nav-item">
        <svg viewBox="0 0 24 24">
            <path d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z" />
        </svg>
        Catalogue
    </a>
    
    <a href="#" class="nav-item">
        <svg viewBox="0 0 24 24">
            <line x1="12" y1="1" x2="12" y2="23" />
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
        </svg>
        Comptabilité
    </a>
    
    <a href="#" class="nav-item">
        <svg viewBox="0 0 24 24">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
            <circle cx="9" cy="7" r="4" />
            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
        </svg>
        RH
    </a>
    
    <a href="#" class="nav-item">
        <svg viewBox="0 0 24 24">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
        </svg>
        Rapports
    </a>

    <div class="sidebar-section">Système</div>

    <a href="#" class="nav-item">
        <svg viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="3" />
            <path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14" />
        </svg>
        Paramètres
    </a>

    <div class="sidebar-bottom">
        <div class="user-row" style="padding:8px 10px; border-radius:8px; background:rgba(255,255,255,0.05); margin-bottom:8px;">
            <div class="avatar"><?= substr($username ?? 'U', 0, 2) ?></div>
            <div class="user-info">
                <div class="name"><?= esc($username ?? 'Utilisateur') ?></div>
                <div class="role">📱 <?= esc($phone_number ?? '') ?></div>
            </div>
        </div>
        <a href="<?= site_url('logout') ?>" class="nav-item" style="background:var(--c-primary); color:#fff; margin:4px 0 0 0; border-radius:7px; padding:9px 14px; text-decoration:none; display:flex; align-items:center; gap:10px; font-size:13.5px; font-weight:500;">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" fill="none">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            Déconnexion
        </a>
    </div>
</aside>