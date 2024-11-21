<?php

declare(strict_types=1);

use App\Core\CustomErrorHandler;
use App\Middleware\AuthMiddleWare;
use Slim\App;

return function (App $app) {
    // Add your middleware here.
    $app->addMiddleware(new AuthMiddleWare);
    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();

    //!NOTE: the error handling middleware MUST be added last.
    $errorMiddleware = $app->addErrorMiddleware(true, true, true);
    $callableResolver = $app->getCallableResolver();
    $responseFactory = $app->getResponseFactory();
    $errorHandler = new CustomErrorHandler($callableResolver, $responseFactory);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);
    $errorMiddleware->getDefaultErrorHandler()->forceContentType(APP_MEDIA_TYPE_JSON);
};
