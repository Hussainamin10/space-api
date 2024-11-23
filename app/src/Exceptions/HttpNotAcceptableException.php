<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Nyholm\Psr7\Factory\Psr17Factory;

class HttpNotAcceptableException extends Exception
{
    protected $code = 406;
    protected $message = 'Not Acceptable';

    public function getResponse(): ResponseInterface
    {
        $psr17Factory = new Psr17Factory();
        $response = $psr17Factory->createResponse(406); // 406 Not Acceptable

        $errorData = [
            'code' => 406,
            'message' => $this->message,
            'description' => 'The requested resource representation is not supported by this server.'
        ];

        $response->getBody()->write(json_encode($errorData));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
