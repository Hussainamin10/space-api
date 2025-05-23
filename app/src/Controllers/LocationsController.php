<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\LocationsModel;
use App\Services\LocationService;
use App\Validation\Validator;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

/**
 * LocationsController handles CRUD operations and query-based actions related to locations.
 */
class LocationsController extends BaseController
{


      /**
     * Constructor for the LocationsController.
     *
     * @param LocationsModel $location_model The model for accessing location data.
     * @param LocationService $locationService The service for processing location business logic.
     */
    public function __construct(private LocationsModel $location_model, private LocationService $locationService)
    {
        $this->location_model = $location_model;
        $this->locationService = $locationService;
    }

    /**
     * Handles retrieval of a paginated and sorted list of locations.
     *
     * @param Request $request The HTTP request containing query parameters for filtering and sorting.
     * @param Response $response The HTTP response to return the location data.
     *
     * @return Response A JSON response with the list of locations.
     *
     * @throws HttpInvalidInputsException For invalid query parameters.
     */
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

        //*Validate the query
        $validator = new Validator($filter_params);
        $validator->rules([
            'numeric' => [
                'minLaunchCount',
                'maxLaunchCount',
                'minLandingCount',
                'maxLandingCount',
                'minCost',
                'maxCost',
                'minThrust',
                'maxThrust'
            ],
            'min' => [
                ['minLaunchCount', 0],
                ['maxLaunchCount', 0],
                ['minLandingCount', 0],
                ['maxLandingCount', 0],
                ['current_page', 1],
                ['pageSize', 1]
            ],
            'requiredWith' => [
                ['current_page', 'pageSize'],
                ['pageSize', 'current_page']
            ],
            'integer' => ['current_page', 'pageSize']
        ]);
        //*If Invalid Return Fail result
        if (!$validator->validate()) {
            throw new HttpInvalidInputsException($request, "Invalid Query:" . $validator->errorsToString());
        }

        $locations = $this->location_model->getLocations(
            $filter_params,
            $sorting_params
        );
        return $this->renderJson($response, $locations);
    }


        /**
     * Retrieves details of a specific location by its ID.
     *
     * @param Request $request The HTTP request.
     * @param Response $response The HTTP response.
     * @param array $uri_args URI arguments containing the location ID.
     *
     * @return Response A JSON response with the location details.
     *
     * @throws HttpInvalidInputsException For invalid location IDs.
     * @throws HttpNotFoundException If no location is found for the provided ID.
     */
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

       /**
     * Creates a new location entry.
     *
     * @param Request $request The HTTP request containing the new location data.
     * @param Response $response The HTTP response to confirm creation.
     *
     * @return Response A JSON response with the creation result.
     */
    public function handleCreateLocation(Request $request, Response $response): Response
    {
        // Retrieve POST request embedded body
        $newLocation = $request->getParsedBody();
        // Pass receive data to service
        $result = $this->locationService->createLocation($newLocation[0]);

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

     /**
     * Deletes a specific location.
     *
     * @param Request $request The HTTP request containing the location ID.
     * @param Response $response The HTTP response confirming deletion.
     * @param array $uri_args URI arguments (optional, not used here).
     *
     * @return Response A JSON response with the deletion result.
     */
    public function handleDeleteLocation(Request $request, Response $response, array $uri_args): Response
    {
        // Retrieve POST request embedded body
        $locationId = $request->getParsedBody()[0]['id'] ?? null;
        $result = $this->locationService->deleteLocation($locationId);
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

      /**
     * Updates an existing location entry.
     *
     * @param Request $request The HTTP request containing the updated location data.
     * @param Response $response The HTTP response confirming the update.
     * @param array $uri_args URI arguments (optional, not used here).
     *
     * @return Response A JSON response with the update result.
     */
    public function handleUpdateLocation(Request $request, Response $response, array $uri_args): Response
    {
        // Retrieve POST request embedded body
        $location = $request->getParsedBody()[0];
        $result = $this->locationService->updateLocation($location);
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
