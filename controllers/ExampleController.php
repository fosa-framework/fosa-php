<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 31/05/2022
 * Time: 06:59
 */

namespace Fosa\Controllers;


use Fosa\Application\Controller;
use Fosa\Application\Request;
use Fosa\Application\Response;

class ExampleController extends Controller
{
    public function __construct($method, Request $request, Response $response)
    {
        parent::__construct($method, $request, $response);
    }

    public function index(Request $request, Response $response)
    {
        return $response->json([
            'message' => 'Hello API consumer !'
        ], 200);
    }
}