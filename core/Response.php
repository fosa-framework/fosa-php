<?php

namespace Fosa\Core;

/**
 * Class Response
 * 
 * @package Fosa\Core
 */

class Response
{
    public function view($template, $data, $locale = NULL)
    {
        return (new Template())->render($template, $data, $locale);
    }

    public function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        return true;
    }

    public function status($status)
    {
        http_response_code($status);
        return true;
    }
}
