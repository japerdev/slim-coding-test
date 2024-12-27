<?php

use App\Handler\HttpErrorHandler;
use DI\Container;
use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

// Build App & Container
$aux = new Container(require __DIR__ . '/Settings.php');
AppFactory::setContainer($aux);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();
$container = $app->getContainer();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(false, true, true);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Set up dependencies
require_once __DIR__ . '/Dependencies.php';
// Set up services
require_once __DIR__ . '/Services.php';
// Set up repositories
require_once __DIR__ . '/Repositories.php';
// Set up routes
require_once __DIR__ . '/Routes.php';

return $app;