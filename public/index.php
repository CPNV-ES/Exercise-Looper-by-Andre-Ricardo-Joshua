<?php
session_start();

use App\Router;
use App\Renderer;

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/src/csrfToken.php';
require_once dirname(__DIR__) . '/src/flashMessages.php';

if (!defined('BASE_DIR')) {
    define('BASE_DIR', dirname(__DIR__));
}
define('SOURCE_DIR', BASE_DIR.'/src');

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(BASE_DIR);
$dotenv->load();

// Parse the requested URI and HTTP method from the server variables.
$route = $_SERVER["REQUEST_URI"];
if (!empty($_SERVER["QUERY_STRING"])) {
    $route = substr($route, 0, strlen($_SERVER["REQUEST_URI"])-strlen($_SERVER["QUERY_STRING"])-1);
}
$method = $_SERVER['REQUEST_METHOD'];

// Instantiate the router and load the routes from the configuration file.
$router = new Router();
$addRoutes = require_once BASE_DIR . '/src/ConfigRoutes.php';
$addRoutes($router);

// Convert all errors, warnings and notices to exceptions
set_error_handler(function ($severity, $message, $filename, $lineno) { throw new \ErrorException($message, 0, $severity, $filename, $lineno); });

// Handle the entire request-response cycle in a try-catch block to prevent crashes.
try {
    // Dispatch the request to get rendering options.
    $rendering_options = $router->dispatch($route, $method);

    // Use the Renderer to display the appropriate view.
    $renderer = new Renderer(SOURCE_DIR);
    $renderer->render($rendering_options, $route);
}
catch (Throwable $error) {
    // Log the detailed error for the developer.
    error_log('APP_LOGS: ' . $error);

    // Prepare a generic 500 error response for the user.
    http_response_code(500);
    $renderer = new Renderer(SOURCE_DIR);
    $renderer->render(['data' => ['title' => '500 Internal Server Error']], $route);
}