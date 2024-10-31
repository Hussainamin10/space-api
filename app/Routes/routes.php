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

    //*Rocket Routes
    //*GET
    $app->get('/rockets', [RocketsController::class, 'handleGetRockets']);
    $app->get('/rockets/{rocketID}', [RocketsController::class, 'handleGetRocketByID']);
    $app->get('/rockets/{rocketID}/missions', [RocketsController::class, 'handleGetMissionsByRocketID']);
    //*POST
    $app->post('/rockets', [RocketsController::class, 'handleCreateRocket']);
    //*DELETE
    $app->delete('/rockets', [RocketsController::class, 'handleDeleteRocket']);
    //*PUT
    $app->put('/rockets', [RocketsController::class, 'handleUpdateRocket']);

    //Space Station Routes
    $app->get('/spacestations', [SpaceStationsController::class, 'handleGetSpaceStations']);
    $app->get('/spacestations/{stationID}', [SpaceStationsController::class, 'handleGetSpaceStationByID']);

    //Location Routes
    $app->get('/locations', [LocationsController::class, 'handleGetLocations']);
    $app->get('/locations/{locationID}', [LocationsController::class, 'handleGetLocationByID']);
    //*POST
    $app->post('/locations', [LocationsController::class, 'handleCreateLocation']);
    //*DELETE
    $app->delete('/locations', [LocationsController::class, 'handleDeleteLocation']);
    //*PUT
    $app->put('/locations', [LocationsController::class, 'handleUpdateLocation']);




    //! Astronaut Routes
    //! Get
    //* astronaut
    $app->get('/astronauts', [AstronautsController::class, 'handleGetAstronauts']);
    //* astronaut by Id
    $app->get('/astronauts/{astronautId}', [AstronautsController::class, 'handleGetAstronautByID']);
    //! Post
    $app->post('/astronauts', [AstronautsController::class, 'handleCreateAstronaut']);
    //! Delete
    $app->delete('/astronauts', [AstronautsController::class, 'handleDeleteAstronaut']);
    //! Put
    $app->put('/astronauts', [AstronautsController::class, 'handleUpdateAstronaut']);

    //! SpaceCompany Routes
    //! Get
    $app->get('/spaceCompanies', [SpaceCompaniesController::class, 'handleGetSpaceCompanies']);
    //* by companyName
    $app->get('/spaceCompanies/{companyName}', [SpaceCompaniesController::class, 'handleGetCompanyByName']);
    //* rockets by companyName
    $app->get('/spaceCompanies/{companyName}/rockets', [SpaceCompaniesController::class, 'handleRocketsByCompanyName']);


    //$app->get('/players/{player_id}', [PlayersController::class, 'handleGetPlayerId']);

    //? Get Planets
    $app->get('/planets', [PlanetController::class, 'handleGetPlanet']);
    $app->get('/planets/{planetID}', [PlanetController::class, 'handleGetPlanetId']);

    //? Get missions
    $app->get('/missions', [MissionController::class, 'handleGetMission']);
    $app->get('/missions/{missionID}', [MissionController::class, 'handleGetMissionId']);

    //? Get astronauts by mission_id
    $app->get('/missions/{mission_id}/astronauts', [MissionController::class, 'handleGetAstronautsByMissionID']);

    //* ROUTE: POST /
    //? Post planets
    $app->post('/planets', [PlanetController::class, 'handleCreatePlanet']);

    $app->delete('/planets', [PlanetController::class, 'handleDeletePlanet']);

    //?PUT
    $app->put('/planets', [PlanetController::class, 'handleUpdatePlanet']);




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
