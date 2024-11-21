<?php

namespace App\Helpers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class LogHelper
{
    private static $accessLog;
    private static $errorLog;

    public static function init()
    {
        // Initialize the access log
        self::$accessLog = new Logger('access');
        self::$accessLog->pushHandler(new StreamHandler(APP_LOGS_PATH . '/access.log'));

        // Initialize the error log
        self::$errorLog = new Logger('error');
        self::$errorLog->pushHandler(new StreamHandler(APP_LOGS_PATH . '/error.log'));
    }

    public static function logAccess($message, $extra)
    {
        if (!self::$accessLog) {
            self::init();
        }
        self::$accessLog->info($message, $extra);
        
    }

    public static function logError($message, $extra)
    {
        if (!self::$errorLog) {
            self::init();
        }
        self::$errorLog->error($message, $extra);
    }
}
