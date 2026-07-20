<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public $defaultGroup = 'default';


    // Configuration SQLite (pour plus tard)
    public array $default = [
    'DSN'          =>'',
    'hostname'     => '',
    'username'     => '',
    'password'     => '',
    'database'     => APPPATH . 'Database/sysinfo.db',
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
    'foreignKeys'  => true,
    'busyTimeout'  => 1000,
    'synchronous'  => null,
    'dateFormat'   => [
        'date'     => 'Y-m-d',
        'datetime' => 'Y-m-d H:i:s',
        'time'     => 'H:i:s',
    ],
];

    //--------------------------------------------------------------------
    // Environment-based database configuration
    //--------------------------------------------------------------------

    /**
     * Override the default database config for the current environment
     *
     * @return array<string, mixed>|null
     */
    public function getDefaultGroup(): ?array
    {
        if ($_ENV['CI_ENVIRONMENT'] === 'testing') {
            return $this->testing ?? null;
        }

        return $this->default ?? null;
    }

    //--------------------------------------------------------------------
    // Constructor
    //--------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Ensure that we always set the database group to 'default' if
        // we are running normally
        if (ENVIRONMENT !== 'testing') {
            $this->defaultGroup = 'default';
        }
    }

}