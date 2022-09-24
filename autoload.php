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

/* Cores */

require_once __DIR__ . '/application/Router.php';
require_once __DIR__ . '/application/Locale.php';
require_once __DIR__ . '/application/Template.php';
require_once __DIR__ . '/application/Request.php';
require_once __DIR__ . '/application/Response.php';
require_once __DIR__ . '/application/Controller.php';
require_once __DIR__ . '/application/Middleware.php';
require_once __DIR__ . '/application/Session.php';
require_once __DIR__ . '/application/Tokenizer.php';
require_once __DIR__ . '/application/DotEnv.php';
require_once __DIR__ . '/application/Email.php';

/* Repositories */
require_once __DIR__ . '/application/repositories/EntityManager.php';
require_once __DIR__ . '/application/repositories/Shark.php';
require_once __DIR__. '/application/repositories/Repository.php';
require_once __DIR__ . '/application/repositories/UserRepository.php';

/* Controllers */
require_once __DIR__ . '/controllers/AppController.php';
require_once __DIR__ . '/controllers/ExampleController.php';
require_once __DIR__ . '/controllers/AuthController.php';

/* Middlewares */
require_once __DIR__ . '/middlewares/TokenMiddleware.php';
require_once __DIR__ . '/middlewares/AuthBasicMiddleware.php';

/*
 * +-------------------------------------------------+
 * | Additional scripts                              |
 * +-------------------------------------------------+
 * | Execute script when app is bootstrapping        |
 * +-------------------------------------------------+
 */

use Fosa\Application\DotEnv;

(new DotEnv(__DIR__ . '/.env'))->load();

$APP_NAME = getenv('APP_NAME') || 'Fosa';

$APP_DEFAULT_LANG = getenv('APP_DEFAULT_LANG') || 'en-EN';

$APP_ENV = getenv('APP_ENV') || 'dev';