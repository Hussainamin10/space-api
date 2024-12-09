<?php

namespace App\Middleware;

use App\Models\AccessLogModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\LogHelper;
use App\Models\AccountsModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * AccessLogMiddleware is a middleware for logging access details for each incoming HTTP request.
 * It captures the request method, URI, query parameters, user's IP address, and JWT authentication data.
 * The access information is logged using the LogHelper class.
 */
class AccessLogMiddleware
{


    /**
     * AccessLogMiddleware constructor.
     * Initializes the middleware with the necessary models for user account management and access logging.
     *
     * @param AccountsModel $accountsModel The model for managing user accounts.
     * @param AccessLogModel $accessLogModel The model for logging access data to the database.
     */
    public function __construct(private AccountsModel $accountsModel, private AccessLogModel $accessLogModel)
    {
        $this->accountsModel = $accountsModel;
        $this->accessLogModel = $accessLogModel;
    }

      /**
     * Handles the logging of access information for each incoming request.
     * It captures the HTTP method, URI, query parameters, and the user's IP address.
     * It also decodes the JWT from the Authorization header to log user-specific information.
     *
     * @param Request $request The incoming HTTP request object.
     * @param Response $response The HTTP response object.
     * @param array $uri_args The URI arguments.
     *
     * @return Response The response object, potentially modified by the middleware.
     */
    public function handleAccessLog(Request $request, Response $response,  array $uri_args)
    {
        $method = $request->getMethod();
        $uri = (string) $request->getUri();
        $message = $_SERVER['REMOTE_ADDR'];
        $queryParams = $request->getQueryParams();


        $queryParamsString = json_encode($queryParams);


        $userAction = '"method" => ' . $method . ', "uri" => ' . $uri . ', "query" => ' . $queryParamsString . ', "ip" => ' . $message;


        $auth_header = $request->getHeaderLine("Authorization");
        $jwt = str_replace("Bearer ", "", $auth_header);
        $decoded = JWT::decode($jwt, new Key(SECRET_KEY, "HS256"));

        // Extract user_id from the decoded JWT
        $issued_at = date('Y-m-d H:i:s');
        $user_id = $this->accountsModel->getUserIDByEmail($decoded->email);

        // Log data
        $logData = [
            "email" => $decoded->email,
            "user_action" => $userAction,
            "logged_at"  => $issued_at,
            "user_id" => $user_id["user_id"]
        ];


        LogHelper::init($this->accessLogModel);


        LogHelper::logAccess($message, $logData);

        return $response;
    }
}
