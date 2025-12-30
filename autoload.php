<?php

/*
 * +---------------------------------+
 * | Fosa                         |
 * +---------------------------------+
 * | @version 1.0                    |
 * | @author Mendrika Rabeh          +
 * | @email frabehevitra@gmail.com   |
 *-----------------------------------
 */

/*
 * +---------------------------------+
 * | Autoload                        |
 * +---------------------------------+
 * | Autoload cores and requirements |
 * +---------------------------------+
 */

/* Composer vendor autoload */

require_once __DIR__ . '/core/vendor/autoload.php';

/**
 * Custom autoload function to automatically load core classes.
 * This function will search for a class file in the following directories:
 * - core/
 * - core/repositories/
 * - controllers/
 * - middlewares/
 */
spl_autoload_register(function ($class) {
    // Extract the class name without the namespace
    $className = basename(str_replace('\\', '/', $class));

    // Directories to search for class files
    $directories = [
        __DIR__ . '/core/',
        __DIR__ . '/core/database/',
        __DIR__ . '/core/database/drivers/',
        __DIR__ . '/core/repositories/',
        __DIR__ . '/app/controllers/',
        __DIR__ . '/app/middlewares/',
    ];

    // Loop through directories and include the file if found
    foreach ($directories as $directory) {
        $file = $directory . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

/*
 * +-------------------------------------------------+
 * | Additional scripts                              |
 * +-------------------------------------------------+
 * | Execute script when app is bootstrapping        |
 * +-------------------------------------------------+
 */

use Fosa\Core\DotEnv;
use Fosa\Core\ErrorHandler;

// Setting up error handler
function errorHandler($errno, $errstr, $errfile, $errline)
{
    (new ErrorHandler())->init($errno, $errstr, $errfile, $errline);
}

set_error_handler("errorHandler");

/*
 * Load environment variables
 */

(new DotEnv(__DIR__ . '/.env'))->load();

$APP_NAME = getenv('APP_NAME') ?: 'Fosa';
$APP_DEFAULT_LANG = getenv('APP_DEFAULT_LANG') ?: 'en-EN';
$APP_ENV = getenv('APP_ENV') ?: 'dev';
