<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', ["error" => ""]);
});

$app->get('/registro', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/registro'");

    // Render index view
    return $this->renderer->render($response, 'registro.phtml', ["error" => ""]);
});

