<?php

namespace App\Exceptions;

use Slim\Exception\HttpSpecializedException;

class HttpInvalidUserPermission extends HttpSpecializedException
{
    protected $code = 403;

    /**
     * @var string
     */
    protected $message = 'Invalid User Permission';

    protected string $title = "403 Forbidden";
    protected string $description = 'Resource Denied';
}
