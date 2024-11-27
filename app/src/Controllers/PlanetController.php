<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\PlanetModel;
use App\Services\PlanetsService;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class PlanetController extends BaseController
{


    public function __construct(private PlanetModel $planet_model, private PlanetsService $planetsService)
    {
        parent::__construct();

        $this->planet_model = $planet_model;
        $this->planetsService = $planetsService;
    }

    //? Get All planets callBack function
    public function handleGetPlanet(Request $request, Response $response): Response
    {

        //* Step 1) Retrieve the filter params
        $filter_params = $request->getQueryParams();
        //dd(data: $filter_params);


        //? pagination
        if (isset($filter_params['current_page']) && isset($filter_params['pageSize'])) {
            $this->planet_model->setPaginationOptions((int)$filter_params['current_page'], (int)$filter_params['pageSize']);
        }

        $players = $this->planet_model->getPlanets(
            $filter_params
        );

        return $this->renderJson($response, $players);
    }

    //? Get  planet by id callBack function
    public function handleGetPlanetId(Request $request, Response $response, array $uri_args): Response
    {
        //dd($uri_args["player_id"]);
        //* Step 1) Receive the received planet ID

        //* Step 2) Validate the planet ID

        if (!isset($uri_args['planetID'])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => 400,
                    "message" => "No planet ID provided"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        $isIntPattern = "/^[0-9]+$/";
        $planet_id = $uri_args["planetID"];
        if (preg_match($isIntPattern, $planet_id) === 0) {

            throw new HttpInvalidInputsException($request, "Invalid planet id provided");
        }

        //* Step 3) if Valid, fetch the planet's info from the DB
        $planet = $this->planet_model->getPlanetById($planet_id);
        // dd($player);
        if ($planet === false) {
            throw new HttpNotFoundException($request, "No matching planets found");
        }
        //* Step 4) Prepare valid json response

        return $this->renderJson($response, $planet);
    }

    public function handleGetExtraPlanetInfo(Request $request, Response $response, array $uri_args): Response
    {

        $planetID = $uri_args["planetID"];
        $result = $this->planetsService->getExtraPlanetInfo($planetID);
        $payload = [];
        if ($result->isSuccess()) {
            $payload['success'] = true;
        } else {
            $payload['success'] = false;
        }

        $payload['message'] = $result->getMessage();
        $payload['data'] = $result->getData()['data'];
        $payload['status'] = $result->getData()['status'];
        return $this->renderJson($response, $payload, $payload['status']);

        return $response;
    }


    public function handleCreatePlanet(Request $request, Response $response, array $uri_args): Response
    {
        //echo "QUACK!!";


        //1) Retrieve the data embedded/included in the request body

        $new_planet = $request->getParsedBody();
        //dd($new_planet);

        //2) Pass the received data to the service
        $result = $this->planetsService->createPlanet($new_planet[0]);

        $payload = [];

        $status_code = 201;
        if ($result->isSuccess()) {
            //prepare a successful response.
            $payload["success"] = true;
        } else {
            //prepare a failure response.
            $status_code = 400;
            $payload["success"] = false;
        }

        $payload["message"] = $result->getMessage();
        $payload["errors"] = $result->getData();
        $payload["status"] = $status_code;


        return $this->renderJson($response, $payload, $status_code);
    }


    public function handleDeletePlanet(Request $request, Response $response, array $uri_args): Response
    {
        //? Retrieve POST request embedded body
        $planetID = $request->getParsedBody()[0]['planetID'] ?? null;
        $result = $this->planetsService->deletePlanet($planetID);
        $payload = [];

        if ($result->isSuccess()) {
            $payload['success'] = true;
        } else {
            $payload['success'] = false;
        }
        $payload['message'] = $result->getMessage();
        $payload['data'] = $result->getData()['data'];
        $payload['status'] = $result->getData()['status'];
        return $this->renderJson($response, $payload, $payload['status']);
    }

    public function handleUpdatePlanet(Request $request, Response $response, array $uri_args): Response
    {

        //? Retrieve POST request embedded body
        $planet = $request->getParsedBody()[0];
        $result = $this->planetsService->updatePlanet($planet);
        $payload = [];
        if ($result->isSuccess()) {
            $payload['success'] = true;
        } else {
            $payload['success'] = false;
        }
        $payload['message'] = $result->getMessage();
        $payload['data'] = $result->getData()['data'];
        $payload['status'] = $result->getData()['status'];
        return $this->renderJson($response, $payload, $payload['status']);
    }
}
