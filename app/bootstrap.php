<?php

require 'vendor/autoload.php';
// Create and configure Slim app
$app = new \Slim\App([
'settings' => [
// Slim Settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'addContentLengthHeader' => false,
        ]
]);



/*******************************************************************************/
/**************************   Twig templates  *********************************/
/*******************************************************************************/
// Fetch DI Container
$container = $app->getContainer();

// Register Twig View helper
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('app/views', [
//        'cache' => 'app/cache'
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};



/*******************************************************************************/
/**************************   Eloquent ORM   **********************************/
/*******************************************************************************/
// Database information
$settings = array(
    'driver' => 'mysql',
    'host' => '10.46.202.200',
    'database' => 'zal',
    'username' => 'harmonic',
    'password' => 'harmonic1',
    'charset' => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix' => ''
);


// Bootstrap Eloquent ORM
$container = new \Illuminate\Container\Container;
$connFactory = new \Illuminate\Database\Connectors\ConnectionFactory($container);
$conn = $connFactory->make($settings);
$resolver = new \Illuminate\Database\ConnectionResolver();
$resolver->addConnection('default', $conn);
$resolver->setDefaultConnection('default');
\Illuminate\Database\Eloquent\Model::setConnectionResolver($resolver);


/*******************************************************************************/
/**************************   Routing and models  *****************************/
/*******************************************************************************/
require __DIR__ . '/models/models.php';
require __DIR__ . '/routes/main.php';
require __DIR__ . '/routes/api.php';
require __DIR__ . '/routes/auth.php';