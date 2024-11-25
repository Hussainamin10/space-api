<?php

namespace App\Controllers;

use App\Core\PasswordTrait;
use App\Exceptions\HttpInvalidInputsException;
use App\Models\AstronautsModel;
use App\Services\AstronautsService;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AstronautsController extends BaseController
{
    //! The use of password trait
    use PasswordTrait;
    public function __construct(private AstronautsModel $astronauts_model, private AstronautsService $astronautsService)
    {
        $this->astronauts_model = $astronauts_model;
        $this->astronautsService = $astronautsService;
    }

    //! Get /astronauts
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
        //* Astronaut has to be an integer
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

        //* Pattern to check astronautID only contains integer
        $isIntPattern = "/^[0-9]+$/";
        $astronautId = $uri_args["astronautId"];
        if (preg_match($isIntPattern, $astronautId) === 0) {
            throw new HttpInvalidInputsException($request, "Invalid astronautID provided");
        }

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
        //* 1) Retrieve the data embedded/included in the request body
        $new_astronaut = $request->getParsedBody();

        //* 2) Pass the received data to the service
        $result = $this->astronautsService->createAstronaut($new_astronaut[0]);
        $payload = [];

        $status_code = 201;
        if ($result->isSuccess()) {
            //* successful message
            $payload["success"] = true;
        } else {
            $status_code = 400;
            //* failure message
            $payload["success"] = false;
        }
        $payload["message"] = $result->getMessage();
        $payload["errors"] = $result->getData();
        $payload["status"] = $status_code;

        return $this->renderJson($response, $payload, $status_code);
    }

    //! Delete /astronauts
    public function handleDeleteAstronaut(Request $request, Response $response, array $uri_args): Response
    {
        //* Retrieve POST request embedded body
        $astronautID = $request->getParsedBody()['astronautID'] ?? null;
        $result = $this->astronautsService->deleteAstronaut($astronautID);
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

    //! Update /astronauts
    public function handleUpdateAstronaut(Request $request, Response $response, array $uri_args): Response
    {
        // Retrieve POST request embedded body
        $astronaut = $request->getParsedBody()[0];
        $result = $this->astronautsService->updateAstronaut($astronaut);
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

    //! Log
    public function handleAccessLog(Request $request, Response $response, array $uri_args): Response
    {
        echo 'logging process';
        //Instantiate the logger/
        $logger = new Logger("ACCESS");

        //2 Push a stream handler
        $logger->pushHandler(new StreamHandler(APP_LOGS_PATH . '/access.log'));
        $log_record = "Hello! is this working";
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $log_record .= $ip_address;
        $extra = $request->getQueryParams();

        $logger->info($log_record, $extra);

        return $response;
    }
}

// Notes:
/*
For the database we have two tables one for creating a user and login, we have to import the tables

For the password hash, we will have to use the PasswordTrait in the code folder

The versioning part of the project will be done in class at the end, because it doesn't take time

User is identifiable before doing the token

For the error handling we will have to create exceptions in the Exceptions folder

we have to have to have a reusable component (declare it as any array)

*/
