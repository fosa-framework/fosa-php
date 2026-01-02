![Fosa](./public/favicon/favicon.ico?raw=true)

# Fosa Framework

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Fosa is a lightweight and elegant PHP web framework designed for endemic developers. It provides a simple yet powerful foundation for building web applications.

**Current Version:** 1.0  
**PHP Requirement:** >= 5.4

## Installation

### Method 1: Create a new project with Composer (Recommended)

```bash
composer create-project fosa-framework/fosa my-app
cd my-app
```

The installer will automatically:
- Create necessary directories
- Generate a `.env` file from `.env.example`
- Create example files and templates
- Set up `.htaccess` for Apache

### Method 2: Install as a dependency

Add Fosa to your existing Composer project:

```bash
composer require fosa-framework/fosa
```

## Configuration

1. **Copy environment file:**
   ```bash
   cp .env.example .env
   ```

2. **Edit `.env` with your settings:**
   ```env
   APP_NAME=My Fosa App
   APP_ENV=development
   R_HOST=localhost
   R_PORT=8085
   
   # Database
   DB_DRIVER=mysql
   DB_HOST=localhost
   DB_NAME=fosa_db
   DB_USER=root
   ```

## Quick Start

### Starting the Development Server

```bash
php server/run
```

The server will run at `http://localhost:8085` (configurable via `.env`)

### Creating Your First Controller

Create a file `app/controllers/YourController.php`:

```php
<?php

namespace Fosa\Controllers;

use Fosa\Core\Controller;
use Fosa\Core\Request;
use Fosa\Core\Response;

class YourController extends Controller
{
    public function __construct($method, Request $request, Response $response)
    {
        parent::__construct($method, $request, $response);
    }

    public function index(Request $request, Response $response)
    {
        return $response->view('your-view', [
            'message' => 'Hello, World!',
        ]);
    }
}
```

### Creating a View Template

Create a file `app/templates/your-view.template.php`:

```php
<!DOCTYPE html>
<html>
<head>
    <title>My Page</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($data['message']); ?></h1>
</body>
</html>
```

All methods provided by the class `Template` are :

| Methods        | Description           | Results  |
| ------------- |:-------------:| -----:|
| `get_app_name()` | Return app name value defined in in `.env` file or `/application/constants/config.php` file.      |    Default `Fosa` |
| `get_locale()`      | Get the current locale. | `en-EN` or `fr-FR` |
| `assets($dir, $name)`      | Get URL of assets located in `statics` folder.      |  `/statics/images/Fosa.png`  |
| `render_locale($key)` | Return translated key based text located in `/application/locales/<locale>/translation.php`.      |    `Welcome` or `Bienvenue` |

### Routing

The routing configuration is in file `index.php` located in at the root project directory, you can easily register new route by using `Router` instance `$router` :

```php
...

use Fosa\Controllers\YourController;

$router = new Router();

/* WEB routes */
...
$router->route('/my-controller', 'GET', YourController::class);

...
```

And the, you can access to your URL `http://localhost:8085/my-controller` .

## Directory Structure

```
my-app/
├── app/
│   ├── controllers/          # Your application controllers
│   ├── middlewares/          # Custom middleware
│   ├── models/               # Data models
│   └── templates/            # View templates
├── src/
│   └── Fosa/                 # Framework core classes
├── public/                   # Public web root (for .htaccess)
├── storage/
│   ├── logs/                 # Application logs
│   └── cache/                # Cache files
├── vendor/                   # Composer dependencies
├── .env                      # Environment configuration
├── composer.json             # Project dependencies
└── index.php                 # Application entry point
```

## Framework Core Components

- **Controller** - Base class for all controllers
- **Request** - Handle incoming HTTP requests
- **Response** - Generate HTTP responses
- **Router** - URL routing system
- **Template** - View rendering engine
- **Middleware** - Request/response middleware pipeline
- **Session** - Session management
- **Database** - Database abstraction layer with drivers
- **Repository** - Data access patterns
- **Email** - Email sending via PHPMailer
- **Locale** - Multi-language support
- **Config** - Configuration management
- **ErrorHandler** - Error and exception handling

## Features

✅ **Lightweight** - Minimal footprint, fast performance  
✅ **PSR-4 Autoloading** - Modern PHP namespace support  
✅ **Middleware Support** - Request/response middleware pipeline  
✅ **Template Engine** - Simple and flexible view rendering  
✅ **Database Abstraction** - MySQL driver included, extensible  
✅ **Repository Pattern** - Clean data access layer  
✅ **Email Integration** - PHPMailer support  
✅ **Multi-language** - Built-in localization support  
✅ **Session Management** - Secure session handling  
✅ **Error Handling** - Comprehensive error management  

## Project Requirements

- **PHP:** 5.4 or higher
- **Composer:** Latest version
- **Database:** MySQL (other databases can be added)
- **Web Server:** Apache (with mod_rewrite), Nginx, or PHP built-in server

## Dependencies

The framework uses the following external packages:

- **PHPMailer** - Email library

All dependencies are automatically installed via Composer.

## Usage Examples

### Routing

Routes are typically defined in your router configuration:

```php
$router->add('GET', '/', 'HomeController@index');
$router->add('GET', '/users/:id', 'UserController@show');
$router->add('POST', '/users', 'UserController@store');
```

### Middleware

Create middleware in `app/middlewares/`:

```php
class AuthBasicMiddleware extends Middleware
{
    private $request;
    private $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function passport()
    {
        return self::validateAuth($this->request->getBasicAuth());
    }

    public function throwMiddlewareException()
    {
        return $this->response->json([
            'error' => 'Passport not validated by middleware',
            'stack' => self::class
        ], 400);
    }

    private function validateAuth($auth)
    {
        if(!$auth) return null;
        $auth_arr = explode(':', base64_decode($auth));
        if(!empty($auth_arr)) {
            list ($username, $password) = $auth_arr;
            return $username === 'admin' && $password === 'admin';
        }
        return false;
    }
}
```

### Database

Using the Repository pattern:

```php
$userRepository = new UserRepository($entityManager);
$user = $userRepository->findById($id);
$users = $userRepository->findAll();
```

### Sending Emails

```php
$email = new Email();
$email->setTo('user@example.com')
      ->setSubject('Welcome!')
      ->setBody('Thank you for signing up!')
      ->send();
```

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Author

**Mendrika Rabeh**  
Email: frabehevitra@gmail.com

## Support

- 📧 Email: frabehevitra@gmail.com
- 🐛 Report issues on GitHub
- 💬 Discuss in GitHub Discussions

---

Made with ❤️ for developers who love simplicity and elegance.
