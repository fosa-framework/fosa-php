<?php

namespace Fosa\Application;

/**
 * Abstract class Middleware
 * @package Fosa\Application
 */

abstract class Middleware
{
    public abstract function passport();
    public abstract function throwMiddlewareException();
}