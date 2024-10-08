<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\AstronautsModel;
use App\Services\AstronautsService;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

class AstronautsController extends BaseController
{
    public function __construct(
        private AstronautsModel $astronauts_model,
        private AstronautsService $astronautsService
    ) {
        parent::__construct();

        $this->astronauts_model = $astronauts_model;
        $this->astronautsService = $astronautsService;
    }



    //! Get astronauts
    public function handleGetAstronauts(Request $request, Response $response): Response
    {

        //* Step 1) Retrieve the filter params
        $filter_params = $request->getQueryParams();

        if (isset($filter_params['current_page']) && isset($filter_params['pageSize'])) {
            $this->astronauts_model->setPaginationOptions((int)$filter_params['current_page'], (int)$filter_params['pageSize']);
        }

        $astronauts = $this->astronauts_model->getAstronauts(
            $filter_params
        );
        return $this->renderJson($response, $astronauts);
    }

    //! Get astronaut by Id
    public function handleGetAstronautByID(Request $request, Response $response, array $uri_args): Response
    {
        //* Step 1) Receive the received astronaut ID

        //* Step 2) Validate the astronaut ID
        if (!isset($uri_args['astronautId'])) {
            return $this->renderJson(
                $response,
                [
                    "status" => "error",
                    "code" => 400,
                    "message" => "No astronaut id provided"
                ],
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        $astronautId = $uri_args["astronautId"];
        //* Step 3) if Valid, fetch the astronaut's info from the DB
        $astronaut = $this->astronauts_model->getAstronautByID(astronautId: $astronautId);
        if ($astronaut === false) {
            throw new HttpNotFoundException($request, "No matching astronauts found");
        }
        //* Step 4) Prepare valid json response
        return $this->renderJson($response, $astronaut);
    }

    //! Post /astronauts
    public function handleCreateAstronaut(Request $request, Response $response): Response
    {
        // echo "QUACK";
        // 1) Retrieve the data embedded/included in the request body
        $new_astronaut = $request->getParsedBody();
        // dd($new_astronaut);

        // 2) Pass the received data to the service
        $result = $this->astronautsService->createAstronaut($new_astronaut);
        $payload = [];
        $status_code = 201;
        if ($result->isSuccess()) {
            // successful message
            $payload["success"] = true;
        } else {
            $status_code = 400;
            // failure message
            $payload["success"] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["errors"] = $result->getData();
        $payload["status"] = $status_code;

        return $this->renderJson($response, $payload, $status_code);
    }
}
