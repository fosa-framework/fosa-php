<?php
namespace Fosa\Core;

/**
 * Class Router
 * 
 * @package Fosa\Core
 */

class Router
{
    private $routes;

    /**
     * Router constructor.
     */

    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * Listen to client call
     *
     * @void
     */

    public function run()
    {
        $request = new Request();
        $response = new Response();
        if($this->match_api($request->getPath())) {
            $this->handleApiRoutes($request, $response);
        } else {
            $this->handleWebRoutes($request, $response);
        }
    }

    /**
     * Add route to Router
     *
     * @param $path_regex
     * @param string $http_method
     * @param $controller
     * @param $method
     * @param null $middleware
     * @return $this
     */

    public function route($path_regex, $http_method = 'GET', $controller, $method = 'index', $middleware = null)
    {
        if(is_array($path_regex)) {
            foreach ($path_regex as $regex)
            {
                $this->routes[$regex] = [
                    'http_method' => $http_method,
                    'controller' => $controller,
                    'method' => $method,
                    'middleware' => $middleware
                ];
            }
            return $this;
        }
        $this->routes[$path_regex] = [
            'http_method' => $http_method,
            'controller' => $controller,
            'method' => $method,
            'middleware' => $middleware
        ];
       return $this;
    }

    /**
     * Handle API call
     *
     * @param Request $request
     * @param Response $response
     * @return bool|void
     */

    protected function handleApiRoutes(Request $request, Response $response)
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Expose-Headers: Content-Length, X-JSON");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization, Access-Control-Allow-Origin");
        header('Access-Control-Max-Age: 86400');
        if($request->getMethod() === 'OPTIONS') {
            header("HTTP/1.1 200 OK");
            return;
        }
        foreach ($this->routes as $path_regex => $values) {
            if($path_regex === $request->getPath()) {
                if($values['http_method'] === $request->getMethod()) {
                    if($values['middleware']) {
                        $middleware = $values['middleware'];
                        $middleware_instance = new $middleware($request, $response);
                        if(!$middleware_instance->passport()) {
                            $middleware_instance->throwMiddlewareException();
                            return;
                        }
                    }
                    $controller = $values['controller'];
                    $method = $values['method'];
                    (new $controller($method, $request, $response));
                    return;
                }
            }
        }
        $response->json([
            'status' => 404,
            'error' => 'Unable to find requested source.',
            'method' => $request->getMethod(),
            'path' => $request->getPath()
        ], 400);
    }

    /**
     * Handle web request
     *
     * @param Request $request
     * @param Response $response
     * @return bool
     */

    protected function handleWebRoutes(Request $request, Response $response)
    {
        foreach ($this->routes as $path_regex => $values)
        {
            if($path_regex === $request->getPath() && $values['http_method'] === $request->getMethod()) {
                $controller = $values['controller'];
                $method = $values['method'];
                (new $controller($method, $request, $response));
                return;
            }
        }

        if(isset($this->routes['{handled-routes}'])) {
            $controller = $this->routes['{handled-routes}']['controller'];
            $method = $this->routes['{handled-routes}']['method'];
            $middleware = $this->routes['{handled-routes}']['middleware'];
            if($middleware) {
                $middleware_instance = new $middleware($response, $response);
                if(!(new $middleware($request))->passport()) {
                    $middleware_instance->throwMiddlewareException();
                    return;
                }
            }
            (new $controller($method, $request, $response));
            return;
        }

        $response->view('404', [
            'method' => $request->getMethod(),
            'path' => $request->getPath(),
        ], $request->getLocale());
    }

    /**
     * Check if API match path
     *
     * @param $path
     * @return false|int
     */

    protected function match_api($path)
    {
        return preg_match('/\/api\//m', $path);
    }
}