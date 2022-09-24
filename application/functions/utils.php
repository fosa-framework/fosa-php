<?php

    abstract class HttpStatusCodeResponse {
        const HTTP_OK = 200;
        const HTTP_CREATED = 201;
        const HTTP_BAD_REQUEST = 400;
        const HTTP_NOT_FOUND = 404;
        const HTTP_INTERNAL_SERVER_ERROR = 500;
    }

    if(!function_exists('slugify')) {
        function slugify($text) {
            // replace non letter or digits by -
            $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    
            // transliterate
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
            // remove unwanted characters
            $text = preg_replace('~[^-\w]+~', '', $text);
    
            // trim
            $text = trim($text, '-');
    
            // remove duplicate -
            $text = preg_replace('~-+~', '-', $text);
    
            // lowercase
            $text = strtolower($text);
    
            if (empty($text)) {
                return 'n-a';
            }
            return $text;
        }
    }

    if(!function_exists('generateRandomString')) {
        function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
    }

    if(!function_exists('generateToken')) {
        function generateToken() {
            return hash('md5', generateRandomString(20));
        }
    }

    if(!function_exists('generateCode')) {
        function generateCode($length = 6) {
            $random = [];
            for($i = 0; $i < $length; $i++) {
                $random[$i] = rand(0, 9);
            }
            return implode('-', $random);
        }
    }