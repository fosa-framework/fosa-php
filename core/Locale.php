<?php

namespace Fosa\Core;

/**
 * Class Locale
 * @package Fosa\Core
 */

class Locale
{
    /**
     * The translation array loaded from the translation file.
     * 
     * @var array
     */
    private $translation = [];

    public function __construct($locale = 'en-EN')
    {
        $LOCAL_DIR = dirname(__DIR__) . '/app/locales/' . $locale;
        if (!is_dir($LOCAL_DIR)) {
            $locale = 'en-EN';
        }
        require_once dirname(__DIR__) . '/app/locales/' . $locale . '/translation.php';
        $this->translation = $translation;
    }

    public function load($key)
    {
        if (!$key) {
            die('Warning : Locale translation key can not be null');
        }
        if (!isset($this->translation[$key])) {
            return NULL;
        }
        return $this->recursive_convert_array_to_obj($this->translation[$key]);
    }

    protected function recursive_convert_array_to_obj($arr)
    {
        if (is_array($arr)) {
            $new_arr = array();
            foreach ($arr as $k => $v) {
                if (is_integer($k)) {
                    $new_arr['index'][$k] = $this->recursive_convert_array_to_obj($v);
                } else {
                    $new_arr[$k] = $this->recursive_convert_array_to_obj($v);
                }
            }

            return (object)$new_arr;
        }
        return $arr;
    }
}
