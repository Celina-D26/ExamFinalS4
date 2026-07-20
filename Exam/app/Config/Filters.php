<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'auth'          => \App\Filters\Auth::class,
    ];

    public $globals = [
        'before' => [
            // ON ENLÈVE 'csrf' D'ICI pour éviter de bloquer les affichages de page GET
        ],
        'after' => [
            'toolbar',
        ],
    ];

    // Le CSRF s'applique uniquement lors des soumissions de formulaires (POST)
    public $methods = [
        'post' => ['csrf'],
    ];

    // Protection des routes via le filtre Auth
    public $filters = [
        'auth' => ['before' => ['dashboard', 'users', 'form']], 
    ];
}