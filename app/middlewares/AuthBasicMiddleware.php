<?php

namespace App\Middlewares;

use Fosa\Core\Middleware;
use Fosa\Core\Request;
use Fosa\Core\Response;


class AuthBasicMiddleware extends Middleware
{
    private $request;
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function passport()
    {
        return self::validateAuth($this->request->getBasicAuth());
    }

    public function throwMiddlewareException()
    {
        return $this->response->json([
            'error' => 'Passport not validated by middleware',
            'stack' => self::class
        ], 400);
    }

    private function validateAuth($auth)
    {
        if(!$auth) return null;
        $auth_arr = explode(':', base64_decode($auth));
        if(!empty($auth_arr)) {
            list ($username, $password) = $auth_arr;
            return $username === 'admin' && $password === 'admin';
        }
        return false;
    }
}