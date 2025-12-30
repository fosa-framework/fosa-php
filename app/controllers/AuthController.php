<?php

namespace Fosa\Controllers;


use Fosa\Core\Controller;
use Fosa\Core\Request;
use Fosa\Core\Response;

class AuthController extends Controller
{

    public function __construct($method, Request $request, Response $response)
    {
        parent::__construct($method, $request, $response);
    }

    public function login(Request $request, Response $response)
    {
        $body = $request->getBody();
        // Handle authentication logic here (e.g., verify username and password)
        return $response->json([
            'data' => $body
        ], 200);
    }
}
