<aside style="width:260px;background:#1f2937;color:#e5e7eb;padding:16px;display:flex;flex-direction:column;flex-shrink:0;height:100vh;position:sticky;top:0;overflow-y:auto;">
    <div style="display:flex;align-items:center;gap:12px;padding:16px 12px;border-bottom:1px solid rgba(255,255,255,0.08);margin-bottom:16px;">
        <div style="background:#2563eb;padding:8px;border-radius:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" stroke="#fff" fill="none" stroke-width="2">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
        </div>
        <div>
            <div style="font-weight:700;font-size:18px;color:#fff;">Mobile Money</div>
            <div style="font-size:11px;color:#9ca3af;">Opérateur v1.0</div>
        </div>
    </div>

    <div style="font-size:11px;text-transform:uppercase;letter-spacing:0.5px;color:#9ca3af;padding:12px 12px 6px 12px;">Gestion</div>

    <a href="<?= site_url('operator/dashboard') ?>" class="nav-link <?= (current_url() == site_url('operator/dashboard')) ? 'active' : '' ?>" style="color:<?= (current_url() == site_url('operator/dashboard')) ? '#93bbfc' : '#d1d5db' ?>;text-decoration:none;display:flex;align-items:center;gap:10px;padding:8px 12px;border-radius:8px;<?= (current_url() == site_url('operator/dashboard')) ? 'background:rgba(37,99,235,0.2);' : '' ?>margin:2px 0;">
        <svg width="20" height="20" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
            <rect width="7" height="9" x="3" y="3" rx="1"/>
            <rect width="7" height="5" x="14" y="3" rx="1"/>
            <rect width="7" height="9" x="14" y="12" rx="1"/>
            <rect width="7" height="5" x="3" y="16" rx="1"/>
        </svg>
        Tableau de bord
    </a>

    <a href="<?= site_url('operator/clients') ?>" class="nav-link <?= (current_url() == site_url('operator/clients')) ? 'active' : '' ?>" style="color:<?= (current_url() == site_url('operator/clients')) ? '#93bbfc' : '#d1d5db' ?>;text-decoration:none;display:flex;align-items:center;gap:10px;padding:8px 12px;border-radius:8px;<?= (current_url() == site_url('operator/clients')) ? 'background:rgba(37,99,235,0.2);' : '' ?>margin:2px 0;">
        <svg width="20" height="20" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        Clients
    </a>

    <a href="<?= site_url('operator/fees') ?>" class="nav-link <?= (current_url() == site_url('operator/fees')) ? 'active' : '' ?>" style="color:<?= (current_url() == site_url('operator/fees')) ? '#93bbfc' : '#d1d5db' ?>;text-decoration:none;display:flex;align-items:center;gap:10px;padding:8px 12px;border-radius:8px;<?= (current_url() == site_url('operator/fees')) ? 'background:rgba(37,99,235,0.2);' : '' ?>margin:2px 0;">
        <svg width="20" height="20" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
            <line x1="12" y1="1" x2="12" y2="23"/>
            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
        </svg>
        Barème des frais
    </a>

    <div style="margin-top:12px;border-top:1px solid rgba(255,255,255,0.08);padding-top:12px;">
        <div style="font-size:11px;text-transform:uppercase;letter-spacing:0.5px;color:#9ca3af;padding:0 12px 6px 12px;">Espace</div>
        <a href="<?= site_url('client/dashboard') ?>" class="nav-link" style="color:#93bbfc;text-decoration:none;display:flex;align-items:center;gap:10px;padding:8px 12px;border-radius:8px;margin:2px 0;">
            <svg width="20" height="20" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
            Client
        </a>
    </div>

    <div style="margin-top:auto;padding-top:16px;border-top:1px solid rgba(255,255,255,0.08);">
        <div style="display:flex;align-items:center;gap:10px;padding:8px 12px;border-radius:8px;background:rgba(255,255,255,0.05);margin-bottom:8px;">
            <div style="width:32px;height:32px;border-radius:50%;background:#2563eb;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:13px;"><?= substr($username ?? 'U', 0, 2) ?></div>
            <div>
                <div style="color:#fff;font-weight:600;font-size:14px;"><?= esc($username ?? 'Utilisateur') ?></div>
                <div style="color:#9ca3af;font-size:11px;">📱 <?= esc($phone_number ?? '') ?></div>
            </div>
        </div>
        <a href="<?= site_url('logout') ?>" style="display:block;padding:9px 14px;background:#ef4444;color:#fff;border-radius:8px;text-decoration:none;font-weight:500;font-size:13.5px;text-align:center;">Déconnexion</a>
    </div>
</aside>