<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 02/06/2022
 * Time: 07:53
 */

namespace Fosa\Application\Repositories;


class TodoRepository extends Repository
{
    public function __construct()
    {
        parent::__construct('todos');
    }

    public function getAll()
    {
        return $this->findAll();
    }
}