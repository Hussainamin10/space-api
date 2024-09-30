<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\RocketsModel;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class RocketsController extends BaseController
{


    public function __construct(private RocketsModel $rockets_model)
    {
        parent::__construct();
    }
    //Route:GET /players
    public function handleGetRockets(Request $request, Response $response): Response
    {

        //* Step 1) Retrieve the filter params
        $filter_params = $request->getQueryParams();
        //dd(data: $filter_params);

        if (isset($filter_params['current_page']) && isset($filter_params['pageSize'])) {
            $this->rockets_model->setPaginationOptions((int)$filter_params['current_page'], (int)$filter_params['pageSize']);
        }
        //!TODO Validate Filter parameters
        //!Is Numerical
        //!Maximum has to be bigger or equal to min values
        //!Incorrect Parameters passed

        $players = $this->rockets_model->getRockets(
            $filter_params
        );
        return $this->renderJson($response, $players);
    }
    //!TODO get Rockets by Name
    public function handleGetRocketByID(Request $request, Response $response, array $uri_args): Response
    {
        //* Step 1) Receive the received rocket ID

        //* Step 2) Validate the Rocket ID
        // Rocket Has to be an integer

        if (!isset($uri_args['rocketID'])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => 400,
                    "message" => "No rocket id provided"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }


        //Pattern to check rocket id only contains integer
        $rocket_id_pattern = "/^[0-9]+$/";
        $rocketID = $uri_args["rocketID"];
        if (preg_match($rocket_id_pattern, $rocketID) === 0) {

            throw new HttpInvalidInputsException($request, "Invalid rocket id provided");
        }

        //* Step 3) if Valid, fetch the rocket's info from the DB
        $rocket = $this->rockets_model->getRocketByID(rocketID: $rocketID);
        if ($rocket === false) {
            throw new HttpNotFoundException($request, "No matching rockets found");
        }
        //* Step 4) Prepare valid json response
        return $this->renderJson($response, $rocket);
    }
}
