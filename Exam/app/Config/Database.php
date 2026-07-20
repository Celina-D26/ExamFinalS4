<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public $defaultGroup = 'default';

    public $default = [
        'DSN'          => 'sqlite:' . APPPATH . 'Database/sysinfo.db',
        'hostname'     => '',
        'username'     => '',
        'password'     => '',
        'database'     => '',
        'DBDriver'     => 'SQLite3',
        'DBPrefix'     => '',
        'pConnect'     => false,
        'DBDebug'      => true,
        'charset'      => 'utf8',
        'DBCollat'     => 'utf8_general_ci',
        'swapPre'      => '',
        'encrypt'      => false,
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 3306,
        'numberNative' => false,
        'dateFormat'   => [
            'date'     => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time'     => 'H:i:s',
        ],
    ];
}