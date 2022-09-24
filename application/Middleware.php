<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 11/02/2022
 * Time: 10:18
 */

namespace Fosa\Application;

abstract class Middleware
{
    public abstract function passport();
    public abstract function throwMiddlewareException();
}