<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpInvalidInputsException extends HttpSpecializedException
{
    protected $code = 400;

    /**
     * @var string
     */
    protected $message = 'Not found.';

    protected string $title = "400 Bad Request";
    protected string $description = 'The request could not be processed due to invalid values/inputs provided. Ple
    .';
}
