<?php

namespace Fosa\Core;

/**
 * Abstract class Middleware
 * @package Fosa\Core
 */

abstract class Middleware
{
    public abstract function passport();
    public abstract function throwMiddlewareException();
}