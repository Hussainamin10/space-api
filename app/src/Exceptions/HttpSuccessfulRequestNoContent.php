<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpSuccessfulRequestNoContent extends HttpSpecializedException
{
    protected $code = 204;

    /**
     * @var string
     */
    protected $message = 'Acceptable. No Content.';
    protected string $title = "204 Successful Request";
    protected string $description = 'The request was successful but no content returned';
}
