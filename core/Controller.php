<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 21/12/2021
 * Time: 12:19
 */

namespace Fosa\Core;

/**
 * Class Controller
 * @package Fosa\Core
 */

class Controller
{
    public function __construct($method, Request $request, Response $response) {
        $this->call_method($method, $request, $response);
    }

    protected function call_method($method, Request $request, Response $response)
    {
        if(method_exists($this, $method))
            $this->$method($request, $response);
        else {
            http_response_code(500);
            die('The requested method "'. $method .'" is not found');
        }
    }
}