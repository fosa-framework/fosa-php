<?php

/*
 * +---------------------------------+
 * | Fosa Framework                  |
 * +---------------------------------+
 * | @version 1.0                    |
 * | @author Mendrika Rabeh          |
 * | @email frabehevitra@gmail.com   |
 * +---------------------------------+
 */

namespace Fosa\Installer;

use Composer\Script\Event;

/**
 * ProjectInstaller class
 * 
 * This class handles the installation and configuration of a new Fosa project
 * when installed via Composer.
 */
class ProjectInstaller
{
    /**
     * Install method called after composer create-project
     *
     * @param Event $event The Composer event
     * @return void
     */
    public static function install(Event $event)
    {
        $io = $event->getIO();
        $vendor = $event->getComposer()->getConfig()->get('vendor-dir');
        $projectRoot = dirname($vendor);

        $io->write('<info>Initializing Fosa Framework project...</info>');

        // Create .env file if it doesn't exist
        self::createEnvFile($projectRoot, $io);

        // Create necessary directories
        self::createDirectories($projectRoot, $io);

        // Create example files
        self::createExampleFiles($projectRoot, $io);

        $io->write('<info>✓ Fosa Framework installation completed successfully!</info>');
        $io->write('<comment>Next steps:</comment>');
        $io->write('1. Configure your .env file with your database and application settings');
        $io->write('2. Create your first controller in app/controllers/');
        $io->write('3. Run: php server/run to start the development server');
    }

    /**
     * Check environment and display messages
     *
     * @param Event $event The Composer event
     * @return void
     */
    public static function checkEnv(Event $event)
    {
        $io = $event->getIO();
        $vendor = $event->getComposer()->getConfig()->get('vendor-dir');
        $projectRoot = dirname($vendor);

        // Check if .env exists
        if (!file_exists($projectRoot . '/.env')) {
            $io->write('<warning>⚠ .env file not found. Please copy .env.example to .env and configure it.</warning>');
        }

        // Check PHP version
        if (version_compare(PHP_VERSION, '5.4', '<')) {
            $io->write('<error>✗ Fosa Framework requires PHP 5.4 or higher. Current version: ' . PHP_VERSION . '</error>');
        } else {
            $io->write('<info>✓ PHP version OK (' . PHP_VERSION . ')</info>');
        }
    }

    /**
     * Create the .env file from template if it doesn't exist
     *
     * @param string $projectRoot The project root directory
     * @param object $io IO interface for output
     * @return void
     */
    private static function createEnvFile($projectRoot, $io)
    {
        $envPath = $projectRoot . '/.env';
        $envExamplePath = $projectRoot . '/.env.example';

        if (!file_exists($envPath)) {
            // Create .env.example if it doesn't exist
            if (!file_exists($envExamplePath)) {
                $envContent = self::getEnvTemplate();
                file_put_contents($envExamplePath, $envContent);
                $io->write('<info>✓ Created .env.example file</info>');
            }

            // Copy .env.example to .env
            if (file_exists($envExamplePath)) {
                copy($envExamplePath, $envPath);
                $io->write('<info>✓ Created .env file from template</info>');
            }
        }
    }

    /**
     * Create necessary project directories
     *
     * @param string $projectRoot The project root directory
     * @param object $io IO interface for output
     * @return void
     */
    private static function createDirectories($projectRoot, $io)
    {
        $directories = [
            '/app/controllers',
            '/app/middlewares',
            '/app/templates',
            '/app/models',
            '/storage/logs',
            '/storage/cache',
            '/public',
        ];

        foreach ($directories as $dir) {
            $path = $projectRoot . $dir;
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
        }

        $io->write('<info>✓ Created project directories</info>');
    }

