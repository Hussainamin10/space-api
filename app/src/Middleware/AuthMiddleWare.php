<?php

namespace App\Middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use LogicException;
use Slim\Exception\HttpUnauthorizedException;
use UnexpectedValueException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;

class AuthMiddleWare implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {

        $uri = $request->getUri()->getPath();
        if (str_contains($uri, '/login') || str_contains($uri, '/register')) {
            return $handler->handle($request);
        }
        //* Extract the JWT from the Authorization header
        $auth_header = $request->getHeaderLine("Authorization");
        $jwt = str_replace("Bearer ", "", $auth_header);

        try {
            $decoded = JWT::decode($jwt, new Key(SECRET_KEY, "HS256"));
            $role = strtolower($decoded->role);
            $request_method = $request->getMethod();
            if ($role == 'general' && $request_method != "GET") {
                throw new HttpUnauthorizedException($request, "General user trying to access unauthorized resource");
            }
        } catch (LogicException $e) {
            // errors having to do with environmental setup or malformed JWT Keys
            throw new HttpUnauthorizedException($request, $e->getMessage());
        } catch (UnexpectedValueException $e) {
            throw new HttpUnauthorizedException($request, $e->getMessage());
        }
        $response = $handler->handle($request);
        return $response;
    }
}
