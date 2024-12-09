<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\MissionModel;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use App\Validation\Validator;


/**
 * Class MissionController
 * Handles HTTP requests related to space missions, including fetching, validating,
 * and managing mission data.
 */
class MissionController extends BaseController
{


      /**
     * MissionController constructor.
     *
     * @param MissionModel $mission_model The mission model dependency.
     */
    public function __construct(private MissionModel $mission_model)
    {
        parent::__construct();

        $this->mission_model = $mission_model;
    }


       /**
     * Handle a GET request to retrieve all missions with optional filters and pagination.
     *
     * @param Request $request  The HTTP request object.
     * @param Response $response The HTTP response object.
     * @return Response The JSON response containing mission data.
     */
    //? Get All Mission callback function
    public function handleGetMission(Request $request, Response $response): Response
    {

        //* Step 1) Retrieve the filter params
        $filter_params = $request->getQueryParams();
        //dd(data: $filter_params);

        //?Pagination
        if (isset($filter_params['current_page']) && isset($filter_params['pageSize'])) {
            $this->mission_model->setPaginationOptions((int)$filter_params['current_page'], (int)$filter_params['pageSize']);
        }

        $players = $this->mission_model->getMissions(
            $filter_params
        );

        return $this->renderJson($response, $players);
    }

    /**
     * Handle a GET request to retrieve a mission by its ID.
     *
     * @param Request $request  The HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $uri_args   The URI arguments, including `missionID`.
     * @return Response The JSON response containing the mission data.
     * @throws HttpInvalidInputsException If the mission ID is invalid.
     * @throws HttpNotFoundException If the mission is not found.
     */
    //? Get Mission by ID callback function
    public function handleGetMissionId(Request $request, Response $response, array $uri_args): Response
    {
        //dd($uri_args["player_id"]);
        //* Step 1) Receive the received missions ID

        //* Step 2) Validate the missions ID

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

        $isIntPattern = "/^[0-9]+$/";
        $mission_id = $uri_args["missionID"];

        if (preg_match($isIntPattern, $mission_id) === 0) {
            throw new HttpInvalidInputsException($request, "Invalid mission id provided");
        }

        //* Step 3) if Valid, fetch the mission's info from the DB
        $mission = $this->mission_model->getMissionById($mission_id);
        // dd($player);
        if ($mission === false) {
            throw new HttpNotFoundException($request, "No matching mission found");
        }
        //* Step 4) Prepare valid json response

        return $this->renderJson($response, $mission);
    }

      /**
     * Handle a GET request to retrieve astronauts associated with a specific mission ID.
     *
     * @param Request $request  The HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $uri_args   The URI arguments, including `mission_id`.
     * @return Response The JSON response containing the astronauts associated with the mission.
     * @throws HttpInvalidInputsException If the mission ID is invalid.
     * @throws HttpNotFoundException If the mission is not found.
     */
    //?Get Astronauts by Mission ID callback function
    public function  handleGetAstronautsByMissionID(Request $request, Response $response, array $uri_args): Response
    {
        $mission_id = $uri_args["mission_id"];
        $validator = new Validator(['ID' => $mission_id]);

        $validator->rule('integer', 'ID');

        //IF Id Provided is not an integer
        if (!$validator->validate()) {
            throw new HttpInvalidInputsException($request, "Invalid mission id provided");
        }

        $result = $this->mission_model->getAstronautsByMissionID($mission_id);

        //IF mission doesn't exist
        if (!$result['mission']) {
            throw new HttpNotFoundException($request, "No matching missions found");
        }

        return $this->renderJson($response, $result);
    }
}
