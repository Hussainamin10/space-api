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

class LoggingMiddleware implements MiddlewareInterface
{

    public function __construct(private AccountsModel $accountsModel, private AccessLogModel $accessLogModel)
    {
        $this->accountsModel = $accountsModel;
        $this->accessLogModel = $accessLogModel;
    }
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
