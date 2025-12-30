<?php

namespace Fosa\Application\Repositories;

/**
 * Class Repository
 * 
 * @package Fosa\Application\Repositories
 */

class Repository extends Shark
{
    public function __construct($table)
    {
        parent::__construct($table);
    }
}