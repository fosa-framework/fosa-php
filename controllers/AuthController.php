<?php

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
        // Handle authentication logic here (e.g., verify username and password)
        return $response->json([
            'data' => $body
        ], 200);
    }
}
