<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccountController extends BaseController
{
    public function handleAccessLog(Request $request, Response $response): Response
    {
        // TODO: 1) Validate the received user credentials against the DB: check if there is a record matching the supplied user info: username/email: password.


        //* Assuming the user was already logged in ...
        //! Generate a JWT token containing private claims about the authenticated user.
        $issued_at = time();
        $expiries_at = $issued_at + 60;

        $registered_claims = [
            'iss' => 'http://localhost/space-api/',
            'aud' => 'http://space-api.com',
            'iat' => $issued_at,
            'exp' => $expiries_at

        ];

        //Store the user info
        $private_claims = array(
            "user_id" => 1,
            "email" => "ladybug@io.com",
            "username" => "ladybug",
            "role" => "admin"

        );

        $payload = array_merge($private_claims, $registered_claims);
        $jwt = JWT::encode($payload, SECRET_KEY, 'HS256');
        $jwt_data = array(
            "status" => "success",
            "message" => "The JWT token was successfully",
            "token" => $jwt
        );

        return $this->renderJson($response, $jwt_data);
    }
}
