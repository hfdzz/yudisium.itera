<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class SILABOR extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * SILABOR API URL
     * --------------------------------------------------------------------------
     *
     * The URL of the SILABOR API. 
     */
    public array $silaborAPIURL = [
        'getAllBebasLabURL' => 'https://silabor.itera.ac.id/data/bebaslab',
    ];

    public bool $refreshCache = false;
}
