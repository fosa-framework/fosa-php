<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 24/09/2022
 * Time: 10:10
 */

namespace Fosa\Application;


class Locale
{
    private $translation = [];

    public function __construct($locale = 'en-EN')
    {
        $LOCAL_DIR = __DIR__ . '/locales/' . $locale;
        if (!is_dir($LOCAL_DIR)) {
            $locale = 'en-EN';
        }
        require_once __DIR__ . '/locales/' . $locale . '/translation.php';
        $this->translation = $translation;
    }

    public function load($key)
    {
        if (!$key) {
            die('Warning : Locale translation key can not be null');
        }
        if (!isset($this->translation[$key])) {
            die('Warning : Locale translation key is not set in translation array.');
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