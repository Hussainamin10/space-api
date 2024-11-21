<?php

namespace App\Models;

use App\Core\PDOService;

class AccessLogModel extends BaseModel
{
    private string $table_name = "ws_logs";
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    public function log(string $logged_at, string $user_action): mixed
    {
        $last_id = $this->insert($this->table_name, $user_action);
        return $last_id;
    }
}
