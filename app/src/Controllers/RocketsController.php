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
        if (isset($filter_params['current_page']) && isset($filter_params['pageSize'])) {
            $this->rockets_model->setPaginationOptions((int)$filter_params['current_page'], (int)$filter_params['pageSize']);
        }
        //* Step 2) Retrieve the sorting params

        $sort_params = [];
        $order = isset($filter_params['order']) ? strtolower($filter_params['order']) : 'asc';

        //Check if sort_by is set
        if (isset($filter_params['sort_by'])) {
            $sort_fields = explode(',', $filter_params['sort_by']);
            //Check if the sort params and order params are valid
            $allowed_order = ['asc', 'desc'];
            $allowed_sort = ['rocketHeight', 'launchCost', 'companyName'];

            //Validate order params
            if (!in_array($order, $allowed_order)) {
                throw new HttpInvalidInputsException($request, "Invalid order provided. Only asc or desc allowed");
            }

            //*Validate sort parameters
            foreach ($sort_fields as $field) {
                $field = trim($field);
                if (!in_array($field, $allowed_sort)) {
                    throw new HttpInvalidInputsException($request, "Invalid sort_by provided. Only rocketHeight, launchCost and companyName allowed");
                }
                $sort_params[] = $field;
            }
        }

        $sorting_params = ["sortBy" => $sort_params, "order" => $order];
        //The expected filter values can instead be documented in the proposal instead of validating here.
        $rockets = $this->rockets_model->getRockets(
            $filter_params,
            $sorting_params
        );

        return $this->renderJson($response, $rockets);
    }

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
