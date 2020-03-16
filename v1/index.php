<?php
if (PHP_SAPI == 'cli-server') {
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

// instanciar app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

// cargar elementos
require __DIR__ . '/../src/dependencies.php';
//require __DIR__ . '/../src/middleware.php';
require __DIR__ . '/../src/routes.php';
require __DIR__ . '/../app/app_loader.php';

//añadri validacion de token para consumo de mi apirest
//$app->add( new Middleware\tokenAuth($container) );

// uiniciar app
$app->run();