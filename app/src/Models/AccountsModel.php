<?php

namespace App\Models;

use App\Core\PDOService;

class AccountsModel extends BaseModel
{

    private string $table_name = "ws_users";
    public function __construct(PDOService $dbo)
    {
        parent::__construct($dbo);
    }
    public function getAccountByEmail(string $email): mixed
    {
        $sql = "SELECT * FROM {$this->table_name} WHERE email = :email";
        $account_info = $this->fetchSingle(
            $sql,
            [
                "email" => $email
            ]
        );
        return $account_info;
    }

    public function createAccount(array $newAccount): mixed
    {
        $newID = $this->insert($this->table_name, $newAccount);
        return $newID;
    }
}
