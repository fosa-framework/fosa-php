<?php

namespace App\Controllers;

use Fosa\Core\Controller;
use Fosa\Core\Request;
use Fosa\Core\Response;

class AppController extends Controller
{
    public function __construct($method, Request $request, Response $response)
    {
        parent::__construct($method, $request, $response);
    }

    public function index(Request $request, Response $response)
    {
        return $response->view('app', [], $request->getLocale());
    }

    public function hello(Request $request, Response $response)
    {
        return $response->json([
            'message' => 'Hello, welcome to Fosa PHP Framework!'
        ]);
    }
}
