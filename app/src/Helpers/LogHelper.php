<?php

namespace App\Helpers;

use App\Models\AccessLogModel;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * LogHelper is a utility class for managing logging operations, including access and error logs.
 * It leverages Monolog for logging to files and supports logging to a database using the AccessLogModel.
 */
class LogHelper
{
      /**
     * @var Logger|null $accessLog The logger instance for logging access information.
     */
    private static ?Logger $accessLog = null;

        /**
     * @var Logger|null $errorLog The logger instance for logging error information.
     */
    private static ?Logger $errorLog = null;

       /**
     * @var AccessLogModel|null $logModel The model for logging to the database.
     */
    private static ?AccessLogModel $logModel = null;

      /**
     * Initializes the LogHelper by setting up access and error loggers.
     *
     * @param AccessLogModel $accessLogModel The model for logging access to the database.
     */
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

       /**
     * Logs access information both to the file and the database.
     *
     * @param string $message The message to log.
     * @param array $extra Additional context or data to log.
     *
     * @throws \Exception If LogHelper has not been initialized.
     */
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

      /**
     * Logs error information to the error log.
     *
     * @param string $message The error message to log.
     * @param array $extra Additional context or data to log.
     */
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
