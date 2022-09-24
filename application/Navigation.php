<?php

    include __DIR__ . '/Config.php';
    if(!defined('BASEURL')) {
        define('BASEURL', $config['base_url']);
    }
    /**
     * Navigation on all pages
     */
    class Navigation {

        function __construct() {}

        public function navigate($route, $params = []) {
            $exploded = explode('?', $route);
            if($exploded && count($exploded) > 1) {
                parse_str($exploded[1], $defaultParams);
                array_merge($params, $defaultParams);
                $route = $exploded[0];
            }
            $urlparams = '?';
            if(count($params) > 0) {
                $urlparams .= http_build_query($params);
            }
            if($route == '/') {
                exit(header("Location: ". BASEURL . '/' . $urlparams));
            }
            $file = $route . '.php';
            if(file_exists($file)) {
                exit(header("Location: ". BASEURL . '/' . $route . $urlparams));
            } else {
                $this->navigate('404', array_merge($params, [
                    'origin' => $file
                ]));
            }
        }

        public function redirect($route, $params = ['rdr' => 1])
        {
            exit(header("Location: " . BASEURL . $route . '?' . http_build_query($params)));
        }
    }

?>