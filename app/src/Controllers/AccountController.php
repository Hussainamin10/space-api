<?php

namespace App\Controllers;

use App\Exceptions\HttpInvalidInputsException;
use App\Models\AccountsModel;
use App\Services\AccountsService;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Class AccountController
 *
 * Controller for handling account-related operations such as login and registration.
 */
class AccountController extends BaseController
{
      /**
     * AccountController constructor.
     *
     * @param AccountsModel $accountsModel The accounts model instance.
     * @param AccountsService $accountsService The accounts service instance.
     */
    public function __construct(private AccountsModel $accountsModel, private AccountsService $accountsService)
    {
        $this->accountsModel = $accountsModel;
        $this->accountsService = $accountsService;
    }

      /**
     * Handles user login and generates a JWT token for authenticated users.
     *
     * @param Request $request The incoming HTTP request.
     * @param Response $response The HTTP response to be returned.
     *
     * @return Response The HTTP response containing the JWT token or an error message.
     *
     * @throws HttpInvalidInputsException If the request body is invalid.
     */
    public function handleAccessLogin(Request $request, Response $response): Response
    {
        if (!isset($request->getParsedBody()[0])) {
            throw new HttpInvalidInputsException($request, "Invalid inputs");
        }
        // TODO: 1) Validate the received user credentials against the DB: check if there is a record matching the supplied user info: username/email: password.
        $body = $request->getParsedBody()[0];
        $result = $this->accountsService->getAccountByEmailPassword($body);

        if (!$result->isSuccess()) {
            $payload = [];
            $payload['success'] = false;
            $payload['message'] = $result->getMessage();
            $payload['data'] = $result->getData()['data'];
            $payload['status'] = $result->getData()['status'];
            return $this->renderJson($response, $payload, $payload['status']);
        }
        //* Assuming the user was already logged in ...
        $account = $result->getData()['data'];

        //! Generate a JWT token containing private claims about the authenticated user.
        $issued_at = time();
        $expiries_at = $issued_at + 3600;

        $registered_claims = [
            'iss' => 'http://localhost/space-api/',
            'aud' => 'http://space-api.com',
            'iat' => $issued_at,
            'exp' => $expiries_at

        ];

        //Store the user info
        $private_claims = $account;
        $payload = array_merge($private_claims, $registered_claims);
        $jwt = JWT::encode($payload, SECRET_KEY, 'HS256');
        $jwt_data = array(
            "status" => "success",
            "message" => "The JWT token was successfully",
            "token" => $jwt
        );

        return $this->renderJson($response, $jwt_data);
    }

     /**
     * Handles user registration and creates a new account.
     *
     * @param Request $request The incoming HTTP request.
     * @param Response $response The HTTP response to be returned.
     *
     * @return Response The HTTP response containing the registration result.
     *
     * @throws HttpInvalidInputsException If the request body is invalid.
     */
    public function handleAccountRegister(Request $request, Response $response): Response
    {
        if (!isset($request->getParsedBody()[0])) {
            throw new HttpInvalidInputsException($request, "Invalid inputs");
        }
        $body = $request->getParsedBody()[0];
        $result = $this->accountsService->createAccount($body);
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
