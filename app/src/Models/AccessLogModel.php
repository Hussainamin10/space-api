<?php

namespace App\Models;

use App\Core\PDOService;

/**
 * Class AccessLogModel
 * 
 * This class handles access logs for the application. It provides functionality to log data into the `ws_log` table.
 */

class AccessLogModel extends BaseModel
{

    /**
     * @var string The name of the table used for logging.
     */
    private string $table_name = "ws_log";

    /**
     * AccessLogModel constructor.
     * 
     * @param PDOService $dbo The database service object used for database interactions.
     */
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    /**
     * Logs data into the access log table.
     * 
     * @param mixed $data The data to be logged.
     * 
     * @return mixed The ID of the last inserted record.
     */
    public function log($data): mixed
    {
        $last_id = $this->insert($this->table_name, $data);
        return $last_id;
    }
}
