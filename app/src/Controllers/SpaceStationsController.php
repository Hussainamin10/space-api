<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\SpaceStationsModel;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class SpaceStationsController extends BaseController
{


    public function __construct(private SpaceStationsModel $space_station_model)
    {
        parent::__construct();
    }
    //Route:GET /players
    public function handleGetSpaceStations(Request $request, Response $response): Response
    {

        //* Step 1) Retrieve the filter params
        $filter_params = $request->getQueryParams();
        //dd(data: $filter_params);

        if (isset($filter_params['current_page']) && isset($filter_params['pageSize'])) {
            $this->space_station_model->setPaginationOptions((int)$filter_params['current_page'], (int)$filter_params['pageSize']);
        }

        $players = $this->space_station_model->getSpaceStations(
            $filter_params
        );
        //dd($players);
        /*$json_paylod = json_encode($players);

        $response->getBody()->write("$json_paylod");


        return $response->withHeader(
            "Content-Type",
            "application/json"
        )->withStatus(201);
        */
        return $this->renderJson($response, $players);
    }


    public function handleGetSpaceStationByID(Request $request, Response $response, array $uri_args): Response
    {
        //* Step 1) Receive the received spaceStation ID

        //* Step 2) Validate the spaceStation ID
        // Rocket Has to be an integer

        if (!isset($uri_args['stationID'])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => 400,
                    "message" => "No space station id provided"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }


        //Pattern to check rocket id only contains integer
        $isIntPattern = "/^[0-9]+$/";
        $stationID = $uri_args["stationID"];
        if (preg_match($isIntPattern, $stationID) === 0) {
            throw new HttpInvalidInputsException($request, "Invalid space station id provided");
        }

        //* Step 3) if Valid, fetch the rocket's info from the DB
        $spaceStation = $this->space_station_model->getSpaceStationbyID($stationID);
        if ($spaceStation === false) {
            throw new HttpNotFoundException($request, "No matching space station found");
        }
        //* Step 4) Prepare valid json response
        return $this->renderJson($response, $spaceStation);
    }
}
