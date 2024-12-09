<?php

/**
 * RocketsController handles requests related to rocket operations.
 *
 * This class provides endpoints to perform CRUD operations on rockets,
 * retrieve rockets, and calculate lift-off thrust. It uses the RocketsModel
 * for database interactions and the RocketsService for additional business logic.
 *
 * @package App\Controllers
 */

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Exceptions\HttpSuccessfulRequestNoContent;
use App\Models\RocketsModel;
use App\Services\RocketsService;
use App\Validation\Validator;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class RocketsController extends BaseController
{


        /**
     * Constructor for RocketsController.
     *
     * @param RocketsModel $rocketsModel
     * @param RocketsService $rocketsService
     */
    public function __construct(private RocketsModel $rocketsModel, private RocketsService $rocketsService)
    {
        $this->rocketsService = $rocketsService;
        $this->rocketsModel = $rocketsModel;
    }

    /**
     * Retrieves a list of rockets with optional filters and sorting.
     *
     * @route GET /rockets
     *
     * @param Request $request
     * @param Response $response
     * @return Response JSON response containing the list of rockets.
     *
     * @throws HttpInvalidInputsException If invalid query parameters are provided.
     */
    //Route:GET /players
    public function handleGetRockets(Request $request, Response $response): Response
    {

        //* Step 1) Retrieve the filter params
        $filter_params = $request->getQueryParams();
        if (isset($filter_params['current_page']) && isset($filter_params['pageSize'])) {
            $this->rocketsModel->setPaginationOptions((int)$filter_params['current_page'], (int)$filter_params['pageSize']);
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
        //*Validate the sorting
        //*Validate the query

        //*Validate the query
        $validator = new Validator($filter_params);
        $validator->rules([
            'numeric' => [
                'minHeight',
                'maxHeight',
                'minWeight',
                'maxWeight',
                'minCost',
                'maxCost',
                'minThrust',
                'maxThrust'
            ],
            'in' => [
                ['status', ['Active', 'Retired', 'active', 'retired']]
            ],
            'min' => [
                ['minHeight', 0],
                ['maxHeight', 0],
                ['minWeight', 0],
                ['maxWeight', 0],
                ['minCost', 0],
                ['maxCost', 0],
                ['minThrust', 0],
                ['maxThrust', 0],
                ['current_page', 1],
                ['pageSize', 1]
            ],
            'integer' => ['numberOfStages', 'current_page', 'pageSize'],
            'requiredWith' => [
                ['current_page', 'pageSize'],
                ['pageSize', 'current_page']
            ]
        ]);
        //*If Invalid Return Fail result
        if (!$validator->validate()) {
            throw new HttpInvalidInputsException($request, "Invalid Query:" . $validator->errorsToString());
        }
        //The expected filter values can instead be documented in the proposal instead of validating here.
        $rockets = $this->rocketsModel->getRockets(
            $filter_params,
            $sorting_params
        );

        return $this->renderJson($response, $rockets);
    }

     /**
     * Retrieves details of a rocket by its ID.
     *
     * @route GET /rockets/{rocketID}
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return Response JSON response containing the rocket details.
     */
    public function handleGetRocketByID(Request $request, Response $response, array $uri_args): Response
    {
        $rocketID = $uri_args["rocketID"];
        $result = $this->rocketsService->getRocketByID($rocketID);

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
     * Creates a new rocket.
     *
     * @route POST /rockets
     *
     * @param Request $request
     * @param Response $response
     * @return Response JSON response indicating success or failure.
     */
    public function handleCreateRocket(Request $request, Response $response): Response
    {
        // Retrieve POST request embedded body
        $newRocket = $request->getParsedBody();
        if (!isset($request->getParsedBody()[0])) {
            throw new HttpInvalidInputsException($request, "Invalid inputs");
        }
        // Pass receive data to service
        $result = $this->rocketsService->createRocket($newRocket[0]);
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
     * Deletes a rocket by its ID.
     *
     * @route DELETE /rockets
     *
     * @param Request $request
     * @param Response $response
     * @return Response JSON response indicating success or failure.
     *
     * @throws HttpInvalidInputsException If the rocket ID is missing or invalid.
     */
    public function handleDeleteRocket(Request $request, Response $response): Response
    {
        // Retrieve POST request embedded
        if (!isset($request->getParsedBody()[0]['rocketID'])) {
            throw new HttpInvalidInputsException($request, "Invalid inputs");
        }
        $rocketID = $request->getParsedBody()[0]['rocketID'];
        $result = $this->rocketsService->deleteRocket($rocketID);
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
     * Updates the details of a rocket.
     *
     * @route PUT /rockets
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return Response JSON response indicating success or failure.
     */
    public function handleUpdateRocket(Request $request, Response $response, array $uri_args): Response
    {
        if (!isset($request->getParsedBody()[0])) {
            throw new HttpInvalidInputsException($request, "Invalid inputs");
        }
        // Retrieve POST request embedded body
        $rocket = $request->getParsedBody()[0];
        $result = $this->rocketsService->updateRocket($rocket);
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
     * Retrieves a list of launches associated with a specific rocket.
     *
     * @route GET /rockets/{rocketID}/launches
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return Response JSON response containing the launches.
     */
    public function handleGetLaunchesByRocketID(Request $request, Response $response, array $uri_args): Response
    {
        $rocketID = $uri_args["rocketID"];
        $result = $this->rocketsService->getLaunchesByRocketID($rocketID);
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
     * Retrieves a list of missions associated with a specific rocket.
     *
     * @route GET /rockets/{rocketID}/missions
     *
     * @param Request $request
     * @param Response $response
     * @param array $uri_args
     * @return Response JSON response containing the missions.
     */
    public function  handleGetMissionsByRocketID(Request $request, Response $response, array $uri_args): Response
    {
        $rocketID = $uri_args["rocketID"];
        $result = $this->rocketsService->getMissionsByRocketID($rocketID);

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
     * Calculates the lift-off thrust for a given rocket.
     *
     * @route POST /rockets/calculate-lift
     *
     * @param Request $request
     * @param Response $response
     * @return Response JSON response containing the lift-off thrust calculation.
     *
     * @throws HttpInvalidInputsException If the input data is invalid.
     */
    public function handleCalLiftOfThrust(Request $request, Response $response): Response
    {
        if (!isset($request->getParsedBody()[0])) {
            throw new HttpInvalidInputsException($request, "Invalid inputs");
        }
        $body = $request->getParsedBody()[0];
        $result = $this->rocketsService->getLiftCalculation($body);
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
