<?php
/**
 * Created by PhpStorm.
 * User: R. Finoana Mendrika
 * Date: 12/02/2022
 * Time: 15:42
 */

namespace Fosa\Application;

class Template
{
    protected $locale;
    protected $translation;

    public function __construct() {}

    public function render($template, $data, $locale = 'en-EN')
    {
        if(self::template_exist($template))
        {
            $this->locale = $locale;
            $this->translation = (new Locale($locale))->load($template);
            require_once dirname(dirname(__FILE__)) . '/templates/' . $template . '.template.php';
            return true;
        } else {
            self::render('not-found', [
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

    protected function render_locale($key)
    {
        if(!$key) {
            die('Warning: Template renderLocal:$key can not be null.');
        }
        echo $this->resolve_object_value($key, $this->translation);
    }

    protected function resolve_object_value($key, $object) {
        $value = $object;
        $props = explode('.', $key);
        foreach ($props as $prop) {
            $value = $value->{$prop};
        }
        return $value;
    }
}