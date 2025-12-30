<?php

namespace Fosa\Core\Repositories;

/**
 * Class UserRepository
 * 
 * @package Fosa\Core\Repositories
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