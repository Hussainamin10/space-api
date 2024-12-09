<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\LogHelper;
use App\Models\AccessLogModel;
use App\Models\AccountsModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;

/**
 * LoggingMiddleware is a middleware that logs the access information for each incoming request.
 * It captures request details such as HTTP method, URI, query parameters, and the user's IP address.
 * Additionally, it logs the user's action along with their email and user ID (retrieved from the decoded JWT).
 * The access log is written both to a log file and to a database using the AccessLogModel.
 */
class LoggingMiddleware implements MiddlewareInterface
{

    /**
     * Constructor to initialize the necessary models.
     *
     * @param AccountsModel $accountsModel The AccountsModel for accessing account details.
     * @param AccessLogModel $accessLogModel The AccessLogModel for logging access data.
     */
    public function __construct(private AccountsModel $accountsModel, private AccessLogModel $accessLogModel)
    {
        $this->accountsModel = $accountsModel;
        $this->accessLogModel = $accessLogModel;
    }

    /**
     * Processes the incoming request, logs access information, and passes the request to the next handler.
     *
     * The middleware logs the following details:
     * - HTTP method
     * - Request URI
     * - Query parameters
     * - Client IP address
     * - Decoded JWT data (email and user ID)
     *
     * The log is written to both the log file and the database.
     *
     * @param Request $request The incoming request.
     * @param RequestHandler $handler The handler to process the request after the middleware.
     *
     * @return ResponseInterface The response after processing the request.
     */
    public function process(Request $request, RequestHandler $handler): ResponseInterface
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

        $response = $handler->handle($request);
        return $response;
    }
}
