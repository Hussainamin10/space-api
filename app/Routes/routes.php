<?php

declare(strict_types=1);

use App\Controllers\AboutController;
use App\Controllers\AccountController;
use App\Controllers\LocationsController;
use App\Controllers\SpaceStationsController;
use App\Controllers\MissionController;
use App\Controllers\PlanetController;
use App\Controllers\AstronautsController;
use App\Controllers\CarLoanController;
use App\Controllers\SpaceCompaniesController;
use App\Controllers\RocketsController;
use App\Controllers\ZakatController;
use App\Helpers\DateTimeHelper;
use App\Middleware\AccessLogMiddleware;
use App\Middleware\AuthMiddleWare;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

return static function (Slim\App $app): void {

    // Routes without authentication check: /login, /token

    // Routes with authentication
    //* ROUTE: GET /
    $app->get('/', [AboutController::class, 'handleAboutWebService']);



    //*Account
    $app->post('/login', [AccountController::class, 'handleAccessLogin']);
    $app->post('/register', [AccountController::class, 'handleAccountRegister']);

    $app->group('', function (RouteCollectorProxy $group) {
        //*Rocket Routes
        //*GET
        $group->get('/rockets', [RocketsController::class, 'handleGetRockets']);
        $group->get('/rockets/{rocketID}', [RocketsController::class, 'handleGetRocketByID']);
        $group->get('/rockets/{rocketID}/missions', [RocketsController::class, 'handleGetMissionsByRocketID']);
        $group->get('/rockets/{rocketID}/launches', [RocketsController::class, 'handleGetLaunchesByRocketID']);
        //*POST
        $group->post('/rockets', [RocketsController::class, 'handleCreateRocket']);
        $group->post('/rocket/calLift', [RocketsController::class, 'handleCalLiftOfThrust']);
        //*DELETE
        $group->delete('/rockets', [RocketsController::class, 'handleDeleteRocket']);
        //*PUT
        $group->put('/rockets', [RocketsController::class, 'handleUpdateRocket']);

        //*Space Station Routes
        $group->get('/spacestations', [SpaceStationsController::class, 'handleGetSpaceStations']);
        $group->get('/spacestations/{stationID}', [SpaceStationsController::class, 'handleGetSpaceStationByID']);

        //*Location Routes
        $group->get('/locations', [LocationsController::class, 'handleGetLocations']);
        $group->get('/locations/{locationID}', [LocationsController::class, 'handleGetLocationByID']);
        //*POST
        $group->post('/locations', [LocationsController::class, 'handleCreateLocation']);
        //*DELETE
        $group->delete('/locations', [LocationsController::class, 'handleDeleteLocation']);
        //*PUT
        $group->put('/locations', [LocationsController::class, 'handleUpdateLocation']);


        //! Astronaut Routes
        //! Get
        //* astronaut
        $group->get('/astronauts', [AstronautsController::class, 'handleGetAstronauts']);
        //* astronaut by Id
        $group->get('/astronauts/{astronautId}', [AstronautsController::class, 'handleGetAstronautByID']);
        //! Post
        $group->post('/astronauts', [AstronautsController::class, 'handleCreateAstronaut']);
        //! Delete
        $group->delete('/astronauts', [AstronautsController::class, 'handleDeleteAstronaut']);
        //! Put
        $group->put('/astronauts', [AstronautsController::class, 'handleUpdateAstronaut']);
        //! Car Loan Computation
        $group->post('/loan', [CarLoanController::class, 'handleCarLoan']);
        //! Log
        $group->post('/log', [AccessLogMiddleware::class, 'handleAccessLog']);
        // Example route to test error handling
        $group->get('/error', function (Request $request, Response $response) {
            throw new \Slim\Exception\HttpNotFoundException($request, "Something went wrong");
        });

        //! SpaceCompany Routes
        //! Get
        $group->get('/spaceCompanies', [SpaceCompaniesController::class, 'handleGetSpaceCompanies']);
        //* by companyName
        $group->get('/spaceCompanies/{companyName}', [SpaceCompaniesController::class, 'handleGetCompanyByName']);
        //* rockets by companyName
        $group->get('/spaceCompanies/{companyName}/rockets', [SpaceCompaniesController::class, 'handleRocketsByCompanyName']);


        //$app->get('/players/{player_id}', [PlayersController::class, 'handleGetPlayerId']);

        //? Get Planets
        $group->get('/planets', [PlanetController::class, 'handleGetPlanet']);
        $group->get('/planets/{planetID}', [PlanetController::class, 'handleGetPlanetId']);

        //? Get missions
        $group->get('/missions', [MissionController::class, 'handleGetMission']);
        $group->get('/missions/{missionID}', [MissionController::class, 'handleGetMissionId']);

        //? Get astronauts by mission_id
        $group->get('/missions/{mission_id}/astronauts', [MissionController::class, 'handleGetAstronautsByMissionID']);

        //? Compute Zakat
        $group->post('/zakat', [ZakatController::class, 'handleZakat']);

        //* ROUTE: POST /
        //? Post planets
        $group->post('/planets', [PlanetController::class, 'handleCreatePlanet']);

        $group->delete('/planets', [PlanetController::class, 'handleDeletePlanet']);

        //?PUT
        $group->put('/planets', [PlanetController::class, 'handleUpdatePlanet']);
    })->addMiddleware(new AuthMiddleWare());

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
