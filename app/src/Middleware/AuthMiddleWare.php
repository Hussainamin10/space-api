<?php

namespace App\Middleware;

use App\Exceptions\HttpInvalidUserPermission;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use LogicException;
use Slim\Exception\HttpUnauthorizedException;
use UnexpectedValueException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;


/**
 * AuthMiddleware is a middleware that handles authentication and authorization for incoming requests.
 * It checks the presence of a valid JWT in the Authorization header and validates the user's role.
 * If the JWT is missing or invalid, or if the user has insufficient permissions for the requested resource,
 * an HTTP Unauthorized or Forbidden exception is thrown.
 */
class AuthMiddleWare implements MiddlewareInterface
{
    /**
     * Processes the incoming request to verify authentication and authorization.
     * It checks if the request is for login or register endpoints, and if not, validates the JWT.
     * If the user has an invalid role or the JWT is not valid, an exception is thrown.
     *
     * @param Request $request The incoming request.
     * @param RequestHandler $handler The handler to process the request after the middleware.
     *
     * @return ResponseInterface The response after processing the request.
     *
     * @throws HttpUnauthorizedException If the JWT is invalid or missing.
     * @throws HttpInvalidUserPermission If the user does not have the required permissions for the request.
     */
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
                throw new HttpInvalidUserPermission($request, "General user trying to access unauthorized resource");
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
