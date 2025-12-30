<?php

namespace Fosa\Core\Repositories;

/**
 * Class Repository
 * 
 * @package Fosa\Core\Repositories
 */

class Repository extends Shark
{
    public function __construct($table)
    {
        parent::__construct($table);
    }
}