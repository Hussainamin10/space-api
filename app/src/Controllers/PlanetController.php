<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\PlanetModel;
use App\Services\PlanetsService;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

/**
 * Class PlanetController
 * Handles HTTP requests related to planets, including fetching, creating, updating,
 * and deleting planet data.
 */
class PlanetController extends BaseController
{


      /**
     * PlanetController constructor.
     *
     * @param PlanetModel $planet_model The planet model dependency.
     * @param PlanetsService $planetsService The planet service dependency.
     */
    public function __construct(private PlanetModel $planet_model, private PlanetsService $planetsService)
    {
        parent::__construct();

        $this->planet_model = $planet_model;
        $this->planetsService = $planetsService;
    }

       /**
     * Handle a GET request to retrieve all planets with optional filters and pagination.
     *
     * @param Request $request  The HTTP request object.
     * @param Response $response The HTTP response object.
     * @return Response The JSON response containing planet data.
     */
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

       /**
     * Handle a GET request to retrieve a planet by its ID.
     *
     * @param Request $request  The HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $uri_args   The URI arguments, including `planetID`.
     * @return Response The JSON response containing the planet data.
     * @throws HttpInvalidInputsException If the planet ID is invalid.
     * @throws HttpNotFoundException If the planet is not found.
     */
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

        /**
     * Handle a GET request to retrieve additional information for a specific planet.
     *
     * @param Request $request  The HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $uri_args   The URI arguments, including `planetID`.
     * @return Response The JSON response containing additional planet information.
     */

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


      /**
     * Handle a POST request to create a new planet.
     *
     * @param Request $request  The HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $uri_args   The URI arguments (not used).
     * @return Response The JSON response indicating the result of the creation process.
     */
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


        /**
     * Handle a DELETE request to remove a planet.
     *
     * @param Request $request  The HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $uri_args   The URI arguments (not used).
     * @return Response The JSON response indicating the result of the deletion process.
     */
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

    /**
     * Handle a PUT request to update planet details.
     *
     * @param Request $request  The HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $uri_args   The URI arguments (not used).
     * @return Response The JSON response indicating the result of the update process.
     */
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
