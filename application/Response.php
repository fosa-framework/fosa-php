<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 12/02/2022
 * Time: 13:09
 */

namespace Fosa\Application;

class Response
{
    public function __construct()
    {
    }

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
}