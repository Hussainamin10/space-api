<?php

declare(strict_types=1);

use App\Controllers\AboutController;
use App\Controllers\PlayersController;
use App\Controllers\StadiumsController;
use App\Helpers\DateTimeHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return static function (Slim\App $app): void {

    // Routes without authentication check: /login, /token

    // Routes with authentication
    //* ROUTE: GET /
    $app->get('/', [AboutController::class, 'handleAboutWebService']);
    $app->get('/players', [PlayersController::class, 'handleGetPlayers']);
    $app->get('/stadiums', [StadiumsController::class, 'handleGetStadiums']);
    $app->get('/players/{player_id}', [PlayersController::class, 'handleGetPlayerId']);


    // $app->get('/test', [TestController::class, 'handleTest']);

    //* ROUTE: GET /ping
    $app->get('/ping', function (Request $request, Response $response, $args) {

        $payload = [
            "greetings" => "Reporting! Hello there!",
            "now" => DateTimeHelper::now(DateTimeHelper::Y_M_D_H_M),
        ];
        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_PARTIAL_OUTPUT_ON_ERROR));
        return $response;
    });
};
