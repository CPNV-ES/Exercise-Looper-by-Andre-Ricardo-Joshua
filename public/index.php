<?php
session_start();

use App\Router;
use App\Renderer;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

define('BASE_DIR', dirname( __FILE__ ).'/..');
define('SOURCE_DIR', BASE_DIR.'/src');

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

// Dispatch the request and handle any exceptions to prevent crashes.
try {
    $rendering_options = $router->dispatch($route, $method);
}
catch (Exception $error) {
    $rendering_options = ['status_code' => 500];
}

// Use the Renderer to display the appropriate view based on the router's response.
$renderer = new Renderer(SOURCE_DIR);
$renderer->render($rendering_options, $route);