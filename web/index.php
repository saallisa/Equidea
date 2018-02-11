<?php

use Equidea\Equidea;

use Equidea\Core\Http\{Request,Response};
use Equidea\Core\Http\Interfaces\{RequestInterface,ResponseInterface};
use Equidea\Core\Utility\Container;

// Start the session with a lifetime of two hours
session_start(['cookie_lifetime' => 7200]);

// Register the autoloading
spl_autoload_register(function ($class) {
    $class = substr($class, strlen('Equidea\\'));
    include __DIR__ .'/../src/' . str_replace('\\', '/', $class) . '.php';
});

// Create a new HTTP Request
$request = Request::createFromGlobals();

// Create a new HTTP Response
$response = new Response(200);
$response->setType('text/html');

// Create a new dependency injection container
$container = new Container();

// Load templatating config
require __DIR__.'/../app/config/templating.php';

// Load the services
require __DIR__.'/../app/config/services.php';

// Create a new game instance
$equidea = new Equidea($request, $response, $container);

// Set the controller routes
require __DIR__.'/../app/config/routes.php';

// Get the parsed HTTP Response
$response = $equidea->respond();

// Translate the Response
http_response_code($response->getCode());
header('Content-Type: ' . $response->getType());
echo $response->getBody();
