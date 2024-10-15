<?php

declare(strict_types=1);

use App\Controllers\AboutController;
use App\Controllers\LocationsController;
use App\Controllers\SpaceStationsController;
use App\Controllers\MissionController;
use App\Controllers\PlanetController;
use App\Controllers\AstronautsController;
use App\Controllers\SpaceCompaniesController;
use App\Controllers\RocketsController;
use App\Helpers\DateTimeHelper;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return static function (Slim\App $app): void {

    // Routes without authentication check: /login, /token

    // Routes with authentication
    //* ROUTE: GET /
    $app->get('/', [AboutController::class, 'handleAboutWebService']);

    //Rocket Routes
    //*GET
    $app->get('/rockets', [RocketsController::class, 'handleGetRockets']);
    $app->get('/rockets/{rocketID}', [RocketsController::class, 'handleGetRocketByID']);
    $app->get('/rockets/{rocketID}/missions', [RocketsController::class, 'handleGetMissionsByRocketID']);
    //*POST
    $app->post('/rockets', [RocketsController::class, 'handleCreateRocket']);
    //Space Station Routes
    $app->get('/spacestations', [SpaceStationsController::class, 'handleGetSpaceStations']);
    $app->get('/spacestations/{stationID}', [SpaceStationsController::class, 'handleGetSpaceStationByID']);

    //Location Routes
    $app->get('/locations', [LocationsController::class, 'handleGetLocations']);
    $app->get('/locations/{locationID}', [LocationsController::class, 'handleGetLocationByID']);


    $app->get('/planets', [PlanetController::class, 'handleGetPlanet']);
    $app->get('/planets/{planetID}', [PlanetController::class, 'handleGetPlanetId']);

    $app->get('/missions', [MissionController::class, 'handleGetMission']);
    $app->get('/missions/{missionID}', [MissionController::class, 'handleGetMissionId']);

    //! Get astronauts
    $app->get('/astronauts', [AstronautsController::class, 'handleGetAstronauts']);

    //! Get astronaut by Id
    $app->get('/astronauts/{astronautId}', [AstronautsController::class, 'handleGetAstronautByID']);

    //! Get spaceCompanies
    $app->get('/spaceCompanies', [SpaceCompaniesController::class, 'handleGetSpaceCompanies']);

    //! Get spaceCompany by Name
    $app->get('/spaceCompanies/{companyName}', [SpaceCompaniesController::class, 'handleGetCompanyByName']);

    //! Get rockets by companyName
    $app->get('/spaceCompanies/{companyName}/rockets', [SpaceCompaniesController::class, 'handleRocketsByCompanyName']);

    //! Post rockets
    $app->post('/astronauts', [AstronautsController::class, 'handleCreateAstronaut']);




    //$app->get('/players/{player_id}', [PlayersController::class, 'handleGetPlayerId']);

    $app->get('/missions/{mission_id}/astronauts', [MissionController::class, 'handleGetAstronautsByMissionID']);




    //* ROUTE: POST /
    $app->post('/planets', [PlanetController::class, 'handleCreatePlanet']);




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
