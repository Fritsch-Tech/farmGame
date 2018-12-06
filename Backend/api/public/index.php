<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

//
$container = $app->getContainer();
error_reporting(E_ERROR | E_PARSE);

// Middleware
require '../src/middleware/cors.php';
require '../src/middleware/authentication.php';

// Routes
require '../src/routes/user.php';
require '../src/routes/farm.php';
require '../src/routes/crops.php';
require '../src/routes/items.php';
require '../src/routes/fields.php';

$app->run();

?>
