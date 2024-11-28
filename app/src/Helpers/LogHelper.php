<?php

namespace App\Helpers;

use App\Models\AccessLogModel;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LogHelper
{
    private static ?Logger $accessLog = null;
    private static ?Logger $errorLog = null;

    private static ?AccessLogModel $logModel = null;

    // Initialize the loggers
    public static function init(AccessLogModel $accessLogModel)
    {
        // Initialize the access log
        self::$accessLog = new Logger('access');
        self::$accessLog->pushHandler(new StreamHandler(APP_LOGS_PATH . '/access.log'));

        // Initialize the error log
        self::$errorLog = new Logger('error');
        self::$errorLog->pushHandler(new StreamHandler(APP_LOGS_PATH . '/error.log'));

        // Initialize the log model (static)
        self::$logModel = $accessLogModel;
    }

    // Log access information
    public static function logAccess($message, $extra)
    {
        // Initialize the access log if not already initialized
        if (self::$accessLog === null) {
            throw new \Exception("LogHelper not initialized. Call init() first.");
        }

        // Log the access message
        self::$accessLog->info($message, $extra);

        // Log to the database using the model
        if (self::$logModel !== null) {
            self::$logModel->log($extra);
        }
    }

    // Log error information
    public static function logError($message, $extra)
    {
        // Initialize the error log if not already initialized
        if (self::$errorLog === null) {
            self::$errorLog = new Logger('error');
            self::$errorLog->pushHandler(new StreamHandler(APP_LOGS_PATH . '/error.log'));
        }

        // Log the error message
        self::$errorLog->error($message, $extra);
    }
}
