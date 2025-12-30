<?php

namespace Fosa\Application\Repositories;

/**
 * Class UserRepository
 * 
 * @package Fosa\Application\Repositories
 */


class UserRepository extends Repository
{

    public function __construct()
    {
        parent::__construct('users');
    }

    public function getAll()
    {
        return $this->findAll();
    }
}