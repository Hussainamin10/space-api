<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\MissionModel;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;


class MissionController extends BaseController
{


    public function __construct(private MissionModel $mission_model)
    {
        parent::__construct();

        $this->mission_model = $mission_model;
    }

    public function handleGetMission(Request $request, Response $response): Response
    {

        //* Step 1) Retrieve the filter params
        $filter_params = $request->getQueryParams();
        //dd(data: $filter_params);

        if (isset($filter_params['current_page']) && isset($filter_params['pageSize'])) {
            $this->mission_model->setPaginationOptions((int)$filter_params['current_page'], (int)$filter_params['pageSize']);
        }

        $players = $this->mission_model->getMissions(
            $filter_params
        );

        return $this->renderJson($response, $players);
    }

    public function handleGetMissionId(Request $request, Response $response, array $uri_args): Response
    {
        //dd($uri_args["player_id"]);
        //* Step 1) Receive the received player ID

        //* Step 2) Validate the player ID

        if (!isset($uri_args['missionID'])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => 400,
                    "message" => "No mission ID provided"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }


        $mission_id = $uri_args["missionID"];


        //* Step 3) if Valid, fetch the player's info from the DB
        $mission = $this->mission_model->getMissionById($mission_id);
        // dd($player);
        if ($mission === false) {
            throw new HttpNotFoundException($request, "No matching mission found");
        }
        //* Step 4) Prepare valid json response

        return $this->renderJson($response, $mission);
    }

    public function  handleGetAstronautsByMissionID(Request $request, Response $response, array $uri_args): Response
    {
        $mission_id = $uri_args["mission_id"];
        $result = $this->mission_model->getAstronautsByMissionID($mission_id);

        return $this->renderJson($response, $result);
    }
}
