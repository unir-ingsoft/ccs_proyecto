<?php

$app->get('/registro/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/registro'");

    // Render index view
    return $this->renderer->render($response, 'registro.phtml', ["error" => ""]);
});

$app->get('/logout/', function ($request, $response, $args) {
    // Render index view
    unset($_SESSION['logged']);
    unset($_SESSION['nombre']);
    unset($_SESSION['usuariopk']);
    return $this->renderer->render($response, 'index.phtml', ["error" => ""])->withHeader('Location', 'http://kornmexico.com/unirlab02/v1/');
});
