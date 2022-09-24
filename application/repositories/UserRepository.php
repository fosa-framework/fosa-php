<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 08/06/2022
 * Time: 12:18
 */

namespace Fosa\Application\Repositories;


class UserRepository extends Repository
{

    public function __construct()
    {
        parent::__construct('yume2020v1v105_users');
    }

    public function getAll()
    {
        return $this->findAll();
    }
}