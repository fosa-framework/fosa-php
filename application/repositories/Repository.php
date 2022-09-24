<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 11/02/2022
 * Time: 07:14
 */

namespace Fosa\Application\Repositories;

class Repository extends Shark
{
    public function __construct($table)
    {
        parent::__construct($table);
    }
}