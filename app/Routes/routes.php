<?php

declare(strict_types=1);

use App\Controllers\AboutController;
use App\Controllers\LocationsController;
use App\Controllers\RocketsController;
use App\Controllers\SpaceStationsController;
use App\Helpers\DateTimeHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return static function (Slim\App $app): void {

    // Routes without authentication check: /login, /token

    // Routes with authentication
    //* ROUTE: GET /
    $app->get('/', [AboutController::class, 'handleAboutWebService']);

    //Rocket Routes
    $app->get('/rockets', [RocketsController::class, 'handleGetRockets']);
    $app->get('/rockets/{rocketID}', [RocketsController::class, 'handleGetRocketByID']);

    //Space Station Routes
    $app->get('/spacestations', [SpaceStationsController::class, 'handleGetSpaceStations']);
    $app->get('/spacestations/{stationID}', [SpaceStationsController::class, 'handleGetSpaceStationByID']);

    //Location Routes
    $app->get('/locations', [LocationsController::class, 'handleGetLocations']);
    $app->get('/locations/{locationID}', [LocationsController::class, 'handleGetLocationByID']);



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
