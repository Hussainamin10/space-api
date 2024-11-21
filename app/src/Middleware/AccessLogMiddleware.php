<?php

namespace App\Middleware;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\LogHelper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AccessLogMiddleware
{
    public function handleAccessLog(Request $request, Response $response,  array $uri_args)
    {
        $method = $request->getMethod();
        $uri = (string) $request->getUri();
        $message = $_SERVER['REMOTE_ADDR'];
        $queryParams = $request->getQueryParams();
        $date = date('Y-m-d H:i:s');


        $extra = [
            'date' => $date,
            'method' => $method,
            'uri' => $uri,
            'query' => $queryParams
        ];

        //$userAction = `
           // method => {$method},
            //uri => {$uri},
            //query => {$queryParams},
            //ip => {$message}
            //`;

        $auth_header = $request->getHeaderLine("Authorization");
        $jwt = str_replace("Bearer ", "", $auth_header);
        $decoded = JWT::decode($jwt, new Key(SECRET_KEY, "HS256"));

        dd($decoded);


        LogHelper::logAccess($message, $extra);

        return $response;
    }
}