    /**
     * Create example files for the project
     *
     * @param string $projectRoot The project root directory
     * @param object $io IO interface for output
     * @return void
     */
    private static function createExampleFiles($projectRoot, $io)
    {
        // Create example controller
        $controllerTemplate = self::getExampleControllerTemplate();
        $controllerPath = $projectRoot . '/app/controllers/ExampleController.php';
        
        if (!file_exists($controllerPath)) {
            file_put_contents($controllerPath, $controllerTemplate);
            $io->write('<info>✓ Created example controller</info>');
        }

        // Create example template
        $templateTemplate = self::getExampleTemplateTemplate();
        $templatePath = $projectRoot . '/app/templates/example.template.php';
        
        if (!file_exists($templatePath)) {
            file_put_contents($templatePath, $templateTemplate);
            $io->write('<info>✓ Created example template</info>');
        }

        // Create .htaccess for Apache
        $htaccessTemplate = self::getHtaccessTemplate();
        $htaccessPath = $projectRoot . '/public/.htaccess';
        
        if (!file_exists($htaccessPath)) {
            file_put_contents($htaccessPath, $htaccessTemplate);
            $io->write('<info>✓ Created .htaccess file for Apache</info>');
        }
    }

    /**
     * Get environment template
     *
     * @return string
     */
    private static function getEnvTemplate()
    {
        return <<<'EOD'
# Fosa Framework Configuration

# Application Settings
APP_NAME=Fosa Application
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8085

# Server Settings
R_HOST=localhost
R_PORT=8085

# Database Configuration
DB_DRIVER=mysql
DB_HOST=localhost
DB_PORT=3306
DB_NAME=fosa_db
DB_USER=root
DB_PASSWORD=

# Email Configuration
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=noreply@example.com
MAIL_FROM_NAME=Fosa Framework

# Session Configuration
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Locale Configuration
DEFAULT_LOCALE=en-EN
EOD;
    }

    /**
     * Get example controller template
     *
     * @return string
     */
    private static function getExampleControllerTemplate()
    {
        return <<<'EOD'
<?php

namespace Fosa\Controllers;

use Fosa\Core\Controller;
use Fosa\Core\Request;
use Fosa\Core\Response;

/**
 * ExampleController
 * 
 * Example controller showing how to structure your Fosa controllers
 */
class ExampleController extends Controller
{
    /**
     * Constructor
     *
     * @param string $method HTTP method
     * @param Request $request Request object
     * @param Response $response Response object
     */
    public function __construct($method, Request $request, Response $response)
    {
        parent::__construct($method, $request, $response);
    }

    /**
     * Index action - Default controller action
     *
     * @param Request $request Request object
     * @param Response $response Response object
     * @return mixed
     */
    public function index(Request $request, Response $response)
    {
        return $response->view('example', [
            'title' => 'Welcome to Fosa Framework',
            'message' => 'Your application is running successfully!',
        ]);
    }

    /**
     * Show action - Example with parameter
     *
     * @param Request $request Request object
     * @param Response $response Response object
     * @return mixed
     */
    public function show(Request $request, Response $response)
    {
        $id = $request->getParam('id');
        
        return $response->json([
            'status' => 'success',
            'message' => 'Example show action',
            'id' => $id,
        ]);
    }
}
EOD;
    }

    /**
     * Get example template
     *
     * @return string
     */
    private static function getExampleTemplateTemplate()
    {
        return <<<'EOD'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : 'Fosa'; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 50px;
            text-align: center;
            max-width: 600px;
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 2.5em;
        }
        
        p {
            color: #666;
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .badge {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border-radius: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo isset($title) ? htmlspecialchars($title) : 'Fosa Framework'; ?></h1>
        <p><?php echo isset($message) ? htmlspecialchars($message) : 'Welcome!'; ?></p>
        <span class="badge">v1.0</span>
    </div>
</body>
</html>
EOD;
    }

    /**
     * Get .htaccess template for Apache
     *
     * @return string
     */
    private static function getHtaccessTemplate()
    {
        return <<<'EOD'
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
EOD;
    }
}
