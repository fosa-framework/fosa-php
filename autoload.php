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

require_once __DIR__ . '/application/vendor/autoload.php';

/**
 * Custom autoload function to automatically load application classes.
 * This function will search for a class file in the following directories:
 * - application/
 * - application/repositories/
 * - controllers/
 * - middlewares/
 */
spl_autoload_register(function ($class) {
    // Extract the class name without the namespace
    $className = basename(str_replace('\\', '/', $class));

    // Directories to search for class files
    $directories = [
        __DIR__ . '/application/',
        __DIR__ . '/application/database/',
        __DIR__ . '/application/database/drivers/',
        __DIR__ . '/application/repositories/',
        __DIR__ . '/controllers/',
        __DIR__ . '/middlewares/',
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

use Fosa\Application\DotEnv;
use Fosa\Application\ErrorHandler;

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
