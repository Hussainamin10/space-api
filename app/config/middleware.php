<?php

declare(strict_types=1);

use App\Middleware\ContentNegotiationMiddleware;
use App\Core\CustomErrorHandler;
use App\Middleware\AccessLogMiddleware;
use App\Middleware\AuthMiddleWare;
use App\Middleware\LoggingMiddleware;
use Slim\App;

return function (App $app) {
    // Add your middleware here.

    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
    $app->add(new ContentNegotiationMiddleware());
    $app->add(LoggingMiddleware::class);
    //!NOTE: the error handling middleware MUST be added last.
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $callableResolver = $app->getCallableResolver();
    $responseFactory = $app->getResponseFactory();
    $errorHandler = new CustomErrorHandler($callableResolver, $responseFactory);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);
    $errorMiddleware->getDefaultErrorHandler()->forceContentType(APP_MEDIA_TYPE_JSON);
};
