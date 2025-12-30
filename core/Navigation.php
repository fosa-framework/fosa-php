<?php

namespace Fosa\Core;

/**
 * Class Navigation
 * This class is used to navigate between pages.
 * 
 * @package Fosa\Core
 */

use Fosa\Core\Config;

class Navigation {

    function __construct() {
        if(!defined('BASEURL')) {
            // Load the configuration
            $config = new Config();
            $ssl = $config->get('SSL');
            $host = $config->get('HOST');
            $port = $config->get('PORT');

            // Check if the host and port are defined
            if(!$host || !$port) {
                throw new \Exception('Host and port must be defined in the config file or in the .env file.');
            }

            // Set the base URL
            $base_url = ($ssl ? 'https' : 'http') . '://' . $host . ':' . $port;

            define('BASEURL', $base_url);
        }
    }

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