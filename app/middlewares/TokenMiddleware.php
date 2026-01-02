<?php

namespace App\Middlewares;

use Fosa\Core\Request;
use Fosa\Core\Middleware;
use Fosa\Core\Response;
use Fosa\Core\Tokenizer;

class TokenMiddleware extends Middleware
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
        return (new Tokenizer())->isValid($this->request->getBearerToken());
    }

    public function throwMiddlewareException()
    {
        return $this->response->json([
            'error' => 'Passport not validated by middleware',
            'stack' => self::class
        ], 400);
    }
}