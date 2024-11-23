<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exceptions\HttpNotAcceptableException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Nyholm\Psr7\Factory\Psr17Factory;


class ContentNegotiationMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        // Step 1: Get/read the value of the HTTP Accept header
        $acceptHeader = $request->getHeaderLine('Accept');

        // For debugging purposes, you can uncomment this line to see the Accept header value
        // var_dump($acceptHeader);
        // exit;

        // Step 2: Compare it to "application/json"
        if ($acceptHeader !== 'application/json') {
            // If it doesn't match, use Method #1: raise an exception
            throw new HttpNotAcceptableException('Unsupported resource representation');

            // Alternatively, you could use Method #2 to return a specific response
            /*
            return $this->handleNotAcceptableResponse();
            */
        }

        // If the Accept header is acceptable, continue processing the request
        return $handler->handle($request);
    }

    private function handleNotAcceptableResponse(): ResponseInterface
    {
        // Method #2: Create an HTTP response for unsupported representation
        $psr17Factory = new Psr17Factory();
        $response = $psr17Factory->createResponse(406); // 406 Not Acceptable

        $errorData = [
            'code' => 406,
            'message' => 'Unsupported resource representation',
            'description' => 'The requested resource representation is not supported by this server.'
        ];

        $response->getBody()->write(json_encode($errorData));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
