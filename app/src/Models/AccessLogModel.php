<?php

namespace App\Models;

use App\Core\PDOService;

class AccessLogModel extends BaseModel
{
    private string $table_name = "ws_log";
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }

    public function log($data): mixed
    {
        $last_id = $this->insert($this->table_name, $data);
        return $last_id;
    }
}
