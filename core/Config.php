<?php

namespace Fosa\Core;

/**
 * Class Config
 * @package Fosa\Core
 */

class Config
{
    /**
     * The configuration array loaded from the config file.
     * 
     * @var array
     */
    private $config = [];

    public function __construct()
    {
        require __DIR__ . '/constants/config.php';
        $this->config = $config;
    }

    public function get($key)
    {
        if(!$key || !isset($this->config[$key])) {
            return NULL;
        }

        return $this->config[$key];
    }
}