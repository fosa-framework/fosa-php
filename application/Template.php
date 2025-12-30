<?php
namespace Fosa\Application;

/**
 * Class Template
 * 
 * @package Fosa\Application
 */

use Fosa\Application\Config;

class Template
{
    protected $locale;
    protected $translation;

    public function render($template, $data, $locale = NULL)
    {
        if(self::template_exist($template))
        {
            if(!is_null($locale)) {
                $this->locale = $locale;
                $this->translation = (new Locale($locale))->load($template);
            }
            require_once dirname(dirname(__FILE__)) . '/templates/' . $template . '.template.php';
            return true;
        } else {
            self::render('template-not-found', [
                'template' => $template . '.template.php'
            ]);
        }
    }

    protected function template_exist($template)
    {
        $file_url = realpath(dirname(dirname(__FILE__)) . '/templates/'. $template .'.template.php');
        return file_exists($file_url);
    }

    protected function assets($dir, $name)
    {
        echo '/static/' . $dir . '/' . $name;
    }

    protected function get_locale()
    {
        echo $this->locale;
    }

    protected function get_app_name()
    {
        echo (new Config())->get('APP_NAME');
    }

    protected function render_locale($key, $params = [])
    {
        if(!$key) {
            die('Warning: Template renderLocal:$key can not be null.');
        }
        echo $this->resolve_object_value($key, $this->translation, $params);
    }

    protected function resolve_object_value($key, $object, $params) {
        $value = $object;
        $props = explode('.', $key);
        foreach ($props as $prop) {
            $value = $value->{$prop};
        }
        if(count($params) > 0) {
            $TRANSLATION_PARAM_TOKEN = (new Config())->get('TRANSLATION_PARAM_TOKEN') ?: '%%';
            foreach ($params as $key => $param) {
                $value = str_replace($TRANSLATION_PARAM_TOKEN . $key . $TRANSLATION_PARAM_TOKEN   , $param, $value);
            }
        }
        return $value;
    }
}