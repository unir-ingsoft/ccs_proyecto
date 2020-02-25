<?php
use App\Model\UserModel;

$app->get('/registro', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/registro'");

    // Render index view
    return $this->renderer->render($response, 'registro.phtml', ["error" => ""]);
});