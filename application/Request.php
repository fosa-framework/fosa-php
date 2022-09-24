<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 22/12/2021
 * Time: 11:42
 */

namespace Fosa\Application;

class Request
{
    private $uri;
    private $method;

    public function __construct()
    {
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function getHeaders()
    {
        return [
            'Authorization' => isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : null,
            'Content-Type' => isset($_SERVER['HTTP_CONTENT_TYPE']) ? $_SERVER['HTTP_CONTENT_TYPE'] : null,
        ];
    }

    public function getBearerToken()
    {
        $authorization = self::getHeaders()['Authorization'];
        if(!$authorization) return null;
        return explode('Bearer ', $authorization)[1];
    }

    public function getBasicAuth()
    {
        $authorization = self::getHeaders()['Authorization'];
        if(!$authorization) return null;
        return explode('Basic ', $authorization)[1];
    }

    public function getURI()
    {
        return $this->uri;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getPath()
    {
        return explode('?', $this->uri)[0];
    }

    public function getParams()
    {
        return $_GET;
    }

    public function getBody($key = null)
    {
        $body = null;
        if(self::getHeaders()['Content-Type'] === 'application/json') {
            $json = file_get_contents('php://input');
            $body = json_decode($json);
        } else {
            $body = $_POST;
        }
        if($key) {
            if(is_object($body)) $body = $body->$key;
            if(is_array($body)) $body = isset($body[$key]) ? $body[$key] : null;
        }
        return $body;
    }

    public function filter($keys)
    {
        $body = self::getBody();
        if($body) {
            $result = [];
            foreach ($keys as $key)
            {
                if(isset($body[$key])) {
                    $result[$key] = $body[$key];
                }
            }
            return $result;
        }
        return null;
    }

    public function getLocale()
    {
        return isset($_GET['lang']) ? $_GET['lang'] : 'en-EN';
    }
}