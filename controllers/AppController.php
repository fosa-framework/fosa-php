<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 11/02/2022
 * Time: 08:03
 */

namespace Fosa\Controllers;

use Fosa\Application\Controller;
use Fosa\Application\Request;
use Fosa\Application\Response;

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
}