<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 08/06/2022
 * Time: 11:58
 */

namespace Fosa\Controllers;


use Fosa\Application\Controller;
use Fosa\Application\Request;
use Fosa\Application\Response;

class AuthController extends Controller
{

    public function __construct($method, Request $request, Response $response)
    {
        parent::__construct($method, $request, $response);
    }

    public function login(Request $request, Response $response)
    {
        $body = $request->getBody();
        return $response->json([
            'data' => $body
        ], 200);
    }
}