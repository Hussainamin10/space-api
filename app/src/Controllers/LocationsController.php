<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\LocationsModel;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class LocationsController extends BaseController
{


    public function __construct(private LocationsModel $location_model)
    {
        parent::__construct();
    }
    //Route:GET /players
    public function handleGetLocations(Request $request, Response $response): Response
    {

        //* Step 1) Retrieve the filter params
        $filter_params = $request->getQueryParams();
        //dd(data: $filter_params);

        if (isset($filter_params['current_page']) && isset($filter_params['pageSize'])) {
            $this->location_model->setPaginationOptions((int)$filter_params['current_page'], (int)$filter_params['pageSize']);
        }


        //* Step 2) Retrieve the sorting params
        $sort_params = [];
        $order = isset($filter_params['order']) ? strtolower($filter_params['order']) : 'asc';

        //Check if sort_by is set
        if (isset($filter_params['sort_by'])) {
            $sort_fields = explode(',', $filter_params['sort_by']);
            //Check if the sort params and order params are valid
            $allowed_order = ['asc', 'desc'];
            $allowed_sort = ['name', 'launchCount', 'countryCode'];

            //Validate order params
            if (!in_array($order, $allowed_order)) {
                throw new HttpInvalidInputsException($request, "Invalid order provided. Only asc or desc allowed");
            }

            //*Validate sort parameters
            foreach ($sort_fields as $field) {
                $field = trim($field);
                if (!in_array($field, $allowed_sort)) {
                    throw new HttpInvalidInputsException($request, "Invalid sort_by provided. Only name, launchCount and countryCode allowed");
                }
                $sort_params[] = $field;
            }
        }

        $sorting_params = ["sortBy" => $sort_params, "order" => $order];

        $locations = $this->location_model->getLocations(
            $filter_params,
            $sorting_params
        );
        return $this->renderJson($response, $locations);
    }


    public function handleGetLocationByID(Request $request, Response $response, array $uri_args): Response
    {

        if (!isset($uri_args['locationID'])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => 400,
                    "message" => "No location id provided"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }


        //Pattern to check rocket id only contains integer
        $isIntPattern = "/^[0-9]+$/";
        $locationID = $uri_args["locationID"];
        if (preg_match($isIntPattern, $locationID) === 0) {
            throw new HttpInvalidInputsException($request, "Invalid location id provided");
        }

        //* Step 3) if Valid, fetch the rocket's info from the DB
        $location = $this->location_model->getLocationByID($locationID);
        if ($location === false) {
            throw new HttpNotFoundException($request, "No matching location found");
        }
        //* Step 4) Prepare valid json response
        return $this->renderJson($response, $location);
    }
}
